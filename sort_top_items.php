<?php

require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->new_list;
$transactions = $collection->find()->toArray();

?>

<?php
    include('connections.php');

    $sql = "SELECT * FROM product_list_2";
    $result = $conn->query($sql);

    $row = [];

    if ($result->num_rows > 0) {
      $row = $result->fetch_all(MYSQLI_ASSOC);
    }
?>

<style>
    .popup-container {
    position: fixed;
    top: 50%;
    left: 50%;
    width: 400px;
    height: 600px;
    background-color: white;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
    display: none;
    transform: translate(-50%, -50%);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .popup-content {
    position: relative;
    width: 80%;
    max-width: 600px;
    margin: 20px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    display: flex;
    align-items: center;
    }

    .popup-container.blur {
    filter: blur(5px);
    }

    #closeButton {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 8px 16px;
    background-color: #f00;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
</style>

<!-- <div class="card-body">
    <ul class="p-0 m-0" id="customerList">
    <li class="d-flex mb-4 pb-1">
        <div class="avatar flex-shrink-0 me-3">
            <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
                <small class="text-muted d-block mb-1">ID Barang</small>
                <h6 class="mb-0">Nama Barang</h6>
            </div>
            <div class="user-progress d-flex align-items-center gap-1">
                <h6 class="mb-0">2000</h6>
                <span class="text-muted">QTY</span>
            </div>
        </div>
    </li>
    </ul>
</div> -->

<a id="last7DaysButton" class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
<a id="last4WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 4 Weeks</a>
<a id="last8WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 8 Weeks</a>
<a id="allTimeButton" class="dropdown-item" href="javascript:void(0);">Show All</a>

<ul id="itemList"></ul>

<button id="showPopupButton" onclick="showChartPopup()">Show Pop-up</button>
<div id="popupContainer" class="popup-container">
  <div class="popup-content">
    <!-- Content of the pop-up goes here -->
    <button id="closeButton">Close</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="https://unpkg.com/resize-observer-polyfill/dist/ResizeObserver.global.js"></script>
<script src="config.js"></script> -->

<!-- <script>
    // Assuming you have the MongoDB query result stored in the `transactionsJson` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var transactions_top5_chart = <?php echo json_encode($transactions); ?>;
    var filteredTransactions = []; // Initialize as an empty array

    function filterTransactions(filter) {
        var currentDate = new Date('2011-01-10');
        var startDate;
        var interval = 7;
        var groupBy = 'week_8';

        if (filter === 'last7days') {
            startDate = new Date(currentDate.getTime() - 6 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last4weeks') {
            startDate = new Date(currentDate.getTime() - 27 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last8weeks') {
            startDate = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'allTime') {
            startDate = new Date(2010, 0, 1);
        } else {
            console.log('Invalid filter');
            return;
        }

        filteredTransactions = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate && transactionDate <= currentDate;
        });

        // Calculate item counts across all transactions
        var itemCounts = {};

        filteredTransactions.forEach(function(transaction) {
            transaction.items.forEach(function(item) {
                var itemName = item.item;
                var itemQty = item.qty;

                if (itemCounts[itemName]) {
                    itemCounts[itemName] += itemQty;
                } else {
                    itemCounts[itemName] = itemQty;
                }
            });
        });

        


        // Sort item counts in descending order
        var sortedItemCounts = Object.entries(itemCounts).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 most bought items
        var top5Items = sortedItemCounts.slice(0, 5).map(function(entry) {
            return {
                itemName: entry[0],
                itemCount: entry[1]
            };
        });


        // Update the item list in the HTML
        var itemList = document.getElementById('itemList');
        itemList.innerHTML = ''; // Clear previous list

        top5Items.forEach(function(item) {
            var li = document.createElement('li');
            li.innerText = 'Item: ' + item.itemName + ', Quantity: ' + item.itemCount;
            itemList.appendChild(li);
        });
    }

    // Button event listeners
    var last7DaysButton = document.getElementById('last7DaysButton');
    last7DaysButton.addEventListener('click', function() {
        filterTransactions('last7days');
    });

    var last4WeeksButton = document.getElementById('last4WeeksButton');
    last4WeeksButton.addEventListener('click', function() {
        filterTransactions('last4weeks');
    });

    var last8WeeksButton = document.getElementById('last8WeeksButton');
    last8WeeksButton.addEventListener('click', function() {
        filterTransactions('last8weeks');
    });

    var allTimeButton = document.getElementById('allTimeButton');
    allTimeButton.addEventListener('click', function() {
        filterTransactions('allTime');
    });

    // Initially filter for the last 7 days
    filterTransactions('last7days');
</script> -->

<script>
    // Assuming you have the MongoDB query result stored in the `transactionsJson` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var transactions_top5_chart = <?php echo json_encode($transactions); ?>;
    var filteredTransactions = []; // Initialize as an empty array

    var top5Items_name;
    var summedData = {};
    week_value = [];

    function filterTransactions(filter) {
        var currentDate = new Date('2011-01-10');
        var startDate;
        var startDate_chart = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000);
        var interval = 7;
        var groupBy = 'week_8';

        if (filter === 'last7days') {
            startDate = new Date(currentDate.getTime() - 6 * 24 * 60 * 60 * 1000);
            // console.log(startDate);
        } else if (filter === 'last4weeks') {
            startDate = new Date(currentDate.getTime() - 27 * 24 * 60 * 60 * 1000);
            //console.log(startDate);
        } else if (filter === 'last8weeks') {
            startDate = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000);
            //console.log(startDate);
        } else if (filter === 'allTime') {
            startDate = new Date(2010, 0, 1);
        } else {
            console.log('Invalid filter');
            return;
        }
        
        //console.log(startDate_chart);

        filteredTransactions = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate && transactionDate <= currentDate;
        });

        filteredTransactions_chart = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate_chart && transactionDate <= currentDate;
        });

        // console.log(filteredTransactions);
        // console.log(filteredTransactions_chart);

        // Calculate item counts across all transactions
        var itemCounts = {};

        filteredTransactions.forEach(function(transaction) {
            transaction.items.forEach(function(item) {
                var itemName = item.item;
                var itemQty = item.qty;

                if (itemCounts[itemName]) {
                    itemCounts[itemName] += itemQty;
                } else {
                    itemCounts[itemName] = itemQty;
                }
            });
        });

        // Sort item counts in descending order
        var sortedItemCounts = Object.entries(itemCounts).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 most bought items
        var top5Items = sortedItemCounts.slice(0, 5).map(function(entry) {
            return {
                itemName: entry[0],
                itemCount: entry[1]
            };
        });

        // Fetch item name only
        top5Items_name = [];
        top5Items.forEach(function(transaction) {
            top5Items_name.push(transaction.itemName);
        });

        // Filter transactions with that 5 items only
        
        var top5item_chart = [];
        filteredTransactions_chart.forEach(function(transaction) {
            transaction.items.forEach(function(item) {
                var itemName = item.item;
                var itemQuantity = item.qty;
                var transactionDate = transaction.date;
                var transactionId = transaction.transaction_id;
            
                // Check if the item name is in your list
                if (top5Items_name.includes(itemName)) {
                    // If the item name is in the list, create an object with the desired transaction details
                    var transactionDetails = {
                        transactionId: transactionId,
                        itemName: itemName,
                        itemQuantity: itemQuantity,
                        transactionDate: transactionDate
                    };
                    // Push the transaction details to the top5item_chart array
                    top5item_chart.push(transactionDetails);
                }
            });
        });

        var currentDate = new Date('2011-01-10'); // Replace this with your current date

        // Calculate the start date of the first week
        var firstWeekStartDate = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000); // Subtract 55 days to cover 8 weeks

        var intervalStartDate = new Date(firstWeekStartDate); // Initialize the interval start date
        var intervalEndDate = new Date(intervalStartDate.getTime() + (6 * 24 * 60 * 60 * 1000) - 1 ); // Set the interval end date for the first week

        // Iterate over the 8-week intervals
        for (var i = 1; i <= 8; i++) {
            summedData[i] = {};
            top5Items_name.forEach(function(itemName) {
                summedData[i][itemName] = 0;
            });

            top5item_chart.forEach(function(transaction) {
                var transactionDateParts = transaction.transactionDate.split('/');
                var t_date = new Date(
                    transactionDateParts[2],
                    transactionDateParts[1] - 1,
                    transactionDateParts[0]
                );
                var itemName = transaction.itemName;
                var quantity = transaction.itemQuantity;

                // Check if the interval exists in the summedData object
                if (t_date >= intervalStartDate && t_date <= intervalEndDate) {
                    summedData[i][itemName] += quantity;
                }
            });

            // Move to the next interval
            intervalStartDate = new Date(intervalEndDate.getTime() + 24 * 60 * 60 * 1000);
            intervalEndDate = new Date(intervalEndDate.getTime() + 7 * 24 * 60 * 60 * 1000);
        }

        console.log(summedData);

        // Update the item list in the HTML
        var itemList = document.getElementById('itemList');
        itemList.innerHTML = ''; // Clear previous list

        top5Items.forEach(function(item) {
            var li = document.createElement('li');
            li.innerText = 'Item: ' + item.itemName + ', Quantity: ' + item.itemCount;
            itemList.appendChild(li);
        });
    }

    function showChartPopup() {
        // Add the blur class to the body element
        document.body.classList.add('blur');
        var itemNum = 1;

        top5Items_name.forEach(function(itemName) {
            var week_value = [];
            for (var key in summedData) {
                var nest_doc = summedData[key];
                for (var nest_key in nest_doc) {
                    if (nest_key === itemName) {
                        week_value.push(nest_doc[nest_key]);
                    }
                }
            }

            // Fetch PHP
            var rows = <?php echo json_encode($row); ?>;

            var qtyOnHand = null;

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].item === itemName) {
                    qtyOnHand = rows[i].qty_on_hand;
                    break;
                }
            }
            
            var sum_trend = week_value.reduce((accumulator, currentValue) => {
                return accumulator + currentValue
            },0);

            var status_bb = null;
            if (qtyOnHand < sum_trend) {
                status_bb = 'Restock ASAP';
            } else {
                status_bb = 'Enough Stock for 2 months';
            }

        
            var containerId = 'chartContainer-' + itemNum;
            itemNum = itemNum + 1;

            // Create a chart container element
            var chartContainer = document.createElement('div');
            chartContainer.id = containerId;

            // Create a heading element
            var heading = document.createElement('h2');
            heading.innerText = itemName; // Set the heading text to the item name

            // Append the heading to the chart container
            chartContainer.appendChild(heading);

            // Get total qty sold in 2 months
            var total_qty = document.createElement('h3');
            total_qty.innerText = 'Total sold in 2 months: ' + sum_trend; 

            // Append the total qty to the chart container
            chartContainer.appendChild(total_qty);

            // Get QTY on Hand
            var qoh = document.createElement('h3');
            qoh.innerText = 'QTY on Hand: ' + qtyOnHand; 

            // Append the qty on hand to the chart container
            chartContainer.appendChild(qoh);

            // Get status
            var status_restock = document.createElement('h3');
            status_restock.innerText = 'Restock Status: ' + status_bb; 

            // Append status
            chartContainer.appendChild(status_restock);

            
            // Create a canvas element
            var canvas = document.createElement('canvas');
            canvas.id = 'canvas-' + containerId;
            canvas.width = 400; // Set the canvas width
            canvas.height = 300; // Set the canvas height

            // Append the canvas to the chart container
            chartContainer.appendChild(canvas);

            // Append the chart container to the pop-up container
            var popupContainer = document.getElementById('popupContainer');
            popupContainer.appendChild(chartContainer);

            // Generate the chart with the week_value data
            generateChart(canvas.id, week_value);
        }); 

        // Show the pop-up container
        var popupContainer = document.getElementById('popupContainer');
        popupContainer.style.display = 'block';
    }

    function hideChartPopup() {
        // Remove the blur class from the body element
        document.body.classList.remove('blur');

        // Clear the chart containers inside the pop-up container
        var popupContainer = document.getElementById('popupContainer');
        popupContainer.innerHTML = '';

        // Create and style the close button
        var closeButton = document.createElement('button');
        closeButton.innerText = 'Close';
        closeButton.style.cssText = 'position: absolute; top: 10px; right: 10px; padding: 10px; background-color: #ffffff; border: none; border-radius: 4px; cursor: pointer;';

        // Add the event listener to the close button
        closeButton.addEventListener('click', hideChartPopup);

        // Add the close button to the pop-up container
        popupContainer.appendChild(closeButton);

        // Hide the pop-up container
        popupContainer.style.display = 'none';
    }

    function generateChart(canvasId, data) {
        // Retrieve the canvas element using its ID
        var canvas = document.getElementById(canvasId);

        // Get the chart context
        var ctx = canvas.getContext('2d');

        // Generate the chart using Chart.js
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
            datasets: [
                {
                label: 'Quantity',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
                }
            ]
            },
            options: {
            responsive: true,
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    }

    // Button event listeners
    var last7DaysButton = document.getElementById('last7DaysButton');
    last7DaysButton.addEventListener('click', function() {
        filterTransactions('last7days');
    });

    var last4WeeksButton = document.getElementById('last4WeeksButton');
    last4WeeksButton.addEventListener('click', function() {
        filterTransactions('last4weeks');
    });

    var last8WeeksButton = document.getElementById('last8WeeksButton');
    last8WeeksButton.addEventListener('click', function() {
        filterTransactions('last8weeks');
    });

    var allTimeButton = document.getElementById('allTimeButton');
    allTimeButton.addEventListener('click', function() {
        filterTransactions('allTime');
    });

    var closeButton = document.getElementById('closeButton');
    closeButton.addEventListener('click', hideChartPopup);

    // Initially filter for the last 7 days
    filterTransactions('last7days');
