<?php

require_once "vendor/autoload.php";
require_once "init.php";

// Data
$CLASSIFICATIONS = [];
$FILTERED = [];

$allUsers = $db->collection("users");
$allReports = $db->collection("reports");

$municipality = $_GET["municipality"];

function getUser($userId) {
    global $allUsers;
    $user = [];

    $query = $allUsers->document($userId);
    $snapshot = $query->snapshot();

    if ($snapshot->exists()) {
        $user = $snapshot->data();
    }

    return $user;
}

$query = $allReports->where("municipal", "==", urldecode($_GET["municipality"]));
$reports = $query->documents();

foreach ($reports as $report) {
    if ($report->exists()) {
        if (isset($FILTERED[$report["baranggay"]])) {
            array_push($FILTERED[$report["baranggay"]], [
                "classification" => $report["classification"],
                "classification_type" => $report["classification_type"],
                "action" => $report["action"] ?? "No Action",
                "date" => date("F j, Y", strtotime($report["date"])),
                "description" => $report["description"],
                "involved" => $report["involve"],
                "location_details" => $report["location_details"],
                "municipal" => $report["municipal"],
                "people" => $report["people"],
                "time" => $report["time"],
                "user" => getUser($report["user_id"])
            ]);
        } else {
            $FILTERED[$report["baranggay"]] = [];
            array_push($FILTERED[$report["baranggay"]], [
                "classification" => $report["classification"],
                "classification_type" => $report["classification_type"],
                "action" => $report["action"] ?? "No Action",
                "date" => date("F j, Y", strtotime($report["date"])),
                "description" => $report["description"],
                "involved" => $report["involve"],
                "location_details" => $report["location_details"],
                "municipal" => $report["municipal"],
                "people" => $report["people"],
                "time" => $report["time"],
                "user" => getUser($report["user_id"])
            ]);
        }
    }
}

$mpdf = new \Mpdf\Mpdf(["debug" => true]);


$template = <<<EOD
<style type="text/css">
.styled-table {
border-collapse: collapse;
margin-left: auto;
margin-right: auto;
font-size: 0.9em;
font-family: sans-serif;
min-width: 400px;

box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
background-color: teal;
color: #ffffff;
text-align: left;
}

.styled-table th,
.styled-table td {
padding: 15px 23px;
text-transform: uppercase;
font-size: 10px;
}

.styled-table tbody tr {
border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
border-bottom: 2px solid #009879;
}

</style>
<h1 style="font-family:Arial; color:teal;"> BATAAN iRESPONSE </h1>
<h4 style="font-family:Arial;">Barangay Quick Response and Incident Reporting
</h4>
<h2 style="font-family:Arial;"> SUMMARY REPORTS </h2>
<h3 style="font-family:Arial;">Municipality of $municipality</h3>
EOD;

$data_template = "";

foreach ($FILTERED as $baranggay => $reports) {
    $data_template .= <<<EOD
    <hr>
    EOD;

    $data_template .= <<<EOD
        <p style="color:black; font-size: 15px; font-weight: bold; font-family:Arial;  text-transform: uppercase;">Brgy. {$baranggay}</p>
    EOD;
    $data_template .= <<<EOD
    <table class="styled-table">
    <thead>
    <tr>
        <th style="color:white">Classification</th>
        <th style="color:white">Reported by</th>
        <th style="color:white">Involved</th>
        <th style="color:white">Date/Time</th>
        <th style="color:white">Status</th>
        <th style="color:white">Action</th>
    </tr>
    </thead>
    <tbody>
    EOD;

    foreach ($reports as $report) {
        $involved = $report["involved"] ?? 1;
        $data_template .= <<<EOD
        <tr>
            <td>{$report['classification']}</td>
            <td>{$report['user']['full_name']}</td>
            <td>{$involved}</td>
            <td>{$report['date']} {$report['time']}</td>
            <td>{$report['classification_type']}</td>
            <td>{$report['action']}</td>
        </tr>
        EOD;
    }

    $data_template .= "</tbody>
    </table>";

}

$output = $template . $data_template;

$mpdf->WriteHTML($output);
$mpdf->Output();