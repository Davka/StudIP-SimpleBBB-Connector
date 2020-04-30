<tr>
    <td><?= htmlReady($meeting['meeting_name']) ?></td>
    <? if ($plugin->meeting_plugin_installed) : ?>
        <td>
            <? if ($meeting['course']) : ?>
                <a href="<?= URLHelper::getLink('dispatch.php/course/details/index/' . $meeting['course']->id) ?>"
                   data-dialog="size=auto">
                    <?= htmlReady($meeting['course']->getFullname()) ?>
                </a>
            <? else : ?>
                <?= _('Keine Angabe') ?>
            <? endif ?>
        </td>
    <? endif ?>
    <td style="text-align: center"><?= htmlReady($meeting['participant_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['video_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['listener_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['voice_participant_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['moderator_count']) ?></td>
</tr>