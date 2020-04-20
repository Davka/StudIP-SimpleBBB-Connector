<? $cols = 6 ?>
<form method="post">
    <?= CSRFProtection::tokenTag(); ?>
    <? if (!empty($results)) : ?>
        <? foreach ($results as $result) : ?>
            <table class="default">
                <caption>
                    <?= htmlReady($result['server']->name) ?>
                    <? if ($GLOBALS['perm']->have_perm('root')) : ?>
                        <? $cols++ ?>
                        <span class="actions">
                        <a href="<?= $controller->url_for('settings/edit', $result['server']) ?>"
                           data-dialog="size=auto">
                            <?= Icon::create('edit') ?>
                        </a>
                        <?= Icon::create('trash')->asInput(
                            [
                                'data-confirm' => _('Wollen Sie den Server wirklich löschen?'),
                                'formaction'   => $controller->url_for('settings/delete', $result['server'])
                            ]
                        ) ?>
                        </span>
                    <? endif ?>
                </caption>
                <colgroup>
                    <? if ($GLOBALS['perm']->have_perm('root')) : ?>
                    <col style="width: 20%">
                    <col style="width: 30%">
                    <? else : ?>
                        <col style="width: 50%">
                    <? endif?>
                    <col style="width: 10%">
                    <col style="width: 10%">
                    <col style="width: 10%">
                    <col style="width: 10%">
                    <col style="width: 10%">
                </colgroup>
                <tr>
                    <? if ($GLOBALS['perm']->have_perm('root')) : ?>
                        <th><?= _('Meeting-ID') ?></th>
                    <? endif ?>
                    <th><?= _('Meeting-Name') ?></th>
                    <th><?= _('# Teilnehmer') ?></th>
                    <th><?= _('# Webcams') ?></th>
                    <th><?= _('# Zuhörer') ?></th>
                    <th><?= _('# Audio') ?></th>
                    <th><?= _('# Moderatoren') ?></th>
                </tr>
                <? if (!empty($result['meetings']))  : ?>
                    <? foreach ($result['meetings'] as $meeting) : ?>
                        <tr>
                            <? if ($GLOBALS['perm']->have_perm('root')) : ?>
                                <td><?= htmlReady($meeting['meeting_id']) ?></td>
                            <? endif ?>
                            <td><?= htmlReady($meeting['meeting_name']) ?></td>
                            <td><?= htmlReady($meeting['participant_count']) ?></td>
                            <td><?= htmlReady($meeting['video_count']) ?></td>
                            <td><?= htmlReady($meeting['listener_count']) ?></td>
                            <td><?= htmlReady($meeting['voice_participant_count']) ?></td>
                            <td><?= htmlReady($meeting['moderator_count']) ?></td>
                        </tr>
                    <? endforeach ?>
                <? elseif($result['server_unavailable']) : ?>
                    <tr>
                        <td colspan="<?= $cols ?>" style="text-align: center">
                            <?= MessageBox::error(htmlReady($result['server_unavailable']))?>
                        </td>
                    </tr>
                <? else : ?>
                    <tr>
                        <td colspan="<?= $cols ?>" style="text-align: center"><?= _('Aktuell keine Meetings') ?></td>
                    </tr>
                <? endif ?>
            </table>
        <? endforeach ?>
    <? else : ?>
        <?= MessageBox::info(_('Bisher noch keine Server eingetragen')) ?>
    <? endif ?>
</form>