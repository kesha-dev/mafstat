<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property string $date Дата
 * @property int $num Номер
 * @property int $result Результат игры
 */
class Game extends ActiveRecord
{
    public const RESULT_MIR = 0;
    public const RESULT_MAF = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['num', 'result'], 'integer'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'num' => 'Номер',
            'result' => 'Результат игры',
            'resultName' => 'Результат игры',
        ];
    }

    public static function createOrFindGame($date, $num): ?Game
    {
        $game = Game::findOne(['date' => $date, 'num' => $num]);
        if (!$game) {
            $game = new Game([
                'date' => $date,
                'num' => $num,
            ]);
            $game->save();
        }
        return $game;
    }

    public static function getResultList()
    {
        return [
            self::RESULT_MIR => 'Красные',
            self::RESULT_MAF => 'Чёрные',
        ];
    }

    public function getResultName()
    {
        return self::getResultList()[$this->result];
    }
}