<table class="default">
    <colgroup>
        <col style="width: 50%">
        <col>
    </colgroup>
    <tr>
        <td><?= _('MeetingID') ?></td>
        <td><?= htmlReady((string)$xml->meetingID) ?></td>
    </tr>
    <tr>
        <td><?= _('Meeting-Name') ?></td>
        <td><?= htmlReady((string)$xml->meetingName) ?></td>
    </tr>
    <tr>
        <td><?= _('Anzahl TeilnehmerInnen') ?></td>
        <td><?= (int)$xml->participantCount ?></td>
    </tr>
    <tr>
        <td><?= _('Anzahl ZuhörerInnen') ?></td>
        <td><?= (int)$xml->listenerCount ?></td>
    </tr>
    <tr>
        <td><?= _('Anzahl Audio') ?></td>
        <td><?= (int)$xml->voiceParticipantCount ?></td>
    </tr>
    <tr>
        <td><?= _('Anzahl Video') ?></td>
        <td><?= (int)$xml->videoCount ?></td>
    </tr>
    <tr>
        <td><?= _('Anzahl ModeratorenInnen') ?></td>
        <td><?= (int)$xml->moderatorCount ?></td>
    </tr>
    <tr>
        <td><?= _('Break-Out-Raum') ?></td>
        <td><?= ((string)$xml->isBreakout === 'false') ? _('Nein') : _('Ja') ?></td>
    </tr>
    <? if ($xml->attendees) : ?>
        <td><?= _('Teilnehmer') ?></td>
        <td>
            <ul>
                <? foreach ($xml->attendees->attendee as $attendee) : ?>
                    <li><?= htmlReady((string)$attendee->fullName)?></li>
                <? endforeach ?>
            </ul>
        </td>
    <? endif ?>
</table>