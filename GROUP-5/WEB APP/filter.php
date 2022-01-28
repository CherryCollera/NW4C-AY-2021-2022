<?php
    require_once "init.php";

    $baranggays = $db->collection("baranggays");
    $allUsers = $db->collection("users");
    $allReports = $db->collection("reports");
    $reportsList = $allReports->documents();
    
    $municipal = "";
    $FILTERED = [];

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

    if (isset($_GET["category"])) {
        if (isset($_GET["municipality"])) {
            $query = $allReports->where("classification", "==", urldecode($_GET["category"]))
                                ->where("municipal", "==", urldecode($_GET["municipality"]));
        } else if (!isset($_GET["municipality"]) && isset($_GET["baranggay"])) {
            $query = $allReports->where("classification", "==", urldecode($_GET["category"]))
                                ->where("baranggay", "==", urldecode($_GET["baranggay"]));
        } else {
            $query = $allReports->where("classification", "==", urldecode($_GET["category"]));
        }
        $reports = $query->documents();

        foreach ($reports as $report) {
            if ($report->exists()) {
                if (isset($_GET["municipality"])) {
                    if (!isset($FILTERED[$report["baranggay"]])) {
                        $FILTERED[$report["baranggay"]] = [];
                    }

                    array_push($FILTERED[$report["baranggay"]], [
                        "baranggay" => $report["baranggay"],
                        "classification" => $report["classification"],
                        "classification_type" => $report["classification_type"],
                        "date" => date("F j, Y", strtotime($report["date"])),
                        "description" => $report["description"],
                        "involved" => $report["involve"],
                        "action" => $report["action"] ?? "No Action",
                        "location_details" => $report["location_details"],
                        "municipal" => $report["municipal"],
                        "people" => $report["people"],
                        "time" => $report["time"],
                        "user" => getUser($report["user_id"])
                    ]);
                } else {
                    if (!isset($FILTERED[$report["municipal"]])) {
                        $FILTERED[$report["municipal"]] = [];
                    }

                    array_push($FILTERED[$report["municipal"]], [
                        "baranggay" => $report["baranggay"],
                        "classification" => $report["classification"],
                        "classification_type" => $report["classification_type"],
                        "date" => date("F j, Y", strtotime($report["date"])),
                        "description" => $report["description"],
                        "involved" => $report["involve"],
                        "action" => $report["action"] ?? "No Action",
                        "location_details" => $report["location_details"],
                        "municipal" => $report["municipal"],
                        "people" => $report["people"],
                        "time" => $report["time"],
                        "user" => getUser($report["user_id"])
                    ]);
                }

                
            }
        }
    } else {
        header("location: /");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <title>Bataan Reporting</title>
</head>
<body>
    <div class="shadow-md p-8 bg-gray-800 text-white">
        <h2 class="text-2xl font-bold">Filtering for Category</h2>
        <p>
            <?= isset($_GET["category"]) ? $_GET["category"] : "N/A" ?>
            <?php if (isset($_GET["municipality"])) { ?>
                in <i>Municipality of <?= $_GET["municipality"]; ?></i>
            <?php } else if (isset($_GET["baranggay"])) { ?>
                in <i>Baranggay <?= $_GET["baranggay"]; ?></i>
            <?php } ?>
        </p>
        <?php if (isset($_GET["municipality"])) { ?>
        <button onclick="redirect('/reports.php?municipality=<?= $_GET['municipality']; ?>');" class="bg-blue-600 px-4 mt-4 py-1 hover:bg-blue-500 shadow-sm rounded-md text-white">Go Back</button>
        <?php } else if (isset($_GET["baranggay"])) { ?>
        <button onclick="redirect('/reports.php?baranggay=<?= $_GET['baranggay']; ?>');" class="bg-blue-600 px-4 mt-4 py-1 hover:bg-blue-500 shadow-sm rounded-md text-white">Go Back</button>
        <?php } else { ?>
        <button onclick="redirect('/')" class="bg-blue-600 px-4 mt-4 py-1 hover:bg-blue-500 shadow-sm rounded-md text-white">Go Back</button>
        <?php } ?>
        
    </div>

    

    <div class="m-4">
        <h1 class="m-4 font-light text-2xl">FILTER RESULTS</h1>
        <?php foreach ($FILTERED as $baranggay => $reports) { ?>
            <?php if (isset($_GET["municipality"])) { ?>
            <h1 class="text-lg font-bold"><?= $baranggay ?></h1>
            <?php } else if (isset($_GET["baranggay"])) { ?>
                <h1 class="text-lg font-bold"><?= $_GET["baranggay"] ?></h1>
            <?php } else { ?>
                <h1 class="text-lg font-bold"><?= $baranggay ?></h1>
            <?php } ?>
        <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reported By
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date / Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($reports as $report) { ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <b><?= $report["classification"]; ?></b>
                                                    </div>
                                                    <div class="text-sm text-gray-500 text-light">
                                                        <?= $report["description"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900"><?= $report["user"]["full_name"]; ?></div>
                                            <div class="text-sm text-gray-500"><?= $report["user"]["role"]; ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p><?= $report["date"]; ?></p>
                                            <p><?= $report["time"]; ?></p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php if ($report["classification_type"] == "Low") { ?>
                                                <span class="px-4 py-2 font-bold inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    LOW
                                                </span>
                                            <?php } else { ?>
                                                <span class="px-4 py-2 font-bold inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    HIGH
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $report["action"] ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        <?php } ?>
    </div>

    
    <script src="main.js"></script>
    <script src="main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyDOUEdVLNAgqeJAdy9FlEVY5dZpidT-PEQ",
            authDomain: "ibataanresponse.firebaseapp.com",
            projectId: "ibataanresponse",
            storageBucket: "ibataanresponse.appspot.com",
            messagingSenderId: "1016927101773",
            appId: "1:1016927101773:web:eb127f3df4a4b5d2764d04",
            measurementId: "G-L9GJECBHN8"
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        
        const user = firebase.auth().currentUser;
        firebase.auth().onAuthStateChanged((user) => {
            if (user) {
                var uid = user.uid;
                
                if (user.email != "pangilinanangel20@gmail.com") {
                    window.location.href = "/login.php"
                }
            } else {
                // User is signed out
                // ...
            }
        });
    </script>
</body>
</html>