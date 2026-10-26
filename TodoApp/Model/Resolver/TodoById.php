<?php
/**
 * File: app/code/Codilar/TodoApp/Model/Resolver/TodoById.php
 * READ (one): returns one todo using its id.
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\Resolver;

use Codilar\TodoApp\Model\ResourceModel\Todo as TodoResource;
use Codilar\TodoApp\Model\TodoFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class TodoById implements ResolverInterface
{
    private TodoFactory $todoFactory;
    private TodoResource $todoResource;

    public function __construct(TodoFactory $todoFactory, TodoResource $todoResource)
    {
        $this->todoFactory = $todoFactory;
        $this->todoResource = $todoResource;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        // 1. Make an empty todo and load the data from the database
        $todo = $this->todoFactory->create();
        $this->todoResource->load($todo, $args['id']);

        // 2. If nothing was found, show an error
        if (!$todo->getId()) {
            throw new GraphQlNoSuchEntityException(
                __('Todo with id "%1" does not exist.', $args['id'])
            );
        }

        return $todo->toGraphQlArray();
    }
}
