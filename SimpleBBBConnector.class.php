<?php
require __DIR__ . '/bootstrap.php';

class SimpleBBBConnector extends StudIPPlugin implements SystemPlugin
{
    public $meeting_plugin_installed;

    public function __construct()
    {
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
    }
}
