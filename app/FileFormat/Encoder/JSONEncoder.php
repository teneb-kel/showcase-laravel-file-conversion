<?php


namespace App\FileFormat\Encoder;


class JSONEncoder implements EncoderInterface
{
    public function encode($data)
    {
        return json_encode($data);
    }

    public function getMime()
    {
        return "application/json";
    }

    public function getFileExtension()
    {
        return "json";
    }
}
