<?php

namespace BRTNetwork\BRTLib\GuzzleClient;

use BRTNetwork\BRTLib\Foundation\Contracts\HttpRequestInterface;

class Request implements HttpRequestInterface
{
    private $url    = '';
    private $body;
    private $headers;
    private $isJson = false;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function setJson(array $body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function getHeaders(): array
    {
        $headers = $this->headers;
        if ($this->isJson)
        {
            $headers['Content-Type: application/json'];
        }
        return $headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function isJson()
    {
        $this->isJson = true;
        return $this;
    }
}
