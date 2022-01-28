<?php
session_start();
require_once "vendor/autoload.php";
require_once "Util.php";

putenv('SUPPRESS_GCLOUD_CREDS_WARNING=true');

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Google\Auth\Subscriber;
use Google\Cloud\Core\Timestamp;


$db;

$USER = [];
$LEADERBOARD = [];
$LOCATIONS = [];
$CATEGORIES = [];

function init()
{
    global $LEADERBOARD;
    global $LOCATIONS;
    global $db;
    global $CATEGORIES;

    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        "projectId" => "ibataanresponse"
    ]);

    $locationsRef = $db->collection('baranggays');
    $locations = $locationsRef->documents();
    foreach ($locations as $location) {
        if ($location->exists()) {
            
            $data = $location->data();
            $municipality = $data["municipality"];
            $baranggay = $data["title"];

            if (isset($LOCATIONS[$municipality])) {
                array_push($LOCATIONS[$municipality], $baranggay);
            } else {
                $LOCATIONS[$municipality] = [$baranggay];
            }
        }
    }

    $leaderboardRef = $db->collection("reports");
    $leaderboard = $leaderboardRef->documents();

    foreach ($leaderboard as $placement) {
        if ($placement->exists()) {
            if (!in_array($placement["classification"], $CATEGORIES)) {
                array_push($CATEGORIES, $placement["classification"]);
            }

            if (isset($LEADERBOARD[$placement["classification"]][$placement["municipal"]])) {
                $LEADERBOARD[$placement["classification"]][$placement["municipal"]]++;
                arsort($LEADERBOARD[$placement["classification"]]);
            } else {
                $LEADERBOARD[$placement["classification"]][$placement["municipal"]] = 1;
                arsort($LEADERBOARD[$placement["classification"]]);
            }
        }
    }

}

init();