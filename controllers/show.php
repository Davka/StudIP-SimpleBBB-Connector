<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

use Vec\BBB\Controller;
use Vec\BBB\GreenlightConnection;
use Vec\BBB\Server;
use Vec\BBB\BigBlueButton;

class ShowController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        $this->buildSidebar();
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

            $bbb = new BigBlueButton(
                $server->secret,
                rtrim($server->url, 'api')
            );

            try {
                $response = $bbb->getMeetings();
                $meetings = $response->getRawXml()->meetings->meeting;

                if (!empty($meetings)) {
                    $result['complete_ounter'] = count($meetings);

                    foreach ($meetings as $meeting) {
                        $all_meetings++;
                        $course              = null;
                        $current_course_date = null;
                        if ($this->plugin->meeting_plugin_installed) {
                            $course = Course::findOneBySQL('JOIN vc_meeting_course vmc on vmc.course_id = Seminar_id
                                JOIN vc_meetings vm ON vm.id = vmc.meeting_id WHERE vm.remote_id = ?',
                                [(string)$meeting->meetingID]
                            );

                            if ($course) {
                                $current_course_date = CourseDate::findOneBySQL(
                                    'range_id = ? AND UNIX_TIMESTAMP() BETWEEN date and end_time',
                                    [$course->id]
                                );
                            }
                        }
                        $result['meetings'][] =
                            [
                                'meeting_id'              => (string)$meeting->meetingID,
                                'meeting_name'            => (string)$meeting->meetingName,
                                'participant_count'       => (string)$meeting->participantCount,
                                'max_users'               => (int)$meeting->maxUsers,
                                'video_count'             => (int)$meeting->videoCount,
                                'listener_count'          => (int)$meeting->listenerCount,
                                'voice_participant_count' => (int)$meeting->voiceParticipantCount,
                                'moderator_count'         => (int)$meeting->moderatorCount,
                                'moderator_pw'            => (string)$meeting->moderatorPW,
                                'is_break_out'            => (string)$meeting->isBreakout === "true",
                                'course'                  => $course,
                                'current_course_date'     => $current_course_date
                            ];

                        $complete_participant_count       += (int)$meeting->participantCount;
                        $complete_video_count             += (int)$meeting->videoCount;
                        $complete_listener_count          += (int)$meeting->listenerCount;
                        $complete_voice_participant_count += (int)$meeting->voiceParticipantCount;
                        $complete_moderator_count         += (int)$meeting->moderatorCount;
                    }
                }
            } catch (Exception $e) {
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
                '<p>' . sprintf(_('%u lfd. Konferenzen'), $all_meetings) . '</p>'
            )
        );
        $infos->addElement(
            new WidgetElement(
                '<p>' . sprintf(_('%u TeilnehmerInnen (aktuell)'), $all_participants) . '</p>'
            )
        );

        if ($this->plugin->meeting_plugin_installed) {
            $meetings_room_counter = DBManager::get()->fetchColumn(
                "SELECT COUNT(*) FROM vc_meetings WHERE driver = 'BigBlueButton'"
            );
            $infos->addElement(
                new WidgetElement(
                    '<p>' . sprintf(_('%u Stud.IP-Meetingräume (Summe)'), $meetings_room_counter) . '</p>'
                )
            );
        }
        try {
            $greenlight_room_counter = GreenlightConnection::Get()->countRooms();
            $infos->addElement(
                new WidgetElement(
                    '<p>' . sprintf(_('%u Greenlight-Meetingräume (Summe)'), $greenlight_room_counter) . '</p>'
                )
            );
        } catch (Exception $e) {
        }

        if ($greenlight_room_counter) {
            $infos->addElement(
                new WidgetElement(
                    '<p>' . sprintf(_('%u Meetingräume (Summe)'), ($greenlight_room_counter + $meetings_room_counter)) . '</p>'
                )
            );
        }
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
