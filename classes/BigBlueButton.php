<?php

namespace Vec\BBB;

use BigBlueButton\BigBlueButton as BBB;
use Config;

class BigBlueButton extends BBB
{
    public function __construct($securitySecret, $bbbServerBaseUrl)
    {
        $curlOpts = [];
        if(Config::get()->BBB_API_PROXY) {
            $curlOpts['curl'][CURLOPT_PROXY] =  Config::get()->BBB_API_PROXY;
        }
        parent::__construct($bbbServerBaseUrl, $securitySecret, $curlOpts);
    }
}