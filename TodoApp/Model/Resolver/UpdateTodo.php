<?php
/**
 * File: app/code/Codilar/TodoApp/Model/Resolver/UpdateTodo.php
 * UPDATE: changes an existing todo. Only the fields you send are changed.
 */
declare(strict_types=1);

namespace Codilar\TodoApp\Model\Resolver;

use Codilar\TodoApp\Model\ResourceModel\Todo as TodoResource;
use Codilar\TodoApp\Model\TodoFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class UpdateTodo implements ResolverInterface
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
        // 1. Find the existing todo
        $todo = $this->todoFactory->create();
        $this->todoResource->load($todo, $args['id']);

        if (!$todo->getId()) {
            throw new GraphQlNoSuchEntityException(
                __('Todo with id "%1" does not exist.', $args['id'])
            );
        }

        // 2. Change only the fields that were sent
        if (array_key_exists('title', $args)) {
            $title = trim((string) $args['title']);
            if ($title === '') {
                throw new GraphQlInputException(__('Title cannot be empty.'));
            }
            $todo->setData('title', $title);
        }

        if (array_key_exists('description', $args)) {
            $todo->setData('description', $args['description']);
        }

        if (array_key_exists('completed', $args)) {
            $todo->setData('is_completed', $args['completed'] ? 1 : 0);
        }

        // 3. Save and return the updated todo
        $this->todoResource->save($todo);

        return $todo->toGraphQlArray();
    }
}
