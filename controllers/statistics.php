<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

use Vec\BBB\Controller;
use Vec\BBB\Metric;

class StatisticsController extends Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Metric::collect();
        $this->buildSidebar();
    }

    public function index_action()
    {
        Navigation::activateItem('simplebbbconnector/statistics/index');
        PageLayout::setTitle(_('Statistik'));
        $current_month_complete = Metric::getStatistics('current_month');
        $data = ['labels' => array_keys($current_month_complete)];
        $data['datasets'][] = $this->buildDataSet(strftime('%B'), $current_month_complete, 'red', 'redDark');
        $data['datasets'][] = $this->buildDataSet(_('Diese Woche'), Metric::getStatistics('current_week'), 'blue', 'blueDark');
        $data['datasets'][] = $this->buildDataSet(_('Letzte Woche'), Metric::getStatistics('last_week'), 'green', 'greenDark');
        $data['datasets'][] = $this->buildDataSet(_('Heute'), Metric::getStatistics('today'), 'yellow', 'yellowDark');
        $data['datasets'][] = $this->buildDataSet(_('Gestern'), Metric::getStatistics('yesterday'), 'purple', 'purpleDark');
        $this->dataset = json_encode($data);
        $this->biggest_meetings = Metric::getStatistics('current_month', 'all', 10);
    }

    public function export_csv_action()
    {
        $results = Metric::getExport();
        $this->render_csv(
            $results,
            'BigBlueButtonStatistik_' . time() . '.csv'
        );
    }

    public function buildDataSet($label, $data, $border_color, $background_color)
    {
        $set = [
            'label' => $label,
            'data' => array_map('intval', array_values($data)),
            'borderWidth' => 1
        ];

        for ($i = 0; $i < count($data); $i++) {
            $set['borderColor'][] = $this->getColor($border_color);
            $set['backgroundColor'][] = $this->getColor($background_color);
        }
        return $set;
    }

    private function getColor($color)
    {
        $colors = [
            'redDark' => 'rgba(255, 99, 132, 0.2)',
            'red' => 'rgba(255, 99, 132, 1)',
            'blueDark' => 'rgba(54, 162, 235, 0.2)',
            'blue' => 'rgba(54, 162, 235, 1)',
            'yellowDark' => 'rgba(255, 206, 86, 0.2)',
            'yellow' => 'rgba(255, 206, 86, 1)',
            'greenDark' => 'rgba(75, 192, 192, 0.2)',
            'green' => 'rgba(75, 192, 192, 1)',
            'purpleDark' => 'rgba(153, 102, 255, 0.2)',
            'purple' => 'rgba(153, 102, 255, 1)',
            'brownDark' => 'rgba(255, 159, 64, 0.2)',
            'brown' => 'rgba(255, 159, 64, 1)'
        ];
        return $colors[$color];
    }

    private function buildSidebar()
    {
        $template_factory = new Flexi_TemplateFactory(__DIR__ . '/../templates');
        $template = $template_factory->open('date-export-widget.php');
        $template->url = $this->url_for('statistics/export_csv');
        $exports = new SidebarWidget();
        $exports->setTitle(_('CSV-Export'));
        $exports->addElement(
            new WidgetElement($template->render())
        );

        Sidebar::Get()->addWidget($exports);
    }
}