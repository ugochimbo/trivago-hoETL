<?php declare(strict_types = 1);

namespace Converter\Validator;

interface RecordValidator
{
    const NAME_ENCODING_FORMAT = 'ASCII';

    /**
     * @param array $record
     * @return bool
     */
    public function isValid(array $record) : bool;
}
