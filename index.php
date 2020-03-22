

<?php

require 'vendor/autoload.php';

use PostgreSQL\Connection as Connection;
use PostgreSQL\TableCreator as TableCreator;

$db_connection = NAN;
try {
    $db_connection = Connection::get()->connect();
    TableCreator::get()->create($db_connection);
    Connection::get()->disconnect();
} catch (Exception $e) {
    Connection::get()->disconnect();
    echo $e->getMessage();
}

