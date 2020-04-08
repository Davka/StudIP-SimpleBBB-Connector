<?php

class InitDb extends Migration
{
    public function up()
    {
        DBManager::get()->exec("
        CREATE TABLE `bigbluebutton_servers` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
          `url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
          `secret` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
          `mkdate` int(11) DEFAULT NULL,
          `chdate` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
        );
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        DBManager::get()->exec('DROP TABLE `bigbluebutton_servers`');
        SimpleORMap::expireTableScheme();
    }
}