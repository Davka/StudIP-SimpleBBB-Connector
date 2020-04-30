<?php

namespace Vec\BBB;

use SimpleORMap;

class Server extends SimpleORMap
{
    protected static function configure($config = [])
    {
        $config['db_table'] = 'bigbluebutton_servers';

        $config['belongs_to']['category'] = [
            'class_name'  => 'Vec\\BBB\\Category',
            'foreign_key' => 'category_id',
        ];
        parent::configure($config);
    }

    private function getChecksum(string $route, string $queryBuild): string
    {
        return sha1($route . $queryBuild . $this->secret);
    }

    public function getAPIURL(string $apiRoute = "getMeetings"): string
    {
        $checksum = $this->getChecksum($apiRoute, $this->getQueryBuild());
        return $this->url . "/{$apiRoute}?checksum={$checksum}";
    }

    public function getCancelURL(string $meetingID, string $moderatorPassword): string
    {
        $params     = [
            'meetingID' => $meetingID,
            'password'  => $moderatorPassword,
            'redirect'  => true,
        ];
        $queryBuild = $this->getQueryBuild($params);
        $checkSum   = $this->getChecksum('end', $queryBuild);
        return $this->url . "/end?{$queryBuild}&checksum={$checkSum}";
    }


    private function getQueryBuild(array $params = [])
    {
        return http_build_query($params);
    }
}