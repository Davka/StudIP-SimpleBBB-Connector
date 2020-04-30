<tr>
    <td><?= htmlReady($meeting['meeting_name']) ?></td>
    <? if ($plugin->meeting_plugin_installed) : ?>
        <td>
            <? if ($meeting['course']) : ?>
                <?= htmlReady($meeting['course']->getFullname()) ?>
            <? else : ?>
                <?= _('Keine Angabe') ?>
            <? endif ?>
        </td>
    <? endif ?>
    <td><?= htmlReady($meeting['participant_count']) ?></td>
    <td><?= htmlReady($meeting['video_count']) ?></td>
    <td><?= htmlReady($meeting['listener_count']) ?></td>
    <td><?= htmlReady($meeting['voice_participant_count']) ?></td>
    <td><?= htmlReady($meeting['moderator_count']) ?></td>
</tr>