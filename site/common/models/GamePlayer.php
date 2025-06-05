<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "game_player".
 *
 * @property int $id
 * @property int $player_id Игрок
 * @property int $game_id Игра
 * @property int $result_string Результат х100
 * @property int $penalty_string Штраф х100
 * @property int $role Роль
 * @property int $pu ПУ
 * @property-write $result
 * @property-write $roleByCode
 * @property-write $puByCode
 */
class GamePlayer extends ActiveRecord
{
    public const ROLE_MIR = 0;
    public const ROLE_DON = 1;
    public const ROLE_MAF = 2;
    public const ROLE_SHER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'game_player';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['player_id', 'game_id', 'result_string', 'penalty_string', 'role',], 'integer'],
            [['pu'], 'boolean'],
            [['pu'], 'default', 'value' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'player_id' => 'Игрок',
            'game_id' => 'Игра',
            'result_string' => 'Результат х100',
            'penalty_string' => 'Штраф х100',
            'role' => 'Роль',
            'pu' => 'ПУ',
        ];
    }

    public static function createOrFindGamePlayer($gameId, $playerId): ?GamePlayer
    {
        $gamePlayer = GamePlayer::findOne([
            'player_id' => $playerId,
            'game_id' => $gameId,
        ]);
        if (!$gamePlayer) {
            $gamePlayer = new GamePlayer([
                'player_id' => $playerId,
                'game_id' => $gameId,
            ]);
            $gamePlayer->save();
        }
        return $gamePlayer;
    }

    public function setResult($value)
    {
        $this->result_string = $value * 100;
    }

    public function getResult()
    {
        return $this->result_string / 100;
    }

    public function setRoleByCode($value)
    {
        $this->role = match ($value) {
            'FFFFFF' => self::ROLE_MIR,
            '000000' => self::ROLE_DON,
            'BFBFBF' => self::ROLE_MAF,
            'FFC000' => self::ROLE_SHER,
            default => null,
        };
    }

    public function setPuByCode($value)
    {
        $this->pu = match ($value) {
            'FFFF0000' => true,
            'FF000000' => false,
            default => false,
        };
    }

    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['id' => 'player_id']);
    }

    public function getGame()
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }
}