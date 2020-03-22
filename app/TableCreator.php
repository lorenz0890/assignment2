<?php

namespace PostgreSQL;

/**
 * SOURCE: https://www.postgresqltutorial.com/postgresql-php/connect/
 * Represent the Connection
 */
class TableCreator {

    /**
     * Creator
     * @var type
     */
    private static $creator;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \void #deprecated
     * @throws \Exception
     */
    public function create($db_connection) {
        $query = "create table if not exists interop2.public.person(
        personid integer not null primary key,
        age integer not null,
        sex varchar(6) not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table person created successfully<br>";
        }



        $query = "create table if not exists interop2.public.personname(
        personid integer not null
            primary key
            references interop2.public.person(personid)
            on delete cascade,
        firstname varchar(30) not null,
        middlename varchar(30),
        lastname varchar(30) not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table personname created successfully<br>";
        }


        $query = "create table if not exists interop2.public.host(
        hostid integer not null
            primary key
            references interop2.public.person(personid)
            on delete cascade,
        budget float not null,
        numgamingpcs integer not null,
        availablebeer integer not null,
        maxroomcapacity integer not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table host created successfully<br>";
        }



        $query = "create table if not exists interop2.public.hostaddress(
        hostid integer not null
            primary key
            references interop2.public.host(hostid)
            on delete cascade,
        cityname varchar(30) not null,
        street varchar(30) not null,
        number integer not null,
        door integer not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table hostaddress created successfully<br>";
        }


        $query = "create table if not exists interop2.public.friend(
        friendid integer not null
            primary key
            references interop2.public.person(personid)
            on delete cascade,
        invitinghostid integer not null
            references interop2.public.person(personid),
        wantedbeers integer not null,
        friendscince date not null,
        friendimportance integer not null
            constraint importance_positive check (0 < friendimportance),
        christian bool not null,
        jewish bool not null,
        islamic bool not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table friend created successfully<br>";
        }

        return;
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$creator) {
            static::$creator = new static();
        }

        return static::$creator;
    }

    protected function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }

}
