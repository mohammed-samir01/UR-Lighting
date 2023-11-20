<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResponseZatca extends Model
{
   protected $table = 'response_zatca';
   protected $guarded = [];
   public $timestamps = false;
   protected $casts = [
     'response_invoice' => 'array',
     'response_credit' => 'array',
     'response_debit' => 'array',
     'response_cert' => 'array',
     'response_csr' => 'array'
   ];

}
