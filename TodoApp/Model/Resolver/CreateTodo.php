<?php
/**
 * File: app/code/Codilar/TodoApp/Model/Resolver/CreateTodo.php
 * CREATE: adds a new todo to the database.
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\Resolver;

use Codilar\TodoApp\Model\ResourceModel\Todo as TodoResource;
use Codilar\TodoApp\Model\TodoFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreateTodo implements ResolverInterface
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
        // 1. Title must not be empty
        $title = trim((string) $args['title']);
        if ($title === '') {
            throw new GraphQlInputException(__('Title cannot be empty.'));
        }

        // 2. Make a new todo and set its data
        $todo = $this->todoFactory->create();
        $todo->setData('title', $title);
        $todo->setData('description', $args['description'] ?? null);
        $todo->setData('is_completed', 0);

        // 3. Save to the database
        $this->todoResource->save($todo);

        // 4. Load again so created_at (set by the database) is included
        $this->todoResource->load($todo, $todo->getId());

        return $todo->toGraphQlArray();
    }
}
