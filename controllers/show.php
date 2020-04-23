<?php

use Vec\BBB\Controller;
use Vec\BBB\Server;
use Symfony\Component\HttpClient\HttpClient;

class ShowController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if($GLOBALS['perm']->have_perm('root')) {
            $this->buildSidebar();
        }
    }

    public function index_action()
    {
        Navigation::activateItem('/simplebbbconnector/overview/index');
        PageLayout::setTitle(_('Serverübersicht'));
        $servers = Server::findBySQL('1 ORDER BY CAST(`name` AS unsigned), `mkdate`');

        $results          = [];
        $all_participants = 0;
        $all_meetings     = 0;

        foreach ($servers as $server) {
            $result                     = ['server' => $server];
            $complete_participant_count = 0;
            try {
                $client                    = HttpClient::create();
                $response                  = $client->request('POST', $server->getAPIURL());
                $meetings                  = new SimpleXMLElement($response->getContent());
                if(!empty($meetings->meetings->meeting)) {
                    $result['complete_ounter'] = count($meetings->meetings->meeting);

                    foreach ($meetings->meetings->meeting as $meeting) {
                        $all_meetings++;
                        $result['meetings'][]       =
                            [
                                'meeting_id'              => (string)$meeting->meetingID,
                                'meeting_name'            => (string)$meeting->meetingName,
                                'participant_count'       => (string)$meeting->participantCount,
                                'video_count'             => (int)$meeting->videoCount,
                                'listener_count'          => (int)$meeting->listenerCount,
                                'voice_participant_count' => (int)$meeting->voiceParticipantCount,
                                'moderator_count'         => (int)$meeting->moderatorCount,
                            ];
                        $complete_participant_count += (int)$meeting->participantCount;
                    }
                }
            } catch(Symfony\Component\HttpClient\Exception\TransportException $e) {
                $result['server_unavailable'] = $e->getMessage();
            }
            $all_participants                     += $complete_participant_count;
            $result['complete_participant_count'] = $complete_participant_count;

            $results[] = $result;
        }
        $this->all_participants = $all_participants;
        $this->all_meetings     = $all_meetings;
        $this->results          = $results;

        $infos = new SidebarWidget();
        $infos->setTitle(_('Infos'));
        $infos->addElement(
            new WidgetElement(
                '<p>' . sprintf(_('Insgesamt %u Meetings'), $all_meetings) . '</p>'
            )
        );
        $infos->addElement(
            new WidgetElement(
                '<p>' . sprintf(_('Insgesamt %u Meeting-Teilnehmer'), $all_participants) . '</p>'
            )
        );
        Sidebar::Get()->addWidget($infos);
    }

    private function buildSidebar()
    {
        $actions = new ActionsWidget();
        $actions->addLink(
            _('Server hinzufügen'),
            $this->url_for('settings/add'),
            Icon::create('add'),
            ['data-dialog' => 'size=auto']
        );
        Sidebar::Get()->addWidget($actions);
    }
}
