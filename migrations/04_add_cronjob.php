<?php

/**
 * @author      David Siegfried <david.siegfried@uni-vechta.de>
 * @license     GPL2 or any later version
 * @since       4.0
 */
class AddCronjob extends Migration
{
    public function up()
    {
        $task_id  = CronjobScheduler::registerTask(self::getCronjobFilename());
        $schedule = CronjobScheduler::schedulePeriodic($task_id, 0, 0, 2);

        $schedule->active = true;
        $schedule->store();

        DBManager::get()->execute(
            "CREATE TABLE `bigbluebutton_metrics` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `server_id` int(11) DEFAULT NULL,
              `meeting_id` varchar(64) DEFAULT NULL,
              `meeting_name` varchar(255) DEFAULT NULL,
              `participant_count` int(11) DEFAULT NULL,
              `video_count` int(11) DEFAULT NULL,
              `listener_count` int(11) DEFAULT NULL,
              `voice_participant_count` int(11) DEFAULT NULL,
              `moderator_count` int(11) DEFAULT NULL,
              `is_break_out` int(1) DEFAULT NULL,
              `start_time` datetime DEFAULT NULL,
              `end_time` datetime DEFAULT NULL,
              `mkdate` int(11) DEFAULT NULL,
              `chdate` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        );
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $task = reset(CronjobTask::findByClass('BBBCollector'));
        if($task) {
            CronjobScheduler::unregisterTask($task->task_id);
        }
        DBManager::get()->exec('DROP TABLE `bigbluebutton_metrics`');
        SimpleORMap::expireTableScheme();
    }

    private static function getCronjobFilename()
    {
        return str_replace($GLOBALS['STUDIP_BASE_PATH'] . '/', '',
            realpath(__DIR__ . '/../cronjobs/BBBCollector.php'));
    }
}