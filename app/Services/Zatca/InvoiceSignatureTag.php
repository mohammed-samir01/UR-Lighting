<?php


namespace App\Services\Zatca;


use Salla\ZATCA\Tag;

class InvoiceSignatureTag extends Tag
{
    public function __construct($value)
    {
        parent::__construct(7, $value);
    }
}
