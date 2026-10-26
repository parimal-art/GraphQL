<?php
/**
 * File: app/code/Codilar/TodoApp/Model/Todo.php
 * The Model = ONE todo (one row of the table).
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model;

use Magento\Framework\Model\AbstractModel;

class Todo extends AbstractModel
{
    /**
     * Connect this model to its ResourceModel (the class that talks to the DB).
     */
    protected function _construct()
    {
        $this->_init(\Codilar\TodoApp\Model\ResourceModel\Todo::class);
    }

    /**
     * Turns this todo into a simple array.
     * The keys must match the field names in schema.graphqls.
     * All resolvers use this one method, so we write it only once.
     */
    public function toGraphQlArray(): array
    {
        return [
            'id'          => (int) $this->getId(),
            'title'       => $this->getData('title'),
            'description' => $this->getData('description'),
            'completed'   => (bool) $this->getData('is_completed'),
            'created_at'  => $this->getData('created_at'),
        ];
    }
}
