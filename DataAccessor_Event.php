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
     * @param array Event constraints with keys as individual constraint names.
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
     * @var string
     */
    protected $_collection;

    /**
     * Instance of mongo database.
     * @var MongoDB instance
     */
    protected $_db;

    /**
     * Instantiate new instance of mongo database
     * and set class collection to mongoDB events collection.
     */
    protected function _constructDb()
    {
        $mongoConnection = new Mongo();
        $this->_db = $mongoConnection->selectDB($this->_databaseName);
        $this->_collection = new MongoCollection($this->_db, $this->_collectionName);
    }
}
?>
