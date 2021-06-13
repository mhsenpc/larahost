<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Str;

class ConnectionInfoGenerator
{
    public static function generate(string $project_name): ConnectionInfo {
        $connection_info                = new ConnectionInfo();
        $password                       = Str::random();
        $connection_info->db_connection = "mysql";
        $connection_info->db_host       = "{$project_name}_db";
        $connection_info->db_name       = $project_name;
        $connection_info->db_port       = 3306;
        $connection_info->db_username   = 'root';
        $connection_info->db_password   = $password;
        return $connection_info;
    }
}
