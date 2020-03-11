<?php


namespace App\FileFormat\Encoder;


class JSONEncoder implements EncoderInterface
{
    public function encode(array $data) : string
    {
        return json_encode($data);
    }

    public function getMime() : string
    {
        return "application/json";
    }

    public function getFileExtension() : string
    {
        return "json";
    }
}
