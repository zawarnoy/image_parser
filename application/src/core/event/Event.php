<?php

namespace Application\Src\Core\Event;

use ArrayObject;

class Event
{
    protected static $events = [];

    /**
     * @param string $eventName
     * @param callable $callback
     *
     */
    public static function attach(string $eventName, Callable $callback)
    {
        if (!isset(self::$events[$eventName])) {
            self::$events[$eventName] = [];
        }

        self::$events[$eventName][] = $callback;
    }

    /**
     * @param string $eventName
     * @param ArrayObject $params
     */
    public static function trigger(string $eventName, ArrayObject $params)
    {
        if (empty(self::$events[$eventName])) {
            return;
        }

        foreach (self::$events[$eventName] as $callback) {
            $callback($params);
        }
    }
}