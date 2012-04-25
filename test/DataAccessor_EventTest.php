<?php

/**
 * Class that tests functions contained in DataAccessor_Event.
 */
class DataAccessor_EventTest
{
    /**
     * Setup test data and test mongo database.
     */
    public function __construct()
    {
        $this->_testData['event1'] = array(
            'startDateTime' => '2012-12-24 18:56:35',
            'endDateTime' => '2012-12-6 3:56:00',
            'timestamp' => date("Y-m-d H:i:s"),
            'shortDescription' => 'End of civilization as we currently know it',
            'location' => '-33.8670522,151.1957362',
            'userEmail' => 'fake@fake.ca'
        );

        $this->_testData['event2'] = array(
            'dateTime' => '1995-05-23 11:00:00',
            'endTime' => '1995-05-23 13:00:00',
            'timestamp' => date("Y-m-d H:i:s"),
            'shortDescription' => 'Watch great movie',
            'location' => '-33.8670522,151.1957362',
            'userEmail' => 'fake2@fake.ca'
        );

        $this->_testData['invalidEvent1'] = array(
            'invalidEventAttribute' => 'someValue'
        );

        $mongoConnection = new Mongo();
        $this->_testDatabase = $mongoConnection->selectDB($this->_testDatabaseName);
    }

    /**
     * Drop test mongo database.
     */
    public function __destruct()
    {
        // Delete data from test database.
        $this->_testDatabase->drop();
    }

    /**
     * Verify save functionality.
     */
    public function testSave()
    {
        print "\nRunning save event test.";

        require_once '../DataAccessor_Event.php';
        $event = new DataAccessor_Event();
        // Set event object database to test database.
        $event->databaseName = $this->_testDatabaseName;

        if ($event->insertIntoCollection($this->_testData['event1']) !== true) {
            print "\n\n ! An error has occurred while attempting to save an event.\n\n";
        }
    }

    /**
     * Test save function with invalid data.
     */
    public function testSaveInvalidEvent()
    {
        $event = new DataAccessor_Event();
        if ($event->insertIntoCollection($this->_testData['invalidEvent1']) !== false) {
            print "\n\n ! An error has occurred while attempting to save an invalid event.\n\n";
        }
    }

    /**
     * Verify find event functionality.
     */
    public function testGetAll()
    {
        print "\nRunning get events test.";

        $event = new DataAccessor_Event();
        $event->databaseName = $this->_testDatabaseName;
        $allEventsForUser1 = $event->getAll(array('userEmail' => $this->_testData['event1']['userEmail']));
        if (count($allEventsForUser1) !== 1) {
            print "\n\n ! Could not find event from save test.\n\n";
        };
    }

    /**
     * Array of input test data keyed by data name.
     */
    protected $_testData;

    /**
     * Name of mongo database we will use for testing.
     * @var string
     */
    protected $_testDatabaseName = 'myTestDatabase942';

    /**
     * Instance of mongo database connection.
     * @var MongoDB
     */
    protected $_testDatabase;
}

echo "\n Now running tests to exercise event class\n\n";
$eventTestInstance = new DataAccessor_EventTest();
$eventTestInstance->testSave();
$eventTestInstance->testSaveInvalidEvent();
$eventTestInstance->testGetAll();

print "\nTesting has finished!\n\n";
?>
