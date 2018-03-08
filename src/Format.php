<?php declare(strict_types = 1);

namespace Converter;

use Converter\Encoder\{
    Encoder, TextEncoder, HTMLEncoder, JsonEncoder, XMLEncoder
};
use Converter\Validator\Sanitizer;

final class Format
{
    /**
     * Todo: Make this configurable.
     *
     * @var array
     */
    private static $encoders = [
        'json' => JsonEncoder::class,
        'xml' =>  XMLEncoder::class,
        'html' => HTMLEncoder::class,
        'txt' => TextEncoder::class,
    ];

    /**
     * Todo: Make this configurable.
     *
     * @var array
     */
    public static $defaultFormats = ['xml', 'json'];

    /**
     * @param array $formats
     * @return array
     *
     * @throws \DomainException
     */
    public static function encoders(array $formats): array
    {
        $formats = empty($formats) ? Format::$defaultFormats : $formats;

        return array_map(function($format){
            return self::encoderFor($format);
        }, Sanitizer::sanitizeFormats($formats));
    }

    /**
     * @param string $format
     * @return mixed
     *
     * @throws \DomainException
     */
    public static function encoderFor(string $format): Encoder
    {
        if (!isset(self::$encoders[$format])) {
            throw new \DomainException(sprintf('Encoder class not found for %s', $format));
        }

        return new self::$encoders[$format]();
    }

    /**
     * @param string $fileName
     * @param string $extension
     * @return string
     */
    public static function formattedFileName(string $fileName, string $extension): string
    {
        $fileName = substr($fileName, 0, strpos($fileName, '.'));

        return sprintf('%s.%s', $fileName, Sanitizer::sanitizeFormat($extension));
    }
}
