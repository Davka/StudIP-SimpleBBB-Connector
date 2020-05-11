<form method="post">
    <?= CSRFProtection::tokenTag() ?>
    <table class="default">
        <thead>
            <tr>
                <th><?= _('Name') ?></th>
                <th class="actions"><?= _('Aktion') ?></th>
            </tr>
        </thead>
        <? if (!empty($categories)) : ?>
            <? foreach ($categories as $category) : ?>
                <tr>
                    <td><?= htmlReady($category->name) ?></td>
                    <td class="actions">
                        <a href="<?= $controller->url_for('category/edit/' . $category->id) ?>" data-dialog="size=auto">
                            <?= Icon::create('edit') ?>
                        </a>
                        <?= Icon::create('trash')->asInput(
                            [
                                'formaction'   => $controller->url_for('category/delete/' . $category->id),
                                'data-confirm' => _('Wollen Sie die Kategorie wirklich löschen?'),
                                'data-dialog'  => 'size=auto'
                            ])
                        ?>
                    </td>
                </tr>
            <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="2" style="text-align: center">
                    <?= _('Bisher wurden keine Kategorien eingetragen') ?>
                </td>
            </tr>
        <? endif ?>
    </table>
    <footer data-dialog-button>
        <?= Studip\LinkButton::create(
            _('Kategorie hinzufügen'),
            $controller->url_for('category/add'),
            ['data-dialog' => 'size=auto']
        ) ?>
    </footer>
</form>