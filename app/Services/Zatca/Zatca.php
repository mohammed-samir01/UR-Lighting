<?php


namespace App\Services\Zatca;


use App\CPU\Helpers;

class Zatca extends AbstractRequestZatca
{
    public function reporting_invoice($invoice)
    {
        $cert = Helpers::csrOrCert('cert', true);
        $auth = base64_encode($cert->binarySecurityToken . ':' . $cert->secret);
        $this->setEndPoint('invoices/reporting/single');
        $this->setHeaders([
            'Clearance-Status' => '0',
            'Accept-Language' => 'en',
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData($invoice);
        return $res = $this->buildRequest();
        return $res->json();
    }

    public function compliance_check($invoice)
    {
        $csr = Helpers::csrOrCert('csr', true);
        $auth = base64_encode($csr->binarySecurityToken . ':' . $csr->secret);
        $this->setEndPoint('compliance/invoices');
        $this->setHeaders([
            'Accept-Language' => 'en',
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData($invoice);
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

    public function get_certificate($request_id, $auth)
    {
        $this->setEndPoint('production/csids');
        $this->setHeaders([
            'Authorization' => 'Basic ' . $auth
        ]);
        $this->setData(['compliance_request_id' => $request_id]);
        return $this->buildRequest();
    }

}
