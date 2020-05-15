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
    }

    public function index_action()
    {
        Navigation::activateItem('simplebbbconnector/statistics/index');
        PageLayout::setTitle(_('Statistik'));
        $current_month_complete = Metric::getStatistics('current_month');
        $today_complete = Metric::getStatistics('today');

        $this->labels = json_encode(array_keys($current_month_complete));
        $this->current_month_complete = json_encode(array_map('intval', array_values($current_month_complete)));
        $this->today_complete = json_encode(array_map('intval', array_values($today_complete)));
        $this->biggest_meetings = Metric::getStatistics('current_month', 'all', 10);
    }
}