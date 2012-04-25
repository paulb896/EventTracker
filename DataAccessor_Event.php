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
     * Format search query for events.
     * 
     * @param array $searchArray
     * @return array
     */
    protected function _getFormattedMongoQuery($searchArray)
    {
        if (array_key_exists('startDateTime', $searchArray)) {
            $searchArray['startDateTime'] = array('$gte' => new MongoDate(strtotime($searchArray['startDateTime'])));
        }

        if (array_key_exists('endDateTime', $searchArray)) {
            $searchArray['endDateTime'] = array('$lte' => new MongoDate(strtotime($searchArray['endDateTime'])));
        }

        return $searchArray;
    }

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
     * @return bool True if data is valid for collection, false otherwise.
     */
    protected function _isValidCollectionData(array &$data)
    {
        // Change values to FILTER_VALIDATE_ constants.
        $validData = array(
            'userEmail' => 'string',
            'startDateTime' => 'string',
            'endDateTime' => 'string',
            'timeStamp' => 'string',
            'location' => 'string',
            'shortDescription' => 'string'
        );

        if (count(array_diff_key($data, $validData)) !== 0) {
            return false;
        }

        if (array_key_exists('startDateTime', $data)) {
            $data['startDateTime'] = new MongoDate(strtotime($data['startDateTime']));
        }

        if (array_key_exists('endDateTime', $data)) {
            $data['endDateTime'] = new MongoDate(strtotime($data['endDateTime']));
        }

        if (array_key_exists('timeStamp', $data)) {
            $data['timeStamp'] = new MongoDate(strtotime($data['timeStamp']));
        }

        // todo: Add more validation here as needed..
        // todo: Add formatting for insert here.
        return true;
    }
}
?>
