<?php
    // require_once "init.php";
    
    // global $db;
    
    // $INCIDENTS_TOTAL = [];
    
    // $reportsRef = $db->collection("reports");
    // $reports = $reportsRef->documents();
    // foreach ($reports as $report) {
    //     if ($report->exists()) {
            
    //     }
    // }

    // echo json_encode($INCIDENTS_TOTAL);

    require_once "init.php";
    
    global $db;
    
    $INCIDENTS_TOTAL = [];
    
    $filter = false;
    $start = 0;
    $end = 0;

    if (isset($_GET["month"])) {
        $filter = true;
        $month = $_GET["month"];
        $endMonth = ($month + 1) % 12;

        $endMonth = $endMonth == 0 ? 1 : $endMonth;
        $year = 2021;
        $endYear = $endMonth < $month ? $year + 1 : $year;

        $start = strtotime("$month/0/$year");
        $end = strtotime("$endMonth/30/$endYear");
    }

    $reportsRef = $db->collection("reports");
    $reports = $reportsRef->documents();
    
    foreach ($reports as $report) {
        if ($report->exists()) {
            if ($filter) {
                if ((strtotime($report["date"]) >= $start) && (strtotime($report["date"]) <= $end)) {
                    if (isset($INCIDENTS_TOTAL[$report["classification"]])) {
                        $INCIDENTS_TOTAL[$report["classification"]]++;
                    } else {
                        $INCIDENTS_TOTAL[$report["classification"]] = 1;
                    }
                }
            } else {
                if (isset($INCIDENTS_TOTAL[$report["classification"]])) {
                    $INCIDENTS_TOTAL[$report["classification"]]++;
                } else {
                    $INCIDENTS_TOTAL[$report["classification"]] = 1;
                }
            }
        }
    }

    echo json_encode($INCIDENTS_TOTAL);