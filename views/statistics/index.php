<section class="bbb-metrics">
    <? if(!empty($current_month_complete)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= sprintf(_('Statistik für %s'), strftime('%B'))?></h1>
            </header>
            <section>
                <div class="bar ct-chart ct-golden-section ct-negative-labels"></div>
                <div class="pie ct-chart ct-golden-section ct-negative-labels"></div>
                <script>
                    var data = {
                        labels: <?= json_encode(array_keys($current_month_complete))?>,
                        series: <?= json_encode(array_map('intval', array_values($current_month_complete)))?>
                    }
                    console.log(data);
                    new Chartist.Bar('.bar', data , {
                        distributeSeries: true,
                    }).on('draw', function(data) {
                        if(data.type === 'bar') {
                            data.element.attr({
                                style: 'stroke-width: 30px'
                            });
                        }
                    });
                    const sum = function(a, b) {return a + b };
                    new Chartist.Pie('.pie ', {series: data.series} , {
                        labelInterpolationFnc: function(value) {

                            return Math.round(value / data.series.reduce(sum) * 100) + '%';
                        }
                    });
                </script>
            </section>
        </section>
    <? endif?>

</section>