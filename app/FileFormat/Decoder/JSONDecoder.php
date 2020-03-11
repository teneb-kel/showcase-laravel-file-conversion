<?php


namespace App\FileFormat\Decoder;


class JSONDecoder implements DecoderInterface
{
    public function decode(string $data) : array
    {
        return json_decode($data, true);
    }
}
