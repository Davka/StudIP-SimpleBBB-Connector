<section class="bbb-metrics">
    <? if (!empty($current_month_complete)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= sprintf(_('Statistik für %s'), strftime('%B')) ?></h1>
            </header>
            <section>
                <canvas id="bar-chart" style="width: 100%; height: 400px"></canvas>
                <script>
                    var ctx = document.getElementById('bar-chart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= $labels ?>,
                            datasets: [{
                                label: '# <?= strftime('%B')?>',
                                data: <?= $current_month_complete ?>,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }, {
                                label: '# <?= _('Heute')?>',
                                data: <?= $today_complete ?>,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
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
                    <caption><?= _('Die größesten Konferezen')?></caption>
                    <thead>
                        <tr>
                            <th><?= _('Meeting-Name')?></th>
                            <th><?= _('Anzahl TeilnehmerInnen')?></th>
                            <th><?= _('Anzahl Video')?></th>
                            <th><?= _('Anzahl ZuhörerInnen')?></th>
                            <th><?= _('Anzahl Audio')?></th>
                            <th><?= _('Anzahl ModeratorenInnen')?></th>
                            <th><?= _('Ist BreakOut-Raum')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($biggest_meetings as $meeting) : ?>
                            <tr>
                                <td><?= htmlReady($meeting['meeting_name'])?></td>
                                <td><?= htmlReady($meeting['participant_count'])?></td>
                                <td><?= htmlReady($meeting['video_count'])?></td>
                                <td><?= htmlReady($meeting['listener_count'])?></td>
                                <td><?= htmlReady($meeting['voice_participant_count'])?></td>
                                <td><?= htmlReady($meeting['moderator_count'])?></td>
                                <td><?= $meeting['is_break_out'] === 1 ? _('Ja'): _('Nein')?></td>
                            </tr>
                        <? endforeach?>
                    </tbody>
                </table>
            <? endif ?>
        </section>
    <? endif ?>
</section>