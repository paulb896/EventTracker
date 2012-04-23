<?php



// Setup test data.












class DataAccessor_EventTest
{
    /**
     * Setup test data and test mongo database.
     */
    public function __construct()
    {
        $this->_testData['event1'] = array(
            'dateTime' => '2012-12-24 18:56:35',
            'timestamp' => date("Y-m-d H:i:s"),
            'shortDescription' => 'End of civilization as we currently know it',
            'location' => '-33.8670522,151.1957362',
            'userEmail' => 'fake@fake.ca'
        );

        $this->_testData['event2'] = array(
            'dateTime' => '1995-05-23 11:00:00',
            'timestamp' => date("Y-m-d H:i:s"),
            'shortDescription' => 'I really ',
            'location' => '-33.8670522,151.1957362',
            'userEmail' => 'fake2@fake.ca'
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

        $event->insertIntoCollection($this->_testData['event1']);

        $collection = new MongoCollection($this->_testDatabase, 'events');
        $dataFromTestDB = $collection->findOne();

        if ($this->_testData['event1']['dateTime'] != $dataFromTestDB['dateTime']) {
            print "\n\n ! An error has occurred while attempting to save an event.\n\n";
        }
    }

    /**
     * Verify find event functionality.
     */
    public function testFind()
    {
        //print "\nRunning get events test.";
        //$allEventsForUser1 = $event->getAll(array('userEmail' => $testEventDataExample1['userEmail']));
        //if (count($allEventsForUser1) !== 1) {
            
        //};
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
$eventTestClass = new DataAccessor_EventTest();
$eventTestClass->testSave();

print "\nTesting has finished!\n\n";
?>
