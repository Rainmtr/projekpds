<?php

require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->new_list;
$transactions = $collection->find()->toArray();

?>

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
        var top5Items_name = [];
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

        // console.log(top5Items_name);
        // console.log(top5item_chart);

        // top5item_chart.forEach(function(transaction) {
        //     var interval = transaction.transactionDate; // Assuming the transactionDate represents the interval
        //     var itemName = transaction.itemName;
        //     var quantity = transaction.itemQuantity;

        //     // Check if the interval exists in the summedData object
        //     if (!summedData[interval]) {
        //         summedData[interval] = {};
        //         top5Items_name.forEach(function(itemName) {
        //             summedData[interval][itemName] = 0;
        //         });
        //     }

        //     // Check if the item name exists in the interval's data
        //     if (!summedData[interval][itemName]) {
        //         summedData[interval][itemName] = 0;
        //     }

        //     // Accumulate the quantity for the item name within the interval
        //     summedData[interval][itemName] += quantity;
        // });

        // console.log(summedData);

        // var currentDate = new Date('2011-01-10'); // Replace this with your current date

        // // Calculate the start date of the first week
        // var firstWeekStartDate = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000); // Subtract 55 days to cover 8 weeks

        // var intervalStartDate = new Date(firstWeekStartDate); // Initialize the interval start date
        // var intervalEndDate = new Date(intervalStartDate.getTime() + (6 * 24 * 60 * 60 * 1000) - 1 ); // Set the interval end date for the first week

        // var intervals = []; // Array to store the intervals

        // // Iterate over the 8-week intervals
        // for (var i = 1; i <= 8; i++) {
        //     var interval = {
        //         startDate: new Date(intervalStartDate),
        //         endDate: new Date(intervalEndDate)
        //     };

        //     intervals.push(interval);

        //     // Move to the next interval
        //     intervalStartDate = new Date(intervalEndDate.getTime() + 24 * 60 * 60 * 1000);
        //     intervalEndDate = new Date(intervalEndDate.getTime() + 7 * 24 * 60 * 60 * 1000);
        // }

        // console.log(intervals);

        var summedData = {};

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


        // var transactionValueData = calculateTransactionValue(filteredTransactions_charts, startDate, currentDate, interval, groupBy);

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