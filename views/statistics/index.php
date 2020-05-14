<section class="bbb-metrics">
    <? if(!empty($current_month_complete)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= sprintf(_('Statistik für %s'), strftime('%B'))?></h1>
            </header>
            <section class="bbb-metrics month-chart">
                <script>
                    new Chartist.Bar('.month-chart', {
                        labels: <?= json_encode(array_keys($current_month_complete))?>,
                        series: <?= json_encode(array_values($current_month_complete))?>
                    }, {
                        distributeSeries: true,
                    }).on('draw', function(data) {
                        if(data.type === 'bar') {
                            data.element.attr({
                                style: 'stroke-width: 30px'
                            });
                        }
                    });
                </script>
            </section>
        </section>
    <? endif?>

</section>