<?php

class Foo
{
    public $randomNumber;

    public function __construct() {
        $this->randomNumber = rand();
    }
}

class Bar extends Foo
{
    public $foo;

    public function __construct(Foo $foo) {
        $this->foo = $foo;
    }
}

interface FooBarContract
{
    /**
     * Get random number
     *
     * @return int
     */
    public function sayNumber();
}

class FooBar implements FooBarContract
{
    protected $bar;

    public function __construct(Bar $bar) {
        $this->bar = $bar;
    }

    public function sayNumber()
    {
        echo "Number is {$this->bar->foo->randomNumber} \n";
    }
}
