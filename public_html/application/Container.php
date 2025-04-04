<?php

namespace App;

class Container
{
    protected array $bindings = [];

    public function set(string $abstract, callable $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $abstract): mixed
    {
        if (!isset($this->bindings[$abstract])) {
            return new $abstract(); // Простейший fallback
        }

        return $this->bindings[$abstract]($this);
    }
}