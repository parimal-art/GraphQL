<?php
/**
 * File: app/code/Codilar/TodoApp/Model/Resolver/Todos.php
 * READ (all): returns the list of all todos.
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\Resolver;

use Codilar\TodoApp\Model\ResourceModel\Todo\CollectionFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Todos implements ResolverInterface
{
    private CollectionFactory $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        // Create a collection (list) and sort by id
        $collection = $this->collectionFactory->create();
        $collection->setOrder('todo_id', 'ASC');

        // Convert every todo to a simple array
        $result = [];
        foreach ($collection as $todo) {
            $result[] = $todo->toGraphQlArray();
        }

        return $result;
    }
}
