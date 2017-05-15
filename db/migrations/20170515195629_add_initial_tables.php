<?php

use Phinx\Migration\AbstractMigration;

class AddInitialTables extends AbstractMigration
{
    public function change()
    {
        $this->addUserTable();
        $this->addBoxTable();
        $this->addCardTable();
        $this->addBoxCardTable();
    }

    private function addUserTable()
    {
        $this->table('user', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string')
            ->addIndex(['id'], ['unique' => true])
            ->addColumn('name', 'string')
            ->addColumn('password', 'string')
            ->addColumn('email', 'string')
            ->addIndex(['email'], ['unique' => true])
            ->save();
    }

    private function addBoxTable()
    {
        $table = $this->table('box', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'string')
            ->addIndex(['id'], ['unique' => true])
            ->addColumn('user_id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('section', 'integer')
            ->save();
    }

    private function addCardTable()
    {
        $this->table('card', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string')
            ->addIndex(['id'], ['unique' => true])
            ->addColumn('obverse', 'string')
            ->addColumn('reverse', 'string')
            ->save();
    }

    private function addBoxCardTable()
    {
        $table = $this->table('box', ['id' => false, 'primary_key' => 'id']);

        $table->addColumn('box_id', 'string')
            ->addColumn('card_id', 'string')
            ->save();
    }
}
