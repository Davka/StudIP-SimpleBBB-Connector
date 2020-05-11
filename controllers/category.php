<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

use Vec\BBB\Controller;
use Vec\BBB\Category;

class CategoryController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if (!$GLOBALS['perm']->have_perm('root')) {
            throw new AccessDeniedException();
        }
    }

    public function index_action()
    {
        PageLayout::setTitle(_('Serverkategorien - verwalten'));
        $this->categories = Category::findBySQL('1 ORDER BY `name`');
    }

    public function add_action()
    {
        PageLayout::setTitle(_('Kategorie hinzufügen'));
        $this->render_template('category/create.php');
    }

    public function edit_action($category_id)
    {
        PageLayout::setTitle(_('Kategorie bearbeiten'));
        $this->category = Category::find($category_id);
        $this->render_template('category/create.php');
    }

    public function store_action($category_id = null)
    {
        CSRFProtection::verifyUnsafeRequest();
        $data = ['name' => Request::get('name')];
        if ($category_id) {
            $category = Category::find($category_id);
            $category->setData($data);
        } else {
            $category = Category::build($data);
        }

        if ($category->store()) {
            PageLayout::postSuccess(_('Die Kategorie wurde erfolgreich gespeichert!'));
        }
        $this->redirect($this->index());
    }

    public function delete_action($category_id)
    {
        $category = Category::find($category_id);
        if ($category && $category->delete()) {
            PageLayout::postSuccess(_('Die Kategorie wurde erfolgreich gelöscht'));
        }
        $this->redirect($this->index());
    }
}