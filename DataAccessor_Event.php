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
     * @return array Array of single event information arrays.
     */
    public function getEvents(array $eventConstraints)
    {
        
    }

    /**
     * Mongo collection name.
     * @var string
     */
    protected $_collection;

    /**
     * @var MongoDB instance
     */
    protected $_db;

    /**
     * Instantiate new instance of mongo database
     * and set class collection to mongoDB events collection.
     *
     * todo: Add dynamic collection and database names.
     */
    protected function _constructDb()
    {
        $mongoDatabase = new Mongo();
        $this->_db = $mongoDatabase->myNewDatabase;
        $this->_collection = $this->_db->events;
    }
}
?>
