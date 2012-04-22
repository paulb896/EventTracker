<?php
/**
 * Require extended class.
 */
 require_once 'DataAccessor_AbstractMongo.php';

/**
 * MongoDB relations for events collection.
 */
class DataAccessor_Event extends DataAccessor_AbstractMongo
{
    /**
     * Get name of this collection.
     * 
     * @return string Name of collection.
     */
    protected function _getCollectionName()
    {
        return 'events';
    }

    /**
     * Verify data is acceptable for collection.
     * 
     * @param array Array of data keyed by data name.
     * @return bool True if data is valid for collection.
     */
    protected function _isValidCollectionData(array $data)
    {
        // Change values to FILTER_VALIDATE_ constants.
        $validData = array(
            'userEmail' => 'string',
            'dateTime' => 'string',
            'timestamp' => 'string',
            'location' => 'string',
            'shortDescription' => 'string'
        );

        if (count(array_diff_key($validData, $data)) !== 0) {
            return false;
        }

        return true;
    }
}
?>
