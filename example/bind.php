<?php

use IquxByte\ContainerDI;

require_once '../src/__autoload.php';
require_once 'class.php';

/**
 * Simple bind class to container
 */
ContainerDI::bind(Foo::class);

/**
 * bind with custom name
 */
ContainerDI::bind('class.foo', Foo::class);

/**
 * use closure to bind
 */
ContainerDI::bind(Foo::class, function ($containerDI) {
    return new Foo;
});

/**
 * bind class with interface to container
 */
ContainerDI::bind(FooBarContract::class, FooBar::class);

/**
 * Get instance
 */
$instance = ContainerDI::make(FooBar::class);

/**
 * Get class from interface
 */
$instance = ContainerDI::make(FooBarContract::class);

/**
 * Singleton class to container
 */
ContainerDI::singleton(Bar::class);

/**
 * Test singleton
 */
var_dump(ContainerDI::make(Bar::class) === ContainerDI::make(Bar::class));

/**
 * Test bind
 */
var_dump(ContainerDI::make(FooBarContract::class) === ContainerDI::make(FooBarContract::class));
