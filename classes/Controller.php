<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

namespace Vec\BBB;

use PluginController;
use Request;
use AccessDeniedException;

class Controller extends PluginController
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if (!$this->plugin->isAdmin()) {
            throw new AccessDeniedException();
        }
    }

    public function render_template($template_name, $layout = null)
    {
        $layout_file = Request::isXhr()
            ? 'layouts/dialog.php'
            : 'layouts/base.php';

        $layout = $GLOBALS['template_factory']->open($layout_file);

        parent::render_template($template_name, $layout);
    }
}