</script>

<!-- <script>
    /**
     * Dashboard Analytics
     */

    'use strict';

    (function () {
    let cardColor, headingColor, axisColor, shadeColor, borderColor;

    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;


    // Income Chart - Area chart
    // --------------------------------------------------------------------
    const incomeChartEl = document.querySelector('#incomeChart'),
        incomeChartConfig = {
        series: [
            {
            data: [24, 21, 30, 22, 42, 26, 35, 29]
            }
        ],
        chart: {
            height: 215,
            parentHeightOffset: 0,
            parentWidthOffset: 0,
            toolbar: {
            show: false
            },
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 2,
            curve: 'smooth'
        },
        legend: {
            show: false
        },
        markers: {
            size: 6,
            colors: 'transparent',
            strokeColors: 'transparent',
            strokeWidth: 4,
            discrete: [
            {
                fillColor: config.colors.white,
                seriesIndex: 0,
                dataPointIndex: 7,
                strokeColor: config.colors.primary,
                strokeWidth: 2,
                size: 6,
                radius: 8
            }
            ],
            hover: {
            size: 7
            }
        },
        colors: [config.colors.primary],
        fill: {
            type: 'gradient',
            gradient: {
            shade: shadeColor,
            shadeIntensity: 0.6,
            opacityFrom: 0.5,
            opacityTo: 0.25,
            stops: [0, 95, 100]
            }
        },
        grid: {
            borderColor: borderColor,
            strokeDashArray: 3,
            padding: {
            top: -20,
            bottom: -8,
            left: -10,
            right: 8
            }
        },
        xaxis: {
            categories: ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            axisBorder: {
            show: false
            },
            axisTicks: {
            show: false
            },
            labels: {
            show: true,
            style: {
                fontSize: '13px',
                colors: axisColor
            }
            }
        },
        yaxis: {
            labels: {
            show: false
            },
            min: 10,
            max: 50,
            tickAmount: 4
        }
        };
    if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
        const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
        incomeChart.render();
    }

    })();

</script> -->   