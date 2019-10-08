<?php


namespace MedeirosDev\WeatherHereDeveloper;


class Helper
{
    private function __construct() {}

    public static function existsConstInClassByValue(string $class, string $constValue): bool
    {
        return in_array($constValue, self::getClassConstants($class));
    }

    public static function getClassConstants(string $class): array
    {
        try {
            return (new \ReflectionClass($class))->getConstants();
        } catch (\Exception $e) {}

        return [];
    }

    public static function camelCase(string $str, array $noStrip = []): string
    {
        $str = Normalizer::normalize($str, Normalizer::FORM_D);

        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }

    public static function booleanToString($value)
    {
        return ($value) ? 'true' : 'false';
    }

    public static function getFramework(): string
    {
        if (class_exists('\Illuminate\Support\Facades\Artisan')) {

            \Illuminate\Support\Facades\Artisan::call('help',['--version']);
            $output = \Illuminate\Support\Facades\Artisan::output();

            if (strpos($output, 'Laravel') >= 0) {
                return 'Laravel';
            }
        }

        return false;
    }

    public static function isLatitudeAndLongitude(string $string): bool
    {
        $latitudeLongitude = self::getLatitudeAndLongitude($string);
        $latitude = $latitudeLongitude[0];
        $longitude = $latitudeLongitude[1] ?? null;

        return self::validateLatitude($latitude) && self::validateLongitude($longitude);
    }

    public static function getLatitudeAndLongitude(string $latitudeAndLongitude): array
    {
        $delimiter = preg_match('/[\;\,\s]/', $latitudeAndLongitude, $delimiters) ? $delimiters[0] : ';';
        $latitudeLongitude = explode($delimiter, $latitudeAndLongitude);

        $latitudeLongitude[1] = $latitudeLongitude[1] ?? '';

        return $latitudeLongitude;
    }

    public static function validateLatitude(string $latitude): bool {
        return (bool) preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', trim($latitude));
    }

    public static function validateLongitude(string $longitude): bool {
        return (bool) preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/', trim($longitude));
    }

    public static function isZipcode(string $zipcode): bool
    {
        return strlen($zipcode) <= 20 && strlen(preg_replace('/[^0-9]/', '', $zipcode)) >= 6;
    }
}