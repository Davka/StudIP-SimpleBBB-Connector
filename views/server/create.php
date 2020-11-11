<form method="post" action="<?= $controller->url_for('server/store/' . ($server->id ?: '')) ?>" class="default">
    <?= CSRFProtection::tokenTag() ?>
    <label>
        <span class="required">
            <?= _('URL') ?>
        </span>
        <input type="text" name="url" value="<?= $server ? htmlReady($server->url) : '' ?>" required>
    </label>
    <label>
        <span class="required">
            <?= _('Name') ?>
        </span>
        <input type="text" name="name" value="<?= $server ? htmlReady($server->name) : '' ?>" required>
    </label>
    <label>
        <span class="required">
            <?= _('Secret') ?>
        </span>
        <input type="text" name="secret" autocomplete="off" value="<?= $server ? htmlReady($server->secret) : '' ?>" required>
    </label>
    <label>
        <?= _('Kategorie') ?>
        <select name="category_id">
            <option><?= _('Bitte wählen') ?></option>
            <? foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= $server && $server->category_id == $category->id ? 'selected' : '' ?>>
                    <?= htmlReady($category->name) ?>
                </option>
            <? endforeach ?>
        </select>
    </label>
    <footer data-dialog-button>
        <?= Studip\Button::create(_('Speichern')) ?>
    </footer>
</form>
