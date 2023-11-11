<?php


namespace App\Services\Zatca;


use Salla\ZATCA\Tag;

class SignOfCertTag extends Tag
{
    public function __construct($value)
    {
        parent::__construct(9, $value);
    }
}
