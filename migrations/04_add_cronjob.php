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
        $task_id  = CronjobScheduler::registerTask($this->getCronjobFilename());
        $schedule = CronjobScheduler::schedulePeriodic($task_id, 0, 0, 2);

        $schedule->active = true;
        $schedule->store();

        DBManager::get()->execute(
            ""
        );
    }

    public function down()
    {
        $task = reset(CronjobTask::findByClass('BBBCollector'));
        CronjobScheduler::unregisterTask($task->task_id);
    }

    private function getCronjobFilename()
    {
        return str_replace($GLOBALS['STUDIP_BASE_PATH'] . '/', '',
            realpath(__DIR__ . '/../cronjobs/BBBCollector.php'));
    }
}