<?php

namespace BRTNetwork\BRTLib\Foundation\Contracts;


interface HttpClientInterface
{
    public function send(HttpRequestInterface $request): HttpResponseInterface;
}
