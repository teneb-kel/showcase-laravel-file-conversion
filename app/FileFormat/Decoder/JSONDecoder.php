<?php


namespace App\FileFormat\Decoder;


class JSONDecoder implements DecoderInterface
{
    public function decode($data)
    {
        return json_decode($data, true);
    }
}
