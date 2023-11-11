<?php


namespace App\Services\Zatca;


use Illuminate\Support\Facades\Http;

abstract class AbstractRequestZatca
{
    private $url;
    private $headers;
    private $end_point;
    private $data;
    private $response = null;

    public function __construct()
    {
        $this->url = config('app.url_zatca');
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Accept-Version' => 'V2'
        ];
    }

    /**
     * @param mixed $headers
     */
    protected function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * @param mixed $end_point
     */
    protected function setEndPoint($end_point)
    {
        $this->end_point = $end_point;
    }

    /**
     * @param mixed $data
     */
    protected function setData($data)
    {
        $this->data = $data;
    }

    protected function delete_headers(array $headers)
    {
        foreach ($headers as $header) {
            if (array_key_exists($header, $this->headers))
                unset($this->headers[$header]);
        }
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    protected function buildRequest($method = 'POST')
    {
        $url = $this->url . $this->end_point;
        return Http::withHeaders($this->headers)->send($method, $url, [
            'json' => $this->data
        ]);
    }


}
