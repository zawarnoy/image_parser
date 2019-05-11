<?php

namespace Application\Src\Core\Event;

class EventData
{
    protected $class;
    protected $method;

    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
    }

    public function getMethodInstance()
    {
        return $this->class . '::' . $this->method;
    }
}