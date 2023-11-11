<?php


namespace App\Services\Zatca;


class Zatca extends AbstractRequestZatca
{
    public function reporting_invoice($data)
    {
        $auth = 'amer';
        $this->setEndPoint('invoices/reporting/single');
        $this->setHeaders([
            'Clearance-Status' => '0',
            'Accept-Language' => 'en',
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData($data);
        return $this->buildRequest();
    }

    public function compliance_check($data)
    {
        $auth = 'amer';
        $this->setEndPoint('compliance/invoices');
        $this->setHeaders([
            'Accept-Language' => 'en',
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData($data);
        return $this->buildRequest();
    }

    public function request_for_csr($otp, $data)
    {
        $this->setEndPoint('compliance');
        $this->setHeaders([
            'OTP' => $otp,
        ]);
        $this->setData($data);
        return $this->buildRequest();
    }

    public function get_certificate($data)
    {
        $auth = 'amer';
        $this->setEndPoint('production/csids');
        $this->setHeaders([
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData(['compliance_request_id' => $data]);
        return $this->buildRequest();
    }

}
