<tr>
    <td>
        <?= htmlReady($meeting['meeting_name']) ?>
    </td>
    <? if ($plugin->meeting_plugin_installed) : ?>
        <td>
            <? if ($meeting['course']) : ?>
                <a href="<?= URLHelper::getLink('dispatch.php/course/details/index/' . $meeting['course']->id) ?>"
                   data-dialog="size=auto">
                    <?= htmlReady($meeting['course']->getFullname()) ?>
                </a>
                <? if($meeting['current_course_date']) : ?>
                    <small>
                        <?=  htmlReady($meeting['current_course_date']->getFullname())?>
                    </small>
                <? endif ?>
            <? elseif ($meeting['is_break_out']): ?>
                <?= _('Breakout-Raum') ?>
            <? else : ?>
                <?= _('Keine Angabe') ?>
            <? endif ?>
        </td>
    <? endif ?>
    <td style="text-align: center">
            <?= sprintf('%s/%s', htmlReady($meeting['participant_count']), htmlReady($meeting['max_users']))?>
    </td>
    <td style="text-align: center"><?= htmlReady($meeting['video_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['listener_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['voice_participant_count']) ?></td>
    <td style="text-align: center"><?= htmlReady($meeting['moderator_count']) ?></td>
    <td class="actions">
        <?= ActionMenu::get()->
        addLink(
            $controller->url_for('server/join_meeting/' . $server->id,
                [
                    'meeting_id'         => $meeting['meeting_id'],
                    'moderator_password' => $meeting['moderator_pw']
                ]
            ),
            _('Das Meeting beitreten'),
            Icon::create('door-enter'),
            ['target' => '_blank']
        )
            ->addLink(
                $controller->url_for('server/meeting_details/' . $server->id,
                    [
                        'meeting_id'         => $meeting['meeting_id'],
                        'moderator_password' => $meeting['moderator_pw']
                    ]
                ),
                _('Meeting-Details anzeigen'),
                Icon::create('info-circle'),
                ['data-dialog' => 'size=auto']
            )
            ->addButton(
                'cancel_meeting',
                _('Das Meeting beenden'),
                Icon::create('trash'),
                [
                    'data-confirm' => sprintf(
                        _('Sind Sie sicher, dass Sie das Meeting %s beenden wollen'),
                        htmlReady($meeting['meeting_name'])
                    ),
                    'formaction'   => $controller->url_for('server/cancel_meeting/' . $server->id,
                        [
                            'meeting_id'         => $meeting['meeting_id'],
                            'moderator_password' => $meeting['moderator_pw']
                        ]
                    )
                ]
            )->render()
        ?>
    </td>
</tr>