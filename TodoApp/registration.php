<?php
/**
 * File: app/code/Codilar/TodoApp/registration.php
 * Tells Magento that the module "Codilar_TodoApp" exists.
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Codilar_TodoApp',
    __DIR__
);
