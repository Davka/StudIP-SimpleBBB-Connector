<tr>
    <td><?= htmlReady($meeting['meeting_name']) ?></td>
    <? if ($plugin->meeting_plugin_installed) : ?>
        <td>
            <? if ($meeting['course']) : ?>
                <a href="<?= URLHelper::getLink('dispatch.php/course/details/index/' . $meeting['course']->id) ?>"
                   data-dialog="size=auto">
                    <?= htmlReady($meeting['course']->getFullname()) ?>
                </a>
            <? elseif ($meeting['is_break_out']): ?>
                <?= _('Breakout-Raum')?>
            <? else :?>
            <?= _('Keine Angabe') ?>
            <? endif ?>
        </td>
    <? endif ?>
    <td style="text-align: center"><?= htmlReady($meeting['participant_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['video_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['listener_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['voice_participant_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['moderator_count']) ?></td>
    <? if ($GLOBALS['perm']->have_perm('root')): ?>
        <td class="actions">
            <a data-confirm="<?= sprintf(
                _('Sind Sie sicher, dass Sie das Meeting %s beenden wollen'),
                htmlReady($meeting['meeting_name'])
            );
            ?>"
               href="<?= $controller->url_for('server/cancel_meeting/' . $server->id . '/' . $meeting['meeting_id'] . '/' . $meeting['moderator_pw']) ?>">
                <?= Icon::create('trash') ?>
            </a>
        </td>
    <? endif ?>
</tr>