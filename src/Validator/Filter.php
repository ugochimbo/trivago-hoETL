<?php declare(strict_types = 1);

namespace Converter\Validator;

final class Filter
{
    /**
     * @param RecordValidator $recordValidator
     * @param array $records
     * @return array
     */
    public static function validRecords(RecordValidator $recordValidator, array $records) : array
    {
        return array_filter($records, function ($record) use ($recordValidator)  {
            return $recordValidator->isValid($record);
        });
    }
}
