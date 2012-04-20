<?php
/**
 * MongoDB relations for events.
 */
class DataAccessor_Event
{
    /**
     * Save an event to mongoDB.
     * @param array An array of event information for a single event.
     *   Example $event = array(
     *    "time" => "",
     *    "company" => "General Auto Shoppe",
     *    "shortDescription" => "Repair Car Starter",
     *    "userEmail" => "ftw@hotmail.com",
     *    "Location" => "-33,151", //Google api input format Longitude/Latatude,
     *   )
     */
    public function saveEvent(array $event)
    {
        // todo: Add validation for event information.
        $this->_constructDb();
        $this->_collection->insert($event);
    }

    /**
     * Find all events that match event constraints.
     *
     * @param array $eventConstraints Constraints with keys as
     *              individual constraint names.
     *   Example $constraints = array(
     *    "startTime" => "",
     *    "company" => "General Auto Shoppe",
     *    "shortDescription" => "Repair Car Starter",
     *    "userEmail" => "ftw@hotmail.com",
     *    "Location" => "-33,151", //Google api input format Longitude/Latatude,
     *   )
     * 
     * @return array Array of single event information arrays.
     */
    public function getEvents(array $eventConstraints)
    {
        
    }

	/**
	 * Assign key with name to value parameter.
	 * 
	 * @param $key Option name.
	 * @param $value Value to assign
	 * 
	 * todo: Add check for valid option key names.
	 */
	public function __set($key, $value)
	{
		$this->_options[$key] = $value;
	}

    /**
     * Name of mongo database.
     * @var string
     */
    protected $_databaseName = 'myNewDatabase';

    /**
     * Name of mongo database.
     * @var string
     */
    protected $_collectionName = 'events';

    /**
     * Instance of mongo collection.
     * @var MongoCollection
     */
    protected $_collection;

    /**
     * Instance of mongo database.
     * @var MongoDB
     */
    protected $_db;

	/**
	 * Array of key/value paired options.
	 * @var MongoCollection
	 */
	protected $_options = array();

    /**
     * Instantiate new instance of mongo database
     * and set class collection to mongoDB events collection.
     * 
     * todo: Move this into individual db class.
     */
    protected function _constructDb()
    {
        $mongoConnection = new Mongo();

        // todo: Is a pattern forming,.. dun, dun, da!?!
        $databaseName = $this->_databaseName;
        $collectionName = $this->_collectionName;

        // Apply db options.
        if (array_key_exists('databaseName', $this->_options)) {
			$databaseName = $this->_options['databaseName'];
		}
		if (array_key_exists('collectionName', $this->_options)) {
			$collectionName = $this->_options['collectionName'];
		}

        $this->_db = $mongoConnection->selectDB($databaseName);
        $this->_collection = new MongoCollection($this->_db, $collectionName);
    }
}
?>
