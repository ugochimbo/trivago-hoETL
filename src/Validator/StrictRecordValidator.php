<?php declare(strict_types = 1);

namespace Converter\Validator;

final class StrictRecordValidator implements RecordValidator
{
    /**
     * {@inheritdoc}
     */
    public function isValid(array $record): bool
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
            $this->exit(sprintf('Name: "%s" is invalid (contains non-ascii characters).', $name));
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
            $this->exit(sprintf('Star rating: "%s" in invalid (negative or greater than 5).', $rating));
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
            $this->exit(sprintf('URL: "%s" in invalid.', $url));
        }

        return true;
    }

    /**
     * @param string $message
     *
     * @throws \DomainException
     */
    private function exit(string $message)
    {
        throw new \DomainException($message);
    }
}
