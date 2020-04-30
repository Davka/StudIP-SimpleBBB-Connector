<?php

use Vec\BBB\Controller;
use Vec\BBB\Server;
use Vec\BBB\Category;

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

    public function edit_action(Server $server)
    {
        PageLayout::setTitle(_('Server bearbeiten'));
        $this->categories = Category::findBySQL('1 ORDER BY `name`');
        $this->render_template('server/create.php');
    }

    public function store_action(Server $server = null)
    {
        CSRFProtection::verifyUnsafeRequest();
        $data = [
            'url'         => trim(Request::get('url'), '/api') . '/api',
            'name'        => Request::get('name'),
            'secret'      => Request::get('secret'),
            'category_id' => Request::get('category_id')
        ];

        $server->setData($data);

        if ($server->store()) {
            PageLayout::postSuccess(_('Die Serverinformationen wurden erfolgreich gespeichert!'));
        }
        $this->redirect('show/index');
    }

    public function delete_action(Server $server)
    {
        CSRFProtection::verifyUnsafeRequest();

        if ($server->delete()) {
            PageLayout::postSuccess(_('Der Server wurde erfolgreich gelöscht!'));
        }
        $this->redirect('show/index');
    }
}