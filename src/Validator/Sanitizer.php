<?php declare(strict_types = 1);

namespace Converter\Validator;

final class Sanitizer
{
    const CSV_DELIMITER = ';';

    /**
     * @param array $formats
     * @return array
     */
    public static function sanitizeFormats(array $formats) : array
    {
        return array_map(function (string $format){
            return self::sanitizeFormat($format);
        }, $formats);
    }

    /**
     * @param string $format
     * @return string
     */
    public static function sanitizeFormat(string $format) : string
    {
        return mb_strtolower(trim($format));
    }
}
