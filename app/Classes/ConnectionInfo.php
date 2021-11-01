<?php


namespace App\Classes;


use Illuminate\Support\Str;

class ConnectionInfo
{
    protected static $instance;

    public $db_connection;
    public $db_name;
    public $db_host;
    public $db_port;
    public $db_username;
    public $db_password;

    /**
     * @return mixed
     */
    public function getDbConnection() {
        return $this->db_connection;
    }

    /**
     * @return mixed
     */
    public function getDbName() {
        return $this->db_name;
    }

    /**
     * @return mixed
     */
    public function getDbHost() {
        return $this->db_host;
    }

    /**
     * @return mixed
     */
    public function getDbPort() {
        return $this->db_port;
    }

    /**
     * @return mixed
     */
    public function getDbUsername() {
        return $this->db_username;
    }

    /**
     * @return mixed
     */
    public function getDbPassword() {
        return $this->db_password;
    }

    public static function getInstance(string $project_name): ConnectionInfo {
        if (!self::$instance) {
            $connection_info = new ConnectionInfo();
            $password = Str::random();
            $connection_info->db_connection = "mysql";
            $connection_info->db_host = "{$project_name}_db";
            $connection_info->db_name = $project_name;
            $connection_info->db_port = 3306;
            $connection_info->db_username = 'root';
            $connection_info->db_password = $password;
            self::$instance = $connection_info;
        }

        return self::$instance;
    }
}
