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
                <col style="width: 40%">
                <col style="width: 35%">
            <? else : ?>
                <col style="width: 75%">
            <? endif ?>
            <col style="width: 5%">
            <col style="width: 5%">
            <col style="width: 5%">
            <col style="width: 5%">
            <col style="width: 5%">
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
            <td style="text-align: center"><?= $result['complete_participant_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_video_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_listener_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_voice_participant_count'] ?></td>
            <td style="text-align: center"><?= $result['complete_moderator_count'] ?></td>
        </tfoot>
    </table>
<? endforeach ?>
