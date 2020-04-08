<?php

namespace Vec\BBB;

use SimpleORMap;

class Server extends SimpleORMap
{
    protected static function configure($config = [])
    {
        $config['db_table'] = 'bigbluebutton_servers';
        parent::configure($config);
    }

    private function getChecksum(string $route, string $queryBuild): string
    {
        return sha1($route . $queryBuild . $this->secret);
    }

    public function getAPIURL(string $apiRoute = "getMeetings"): string
    {
        $checksum = $this->getChecksum($apiRoute, http_build_query([]));
        return $this->url . "/{$apiRoute}?checksum={$checksum}";
    }
}