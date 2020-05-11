<?php

/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */
class AddGreenlightConfig extends Migration
{
    public function up()
    {
        if (!Config::get()->GREENLIGHT_CONNECTION) {
            Config::get()->create('GREENLIGHT_CONNECTION', [
                'value'       => '',
                'is_default'  => 0,
                'type'        => 'array',
                'range'       => 'global',
                'section'     => 'BigBlueButtonConnector',
                'description' => 'Verbindungsdaten für die Greenlight-Datenbank',
            ]);
        }
    }

    public function down()
    {
    }
}
