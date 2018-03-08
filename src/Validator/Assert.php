<?php declare(strict_types = 1);

namespace Converter\Validator;

final class Assert
{
    /**
     * Todo: Use custom exceptions (in methods below as well)
     *
     * @param string $fileName
     * @return bool
     *
     * @throws \DomainException
     */
    public static function isCsvFile(string $fileName): bool
    {
        if (pathinfo($fileName)['extension'] !== 'csv') {
            throw new \DomainException(sprintf('Input file %s is not a csv file', $fileName));
        };

        return true;
    }

    /**
     * @param string $fileName
     * @return bool
     *
     * @throws \RuntimeException
     */
    public static function isValidFile(string $fileName): bool
    {
        self::fileExists($fileName);
        self::isRegularFile($fileName);
        self::fileIsReadable($fileName);

        return true;
    }

    /**
     * @param string $fileName
     *
     * @throws \RuntimeException
     */
    private static function fileExists(string $fileName): void
    {
        if (!file_exists($fileName)) {
            throw new \RuntimeException(sprintf('Input file %s does not exist', $fileName));
        }
    }

    /**
     * @param string $fileName
     *
     * @throws \RuntimeException
     */
    private static function isRegularFile(string $fileName): void
    {
        if (!is_file($fileName)) {
            throw new \RuntimeException(sprintf('Input file path %s is not a regular file', $fileName));
        }
    }

    /**
     * @param string $fileName
     *
     * @throws \RuntimeException
     */
    private static function fileIsReadable(string $fileName): void
    {
        if (!is_readable($fileName)) {
            throw new \RuntimeException(sprintf('Input file %s is not readable', $fileName));
        }
    }
}
