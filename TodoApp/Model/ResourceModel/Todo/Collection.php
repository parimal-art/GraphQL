<?php
/**
 * File: app/code/Codilar/TodoApp/Model/ResourceModel/Todo/Collection.php
 * The Collection = a LIST of todos (many rows).
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\ResourceModel\Todo;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * First value  = Model class, second value = ResourceModel class
     */
    protected function _construct()
    {
        $this->_init(
            \Codilar\TodoApp\Model\Todo::class,
            \Codilar\TodoApp\Model\ResourceModel\Todo::class
        );
    }
}
