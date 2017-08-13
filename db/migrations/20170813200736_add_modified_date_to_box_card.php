<?php

use Phinx\Migration\AbstractMigration;

class AddModifiedDateToBoxCard extends AbstractMigration
{
    public function change()
    {
        $this->table('box_card')
            ->addColumn('modified_date', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->update();
    }
}
