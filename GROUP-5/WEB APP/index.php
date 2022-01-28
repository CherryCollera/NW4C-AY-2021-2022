<?php
require_once "init.php";

// if (!isset($_SESSION["loggedIn"])) {
//   header("location: /login.php");
// }

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
  <div class="bg-blue-800 px-4 py-16 flex items-center justify-between">
    <div>
      <ul class="text-gray-300">
        <li>1Bataan Response > Dashboard</li>
      </ul>
      <h1 class="text-3xl font-bold text-white">Dashboard</h1>
      <button class="mt-2 border-1 border-red-300 bg-red-500 shadow-md py-1 px-4 text-white rounded-sm hover:bg-red-600 hover:border-red-400" onclick="signOut()">Log Out</button>
    </div>
  </div>
      <div class="mx-auto m-4 px-8 sm-px-6 max-w-7xl">
        <div>
          <label class="text-gray-500 text-sm block font-light" for="filter">Filter by Category</label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <input type="text" name="filter" id="filter" class="outline-none block w-full pr-12 p-2 sm:text-sm border-gray-300 rounded-md" placeholder="Category">
            <ul class="mt-2" data-container-id="filter">
              <?php foreach ($CATEGORIES as $category) { ?>
              <li class="p-2 bg-white border-b-2 hover:bg-blue-100 hover:text-white cursor-pointer hidden" data-input-value="<?= $category ?>" onclick="clickToInput(this)"><?= $category; ?></li>
              <?php } ?>
            </ul>
            <div class="absolute inset-y-0 right-0 flex items-center">
          <label for="filter_municipality" class="sr-only">Municipality</label>
          <select id="filter_municipality" name="filter_municipality" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
            <option selected disabled value="">Select municipality</option>
            <?php
              ksort($LOCATIONS);
              foreach ($LOCATIONS as $municipality => $baranggay) {
            ?>
            <option value="<?= $municipality ?>"><?= $municipality ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="flex mx-4 gap-2 justify-center flex-col items-center">
    <div class="flex-1 bg-white overflow-hidden shadow sm:rounded-lg max-h-4xl max-w-7xl w-full">
      <h1 class="font-medium text-2xl p-2 text-center">🏆 Incident Leaderboard</h1>
      <ul role="list" class="divide-y divide-gray-200">
        <?php $i = 0; foreach ($LEADERBOARD as $classification => $municipality) { ?>
          <?php if ($i < 3) { $i++ ?>
            <?php if ($i == 1) { ?>
              <li class="m-2 p-4 flex justify-between bg-blue-800 text-white text-xl rounded-lg">
                <p>🥇 <?= $classification ?></p>
                <p><?= array_keys($municipality)[0]; ?></p>
              </li>
            <?php } else if ($i == 2) { ?>
              <li class="m-2 p-4 flex justify-between bg-blue-600	 text-white text-xl rounded-lg">
                <p>🥈 <?= $classification ?></p>
                <p><?= array_keys($municipality)[0]; ?></p>
              </li>
            <?php } else if ($i == 3) { ?>
              <li class="m-2 p-4 flex justify-between bg-blue-400 text-white text-xl rounded-lg">
                <p>🥉 <?= $classification ?></p>
                <p><?= array_keys($municipality)[0]; ?></p>
              </li>
            <?php } else { ?>
              <li class="p-2 flex justify-between text-black text-sm">
                <p><?= $classification ?></p>
                <p><?= $municipality[array_keys($municipality)[0]]; ?></p>
              </li>
            <?php } ?>
        <?php } ?>
      <?php } ?>
        
      </ul>
    </div>
    <div class="flex-2 bg-white overflow-hidden shadow sm:rounded-lg max-h-4xl max-w-7xl w-full">
      <h1 class="font-medium text-2xl p-2 text-center">Incident Report Graph</h1>
      <div class="chart-container p-4 mx-auto" data-container-id="incident-graph" style="position: relative; height:50%; width:50%">
        <canvas id="totalIncidentChart"></canvas>
      </div>
      <div class="p-2">
        <select class="py-1 px-4 ring-2 ring-blue-500 rounded-md" name="filter_month" id="filter_month" onchange="updateGraph(this)">
          <option selected disabled>Select Month</option>
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
    </div>
  </div>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="max-w-none mx-auto">
      <h1 class="font-light text-2xl my-2">List of Municipalities</h1>
      <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <ul role="list" class="divide-y divide-gray-200">
        <?php 
        ksort($LOCATIONS);
        foreach ($LOCATIONS as $municipality => $location) { ?>
          <li>
            <a href="reports.php?municipality=<?= $municipality; ?>" class="block hover:bg-gray-50">
              <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="text-sm font-medium text-indigo-600 truncate">
                    <?= $municipality ?>
                  </div>
                  <div class="ml-2 flex-shrink-0 flex">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      <?= count($location); ?> Baranggay
                    </span>
                  </div>
                </div>
                <div class="mt-2 flex justify-between">
                  <div class="sm:flex">
                    <div class="mr-6 flex items-center text-sm text-gray-500">
                      <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" x-description="Heroicon name: solid/users" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                      </svg>
                      Municipality
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </li>
          <?php } ?>
        </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

  <script>
    Chart.register(ChartDataLabels);

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
      }
      // } else {
      //   window.location.href = "/login.php";
      // }
    });

    function signOut() {
      firebase.auth().signOut().then(() => {
        window.location.href = "/login.php";

        axios({
          method: 'get',
          url: 'logoutProcess.php'
        }).then((res) => {
          console.log(res);
        });
      }).catch((error) => {
        // An error happened.
      });
    }

    axios({
      method: "GET",
      url: "totalIncidents.php"
    }).then((response) => {
      const labels = Object.keys(response.data);
      const points = Object.values(response.data);
      const totalPoints = Object.values(response.data).reduce((a, b) => a + b);
      const colors = [];

      const dynamicColors = function() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
      };

      for (let color of labels) {
        colors.push(dynamicColors());
      }
      const ctx = document.getElementById('totalIncidentChart').getContext('2d');
      const totalIncidentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            backgroundColor: colors,
            data: points.map((x) => ((x / totalPoints) * 100).toFixed(2)),
            datalabels: {
              labels: {
                name: {
                  align: 'top',
                  font: {size: 12},
                  formatter: function(value, ctx) {
                    return ctx.chart.data.labels[ctx.dataIndex];
                  }
                },
                value: {
                  align: 'bottom',
                  backgroundColor: function(ctx) {
                    var value = ctx.dataset.data[ctx.dataIndex];
                    return value > 50 ? 'white' : null;
                  },
                  borderColor: 'white',
                  borderWidth: 2,
                  borderRadius: 4,
                  color: function(ctx) {
                    var value = ctx.dataset.data[ctx.dataIndex];
                    return value > 50
                      ? ctx.dataset.backgroundColor
                      : 'white';
                  },
                  formatter: function(value, ctx) {
                    return `${value}%`;
                  },
                  padding: 4
                }
              }
            }
          }],
        },
        options: {
          tooltips: {
            enabled: true
          },
          plugins: {
            datalabels: {
              formatter: (value, ctx) => {
                let sum = ctx.dataset._meta[0].total;
                let percentage = (value * 100 / sum).toFixed(2) + "%";
                return percentage;
              },
              color: '#fff',
            }
          }
        }
      });
    });

    function clickToInput(el) {
      const value = el.getAttribute("data-input-value")
      document.querySelector("#filter").value = value;
      let municipality = document.querySelector("#filter_municipality").value;

      if (municipality) {
        window.location.href = `filter.php?category=${value}&municipality=${municipality}&filter=Search`;
      } else {
        window.location.href = `filter.php?category=${value}&filter=Search`;
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

      let municipality = document.querySelector("#filter_municipality").value;
      
      if (filtered.length && e.keyCode == 13) {
        if (!municipality) {
          window.location.href = `filter.php?category=${filtered[0]}&filter=Search`;
        } else {
          window.location.href = `filter.php?category=${filtered[0]}&municipality=${municipality}&filter=Search`;
        }
      }
    });

    function numberToMonth(month) {
      const months = ["January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      return months[month - 1];
    }
    function updateGraph(el) {
      if (document.querySelector("#totalIncidentChart")) {
        document.querySelector("#totalIncidentChart").remove();
      }

      document.querySelector("div[data-container-id='incident-graph']").innerHTML = `<canvas id="totalIncidentChart"></canvas>`;

      axios({
        method: "GET",
        url: `totalIncidents.php?month=${el.value}`
      }).then((response) => {
        const labels = Object.keys(response.data);
        const points = Object.values(response.data);

        if (!points.length) {
          document.querySelector("div[data-container-id='incident-graph']").innerHTML = `<h1 class="font-bold text-2xl text-center">No data for ${numberToMonth(el.value)}</h1>`;
          return;
        }

        const totalPoints = Object.values(response.data).reduce((a, b) => a + b);
        const colors = [];

        const dynamicColors = function() {
          const r = Math.floor(Math.random() * 255);
          const g = Math.floor(Math.random() * 255);
          const b = Math.floor(Math.random() * 255);
          return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (let color of labels) {
          colors.push(dynamicColors());
        }
        const ctx = document.getElementById('totalIncidentChart').getContext('2d');
        const totalIncidentChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              backgroundColor: colors,
              data: points.map((x) => ((x / totalPoints) * 100).toFixed(2)),
              datalabels: {
                labels: {
                  name: {
                    align: 'top',
                    font: {size: 12},
                    formatter: function(value, ctx) {
                      return ctx.chart.data.labels[ctx.dataIndex];
                    }
                  },
                  value: {
                    align: 'bottom',
                    backgroundColor: function(ctx) {
                      var value = ctx.dataset.data[ctx.dataIndex];
                      return value > 50 ? 'white' : null;
                    },
                    borderColor: 'white',
                    borderWidth: 2,
                    borderRadius: 4,
                    color: function(ctx) {
                      var value = ctx.dataset.data[ctx.dataIndex];
                      return value > 50
                        ? ctx.dataset.backgroundColor
                        : 'white';
                    },
                    formatter: function(value, ctx) {
                      return `${value}%`;
                    },
                    padding: 4
                  }
                }
              }
            }],
          },
          options: {
            tooltips: {
              enabled: true
            },
            plugins: {
              datalabels: {
                formatter: (value, ctx) => {
                  let sum = ctx.dataset._meta[0].total;
                  let percentage = (value * 100 / sum).toFixed(2) + "%";
                  return percentage;
                },
                color: '#fff',
              }
            }
          }
        });
      });
    }
  </script>
</body>

</html>