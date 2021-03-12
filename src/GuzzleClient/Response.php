<?php

namespace BRTNetwork\BRTLib\GuzzleClient;


use BRTNetwork\BRTLib\Foundation\Contracts\HttpResponseInterface;
use Psr\Http\Message\ResponseInterface;

class Response implements HttpResponseInterface
{
    private $body;
    private $headers;
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getBody()
    {
        return $this->response->getBody()
                              ->getContents()
            ;
    }


    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    public function getResponse(): ResponseInterface
    {
        $this->response;
    }
}
