<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */
require __DIR__ . '/bootstrap.php';

class SimpleBBBConnector extends StudIPPlugin implements SystemPlugin
{
    public $meeting_plugin_installed;

    public function __construct()
    {
        if ($GLOBALS['perm']->have_perm('root')) {
            parent::__construct();
            $this->meeting_plugin_installed = PluginEngine::getPlugin('MeetingPlugin') !== null;

            $navigation = new Navigation(_('BigBlueButton'));
            $navigation->setURL(PluginEngine::getURL($this, [], 'show/index'));
            $navigation->setImage(Icon::create('video', Icon::ROLE_NAVIGATION));
            Navigation::addItem('/simplebbbconnector/', $navigation);
            $navigation = new Navigation(_('Serverübersicht'));
            $navigation->setURL(PluginEngine::getURL($this, [], 'show/index'));
            Navigation::addItem('/simplebbbconnector/overview', $navigation);
            $navigation = new Navigation(_('Serverübersicht'));
            $navigation->setURL(PluginEngine::getURL($this, [], 'show/index'));
            Navigation::addItem('/simplebbbconnector/overview/index', $navigation);
            $crobjob_active = CronjobSchedule::countBySql(
                    'INNER JOIN cronjobs_tasks ON cronjobs_tasks.task_id = cronjobs_schedules.task_id 
                WHERE cronjobs_tasks.class = ? 
                    AND cronjobs_tasks.active = 1
                    AND cronjobs_schedules.active = 1',
                    ['BBBCollector']
                ) > 0;
            if ($crobjob_active) {
                $navigation = new Navigation(_('Statistik'));
                $navigation->setURL(PluginEngine::getURL($this, [], 'statistics/index'));
                Navigation::addItem('/simplebbbconnector/statistics', $navigation);
                $navigation = new Navigation(_('Übersicht'));
                $navigation->setURL(PluginEngine::getURL($this, [], 'statistics/index'));
                Navigation::addItem('/simplebbbconnector/statistics/index', $navigation);
            }
        }
    }

    public function perform($unconsumed_path)
    {
        $this->addStylesheet('assets/bbb-connector.less');
        PageLayout::addScript($this->getPluginURL() . '/assets/bbb-connector-app.js');
        parent::perform($unconsumed_path);
    }
}
