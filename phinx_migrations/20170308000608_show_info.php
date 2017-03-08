<?php

use Phinx\Migration\AbstractMigration;

class ShowInfo extends AbstractMigration
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
        $programInfo = $this->table('programinfo');
        $programInfo
            ->addColumn('show_id',        'integer')
            ->addIndex(array('show_id'))
            ->save();

        $showInfo = $this->table('showinfo');
        $showInfo
            ->addColumn('title',            'string',       array('limit' => 255))
            ->addColumn('description',      'text',         array('null' => true))
            ->addColumn('tvdbdesc',         'text',         array('null' => true))
            ->addColumn('showtype',         'string',       array('limit' => 255, 'null' => true))
            ->addColumn('showimage',        'string',       array('limit' => 255, 'null' => true))
            ->addColumn('website',          'string',       array('limit' => 255, 'null' => true))
            ->addColumn('imdb_id',          'string',       array('limit' => 255, 'null' => true))
            ->addColumn('imdb_rating',      'float',        array('null' => true))
            ->addColumn('tomato_rating',    'float',        array('null' => true))
            ->addColumn('date_created',     'datetime')
            ->addColumn('date_updated',     'datetime',     array('null' => true))

            ->addIndex(array('imdb_id'), array('unique' => true))
            ->addIndex(array('title',   'imdb_id', 'imdb_rating', 'tomato_rating', 'showtype'))
            ->save();
    }
}
