<?php


namespace App\FileFormat\Encoder;


interface EncoderInterface
{
    public function encode($data);

    public function getMime();

    public function getFileExtension();
}
