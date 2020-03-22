<?php

namespace PostgreSQL;

/**
 * SOURCE: https://www.postgresqltutorial.com/postgresql-php/connect/
 * Represent the Connection
 */
class Connection {

    /**
     * Connection
     * @var type
     */
    private static $conn;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \Resource
     * @throws \Exception
     */
    public function connect() {
        // read parameters in the ini configuration file
        $params = parse_ini_file('database.ini');
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }

        // connect to the postgresql database
        $conStr = sprintf("host=%s port=%s dbname=%s user=%s password=%s connect_timeout=5",
            $params['host'],
            $params['port'],
            $params['database'],
            $params['user'],
            $params['password']);
        #echo $conStr;

        #$conStr = sprintf("host=localhost port=5432 dbname=interop2 user=lorenzk90
        #password=lorenzk220890 connect_timeout=5");
        $db_connection = pg_pconnect($conStr);
        echo("A connection to the PostgreSQL database sever has been established successfully<br>");
        return $db_connection;
    }

    public function disconnect(){
        pg_close();
        echo("A connection to the PostgreSQL database sever has been closed successfully<br>");
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn;
    }

    protected function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }

}
