<?php

echo "\n Now running event data accessor test\n\n";

// Setup test data.

$testEventDataExample1 = array(
    'dateTime' => '2012-12-24 18:56:35',
    'timestamp' => date("Y-m-d H:i:s"),
    'shortDescription' => 'End of civilization as we currently know it',
    'location' => '-33.8670522,151.1957362',
    'userEmail' => 'fake@fake.ca'
);

$testEventDataExample2 = array(
    'dateTime' => '1995-05-23 11:00:00',
    'timestamp' => date("Y-m-d H:i:s"),
    'shortDescription' => 'I really ',
    'location' => '-33.8670522,151.1957362',
    'userEmail' => 'fake2@fake.ca'
);

$testDBName = 'myTestDatabase942';
$testCollectionName = 'notKnownAsEventAnymore';

require_once '../DataAccessor_Event.php';
$event = new DataAccessor_Event();

// Set event object database to test database.
$event->databaseName = $testDBName;

// Set event collection name to test name.
$event->collectionName = $testCollectionName;

// Setup test mongo database.
$mongoConnection = new Mongo();
$testDB = $mongoConnection->selectDB($testDBName);
$collection = new MongoCollection($testDB, $testCollectionName);

// Test to save event.
print "\nRunning save event test.";
$event->saveEvent($testEventDataExample1);
$dataFromTestDB = $collection->findOne();
if ($testEventDataExample1['dateTime'] != $dataFromTestDB['dateTime']) {
    print "\n\n ! Error has occurred while attempting to save an event.\n\n";
}

// Save an extra record to verify that the query works properly.
$event->saveEvent($testEventDataExample2);

// Running test to get events.
print "\nRunning get events test.";
$allEventsForUser1 = $event->getEvents(array('userEmail' => $testEventDataExample1['userEmail']));
if (count($allEventsForUser1) !== 1) {
	
};

// Delete data from test database.
$testDB->drop();

print "\nTesting has finished!\n\n";
?>
