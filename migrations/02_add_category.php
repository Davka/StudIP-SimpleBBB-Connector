<?php

class AddCategory extends Migration
{
    public function up()
    {
        DBManager::get()->exec(
            'CREATE TABLE `bigbluebutton_category` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) DEFAULT NULL,
              `mkdate` int(11) DEFAULT NULL,
              `chdate` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
        DBManager::get()->exec("ALTER TABLE `bigbluebutton_servers` ADD `category_id` int(11) DEFAULT NULL AFTER `id`");
        SimpleORMap::expireTableScheme();
    }
}