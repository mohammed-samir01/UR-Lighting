<?php


namespace App\Services\Zatca;


use Salla\ZATCA\Tag;

class InvoiceHashTag extends Tag
{
    public function __construct($value)
    {
        parent::__construct(6, $value);
    }
}
