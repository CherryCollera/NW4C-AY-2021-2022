<?php
require_once "init.php";


$CLASSIFICATIONS = [];
$FILTERED = [];

$allUsers = $db->collection("users");
$allReports = $db->collection("reports");

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

if (!isset($_GET["baranggay"]) && isset($_GET["municipality"])) {
    $query = $allReports->where("municipal", "==", urldecode($_GET["municipality"]));

    $reports = $query->documents();
    $query = $allReports->where("municipal", "==", urldecode($_GET["municipality"]));
    foreach ($reports as $report) {
        if ($report->exists()) {
            if (isset($CLASSIFICATIONS[$report["classification"]])) {
                $CLASSIFICATIONS[$report["classification"]]++;
            } else {
                $CLASSIFICATIONS[$report["classification"]] = 1;
            }
        }
    }

} else if (isset($_GET["baranggay"]) && isset($_GET["municipality"])) {
    $query = $allReports->where('baranggay', '==', urldecode($_GET["baranggay"]))
                        ->where("municipal", "==", urldecode($_GET["municipality"]));
    
} else if (isset($_GET["baranggay"]) && !isset($_GET["municipality"])) {
    $municipality = Util::baranggayToMunicipality($_GET["baranggay"], $LOCATIONS);
    header("location: /reports.php?baranggay={$_GET['baranggay']}&municipality={$municipality}");
} else {
    header("location: /");
}

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

<body class="bg-gray-100 overflow-x-hidden">
    <div class="shadow-md p-8 bg-gray-800 text-white">
        <h2 class="text-2xl font-bold"><?= urldecode($_GET["municipality"]); ?></h2>
        <?php if (isset($_GET["baranggay"])) { ?>
            <p><?= urldecode($_GET["baranggay"]); ?></p>
        <?php } ?>
        <div class="flex justify-between">
        <button onclick="redirect('/');" class="bg-blue-600 px-4 mt-4 py-1 hover:bg-blue-500 shadow-sm rounded-md text-white">Go Back</button>
        <a href="reportpdf.php?municipality=<?= $_GET["municipality"] ?>" class="bg-green-700 px-4 mt-4 py-1 hover:bg-green-800 shadow-sm rounded-md text-white">Generate Report</a>
        </div>
    </div>

    <div class="m-4">
        <h1 class="m-4 font-light text-2xl">FILTER</h1>
        <div class="max-w-7xl mx-auto">
            <label class="text-gray-500 text-sm block font-light" for="filter">Filter by Category</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text" name="filter" id="filter" class="outline-none block w-full pr-12 p-2 sm:text-sm border-gray-300 rounded-md" placeholder="Category">
                <ul class="mt-2" data-container-id="filter">
                <?php foreach ($CATEGORIES as $category) { ?>
                    <li class="p-2 bg-white border-b-2 hover:bg-blue-100 hover:text-white cursor-pointer hidden" data-input-value="<?= $category ?>" onclick="clickToInput(this)"><?= $category; ?></li>
                <?php } ?>
                </ul>
            </div>
        </div>

        <h1 class="m-4 font-light text-2xl">CLASSIFICATIONS</h1>
        <div class="grid grid-cols-6 m-4 gap-4">
            <?php foreach ($CLASSIFICATIONS as $classification => $count) { ?>
                <div class="shadow-md p-4 text-center">
                    <h1 class="font-bold"><?= $classification ?></h1>
                    <p><?= $count ?></p>
                </div>
            <?php } ?>
        </div>

        <?php foreach ($FILTERED as $baranggay => $reports) { ?>
            <div class="m-4">
            <?php
                usort($reports, function($a, $b) { 
                    return $b['date'] <=> $a['date'] ?: $a['time'] <=> $b['time'];
                });
            ?>
            <h1 class="text-lg font-bold"><?= $baranggay ?></h1>
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
                                            Involved
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
                                            <?php if (!empty($report["people"])) { ?>
                                                <p><?= $report["people"]; ?></p>
                                                <p class="text-xs">People involved: <?= count(explode(", ", $report["people"])); ?></p>
                                            <?php } else { ?>
                                                <p class="text-xs">N/A</p>
                                            <?php } ?>
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
                </div>
                <br>
            </div>
        <?php } ?>


    <script src="main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <script>
        const CATEGORIES = <?= json_encode($CATEGORIES) ?>

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

        function clickToInput(el, baranggay) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const value = el.getAttribute("data-input-value")
            document.querySelector("#filter").value = value; 
            
            if (urlParams.get("baranggay")) {   
                window.location.href = `filter.php?baranggay=${urlParams.get('baranggay')}&category=${value}&filter=Search`;
            } else if (urlParams.get("municipality")) {
                window.location.href = `filter.php?municipality=${urlParams.get('municipality')}&category=${value}&filter=Search`;
            }
        }

        const FILTER_INPUT = document.querySelector("#filter");
        const FILTER_CONTAINER = document.querySelector("ul[data-container-id='filter']");
        FILTER_INPUT.addEventListener("keyup", function(e) {
        if (!e.target.value) {
            document.querySelectorAll("li[data-input-value]").forEach((el) => {
            el.classList.add("hidden");
            });
            return;
        }

        const value = e.target.value;
        const filtered = CATEGORIES.filter((category) => category.toLowerCase().startsWith(value.toLowerCase()));

        document.querySelectorAll("li[data-input-value]").forEach((el) => {
            el.classList.add("hidden");
        });

        filtered.forEach((el) => {
            document.querySelector(`li[data-input-value='${el}']`).classList.remove("hidden");
        });

        if (filtered.length && e.keyCode == 13) {
            window.location.href = `filter.php?category=${filtered[0]}&filter=Search`;
        }
        });
    </script>
</body>

</html>