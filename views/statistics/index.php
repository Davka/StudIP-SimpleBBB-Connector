<section class="bbb-metrics">
    <? if (!empty($dataset)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= sprintf(_('Statistik für %s'), strftime('%B')) ?></h1>
            </header>
            <section>
                <canvas id="bar-chart" style="width: 100%; height: 400px"></canvas>
                <script>
                    var ctx = document.getElementById('bar-chart').getContext('2d')
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: <?= $dataset?>,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </section>
            <? if (!empty($biggest_meetings)) : ?>
                <table class="default">
                    <caption><?= sprintf(_('Die größesten Konferenzen (im %s)'), strftime('%B')) ?></caption>
                    <thead>
                        <tr>
                            <th><?= _('Meeting-Name') ?></th>
                            <th><?= _('Anzahl TeilnehmerInnen') ?></th>
                            <th><?= _('Anzahl Video') ?></th>
                            <th><?= _('Anzahl ZuhörerInnen') ?></th>
                            <th><?= _('Anzahl Audio') ?></th>
                            <th><?= _('Anzahl ModeratorenInnen') ?></th>
                            <th><?= _('Ist BreakOut-Raum') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($biggest_meetings as $meeting) : ?>
                            <tr>
                                <td><?= htmlReady($meeting['meeting_name']) ?></td>
                                <td><?= htmlReady($meeting['participant_count']) ?></td>
                                <td><?= htmlReady($meeting['video_count']) ?></td>
                                <td><?= htmlReady($meeting['listener_count']) ?></td>
                                <td><?= htmlReady($meeting['voice_participant_count']) ?></td>
                                <td><?= htmlReady($meeting['moderator_count']) ?></td>
                                <td><?= $meeting['is_break_out'] === 1 ? _('Ja') : _('Nein') ?></td>
                            </tr>
                        <? endforeach ?>
                    </tbody>
                </table>
            <? endif ?>
        </section>
    <? endif ?>
</section>