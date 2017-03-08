<?php

use Phinx\Migration\AbstractMigration;

class ExtraShowFields extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $showInfo = $this->table('showinfo');
        $showInfo
            ->addColumn('genre',             'string',       array('limit' => 255, 'after'=>'title', 'null' => true))
            ->addColumn('director',          'string',       array('limit' => 255, 'after'=>'title', 'null' => true))
            ->addColumn('actors',            'string',       array('limit' => 255, 'after'=>'title', 'null' => true))
            ->addColumn('awards',            'string',       array('limit' => 255, 'after'=>'title', 'null' => true))
            ->addIndex(array('genre', 'actors'))
            ->save();
    }
}
