<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

namespace Vec\BBB;

use SimpleORMap;

class Category extends SimpleORMap
{
    protected static function configure($config = [])
    {
        $config['db_table'] = 'bigbluebutton_category';

        $config['has_many']['servers'] = [
            'class_name'        => Server::class,
            'assoc_foreign_key' => 'category_id',
        ];
        parent::configure($config);
    }
}