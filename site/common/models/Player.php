<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "player".
 *
 * @property int $id
 * @property string $name Имя
 * @property int $club_id Клуб
 */
class Player extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'player';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['club_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'club_id' => 'Клуб',
        ];
    }

    public static function createOrFindPlayer($playerName): ?Player
    {
        $player = Player::findOne(['name' => $playerName]);
        if (!$player) {
            $player = new Player(['name' => $playerName]);
            $player->save();
        }
        return $player;
    }

    public function getClub()
    {
        return $this->hasOne(Club::class, ['id' => 'club_id']);
    }
}