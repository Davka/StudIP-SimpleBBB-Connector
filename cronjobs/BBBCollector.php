<?php
require_once __DIR__ . '/../bootstrap.php';

use Vec\BBB\Metric;
use Vec\BBB\Server;
use Vec\BBB\BigBlueButton;

class BBBCollector extends CronJob
{
    public static function getName()
    {
        return _('BBBCollector');
    }

    public static function getDescription()
    {
        return _('Sammelt Meetingdaten, um Statistiken zu erstellen');
    }

    public function execute($last_result, $parameters = [])
    {
        Metric::collect();
    }
}