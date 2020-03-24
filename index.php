

<?php

require 'vendor/autoload.php';

use PostgreSQL\Connection as Connection;
use PostgreSQL\TableCreator as TableCreator;
use PostgreSQL\DataCreator as DataCreator;

$db_connection = NAN;
try {
    $db_connection = Connection::get()->connect();
    TableCreator::get()->create($db_connection);
    DataCreator::get()->create($db_connection);
    Connection::get()->disconnect();
} catch (Exception $e) {
    Connection::get()->disconnect();
    echo $e->getMessage();
}

