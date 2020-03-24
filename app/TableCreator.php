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
    private static $tableCreator;

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



        $query = "create table if not exists interop2.public.partydate(
        date date not null primary key,
        christianholyday bool not null,
        jewishholyday bool not null,
        islamicholyday bool not null,
        nationalholyday bool not null,
        weekend bool not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table partydate created successfully<br>";
        }





        $query = "create table if not exists interop2.public.hastime(
        personid integer not null
            references interop2.public.person(personid)
            on delete  cascade,
        date date not null
            references interop2.public.partydate(date)
            on delete  cascade,
        primary key (personid, date)
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table hastime created successfully<br>";
        }


        $query = "create table if not exists interop2.public.supermarket(
        supermarketid integer not null
            primary key
            references interop2.public.person(personid),
        availablebeer integer not null,
        beeprice float not null,
        name varchar(30) not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table supermarket created successfully<br>";
        }



        $query = "create table if not exists interop2.public.supermarketaddress(
        supermarketid integer not null
            primary key
            references interop2.public.supermarket(supermarketid)
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
            echo "Table supermarketaddress created successfully<br>";
        }




        $query = "create table if not exists interop2.public.buysfrom(
        supermarketid integer not null
            references interop2.public.supermarket(supermarketid)
            on delete cascade,
        hostid integer not null
            references interop2.public.host(hostid)
            on delete cascade,
        primary key (supermarketid, hostid)
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table buysfrom created successfully<br>";
        }



        $query = "create table if not exists interop2.public.game(
        gameid integer not null primary key,
        title varchar(30) not null,
        releasedate date not null,
        funfactor integer not null
            constraint funfactor_positive check (0 < funfactor),
        multiplayer integer not null
            constraint multiplayer_positive check (0 < multiplayer),
        sellprice float not null
            constraint sellprice_positive check (0 < sellprice),
        minimumage integer not null
            constraint minimumage_positive check (0 < minimumage),
        genre varchar(30) not null
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table game created successfully<br>";
        }




        $query = "create table if not exists interop2.public.owns(
        gameid integer not null
            references interop2.public.game(gameid)
            on delete cascade,
        hostid integer not null
            references interop2.public.host(hostid)
            on delete cascade,
        primary key (gameid, hostid)
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table owns created successfully<br>";
        }




        $query = "create table if not exists interop2.public.wants(
        gameid integer not null
            references interop2.public.game(gameid)
            on delete cascade,
        friendid integer not null
            references interop2.public.friend(friendid)
            on delete cascade,
        primary key (gameid, friendid)
                   )";
        $result = pg_query($db_connection, $query);
        if(!$result) {
            echo pg_last_error($db_connection);
        } else {
            echo "Table wants created successfully<br>";
        }



        return;
    }

    /**
     * return an instance of the tablecreator object
     * @return type
     */
    public static function get() {
        if (null === static::$tableCreator) {
            static::$tableCreator = new static();
        }

        return static::$tableCreator;
    }

    protected function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }

}
