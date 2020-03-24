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
        // https://stackoverflow.com/questions/4356289/php-random-string-generator
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandomFloat($min, $max) : float {
        // Source
        // https://stackoverflow.com/questions/14155603/random-float-number-between-0-and-1-0-php
        return rand($min, $max - 1) + (rand(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
    }

    function generateRandomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s')
    {   //Source:
        // https://gist.github.com/samcrosoft/6550473
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }

    function generateDateRangeArray($strDateFrom,$strDateTo) : array {
        // Source
        // https://stackoverflow.com/questions/4312439/php-return-all-dates-between-two-dates-in-an-array
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
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



        for ($x = 0; $x < $numRows; $x++) {
            $inviteid = rand(350, 375);
            $wantedbeers =  rand(1,20);
            $friendsscience = DataCreator::generateRandomDate('1995-02-1', '2020-02-1');
            $importance =  rand(1,10);
            $christian = (bool)rand(0,1);
            $jewish = (bool)rand(0,1);
            $islamic = (bool)rand(0,1);

            if($christian){
                $query = "insert into interop2.public.friend(friendid, invitinghostid, wantedbeers, friendscince, friendimportance, christian, jewish, islamic)
                values($x, $inviteid, $wantedbeers, '$friendsscience', $importance, true, false, false)
                on conflict (friendid) do nothing";
            } else if ($islamic) {
                $query = "insert into interop2.public.friend(friendid, invitinghostid, wantedbeers, friendscince, friendimportance, christian, jewish, islamic)
                values($x, $inviteid, $wantedbeers, '$friendsscience', $importance, false, true, false)
                on conflict (friendid) do nothing";
            } else if ($jewish){
                $query = "insert into interop2.public.friend(friendid, invitinghostid, wantedbeers, friendscince, friendimportance, christian, jewish, islamic)
                values($x, $inviteid, $wantedbeers, '$friendsscience', $importance, false, false, true)
                on conflict (friendid) do nothing";
            } else {
                $query = "insert into interop2.public.friend(friendid, invitinghostid, wantedbeers, friendscince, friendimportance, christian, jewish, islamic)
                values($x, $inviteid, $wantedbeers, '$friendsscience', $importance, false, false, false)
                on conflict (friendid) do nothing";
            }

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table friend created successfully<br>";



        $daterange = DataCreator::generateDateRangeArray('2020-4-30','2024-01-01');
        for ($x = 0; $x < $numRows; $x++) {

            $pdate = $daterange[$x];
            $christian = (bool)rand(0,1);
            $jewish = (bool)rand(0,1);
            $islamic = (bool)rand(0,1);
            $weekend = (bool)rand(0,1);
            $national = (bool)rand(0,1);

            $query = "insert into interop2.public.partydate(date, christianholyday, jewishholyday, islamicholyday, nationalholyday, weekend)
            values('$pdate', %c%, %j%, %i%, %n%, %w%)
            on conflict (date) do nothing";

            if($christian){
                $query = str_replace("%c%", "true", $query);
                $query = str_replace("%j%", "false", $query);
                $query = str_replace("%i%", "false", $query);
            } else if($islamic) {
                $query = str_replace("%c%", "false", $query);
                $query = str_replace("%j%", "false", $query);
                $query = str_replace("%i%", "true", $query);
            } else if ($jewish) {
                $query = str_replace("%c%", "false", $query);
                $query = str_replace("%j%", "true", $query);
                $query = str_replace("%i%", "false", $query);
            } else {
                $query = str_replace("%c%", "false", $query);
                $query = str_replace("%j%", "false", $query);
                $query = str_replace("%i%", "false", $query);
            }
            if ($weekend) {
                $query = str_replace("%w%", "true", $query);
            } else {
                $query = str_replace("%w%", "false", $query);
            }
            if ($national) {
                $query = str_replace("%n%", "true", $query);
            } else {
                $query = str_replace("%n%", "false", $query);
            }

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table partydate created successfully<br>";



        for ($x = 0; $x < $numRows; $x++) {
            $availablebeer = rand(1,100000);
            $beerprice = $this->generateRandomFloat(1, 3);
            $name = $this->generateRandomString(15);
            $query = "insert into interop2.public.supermarket(supermarketid, availablebeer, beeprice, name)
            values($x, $availablebeer, $beerprice, '$name')
            on conflict (supermarketid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table supermarket created successfully<br>";






        for ($x = 0; $x < $numRows; $x++) {
            $city = DataCreator::generateRandomString(10);
            $street = DataCreator::generateRandomString(10);
            $number = rand(1, 100);
            $door =  rand(1,100);

            $query = "insert into interop2.public.supermarketaddress(supermarketid, cityname, street, number, door)
            values($x, '$city', '$street', $number, $door)
            on conflict (supermarketid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table supermarketadress created successfully<br>";





        for ($x = 0; $x < $numRows; $x++) {
            $title = DataCreator::generateRandomString(10);
            $release = DataCreator::generateRandomDate('1999-02-1', '2019-02-1');
            $funfactor = rand(1, 10);
            $minage = rand(16, 18);
            $multiplayer =  rand(1,128);
            $sellprice = $this->generateRandomFloat(10.0, 200.0);
            $genre = DataCreator::generateRandomString(10);

            $query = "insert into interop2.public.game(gameid, title, releasedate, funfactor, multiplayer, sellprice, minimumage, genre)
            values($x, '$title', '$release', $funfactor, $multiplayer, $sellprice, $minage, '$genre')
            on conflict (gameid) do nothing";

            $result = pg_query($db_connection, $query);
            if (!$result) {
                echo pg_last_error($db_connection);
            }
        }
        echo "Content for table game created successfully<br>";

        return;
    }

    /**
     * return an instance of the datcreator object
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
