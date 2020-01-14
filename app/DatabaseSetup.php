<?php

namespace App;

use Illuminate\Support\Str;

class DatabaseSetup
{
    protected $host_name;

    public function __construct()
    {

        if (isset($_SERVER['HTTP_HOST'])) {
            $this->host_name = $_SERVER['HTTP_HOST'];
        } else {
            $this->host_name = "127.0.0.1:8000";
        }
    }

    public function setDatabase()
    {
        $db_host_name = Str::slug($this->host_name);


        $db_list = config('dblist');

        if (!isset($db_list[$db_host_name])) {
            $db_host_name = "default";
        }

        $database = $db_list[$db_host_name]['database'];
        $username = $db_list[$db_host_name]['username'];
        $password = $db_list[$db_host_name]['password'];


        config()->set('database.connections.mysql.database', $database);
        config()->set('database.connections.mysql.username', $username);
        config()->set('database.connections.mysql.password', $password);
    }
}
