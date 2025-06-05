<?php

namespace console\controllers;

use common\components\report\ReportPlayer;
use common\models\Player;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\console\Controller;

class ReportController extends Controller
{
    private $sheet;
    private $spreadsheet;

    public function actionIndex()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();

        $line = 1;
        $this->sheet->setCellValue('A' . $line, 'Имя');
        $this->sheet->setCellValue('B' . $line, 'количество игр за красного');
        $this->sheet->setCellValue('C' . $line, 'Процент побед');
        $this->sheet->setCellValue('D' . $line, 'Суммарный доп балл за роль');
        $this->sheet->setCellValue('E' . $line, 'Средний доп балл за игру');
        $this->sheet->setCellValue('F' . $line, 'Процент плюсовых доп баллов');
        $this->sheet->setCellValue('G' . $line, 'Среднее значение доп балла в выигранных играх');
        $this->sheet->setCellValue('H' . $line, 'Среднее значение доп балла в проигранных играх');
        $this->sheet->setCellValue('I' . $line, 'Количесто штрафов');
        $this->sheet->setCellValue('J' . $line, 'Количество пу');
        $this->sheet->setCellValue('K' . $line, 'Процент пу');
        $this->sheet->setCellValue('L' . $line, 'Дисперсия доп баллов');
        $this->sheet->setCellValue('M' . $line, 'Доп балл относительно среднего по команде');
        $this->sheet->setCellValue('N' . $line, 'количество игр');
        $this->sheet->setCellValue('O' . $line, 'Процент побед');
        $this->sheet->setCellValue('P' . $line, 'Суммарный доп балл за роль');
        $this->sheet->setCellValue('Q' . $line, 'Средний доп балл за игру');
        $this->sheet->setCellValue('R' . $line, 'Процент плюсовых доп баллов');
        $this->sheet->setCellValue('S' . $line, 'Среднее значение доп балла в выигранных играх');
        $this->sheet->setCellValue('T' . $line, 'Среднее значение доп балла в проигранных играх');
        $this->sheet->setCellValue('U' . $line, 'Количесто штрафов');
        $this->sheet->setCellValue('V' . $line, 'Дисперсия доп баллов');
        $this->sheet->setCellValue('W' . $line, 'Доп балл относительно среднего по команде');
        $this->sheet->setCellValue('X' . $line, 'Итог');
        $line++;
        $playerQuery = Player::find();
        foreach ($playerQuery->each() as $player) {
            $reportPlayer = new ReportPlayer($player);
            $result = $reportPlayer->getPlayerData();
            $this->sheet->setCellValue('A' . $line, $result['name']);
            $this->sheet->setCellValue('B' . $line, $result['red_count']);
            $this->sheet->setCellValue('C' . $line, $result['red_victory_percent']);
            $this->sheet->setCellValue('D' . $line, $result['red_dop_summ']);
            $this->sheet->setCellValue('E' . $line, $result['red_dop_avg']);
            $this->sheet->setCellValue('F' . $line, $result['red_dopPlus_percent']);
            $this->sheet->setCellValue('G' . $line, $result['red_dop_avg_victory']);
            $this->sheet->setCellValue('H' . $line, $result['red_dop_avg_lose']);
            $this->sheet->setCellValue('I' . $line, $result['red_penalty_counter']);
            $this->sheet->setCellValue('J' . $line, $result['red_pu']);
            $this->sheet->setCellValue('K' . $line, $result['red_pu_percent']);
            $this->sheet->setCellValue('L' . $line, $result['red_dop_disp']);
            $this->sheet->setCellValue('M' . $line, $result['red_avg_dop_by_avg_dop_everyone']);
            $this->sheet->setCellValue('N' . $line, $result['black_count']);
            $this->sheet->setCellValue('O' . $line, $result['black_victory_percent']);
            $this->sheet->setCellValue('P' . $line, $result['black_dop_summ']);
            $this->sheet->setCellValue('Q' . $line, $result['black_dop_avg']);
            $this->sheet->setCellValue('R' . $line, $result['black_dopPlus_percent']);
            $this->sheet->setCellValue('S' . $line, $result['black_dop_avg_victory']);
            $this->sheet->setCellValue('T' . $line, $result['black_dop_avg_lose']);
            $this->sheet->setCellValue('U' . $line, $result['black_penalty_counter']);
            $this->sheet->setCellValue('V' . $line, $result['black_dop_disp']);
            $this->sheet->setCellValue('W' . $line, $result['black_avg_dop_by_avg_dop_everyone']);
            $this->sheet->setCellValue('X' . $line, $result['result']);
            $line++;
        }

        $writer = new Xlsx($this->spreadsheet);
        $writer->save(\Yii::getAlias('@console/export.xlsx'));
    }
}