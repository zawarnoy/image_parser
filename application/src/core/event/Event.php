<?php

namespace Application\Src\Core\Event;

class Event
{
    protected static $events = [];

    /**
     * @param string $eventName
     * @param EventData $eventData
     */
    public static function attach(string $eventName, EventData $eventData)
    {
        if (!isset(self::$events[$eventName])) {
            self::$events[$eventName] = [];
        }

        self::$events[$eventName][] = $eventData;
    }

    /**
     * @param string $eventName
     * @param $params
     */
    public static function trigger(string $eventName, ...$params)
    {
        if (empty(self::$events[$eventName])) {
            return;
        }

        /** @var EventData $eventData */
        foreach (self::$events[$eventName] as $eventData) {
            if (is_callable($callback = $eventData->getMethodInstance())) {
                call_user_func_array($callback, $params);
            }
        }
    }
}