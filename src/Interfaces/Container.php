<?php

namespace IquxByte\Interfaces;

interface Container
{
    /**
     * Register class or interface to container
     *
     * @param string|object $abstract
     * @param string|object|\Closure $class
     * @return void
     */
    public static function bind($abstract, $class = null);

    /**
     * Register class or interface to container
     * and should resolve one time
     *
     * @param string|object $abstract
     * @param string|object|\Closure $class
     * @return void
     */
    public static function singleton($abstract, $class = null);

    /**
     * Get instance from container
     *
     * @param string $abstract
     * @param array $parameter
     * @return mixed|object
     */
    public static function make(string $abstract, $parameter = []);

    public static function resolve($concrete, $parameter = []);

    public static function alias(string $original, string $alias, bool $autoload = true);
}
