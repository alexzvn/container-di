<?php

namespace IquxByte;

use Closure;
use ReflectionParameter;
use IquxByte\Interfaces\Container;
use ReflectionClass;

class ContainerDI implements Container
{
    protected static $instances = [];

    protected static $singletonInstances = [];

    protected static $singletonContainer = [];

    /**
     * Bind $this class/interface to container
     */
    public function __construct() {

        $self = new ReflectionClass(get_class($this));

        foreach ($self->getInterfaces() as $interface) {
            self::bind($interface->name, get_class($this));
        }
    }

    public static function bind($abstract, $class = null)
    {
        if ($class === null) {
            $class = $abstract;
        }

        self::$instances[$abstract] = $class;
    }

    public static function singleton($abstract, $class = null)
    {
        if ($class === null) {
            $class = $abstract;
        }

        self::$singletonInstances[$abstract] = $class;
    }

    public static function make(string $abstract, $parameter = [])
    {
        if (isset(self::$singletonInstances[$abstract])) {
            if (isset(self::$singletonContainer[$abstract])) {
                return self::$singletonContainer[$abstract];
            }

            return self::$singletonContainer[$abstract] = self::resolve(self::$singletonInstances[$abstract], $parameter);
        }

        if (! isset(self::$instances[$abstract])) {
            self::bind($abstract);
        }

        return self::resolve(self::$instances[$abstract], $parameter);
    }

    public static function resolve($concrete, $parameter = [])
    {
        if ($concrete instanceof Closure) {
            return $concrete(new self, $parameter);
        }

        $reflector = new \ReflectionClass($concrete);

        if (! $reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        return $reflector->newInstanceArgs(
            self::resolveDependencies($constructor->getParameters())
        );
    }

    public static function alias(string $original, string $alias, bool $autoload = true)
    {
        return class_alias($original, $alias, $autoload);
    }

    protected static function resolveDependencies(array $parameters = [])
    {
        foreach ($parameters as $parameter) {
            $dependencies[] = self::resolveDependency($parameter);
        }

        return $dependencies ?? [];
    }

    private static function resolveDependency(ReflectionParameter $parameter)
    {
        $dependency = $parameter->getClass();

        if (is_null($dependency)) {
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            } else {
                throw new \Exception("Can not resolve dependency {$parameter->name}");
            }
        }

        return self::make($dependency->name);
    }
}
