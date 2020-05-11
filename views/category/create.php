<form method="post" action="<?= $controller->url_for('category/store/' . ($category ? $category->id : '')) ?>"
      class="default" data-dialog="size=auto">
    <?= CSRFProtection::tokenTag() ?>
    <label>
        <span class="required">
            <?= _('Name') ?>
        </span>
        <input type="text" name="name" value="<?= $category ? htmlReady($category->name) : '' ?>" required>
    </label>
    <footer data-dialog-button>
        <?= Studip\Button::create(_('Speichern')) ?>
        <?= Studip\LinkButton::create(
            _('Zur Übersicht'),
            $controller->url_for('category/index'),
            ['data-dialog' => 'size=auto']
        ) ?>
    </footer>
</form>