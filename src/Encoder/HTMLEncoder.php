<?php declare(strict_types = 1);

namespace Converter\Encoder;

final class HTMLEncoder implements Encoder
{
    const FORMAT = 'html';
    const SIMPLE_TEMPLATE = "<html><body><ul>%s</ul></body></body></html>";

    /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return self::FORMAT;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(array $records): string
    {
        $data = '';

        foreach ($records as $record) {
            $data = $this->formatRecordHtml($record, $data);
        }

        return sprintf(self::SIMPLE_TEMPLATE, $data);
    }

    /**
     * @param array $record
     * @param string $data
     * @return string
     */
    private function formatRecordHtml(array $record, string $data): string
    {
        foreach ($record as $key => $value) {
            $data .= sprintf("<li>%s : %s</li>", $key, $record[$key]);
        }

        if (!empty($data)) {
            $data .= '<br />';
        }

        return $data;
    }
}
