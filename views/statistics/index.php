<section class="bbb-metrics">
    <? if (!empty($current_month_complete)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= sprintf(_('Statistik für %s'), strftime('%B')) ?></h1>
            </header>
            <section>
                <canvas id="bar-chart" style="width: 100%; height: 400px"></canvas>
                <script>
                    var ctx = document.getElementById('bar-chart').getContext('2d')
                    window.chartColors = {
                        redDark: 'rgba(255, 99, 132, 0.2)',
                        red: 'rgba(255, 99, 132, 1)',
                        blueDark: 'rgba(54, 162, 235, 0.2)',
                        blue: 'rgba(54, 162, 235, 1)',
                        yellowDark: 'rgba(255, 206, 86, 0.2)',
                        yellow: 'rgba(255, 206, 86, 1)',
                        greenDark: 'rgba(75, 192, 192, 0.2)',
                        green:'rgba(75, 192, 192, 1)',
                        purpleDark: 'rgba(153, 102, 255, 0.2)',
                        purple:'rgba(153, 102, 255, 1)',
                        brownDark:'rgba(255, 159, 64, 0.2)',
                        brown:'rgba(255, 159, 64, 1)'
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= $labels ?>,
                            datasets: [{
                                label: '# <?= strftime('%B')?>',
                                data: <?= $current_month_complete ?>,
                                backgroundColor: [
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                    window.chartColors.redDark,
                                ],
                                borderColor: [
                                    window.chartColors.red,
                                    window.chartColors.red,
                                    window.chartColors.red,
                                    window.chartColors.red,
                                    window.chartColors.red,
                                    window.chartColors.red,
                                    window.chartColors.red,
                                ],
                                borderWidth: 1
                            }, {
                                label: '# <?= _('Heute')?>',
                                data: <?= $today_complete ?>,
                                backgroundColor: [
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                    window.chartColors.blueDark,
                                ],
                                borderColor: [
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                    window.chartColors.blue,
                                ],
                                borderWidth: 1
                            }, {
                                label: '# <?= _('Diese Woche')?>',
                                data: <?= $current_week_complete ?>,
                                backgroundColor: [
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                    window.chartColors.greenDark,
                                ],
                                borderColor: [
                                    window.chartColors.green,
                                    window.chartColors.green,
                                    window.chartColors.green,
                                    window.chartColors.green,
                                    window.chartColors.green,
                                    window.chartColors.green,
                                    window.chartColors.green,
                                ],
                                borderWidth: 1
                            }, {
                                label: '# <?= _('Letzte Woche')?>',
                                data: <?= $last_week_complete ?>,
                                backgroundColor: [
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                    window.chartColors.yellowDark,
                                ],
                                borderColor: [
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                    window.chartColors.yellow,
                                ],
                                borderWidth: 1
                            }
                            ]
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
                    <caption><?= sprintf(_('Die größesten Konferezen (im %s)'), strftime('%B')) ?></caption>
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