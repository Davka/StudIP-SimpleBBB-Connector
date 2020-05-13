<? foreach ($servers as $result) : ?>
    <? $cols = 7 ?>
    <table class="default bbb-servers">
        <caption>
            <?= htmlReady($result['server']->name) ?>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <? $cols++ ?>
            <? endif ?>
            <span class="actions">
                <a href="<?= $controller->url_for('server/edit/' . $result['server']->id) ?>"
                   data-dialog="size=auto">
                    <?= Icon::create('edit') ?>
                </a>
                <?= Icon::create('trash')->asInput(
                    [
                        'data-confirm' => _('Wollen Sie den Server wirklich löschen?'),
                        'formaction'   => $controller->url_for('server/delete/' . $result['server']->id)
                    ]
                ) ?>
            </span>
        </caption>
        <colgroup>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <col style="width: 35%">
                <col style="width: 35%">
            <? else : ?>
                <col style="width: 70%">
            <? endif ?>
            <col style="width: 6%">
            <col style="width: 6%">
            <col style="width: 6%">
            <col style="width: 6%">
            <col style="width: 6%">
        </colgroup>
        <tr>
            <th><?= _('Meeting-Name') ?></th>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <th><?= _('Veranstaltung') ?></th>
            <? endif ?>
            <th style="text-align: center"><?= _('# TN') ?></th>
            <th style="text-align: center"><?= _('# Cam') ?></th>
            <th style="text-align: center"><?= _('# Zuhörer') ?></th>
            <th style="text-align: center"><?= _('# Audio') ?></th>
            <th style="text-align: center"><?= _('# Mods') ?></th>
            <th class="actions"><?= _('Aktion') ?></th>
        </tr>
        <? if (!empty($result['meetings']))  : ?>
            <? foreach ($result['meetings'] as $meeting) : ?>
                <?= $this->render_partial('show/_meeting.php', ['meeting' => $meeting, 'server' => $result['server']]) ?>
            <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="<?= $cols ?>" style="text-align: center">
                    <? if($result['server_unavailable']) : ?>
                        <?= MessageBox::error(htmlReady($result['server_unavailable'])) ?>
                    <? else : ?>
                        <?= _('Aktuell keine Meetings') ?>
                    <? endif ?>
                </td>
            </tr>
        <? endif ?>
        <tfoot>
            <td <?= $plugin->meeting_plugin_installed ? 'colspan="2"' : '' ?>></td>
            <td style="text-align: center"><?= $result['complete_participant_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_video_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_listener_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_voice_participant_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_moderator_count'] ?></td>
            <td></td>
        </tfoot>
    </table>
<? endforeach ?>