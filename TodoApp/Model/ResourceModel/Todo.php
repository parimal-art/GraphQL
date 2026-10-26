<?php
/**
 * File: app/code/Codilar/TodoApp/Model/ResourceModel/Todo.php
 * The ResourceModel = talks to the database table (load, save, delete).
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Todo extends AbstractDb
{
    /**
     * First value  = table name (same as in db_schema.xml)
     * Second value = primary key column
     */
    protected function _construct()
    {
        $this->_init('codilar_todoapp_todo', 'todo_id');
    }
}
