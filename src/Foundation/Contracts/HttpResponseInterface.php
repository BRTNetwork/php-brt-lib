<?php

namespace BRTNetwork\BRTLib\Foundation\Contracts;


interface HttpResponseInterface
{
    public function getBody();

    public function getHeaders();
}
