<?php


namespace PostgreSQL;


class DataCreator
{
    /**
     * Creator
     * @var type
     */
    private static $dataCreator;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \void #deprecated
     * @throws \Exception
     */
    public function generateRandomString($length = 10) : string {
        // Source
        //https://stackoverflow.com/questions/4356289/php-random-string-generator
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandomFloat($min, $max) : float {
        //Source
        // https://stackoverflow.com/questions/14155603/random-float-number-between-0-and-1-0-php
        return rand($min, $max - 1) + (rand(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
    }
    public function create($db_connection) {

        $numRows = 777;

        for ($x = 0; $x < $numRows; $x++) {
            $age = rand(15 , 35);
            $sexChoice = rand(15 , 35);
            if ($age%$sexChoice < 35-15){
                $query = "insert into interop2.public.person(personid, age, sex)
                values($x, $age, 'm')
                on conflict (personid) do nothing";
            } else {
                $query = "insert into interop2.public.person(personid, age, sex)
                values($x, $age, 'w')
                on conflict (personid) do nothing";
            }

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table person created successfully<br>";


        for ($x = 0; $x < $numRows; $x++) {

            $firstName = DataCreator::generateRandomString(10);
            $middleName = DataCreator::generateRandomString(10);
            $lastName = DataCreator::generateRandomString(10);

            $query = "insert into interop2.public.personname(personid, firstname, middlename, lastname)
            values($x, '$firstName', '$middleName', '$lastName')
            on conflict (personid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table personname created successfully<br>";



        for ($x = 0; $x < $numRows; $x++) {
            $budget = DataCreator::generateRandomFloat(0.1, 1000.0);
            $numpcs = rand (1, 10);
            $numbeers = rand(1, 100);
            $capacity = rand (1,20);

            $query = "insert into interop2.public.host(hostid, budget, numgamingpcs, availablebeer, maxroomcapacity)
            values($x, $budget, $numpcs, $numbeers, $capacity)
            on conflict (hostid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table host created successfully<br>";




        for ($x = 0; $x < $numRows; $x++) {
            $city = DataCreator::generateRandomString(10);
            $street = DataCreator::generateRandomString(10);
            $number = rand(1, 100);
            $door =  rand(1,100);

            $query = "insert into interop2.public.hostaddress(hostid, cityname, street, number, door)
            values($x, '$city', '$street', $number, $door)
            on conflict (hostid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table hostaddress created successfully<br>";


        return;
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$dataCreator) {
            static::$dataCreator = new static();
        }

        return static::$dataCreator;
    }

    protected function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }
}
