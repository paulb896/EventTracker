<?php
/**
 * MongoDB relations for arbitrary collection.
 * 
 * todo: Make this an abstract class and move validation logic to inherited classes.
 */
abstract class DataAccessor_AbstractMongo
{
    /**
     * Verify data is acceptable for collection.
     * 
     * @param array Array of data keyed by data name. (pass this back by reference).
     * @return bool True if data is valid for collection, false otherwise.
     */
    abstract protected function _isValidCollectionData(array &$data);

    /**
     * Get the name of this mongo collection.
     * 
     * @return string Name of mongo collection.
     */
    abstract protected function _getCollectionName();

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
        if ($this->_isValidCollectionData($collectionData) === false) {
            return false;
        }

        $this->_constructDb();
        $this->_collection->insert($collectionData);
        return true;
    }

    /**
     * Find all records that match constraints.
     *
     * @param array $searchFilters Constraints with keys as
     *              individual constraint names.
     * 
     * @return array Array of single object information arrays.
     */
    public function getAll($searchFilters = array())
    {
        $objects = array();
        //if (!$this->_isValidCollectionData($objectConstraints)) {
        //    return $objects;
        //}

        $this->_constructDb();

        $searchFilters = $this->_getFormattedMongoQuery($searchFilters);

        $objectCursor = $this->_collection->find($searchFilters);
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
            $this->_isDatabaseConstructed = false;
        }
    }

    /**
     * Format query for mongo db find operation.
     * Currently leave this open for child class to override,
     * at this point it seems unnecessary to make abstract.
     * 
     * todo: Possibly make searchArray passed by reference.
     * 
     * @param array $searchArray
     * @return array
     */
    protected function _getFormattedMongoQuery($searchArray)
    {
        return $searchArray;
    }

    /**
     * Name of mongo database.
     * @var string
     */
    protected $_optionDatabaseName = 'myNewDatabase';

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
     * True if database needs to be constructed,
     * false if the database has been initialized.
     * 
     * @var bool
     */
    protected $_isDatabaseConstructed = false;

    /**
     * Array of key/value paired options.
     * @var MongoCollection
     */
    protected $_options = array();

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
        // Skip this function if current database settings
        // have already been initialized.
        if ($this->_isDatabaseConstructed === true) {
            return;
        }

        $mongoConnection = new Mongo();

        $databaseName = $this->_optionDatabaseName;
        $collectionName = $this->_getCollectionName();

        // Apply db options.
        if (array_key_exists('databaseName', $this->_options)) {
            $databaseName = $this->_options['databaseName'];
        }

        $this->_db = $mongoConnection->selectDB($databaseName);
        $this->_collection = new MongoCollection($this->_db, $collectionName);
        $this->_isDatabaseConstructed = true;
    }
}
?>
