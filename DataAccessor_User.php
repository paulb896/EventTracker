<?php
/**
 * Require extended class.
 */
 require_once 'DataAccessor_AbstractMongo.php';

/**
 * MongoDB relations for users collection.
 */
class DataAccessor_User extends DataAccessor_AbstractMongo
{
    /**
     * Get name of this collection.
     * 
     * @return string Name of collection.
     */
    protected function _getCollectionName()
    {
        return 'users';
    }

    /**
     * Verify data is acceptable for collection.
     * 
     * @param array Array of data keyed by data name.
     * @return bool True if data is valid for collection.
     */
    protected function _isValidCollectionData(array $data)
    {
        $validData = array(
            'userEmail' => 'string',
            'alias' => 'string'
        );

        if (count(array_diff_key($data, $validData)) !== 0) {
            return false;
        }

        return true;
    }
}
?>
