<?php


namespace App\FileFormat\Encoder;


class EncoderFactory
{
    const ENCODERS = [
        'json' => JSONEncoder::class,
        'xml' => XMLEncoder::class,
        'csv' => CSVEncoder::class
    ];

    public static function getInstance(string $format) : EncoderInterface
    {
        if (isset(self::ENCODERS[strtolower($format)]))
            $encoder = self::ENCODERS[strtolower($format)];
        else // Fall back to JSON
            $encoder = self::ENCODERS['json'];

        return new $encoder();
    }
}
