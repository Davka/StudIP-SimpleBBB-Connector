import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.register(ChartDataLabels);
STUDIP.domReady(() => {
    const bar = $('#bar-chart');

    if (bar.length) {
        let ctx = bar.get(0).getContext('2d')
        let data = bar.data('set');

        new Chart(ctx, {
            plugins: [ChartDataLabels],
            type: 'bar',
            data: data,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMin: 0,
                        beginAtZero: true
                    }
                }]
            }
        });
    }
});
