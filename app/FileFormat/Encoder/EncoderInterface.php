<?php


namespace App\FileFormat\Encoder;


interface EncoderInterface
{
    public function encode(array $data) : string;

    public function getMime() : string;

    public function getFileExtension() : string;
}
