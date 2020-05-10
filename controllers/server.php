<?php

use Vec\BBB\Controller;
use Vec\BBB\Server;
use Vec\BBB\Category;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;

class ServerController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if (!$GLOBALS['perm']->have_perm('root')) {
            throw new AccessDeniedException();
        }
    }

    public function add_action()
    {
        PageLayout::setTitle(_('Server hinzufügen'));
        $this->categories = Category::findBySQL('1 ORDER BY `name`');
        $this->render_template('server/create.php');
    }

    public function edit_action($server_id)
    {
        PageLayout::setTitle(_('Server bearbeiten'));
        $this->server     = Server::find($server_id);
        $this->categories = Category::findBySQL('1 ORDER BY `name`');
        $this->render_template('server/create.php');
    }

    public function store_action($server_id = null)
    {
        CSRFProtection::verifyUnsafeRequest();
        $data = [
            'url'         => trim(Request::get('url'), '/api') . '/api',
            'name'        => Request::get('name'),
            'secret'      => Request::get('secret'),
            'category_id' => Request::get('category_id')
        ];
        if ($server_id) {
            $server = Server::find($server_id);
            $server->setData($data);
        } else {
            $server = Server::build($data);
        }
        if ($server->store()) {
            PageLayout::postSuccess(_('Die Serverinformationen wurden erfolgreich gespeichert!'));
        }
        $this->redirect('show/index');
    }

    public function delete_action($server_id)
    {
        CSRFProtection::verifyUnsafeRequest();
        $server = Server::find($server_id);
        if ($server->delete()) {
            PageLayout::postSuccess(_('Der Server wurde erfolgreich gelöscht!'));
        }
        $this->redirect('show/index');
    }

    public function join_meeting_action($server_id)
    {
        $server = Server::find($server_id);
        putenv("BBB_SECRET=" . $server->secret);
        putenv("BBB_SERVER_BASE_URL=" . rtrim($server->url, 'api'));
        $bbb                 = new BigBlueButton();
        $join_meeting_params = new JoinMeetingParameters(
            Request::get('meeting_id'),
            htmlReady($GLOBALS['user']->getFullname()),
            Request::get('moderator_password')
        );
        $join_meeting_params->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($join_meeting_params);
        putenv("BBB_SECRET");
        putenv("BBB_SERVER_BASE_URL");
        header('Status: 301 Moved Permanently', false, 301);
        header('Location:' . $url);

        die;
    }

    public function cancel_meeting_action($server_id)
    {
        CSRFProtection::verifyUnsafeRequest();
        $server = Server::find($server_id);
        putenv("BBB_SECRET=" . $server->secret);
        putenv("BBB_SERVER_BASE_URL=" . rtrim($server->url, 'api'));
        $bbb = new BigBlueButton();

        $endMeetingParams = new EndMeetingParameters(
            Request::get('meeting_id'), Request::get('moderator_password')
        );

        $response = $bbb->endMeeting($endMeetingParams);
        if ($response->getReturnCode() == 'SUCCESS') {
            PageLayout::postSuccess(_('Das Meeting wurde erfolgreich beendet'));
        } else {
            PageLayout::postError(_('Das Meeting konnte nicht beendet werden'), [$response->getMessage()]);
        }
        putenv("BBB_SECRET");
        putenv("BBB_SERVER_BASE_URL");
        $this->redirect('show/index');
    }
}