<? foreach ($servers as $result) : ?>

    <table class="default">
        <caption>
            <?= htmlReady($result['server']->name) ?>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <? $cols++ ?>
            <? endif ?>
            <? if ($GLOBALS['perm']->have_perm('root')) : ?>
                <span class="actions">
                        <a href="<?= $controller->url_for('server/edit', $result['server']) ?>"
                           data-dialog="size=auto">
                            <?= Icon::create('edit') ?>
                        </a>
                        <?= Icon::create('trash')->asInput(
                            [
                                'data-confirm' => _('Wollen Sie den Server wirklich löschen?'),
                                'formaction'   => $controller->url_for('server/delete', $result['server'])
                            ]
                        ) ?>
                        </span>
            <? endif ?>
        </caption>
        <colgroup>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <col style="width: 20%">
                <col style="width: 30%">
            <? else : ?>
                <col style="width: 50%">
            <? endif ?>
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
        </colgroup>
        <tr>
            <th><?= _('Meeting-Name') ?></th>
            <? if ($plugin->meeting_plugin_installed) : ?>
                <th><?= _('Veranstaltung') ?></th>
            <? endif ?>
            <th><?= _('# Teilnehmer') ?></th>
            <th><?= _('# Webcams') ?></th>
            <th><?= _('# Zuhörer') ?></th>
            <th><?= _('# Audio') ?></th>
            <th><?= _('# Moderatoren') ?></th>
        </tr>
        <? if (!empty($result['meetings']))  : ?>
            <? foreach ($result['meetings'] as $meeting) : ?>
                <?= $this->render_partial('show/_meeting.php', compact('meeting')) ?>
            <? endforeach ?>
        <? elseif ($result['server_unavailable']) : ?>
            <tr>
                <td colspan="<?= $cols ?>" style="text-align: center">
                    <?= MessageBox::error(htmlReady($result['server_unavailable'])) ?>
                </td>
            </tr>
        <? else : ?>
            <tr>
                <td colspan="<?= $cols ?>" style="text-align: center"><?= _('Aktuell keine Meetings') ?></td>
            </tr>
        <? endif ?>
        <tfoot>
            <td <?= $plugin->meeting_plugin_installed ? 'colspan="2"' : '' ?>></td>
            <td><?= $result['complete_participant_count'] ?></td>
            <td><?= $result['complete_video_count'] ?></td>
            <td><?= $result['complete_listener_count'] ?></td>
            <td><?= $result['complete_voice_participant_count'] ?></td>
            <td><?= $result['complete_moderator_count'] ?></td>
        </tfoot>
    </table>
<? endforeach ?>
