<?php


namespace App\FileFormat\Decoder;


class DecoderFactory
{
    const DECODERS = [
        'json' => JSONDecoder::class,
        'xml' => XMLDecoder::class,
        'csv' => CSVDecoder::class
    ];

    public static function getInstance($format) : DecoderInterface
    {
        if (isset(self::DECODERS[strtolower($format)]))
            $decoder = self::DECODERS[strtolower($format)];
        else // Fall back to JSON
            $decoder = self::DECODERS['application/json'];

        return new $decoder();
    }
}
