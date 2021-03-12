<?php

namespace BRTNetwork\BRTLib\Model\Base;

use BRTNetwork\BRTLib\Utils;

class Balance
{
    protected $drops = '';

    public function __construct(string $drops = '')
    {
        $this->drops = $drops;
    }

    public static function fromDrops($drops)
    {
        return new self($drops);
    }

    public function toBrt()
    {
        return Utils::dropsToBrt($this->drops);
    }

    public function __debugInfo()
    {
        return [
            'drops' => $this->drops,
            'brt'   => Utils::dropsToBrt($this->drops),
        ];
    }
}
