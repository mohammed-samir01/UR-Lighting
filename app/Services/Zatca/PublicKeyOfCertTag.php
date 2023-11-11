<?php


namespace App\Services\Zatca;


use Salla\ZATCA\Tag;

class PublicKeyOfCertTag extends Tag
{
    public function __construct($value)
    {
        parent::__construct(8, $value);
    }
}
