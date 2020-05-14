<?php

/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */
class AddProxyConfig extends Migration
{
    public function up()
    {
        if (!Config::get()->BBB_API_PROXY) {
            Config::get()->create('BBB_API_PROXY', [
                'value'       => '',
                'is_default'  => 0,
                'type'        => 'array',
                'range'       => 'global',
                'section'     => 'BigBlueButtonConnector',
                'description' => 'Proxyserver für die API-Verbindung',
            ]);
        }
    }

    public function down()
    {
        if (!Config::get()->BBB_API_PROXY) {
            Config::get()->delete('BBB_API_PROXY');
        }
    }
}
