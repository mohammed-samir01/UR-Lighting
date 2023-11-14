<?php


namespace App\Services\Zatca;


class Zatca extends AbstractRequestZatca
{
    public function reporting_invoice($data)
    {
        $auth = 'VFVsSlJERkVRME5CTTIxblFYZEpRa0ZuU1ZSaWQwRkJaVE5WUVZsV1ZUTTBTUzhyTlZGQlFrRkJRamRrVkVGTFFtZG5jV2hyYWs5UVVWRkVRV3BDYWsxU1ZYZEZkMWxMUTFwSmJXbGFVSGxNUjFGQ1IxSlpSbUpIT1dwWlYzZDRSWHBCVWtKbmIwcHJhV0ZLYXk5SmMxcEJSVnBHWjA1dVlqTlplRVo2UVZaQ1oyOUthMmxoU21zdlNYTmFRVVZhUm1ka2JHVklVbTVaV0hBd1RWSjNkMGRuV1VSV1VWRkVSWGhPVlZVeGNFWlRWVFZYVkRCc1JGSlRNVlJrVjBwRVVWTXdlRTFDTkZoRVZFbDVUVVJaZUUxcVJUTk9SRUV4VFd4dldFUlVTVEJOUkZsNFRWUkZNMDVFUVRGTmJHOTNVMVJGVEUxQmEwZEJNVlZGUW1oTlExVXdSWGhFYWtGTlFtZE9Wa0pCYjFSQ1YwWnVZVmQ0YkUxU1dYZEdRVmxFVmxGUlRFVjNNVzlaV0d4b1NVaHNhRm95YUhSaU0xWjVUVkpKZDBWQldVUldVVkZFUlhkcmVFMXFZM1ZOUXpSM1RHcEZkMVpxUVZGQ1oyTnhhR3RxVDFCUlNVSkNaMVZ5WjFGUlFVTm5Ua05CUVZSVVFVczViSEpVVm10dk9YSnJjVFphV1dOak9VaEVVbHBRTkdJNVV6UjZRVFJMYlRkWldFb3JjMjVVVm1oTWEzcFZNRWh6YlZOWU9WVnVPR3BFYUZKVVQwaEVTMkZtZERoREwzVjFWVms1TXpSMmRVMU9ielJKUTBwNlEwTkJhVTEzWjFsblIwRXhWV1JGVVZOQ1owUkNLM0JJZDNkbGFrVmlUVUpyUjBFeFZVVkNRWGRUVFZNeGIxbFliR2htUkVsMFRXcE5NR1pFVFhSTlZFVjVUVkk0ZDBoUldVdERXa2x0YVZwUWVVeEhVVUpCVVhkUVRYcEJkMDFFWXpGT1ZHYzBUbnBCZDAxRVFYcE5VVEIzUTNkWlJGWlJVVTFFUVZGNFRWUkJkMDFTUlhkRWQxbEVWbEZSWVVSQmFHRlpXRkpxV1ZOQmVFMXFSVmxOUWxsSFFURlZSVVIzZDFCU2JUbDJXa05DUTJSWVRucGhWelZzWXpOTmVrMUNNRWRCTVZWa1JHZFJWMEpDVTJkdFNWZEVObUpRWm1KaVMydHRWSGRQU2xKWWRrbGlTRGxJYWtGbVFtZE9Wa2hUVFVWSFJFRlhaMEpTTWxsSmVqZENjVU56V2pGak1XNWpLMkZ5UzJOeWJWUlhNVXg2UWs5Q1owNVdTRkk0UlZKNlFrWk5SVTluVVdGQkwyaHFNVzlrU0ZKM1QyazRkbVJJVGpCWk0wcHpURzV3YUdSSFRtaE1iV1IyWkdrMWVsbFRPVVJhV0Vvd1VsYzFlV0l5ZUhOTU1WSlVWMnRXU2xSc1dsQlRWVTVHVEZaT01WbHJUa0pNVkVWMVdUTktjMDFKUjNSQ1oyZHlRbWRGUmtKUlkwSkJVVk5DYjBSRFFtNVVRblZDWjJkeVFtZEZSa0pSWTNkQldWcHBZVWhTTUdORWIzWk1NMUo2WkVkT2VXSkROVFpaV0ZKcVdWTTFibUl6V1hWak1rVjJVVEpXZVdSRlZuVmpiVGx6WWtNNVZWVXhjRVpoVnpVeVlqSnNhbHBXVGtSUlZFVjFXbGhvTUZveVJqWmtRelZ1WWpOWmRXSkhPV3BaVjNobVZrWk9ZVkpWYkU5V2F6bEtVVEJWZEZVelZtbFJNRVYwVFZObmVFdFROV3BqYmxGM1MzZFpTVXQzV1VKQ1VWVklUVUZIUjBneWFEQmtTRUUyVEhrNU1HTXpVbXBqYlhkMVpXMUdNRmt5UlhWYU1qa3lURzVPYUV3eU9XcGpNMEYzUkdkWlJGWlNNRkJCVVVndlFrRlJSRUZuWlVGTlFqQkhRVEZWWkVwUlVWZE5RbEZIUTBOelIwRlJWVVpDZDAxRFFtZG5ja0puUlVaQ1VXTkVRWHBCYmtKbmEzSkNaMFZGUVZsSk0wWlJiMFZIYWtGWlRVRnZSME5EYzBkQlVWVkdRbmROUTAxQmIwZERRM05IUVZGVlJrSjNUVVJOUVc5SFEwTnhSMU5OTkRsQ1FVMURRVEJyUVUxRldVTkpVVU5XZDBSTlkzRTJVRThyVFdOdGMwSllWWG92ZGpGSFpHaEhjRGR5Y1ZOaE1rRjRWRXRUZGpnek9FbEJTV2hCVDBKT1JFSjBPU3N6UkZOc2FXcHZWbVo0ZW5Ka1JHZzFNamhYUXpNM2MyMUZaRzlIVjFaeVUzQkhNUT09OlhsajE1THlNQ2dTQzY2T2JuRU8vcVZQZmhTYnMza0RUalduR2hlWWhmU3M9';
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
