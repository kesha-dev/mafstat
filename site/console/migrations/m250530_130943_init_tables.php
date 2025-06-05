<?php

use yii\db\Migration;

/**
 * Class m250530_130943_init_tables
 */
class m250530_130943_init_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('club', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment("Название"),
        ]);
        $this->insert('club', [
            'id' => 1,
            'name' => 'Cult',
        ]);
        $this->insert('club', [
            'id' => 2,
            'name' => 'Gatti',
        ]);
        $this->insert('club', [
            'id' => 3,
            'name' => 'Ktl',
        ]);

        $this->createTable('player', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Имя'),
            'club_id' => $this->integer()->comment('Клуб'),
        ]);
        $this->createIndex('club_id_idx', 'player', 'club_id');

        $this->createTable('game', [
            'id' => $this->primaryKey(),
            'date' => $this->string()->comment('Дата'),
            'num' => $this->integer()->comment('Номер'),
            'result' => $this->integer()->comment('Результат игры'),
        ]);
        $this->createTable('game_player', [
            'id' => $this->primaryKey(),
            'player_id' => $this->integer()->comment('Игрок'),
            'game_id' => $this->integer()->comment('Игра'),
            'result_string' => $this->integer()->comment('Результат х100'),
            'penalty_string' => $this->integer()->comment('Штраф х100'),
            'role' => $this->integer()->comment('Роль'),
            'pu' => $this->boolean()->comment('ПУ'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('club_id_idx', 'player');
        $this->dropTable('player');
        $this->dropTable('club');
        $this->dropTable('game');
        $this->dropTable('game_player');
    }
}