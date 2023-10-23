<?php

return [
    "refresh_token"  => "AMf-vByvxmPEQGsq77hAQPQLrLtPtlsbiuHXtSm_p-tNI-iJR-lqMpT8v_e4S6YVskGM7zdvjwa_H7HDpGISradGgntfQqpyJznw1snqk5j6soU4f0CCHnP8ExggBK2ezSSLRUTfn2WV-Jg1t-a5_BPWg84Mcjqn8IyZpqL2i4Wh2ub9bCAFBFmy0ucxO02gcM4xxudo2aSt-Og1tAw7mZslAi1xneEKtA",
    "access_token"   => "" ,

    /*
    | Mode only values: "test" or "live"
    */

    "mode"     => "test",

    /*
    |--------------------------------------------------------------------------
    | Oto currency
    |--------------------------------------------------------------------------
    | EGP , SAR , USD, .. etc
    */
    "currency" => "SAR" ,
    /*
    |--------------------------------------------------------------------------
    | TEST Payment Request url
    |--------------------------------------------------------------------------
    */

    "test_urls" => [
        "refresh_token"         => "https://api.tryoto.com/rest/v2/refreshToken",
        "available_cities"      => "https://api.tryoto.com/rest/v2/availableCities",
        "check_delivery_fee"    => "https://api.tryoto.com/rest/v2/checkOTODeliveryFee",
        "create_order"          => "https://api.tryoto.com/rest/v2/createOrder",
        "cancel_order"          => "https://api.tryoto.com/rest/v2/cancelOrder",
        "order_status"          => "https://api.tryoto.com/rest/v2/orderStatus",
        "create_shipment"       => "https://api.tryoto.com/rest/v2/createShipment",
        "create_return_shipment"=> "https://api.tryoto.com/rest/v2/createReturnShipment",

    ],
    /*
    |--------------------------------------------------------------------------
    | LIVE Payment Request url
    |--------------------------------------------------------------------------
    */

    "live_urls" => [
        "refresh_token"         => "",
        "available_cities"      => "",
        "check_delivery_fee"    => "",
        "create_order"          => "",
        "cancel_order"          => "",
        "order_status"          => "",
        "create_shipment"       => "",
        "create_return_shipment"=> "",
    ],



];
