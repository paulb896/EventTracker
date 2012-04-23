<?php
/**
 * MongoDB relations for arbitrary collection.
 * 
 * todo: Make this an abstract class and move validation logic to inherited classes.
 */
abstract class DataAccessor_AbstractMongo
{
    /**
     * Save an event to mongoDB.
     * @param array An array of event information for a single collection object.
     *   Example $collectionData = array(
     *    "time" => "",
     *    "company" => "General Auto Shoppe",
     *    "shortDescription" => "Repair Car Starter",
     *    "userEmail" => "ftw@hotmail.com",
     *    "Location" => "-33,151" //Google api input format Longitude/Latatude
     *   )
     * @return bool True if insert was successful.
     */
    public function insertIntoCollection(array $collectionData)
    {
        if (!$this->_isValidCollectionData($collectionData)) {
            return false;
        }

        $this->_constructDb();
        $this->_collection->insert($collectionData);
        return true;
    }

    /**
     * Find all records that match constraints.
     *
     * @param array $objectConstraints Constraints with keys as
     *              individual constraint names.
     * 
     * @return array Array of single object information arrays.
     */
    public function getAll($objectConstraints = array())
    {
        $objects = array();
        //if (!$this->_isValidCollectionData($objectConstraints)) {
        //    return $objects;
        //}

        $this->_constructDb();
        
        $objectCursor = $this->_collection->find($objectConstraints);
        foreach($objectCursor as $singleObject) {
            $objects[] = (array) $singleObject;
        }

        return $objects;
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
        if ($this->_isValidOption($key)) {
            $this->_options[$key] = $value;
        }
    }

    /**
     * Name of mongo database.
     * @var string
     */
    protected $_optionDatabaseName = 'myNewDatabase';

    /**
     * Get the name of this mongo collection.
     * 
     * @return string Name of mongo collection.
     */
    abstract protected function _getCollectionName();

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
     * Verify data is acceptable for collection.
     * 
     * @param array Array of data keyed by data name.
     * @return bool True if data is valid for collection.
     */
    abstract protected function _isValidCollectionData(array $data);

    /**
     * Verify that option name is valid.
     * 
     * @param string $optionName Name of option to be set.
     * @return bool True if option name is valid.
     */
    protected function _isValidOption($optionName)
    {
        $validOptions = array(
            'databaseName' => 'string'
        );

        if (array_key_exists($optionName, $validOptions)) {
            return true;
        }

        return false;
    }

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
        $databaseName = $this->_optionDatabaseName;
        $collectionName = $this->_getCollectionName();

        // Apply db options.
        if (array_key_exists('databaseName', $this->_options)) {
            $databaseName = $this->_options['databaseName'];
        }

        $this->_db = $mongoConnection->selectDB($databaseName);
        $this->_collection = new MongoCollection($this->_db, $collectionName);
    }
}
?>
