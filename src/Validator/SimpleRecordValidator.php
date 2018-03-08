<?php declare(strict_types = 1);

namespace Converter\Validator;

final class SimpleRecordValidator implements RecordValidator
{
    /**
     * @var bool
     */
    private $displayErrors;

    /**
     * @param bool $displayErrors
     */
    public function __construct(bool $displayErrors = false)
    {
        $this->displayErrors = $displayErrors;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(array $record) : bool
    {
        return $this->isValidHotelName($record['name'])
            && $this->isValidRating(floatval($record['stars']))
            && $this->isValidUri($record['uri']);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function isValidHotelName(string $name) : bool
    {
        if (!mb_check_encoding($name, self::NAME_ENCODING_FORMAT)) {
            $this->printError(sprintf('Name: "%s" is invalid (contains non-ascii characters).', $name));

            return false;
        }

        return true;
    }

    /**
     * @param float $rating
     * @return bool
     */
    private function isValidRating(float $rating) : bool
    {
        if ($rating < 0 || $rating > 5) {
            $this->printError(sprintf('Star rating: "%s" in invalid (negative or greater than 5).', $rating));

            return false;
        }

        return true;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isValidUri(string $url) : bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->printError(sprintf('URL: "%s" in invalid.', $url));

            return false;
        }

        return true;
    }

    /**
     * @param string $message
     *
     */
    private function printError(string $message)
    {
        if (!$this->displayErrors) {
            return;
        }

        echo $message . PHP_EOL;
    }
}
