<form method="post" action="<?= $controller->store($server ?: null) ?>" class="default">
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
        <input type="text" name="secret" value="<?= $server ? htmlReady($server->secret) : '' ?>" required>
    </label>
    <footer data-dialog-button>
        <?= Studip\Button::create(_('Speichern')) ?>
    </footer>
</form>