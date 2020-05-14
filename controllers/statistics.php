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

        $this->current_month_complete = Metric::getStatistics('current_month');
    }
}