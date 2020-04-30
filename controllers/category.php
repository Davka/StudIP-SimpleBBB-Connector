<?php

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

    public function edit_action(Category $category)
    {
        PageLayout::setTitle(_('Kategorie bearbeiten'));
        $this->render_template('category/create.php');
    }

    public function store_action(Category $category = null)
    {
        CSRFProtection::verifyUnsafeRequest();

        $category->setData(['name' => Request::get('name')]);
        if ($category->store()) {
            PageLayout::postSuccess(_('Die Kategorie wurde erfolgreich gespeichert!'));
        }
        $this->redirect($this->index());
    }

    public function delete_action(Category $category)
    {
        if ($category->delete()) {
            PageLayout::postSuccess(_('Die Kategorie wurde erfolgreich gelöscht'));
        }
        $this->redirect($this->index());
    }
}