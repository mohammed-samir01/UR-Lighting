<?php
namespace App\Http\Controllers\Admin\Zatca;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Services\Zatca\Zatca;

class ApiZatcaController extends Controller
{
    private $zatca;

    public function __construct()
    {
        $this->zatca = new Zatca();
    }

    public function reporting_invoice()
    {
        return Order::with('details','seller','customer')->find(100002);
        $response = $this->zatca->reporting_invoice(['am' => 'so']);
    }



}
