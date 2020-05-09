<?php

use Vec\BBB\Controller;
use Vec\BBB\Server;
use BigBlueButton\BigBlueButton;

class ShowController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if ($GLOBALS['perm']->have_perm('root')) {
            $this->buildSidebar();
        }
    }

    public function index_action()
    {
        Navigation::activateItem('/simplebbbconnector/overview/index');
        PageLayout::setTitle(_('Serverübersicht'));
        $servers = SimpleORMapCollection::createFromArray(
            Server::findBySQL('1')
        )->orderBy('name');

        $results          = [];
        $all_participants = 0;
        $all_meetings     = 0;

        foreach ($servers as $server) {
            $result                           = ['server' => $server];
            $complete_participant_count       = 0;
            $complete_video_count             = 0;
            $complete_listener_count          = 0;
            $complete_voice_participant_count = 0;
            $complete_moderator_count         = 0;
            try {
                putenv("BBB_SECRET=" . $server->secret);
                putenv("BBB_SERVER_BASE_URL=" . rtrim($server->url, 'api'));

                $bbb      = new BigBlueButton();
                $response = $bbb->getMeetings();
                $meetings = $response->getRawXml()->meetings->meeting;

                if (!empty($meetings)) {
                    $result['complete_ounter'] = count($meetings);

                    foreach ($meetings as $meeting) {
                        $all_meetings++;
                        $course = null;
                        if ($this->plugin->meeting_plugin_installed) {
                            $course = \Course::findOneBySQL(
                                'JOIN vc_meeting_course vmc on vmc.course_id = Seminar_id 
                                JOIN vc_meetings vm ON vm.id = vmc.meeting_id
                                WHERE vm.remote_id = ?',
                                [(string)$meeting->meetingID]
                            );
                        }
                        $result['meetings'][] =
                            [
                                'meeting_id'              => (string)$meeting->meetingID,
                                'meeting_name'            => (string)$meeting->meetingName,
                                'participant_count'       => (string)$meeting->participantCount,
                                'video_count'             => (int)$meeting->videoCount,
                                'listener_count'          => (int)$meeting->listenerCount,
                                'voice_participant_count' => (int)$meeting->voiceParticipantCount,
                                'moderator_count'         => (int)$meeting->moderatorCount,
                                'moderator_pw'            => (string)$meeting->moderatorPW,
                                'is_break_out'            => (string)$meeting->isBreakout === "true",
                                'course'                  => $course
                            ];

                        $complete_participant_count       += (int)$meeting->participantCount;
                        $complete_video_count             += (int)$meeting->videoCount;
                        $complete_listener_count          += (int)$meeting->listenerCount;
                        $complete_voice_participant_count += (int)$meeting->voiceParticipantCount;
                        $complete_moderator_count         += (int)$meeting->moderatorCount;
                    }
                }
            } catch (Symfony\Component\HttpClient\Exception\TransportException $e) {
                $result['server_unavailable'] = $e->getMessage();
            }
            $all_participants                           += $complete_participant_count;
            $result['complete_participant_count']       = $complete_participant_count;
            $result['complete_video_count']             = $complete_video_count;
            $result['complete_listener_count']          = $complete_listener_count;
            $result['complete_voice_participant_count'] = $complete_voice_participant_count;
            $result['complete_moderator_count']         = $complete_moderator_count;
            if ($server->category) {
                $category_name = $server->category->name;
            } else {
                $category_name = _('Allgemein');
            }
            $results[$category_name]['category_participant_count']       += $complete_participant_count;
            $results[$category_name]['category_video_count']             += $complete_video_count;
            $results[$category_name]['category_listener_count']          += $complete_listener_count;
            $results[$category_name]['category_voice_participant_count'] += $complete_voice_participant_count;
            $results[$category_name]['category_moderator_count']         += $complete_moderator_count;
            $results[$category_name]['results'][]                        = $result;
        }

        ksort($results);

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
            _('Server-Kategorien verwalten'),
            $this->url_for('category/index'),
            Icon::create('category'),
            ['data-dialog' => 'size=auto']
        );
        $actions->addLink(
            _('Server hinzufügen'),
            $this->url_for('server/add'),
            Icon::create('add'),
            ['data-dialog' => 'size=auto']
        );
        Sidebar::Get()->addWidget($actions);
    }
}
