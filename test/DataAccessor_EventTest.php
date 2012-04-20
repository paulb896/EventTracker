<?php

echo "Now running event data accessor test\n\n";

// Test 1
$testEventData = array(
    'dateTime' => '2012-12-24 18:56:35',
    'timestamp' => date("Y-m-d H:i:s"),
    'shortDescription' => 'End of civilization as we currently know it',
    'location' => '-33.8670522,151.1957362',
    'userEmail' => 'fake@fake.ca',
);
//print_r($testEventData);

require_once '../DataAccessor_Event.php';
$event = new DataAccessor_Event();
$event->saveEvent($testEventData);

// todo: Delete event here.
print "\n\nProgram has finished.\n\n";

?>
