<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

namespace Vec\BBB;

use SimpleORMap;

class Server extends SimpleORMap
{
    protected static function configure($config = [])
    {
        $config['db_table'] = 'bigbluebutton_servers';

        $config['belongs_to']['category'] = [
            'class_name'  => Category::class,
            'foreign_key' => 'category_id',
        ];
        parent::configure($config);
    }
}