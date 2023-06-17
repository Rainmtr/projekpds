<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->new_list;
$transactions = $collection->find()->toArray();

?>


<a id="last7DaysButton" class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
<a id="last4WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 4 Weeks</a>
<a id="last8WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 8 Weeks</a>
<a id="allTimeButton" class="dropdown-item" href="javascript:void(0);">Show All</a>

<ul id="countryList"></ul>

<!-- <script>
    // Assuming you have the MongoDB query result stored in the `transactions` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var transactions_top5_item = <?php echo json_encode($transactions); ?>;
    var transactions_top5_chart = <?php echo json_encode($transactions); ?>;

    var filteredTransactions = []; // Initialize as an empty array

    function filterTransactions(filter) {
        var currentDate = new Date('2011-01-10');
        var startDate;

        if (filter === 'last7days') {
            startDate = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last4weeks') {
            startDate = new Date(currentDate.getTime() - 4 * 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'last8weeks') {
            startDate = new Date(currentDate.getTime() - 8 * 7 * 24 * 60 * 60 * 1000);
            console.log(startDate);
        } else if (filter === 'allTime') {
            startDate = new Date(2010, 0, 1);
        } else {
            console.log('Invalid filter');
            return;
        }

        // Filter the transactions based on the date range
        filteredTransactions = transactions_top5_item = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate && transactionDate <= currentDate;
        });

        // Calculate country transaction counts
        var countryCounts = {};

        filteredTransactions.forEach(function(transaction) {
            var country = transaction.ship_country;

            if (countryCounts[country]) {
                countryCounts[country]++;
            } else {
                countryCounts[country] = 1;
            }
        });

        // Sort country counts in descending order
        var sortedCountryCounts = Object.entries(countryCounts).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 country destinations
        var top5Countries = sortedCountryCounts.slice(0, 5).map(function(entry) {
            return {
                country: entry[0],
                count: entry[1]
            };
        });

        // Filter transactions_top5_item array based on top 5 countries
        var filteredTransactions_item = transactions_top5_item.filter(function(transaction) {
            return top5Countries.find(function(countryObj) {
                return countryObj.country === transaction.ship_country;
            });
        });
        

        // Calculate the quantity of each item sold for each country
        var countryMostSoldItems = {};
        filteredTransactions_item.forEach(function(transaction) {
            var country = transaction.ship_country;
            var items = transaction.items;
            items.forEach(function(item) {
                var itemName = item.item;
                var itemQty = item.qty;
                if (!countryMostSoldItems[country]) {
                    countryMostSoldItems[country] = {};
                }
                if (!countryMostSoldItems[country][itemName]) {
                countryMostSoldItems[country][itemName] = 0;
                }
                countryMostSoldItems[country][itemName] += itemQty;
            });
        });



        // Find the most sold item for each country
        var top5CountriesMostSoldItems = [];
        for (var country in countryMostSoldItems) {
            var items = countryMostSoldItems[country];
            var mostSoldItem = Object.entries(items).reduce(function(a, b) {
                return a[1] > b[1] ? a : b;
            });
            top5CountriesMostSoldItems.push({
                country: country,
                mostSoldItem: mostSoldItem[0],
                quantity: mostSoldItem[1]
            });
        }


        // Update the country list in the HTML
        var countryList = document.getElementById('countryList');
        countryList.innerHTML = ''; // Clear previous list

        top5Countries.forEach(function(country) {
            var li = document.createElement('li');
            li.innerText = 'Country: ' + country.country + ', Transaction Count: ' + country.count;
            countryList.appendChild(li);
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
    // Assuming you have the MongoDB query result stored in the `transactions` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var transactions_top5_item = <?php echo json_encode($transactions); ?>;
    var transactions_top5_chart = <?php echo json_encode($transactions); ?>;

    var filteredTransactions = []; // Initialize as an empty array

    function filterTransactions(filter) {
        var currentDate = new Date('2011-01-10');
        var startDate;
        var interval;
        var groupBy;

        if (filter === 'last7days') {
            startDate = new Date(currentDate.getTime() - 6 * 24 * 60 * 60 * 1000);
            interval = 1;
            groupBy = 'day';
            //console.log(startDate);
        } else if (filter === 'last4weeks') {
            startDate = new Date(currentDate.getTime() - 27 * 24 * 60 * 60 * 1000);
            interval = 7;
            groupBy = 'week_4';
            // console.log(startDate);
        } else if (filter === 'last8weeks') {
            startDate = new Date(currentDate.getTime() - 55 * 24 * 60 * 60 * 1000);
            interval = 7;
            groupBy = 'week_8';
            // console.log(startDate);
        } else if (filter === 'allTime') {
            startDate = new Date(2010, 0, 1);
            interval = 1;
            groupBy = 'month';
        } else {
            console.log('Invalid filter');
            return;
        }

        // Filter the transactions based on the date range
        filteredTransactions = transactions_top5_item = transactions_top5_chart = transactions.filter(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );
            return transactionDate >= startDate && transactionDate <= currentDate;
        });

        // Calculate country transaction counts
        var countryCounts = {};

        filteredTransactions.forEach(function(transaction) {
            var country = transaction.ship_country;

            if (countryCounts[country]) {
                countryCounts[country]++;
            } else {
                countryCounts[country] = 1;
            }
        });

        // Sort country counts in descending order
        var sortedCountryCounts = Object.entries(countryCounts).sort(function(a, b) {
            return b[1] - a[1];
        });

        // Get top 5 country destinations
        var top5Countries = sortedCountryCounts.slice(0, 5).map(function(entry) {
            return {
                country: entry[0],
                count: entry[1]
            };
        });

        // Filter transactions_top5_item and filteredTransactions_charts array based on top 5 countries
        var filteredTransactions_item = transactions_top5_item.filter(function(transaction) {
            return top5Countries.find(function(countryObj) {
                return countryObj.country === transaction.ship_country;
            });
        });
        var filteredTransactions_charts = filteredTransactions_item
        

        // Calculate the quantity of each item sold for each country
        var countryMostSoldItems = {};
        filteredTransactions_item.forEach(function(transaction) {
            var country = transaction.ship_country;
            var items = transaction.items;
            items.forEach(function(item) {
                var itemName = item.item;
                var itemQty = item.qty;
                if (!countryMostSoldItems[country]) {
                    countryMostSoldItems[country] = {};
                }
                if (!countryMostSoldItems[country][itemName]) {
                countryMostSoldItems[country][itemName] = 0;
                }
                countryMostSoldItems[country][itemName] += itemQty;
            });
        });

        // Find the most sold item for each country
        var top5CountriesMostSoldItems = [];
        for (var country in countryMostSoldItems) {
            var items = countryMostSoldItems[country];
            var mostSoldItem = Object.entries(items).reduce(function(a, b) {
                return a[1] > b[1] ? a : b;
            });
            top5CountriesMostSoldItems.push({
                country: country,
                mostSoldItem: mostSoldItem[0],
                quantity: mostSoldItem[1]
            });
        }
    
        // Calculate transaction value for each interval (day/week/month)
        var transactionValueData = calculateTransactionValue(filteredTransactions_charts, startDate, currentDate, interval, groupBy);
        console.log(transactionValueData);

        // Update the country list in the HTML
        var countryList = document.getElementById('countryList');
        countryList.innerHTML = ''; // Clear previous list

        top5Countries.forEach(function(country) {
            var li = document.createElement('li');
            li.innerText = 'Country: ' + country.country + ', Transaction Count: ' + country.count;
            countryList.appendChild(li);
        });
            
    }

    function calculateTransactionValue(transactions, startDate, endDate, interval, groupBy) {
        var transactionValueData = [];
        var currentDate = new Date(startDate);
        // console.log(startDate);
        // console.log(endDate);
        // console.log(interval);
        // console.log(groupBy);

        while (currentDate <= endDate) {
            var intervalStartDate;
            var intervalEndDate;

            if (groupBy === 'day') {
                intervalStartDate = new Date(currentDate);
                intervalStartDate.setHours(0, 0, 0, 0);
                intervalEndDate = new Date(currentDate);
                intervalEndDate.setHours(23, 59, 59, 999);
            } else if (groupBy === 'week_4') {
                intervalStartDate = new Date(currentDate);
                intervalStartDate.setDate(intervalStartDate.getDate() - (interval * 4) - 1);
                intervalStartDate.setHours(0, 0, 0, 0);
                intervalEndDate = new Date(currentDate);
                intervalEndDate.setHours(23, 59, 59, 999);
            } else if (groupBy === 'week_8') {
                intervalStartDate = new Date(currentDate);
                intervalStartDate.setDate(intervalStartDate.getDate() - (interval * 8) - 1);
                intervalStartDate.setHours(0, 0, 0, 0);
                intervalEndDate = new Date(currentDate);
                intervalEndDate.setHours(23, 59, 59, 999);
            } else if (groupBy === 'month') {
                intervalStartDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - (interval - 1), 1);
                intervalStartDate.setHours(0, 0, 0, 0);
                intervalEndDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), getDaysInMonth(currentDate.getFullYear(), currentDate.getMonth()));
                intervalEndDate.setHours(23, 59, 59, 999);
            }

            var intervalValueData = {};

            transactions.forEach(function(transaction) {
            var transactionDateParts = transaction.date.split('/');
            var transactionDate = new Date(
                transactionDateParts[2],
                transactionDateParts[1] - 1,
                transactionDateParts[0]
            );

            if (transactionDate >= intervalStartDate && transactionDate <= intervalEndDate) {
                var country = transaction.ship_country;
                var transactionValue = transaction.total_price;

                if (!intervalValueData[country]) {
                    intervalValueData[country] = {
                        value: 0,
                        count: 0
                    };
                }

                intervalValueData[country].value += transactionValue;
                intervalValueData[country].count++;
            }
            });

            for (var country in intervalValueData) {
                transactionValueData.push({
                    country: country,
                    interval: formatDate(currentDate, groupBy),
                    value: intervalValueData[country].value.toFixed(2),
                    count: intervalValueData[country].count
                });
            }
            

            // Move to the next interval
            if (groupBy === 'day') {
                currentDate.setDate(currentDate.getDate() + 1);
            } else if (groupBy === 'week_4' || groupBy === 'week_8') {
                currentDate.setDate(currentDate.getDate() + 7);
            } else if (groupBy === 'month') {
                currentDate.setMonth(currentDate.getMonth() + interval);
            }
        }

        return transactionValueData;
    }

    function getDaysInMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
    }

    function formatDate(date, groupBy) {
        if (groupBy === 'day') {
            return date.toLocaleDateString();
        } else if (groupBy === 'week_4' || groupBy === 'week_8') {
            var startDate = new Date(date);
            startDate.setDate(date.getDate() - 6);
            return startDate.toLocaleDateString() + ' - ' + date.toLocaleDateString();
        } else if (groupBy === 'month') {
            return date.toLocaleString('default', { month: 'long', year: 'numeric' });
        }
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