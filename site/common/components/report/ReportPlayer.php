<?php

namespace common\components\report;

use common\models\Game;
use common\models\GamePlayer;
use common\models\Player;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\base\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportPlayer extends Component
{
    private ?Player $player;

    public function __construct(Player $player, $config = [])
    {
        $this->player = $player;
        parent::__construct($config);
    }

    /*
         * Имя name
         * количество игр за красного red_count
         * Процент побед red_victory_percent
         * Суммарный доп балл за роль red_dop_summ
         * Средний доп балл за игру red_dop_avg
         * Процент плюсовых доп баллов red_dopPlus_percent
         * Среднее значение доп балла в выигранных играх red_dop_avg_victory
         * Среднее значение доп балла в проигранных играх red_dop_avg_lose
         * Количесто штрафов red_penalty_counter
         * Количество пу red_pu
         * Процент пу red_pu_percent
         * Дисперсия доп баллов red_dop_disp
         * Доп балл относительно среднего по команде red_avg_dop_by_avg_dop_everyone

          ЧЕРНЫЙ
         * количество игр black_count
         * Процент побед black_victory_percent
         * Суммарный доп балл за роль black_dop_summ
         * Средний доп балл за игру black_dop_avg
         * Процент плюсовых доп баллов black_dopPlus_percent
         * Среднее значение доп балла в выигранных играх black_dop_avg_victory
         * Среднее значение доп балла в проигранных играх black_dop_avg_lose
         * Количесто штрафов black_penalty_counter
         * Дисперсия доп баллов black_dop_disp
         * Доп балл относительно среднего по команде black_avg_dop_by_avg_dop_everyone
         * Итог result
         */
    public function getPlayerData()
    {
        $data = [];
        $data['name'] = $this->player->name;
        $gamePlayerAllQuery = GamePlayer::find()->where(['role' => [GamePlayer::ROLE_MIR, GamePlayer::ROLE_SHER]]);
        $summDopByEveryone = 0;
        foreach ($gamePlayerAllQuery->each() as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MIR ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $summDopByEveryone += $gameDop;
        }
        if ($gamePlayerAllQuery->count() != 0) {
            $avgDopByEveryone = number_format($summDopByEveryone / $gamePlayerAllQuery->count(), 2);
        } else {
            $avgDopByEveryone = 0;
        }


        $gamePlayerList = GamePlayer::find()
            ->where(['player_id' => $this->player->id, 'role' => [GamePlayer::ROLE_MIR, GamePlayer::ROLE_SHER]])
            ->all();

        $data['red_count'] = count($gamePlayerList);

        $victoryCounter = 0;
        $dopSumm = 0;
        $dopPlusCounter = 0;
        $dopSummVictory = 0;
        $dopSummLose = 0;
        $penaltyCounter = 0;
        $puCounter = 0;
        foreach ($gamePlayerList as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MIR ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $victoryCounter += $gameResult;
            $dopSumm += $gameDop;
            $dopPlusCounter += ($gameDop > 0) ? 1 : 0;
            if ($gameResult) {
                $dopSummVictory += $gameDop;
            } else {
                $dopSummLose += $gameDop;
            }
            $penaltyCounter += $gamePlayer->penalty_string ? 1 : 0;
            $puCounter += $gamePlayer->pu ? 1 : 0;
        }
        if ($data['red_count'] != 0) {
            $data['red_victory_percent'] = (number_format($victoryCounter / $data['red_count'] * 100, 2)) . '%';
        } else {
            $data['red_victory_percent'] = 0;
        }

        $data['red_dop_summ'] = $dopSumm;
        if ($data['red_count'] != 0) {
            $data['red_dop_avg'] = number_format($dopSumm / $data['red_count'], 2);
        } else {
            $data['red_dop_avg'] = 0;
        }

        if ($data['red_count'] != 0) {
            $data['red_dopPlus_percent'] = number_format($dopPlusCounter / $data['red_count'] * 100, 2) . '%';
        } else {
            $data['red_dopPlus_percent'] = 0;
        }

        if ($victoryCounter != 0) {
            $data['red_dop_avg_victory'] = number_format($dopSummVictory / $victoryCounter, 2);
        } else {
            $data['red_dop_avg_victory'] = 0;
        }

        if ($data['red_count'] - $victoryCounter != 0) {
            $data['red_dop_avg_lose'] = number_format($dopSummLose / ($data['red_count'] - $victoryCounter), 2);
        } else {
            $data['red_dop_avg_lose'] = 0;
        }

        $data['red_penalty_counter'] = $penaltyCounter;
        $data['red_pu'] = $puCounter;
        if ($data['red_count'] != 0) {
            $data['red_pu_percent'] = number_format($puCounter / $data['red_count'] * 100, 2) . '%';
        } else {
            $data['red_pu_percent'] = 0;
        }


        $squareDispSumm = 0;
        foreach ($gamePlayerList as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MIR ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $squareDispSumm += ($gameDop - $data['red_dop_avg']) * ($gameDop - $data['red_dop_avg']);
        }
        if (($data['red_count'] - 1) != 0) {
            $data['red_dop_disp'] = $squareDispSumm / ($data['red_count'] - 1);
        } else {
            $data['red_dop_disp'] = 0;
        }
        $data['red_avg_dop_by_avg_dop_everyone'] = $data['red_dop_avg'] - $avgDopByEveryone;

        $gamePlayerAllQuery = GamePlayer::find()->where(['role' => [GamePlayer::ROLE_MAF, GamePlayer::ROLE_DON]]);
        $summDopByEveryone = 0;
        foreach ($gamePlayerAllQuery->each() as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MAF ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $summDopByEveryone += $gameDop;
        }

        if ($gamePlayerAllQuery->count() != 0) {
            $avgDopByEveryone = number_format($summDopByEveryone / $gamePlayerAllQuery->count(), 2);
        } else {
            $avgDopByEveryone = 0;
        }

        $gamePlayerList = GamePlayer::find()
            ->where(['player_id' => $this->player->id, 'role' => [GamePlayer::ROLE_MAF, GamePlayer::ROLE_DON]])
            ->all();
        $data['black_count'] = count($gamePlayerList);

        $victoryCounter = 0;
        $dopSumm = 0;
        $dopPlusCounter = 0;
        $dopSummVictory = 0;
        $dopSummLose = 0;
        $penaltyCounter = 0;
        $puCounter = 0;
        foreach ($gamePlayerList as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MAF ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $victoryCounter += $gameResult;
            $dopSumm += $gameDop;
            $dopPlusCounter += ($gameDop > 0) ? 1 : 0;
            if ($gameResult) {
                $dopSummVictory += $gameDop;
            } else {
                $dopSummLose += $gameDop;
            }
            $penaltyCounter += $gamePlayer->penalty_string ? 1 : 0;
            $puCounter += $gamePlayer->pu ? 1 : 0;
        }
        if ($data['black_count'] != 0) {
            $data['black_victory_percent'] = (number_format($victoryCounter / $data['black_count'] * 100, 2)) . '%';
        } else {
            $data['black_victory_percent'] = 0;
        }

        $data['black_dop_summ'] = $dopSumm;
        if ($data['black_count'] != 0) {
            $data['black_dop_avg'] = number_format($dopSumm / $data['black_count'], 2);
        } else {
            $data['black_dop_avg'] = 0;
        }

        if ($data['black_count'] != 0) {
            $data['black_dopPlus_percent'] = number_format($dopPlusCounter / $data['black_count'] * 100, 2) . '%';
        } else {
            $data['black_dopPlus_percent'] = 0;
        }

        if ($victoryCounter != 0) {
            $data['black_dop_avg_victory'] = number_format($dopSummVictory / $victoryCounter, 2);
        } else {
            $data['black_dop_avg_victory'] = 0;
        }

        if ($data['black_count'] - $victoryCounter != 0) {
            $data['black_dop_avg_lose'] = number_format($dopSummLose / ($data['black_count'] - $victoryCounter), 2);
        } else {
            $data['black_dop_avg_lose'] = 0;
        }

        $data['black_penalty_counter'] = $penaltyCounter;

        $squareDispSumm = 0;
        foreach ($gamePlayerList as $gamePlayer) {
            $gameResult = $gamePlayer->game->result == Game::RESULT_MAF ? 1 : 0;
            $gameDop = $gamePlayer->result - $gameResult;
            $squareDispSumm += ($gameDop - $data['black_dop_avg']) * ($gameDop - $data['black_dop_avg']);
        }
        if ($data['black_count'] - 1 != 0) {
            $data['black_dop_disp'] = $squareDispSumm / ($data['black_count'] - 1);
        } else {
            $data['black_dop_disp'] = 0;
        }

        $data['black_avg_dop_by_avg_dop_everyone'] = $data['black_dop_avg'] - $avgDopByEveryone;

        $allPlayersGame = GamePlayer::find()->where(['player_id' => $this->player->id])->all();
        $summBall = 0;
        foreach ($allPlayersGame as $gamePlayer) {
            $summBall += $gamePlayer->result;
        }
        $data['result'] = $summBall;
        return $data;
    }
}