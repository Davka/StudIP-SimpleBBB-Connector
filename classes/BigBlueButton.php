<?php

namespace Vec\BBB;

use BigBlueButton\BigBlueButton as BBB;
use Config;

class BigBlueButton extends BBB
{
    public function __construct($securitySecret, $bbbServerBaseUrl)
    {
        parent::__construct($securitySecret, $bbbServerBaseUrl);

        if(Config::get()->BBB_API_PROXY) {
            $this->setCurlOptions('CURLOPT_PROXY', Config::get()->BBB_API_PROXY);
        }
    }
}