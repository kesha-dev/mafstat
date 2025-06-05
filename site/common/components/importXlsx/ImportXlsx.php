<?php

namespace common\components\importXlsx;

use common\models\Game;
use common\models\GamePlayer;
use common\models\Player;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\base\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\helpers\VarDumper;

class ImportXlsx extends Component implements ImportXlsxInterface
{
    protected Spreadsheet $spreadsheet;

    public function __construct($path, $config = [])
    {
        if (!file_exists($path) || is_dir($path)) {
            throw new FileNotFoundException($path . ' Файл не найден');
        }
        try {
            $this->spreadsheet = IOFactory::load($path);
        } catch (\Exception $e) {
            echo 'Ошибка при открытии файла: ', $e->getMessage();
        }
        parent::__construct($config);
    }

    public function run()
    {
        $gamePagesList = $this->getGamePages();
        foreach ($gamePagesList as $gamePageName) {
            $this->getGameData($gamePageName);
        }
    }

    public function getDateByPageName($gamePageName)
    {
        $startPos = mb_strpos($gamePageName, '(');
        $endPos = mb_strpos($gamePageName, ')');

        if ($startPos === false || $endPos === false || $endPos <= $startPos) {
            return null;
        }

        return mb_substr($gamePageName, $startPos + 1, $endPos - $startPos - 1);
    }

    public function getGamePages()
    {
        $sheetNames = $this->getSheetList();
        return preg_grep('/^№\d+/', $sheetNames);
    }

    public function getSheetList()
    {
        return $this->spreadsheet->getSheetNames();
    }

    public function getGameData($sheetName)
    {
        $sheet = $this->spreadsheet->getSheetByName($sheetName);

        $range = 'A2:E11';
        $data = $sheet->rangeToArray($range, null, true, true, true);
        $item = $data[array_key_first($data)];
        if ($item['B'] == 0 && $item['C'] == 0 && $item['D'] == 0 && $item['E'] == 0) {
            return null;
        }

        $date = $this->getDateByPageName($sheetName);
        if (!$date) {
            return null;
        }

        $games = [];
        for ($gameNumber = 1; $gameNumber <= 4; $gameNumber++) {
            $game = Game::createOrFindGame($date, $gameNumber);
            $games[] = $game;
        }

        foreach ($data as $line => $playerResult) {
            $player = Player::createOrFindPlayer($playerResult['A']);

            $index = 0;
            foreach ($playerResult as $column => $value) {
                if ($column == 'A') {
                    continue;
                }
                $gamePlayer = GamePlayer::createOrFindGamePlayer($games[$index]->id, $player->id);
                $gamePlayer->result = $value;

                $style = $sheet->getStyle($column . $line);
                $backgroundColor = $style->getFill()->getStartColor()->getRGB();
                $gamePlayer->roleByCode = $backgroundColor;

                $fontColor = $style->getFont()->getColor()->getARGB();
                $gamePlayer->puByCode = $fontColor;

                $gamePlayer->save();
                $index++;
            }
        }

        foreach ($games as $game) {
            $mafResult = GamePlayer::find()
                ->where(['game_id' => $game->id, 'role' => [GamePlayer::ROLE_DON, GamePlayer::ROLE_MAF]])
                ->andWhere(['>=', 'result_string', 100])->exists();
            $game->result = $mafResult ? Game::RESULT_MAF : Game::RESULT_MIR;
            $game->save();
        }
    }
}