<?php


namespace MedeirosDev\WeatherHereDeveloper;


class Helper
{
    private function __construct() {}

    public static function existsConstInClassByValue(string $class, string $constValue): bool
    {
        return in_array($constValue, self::existsConstInClassByValue($class));
    }

    public static function getClassConstants(string $class): array
    {
        try {
            return (new \ReflectionClass($class))->getConstants();
        } catch (\Exception $e) {}

        return [];
    }
}