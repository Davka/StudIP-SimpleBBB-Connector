<?php
/**
 * @author  David Siegfried <david.siegfried@uni-vechta.de>
 * @license GPL2 or any later version
 */

namespace Vec\BBB;

use Config;
use Exception;
use PDO;
use Studip;

class GreenlightConnection
{
    private static $instance = null;

    public static function Get(): GreenlightConnection
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $config = Config::Get()->GREENLIGHT_CONNECTION;

        if (!$config) {
            throw new Exception('POS connection is not configured');
        }

        return self::$instance = new self(
            $config['host'][Studip\ENV],
            $config['user'],
            $config['password'],
            $config['schema']
        );
    }

    private $connection;

    private function __construct($host, $username, $password, $schema)
    {
        $dsn              = sprintf(
            'pgsql:host=%s;user=%s;password=%s;dbname=%s',
            $host, $username, $password, $schema
        );
        $this->connection = new PDO($dsn);
        $this->connection->exec("SET NAMES 'UTF-8'");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function query($query, $parameters = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($parameters);
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($statement as $row) {
            $row = array_map('trim', $row);

            yield $row;
        }
    }


    public function countRooms(): int
    {
        $sql = "SELECT COUNT(*) FROM rooms";
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        return $stm->fetchColumn();
    }
}