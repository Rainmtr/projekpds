<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->projek_pds->new_list;
$transactions = $collection->find()->toArray();

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

    #closeButton_country {
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

<a id="last7DaysButton_country" class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
<a id="last4WeeksButton_country" class="dropdown-item" href="javascript:void(0);">Last 4 Weeks</a>
<a id="last8WeeksButton_country" class="dropdown-item" href="javascript:void(0);">Last 8 Weeks</a>
<a id="allTimeButton_country" class="dropdown-item" href="javascript:void(0);">Show All</a>

<ul id="countryList"></ul>

<button id="showPopupButton" onclick="showChartPopup_country()">Show Pop-up</button>
<div id="popupContainer_country" class="popup-container">
  <div class="popup-content">
    <button id="closeButton_country">Close</button>
  </div>
</div>

<script>
    // Assuming you have the MongoDB query result stored in the `transactions` variable
    var transactions = <?php echo json_encode($transactions); ?>;
    var transactions_top5_item = <?php echo json_encode($transactions); ?>;
    var transactions_top5_chart = <?php echo json_encode($transactions); ?>;

    var filteredTransactions = []; // Initialize as an empty array

    var top5_average  = {};
    var top5_value = {};
    var top5Countries = {};
    var top5CountriesMostSoldItems = [];

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
        var countryValue = {};

        filteredTransactions.forEach(function(transaction) {
            var country = transaction.ship_country;

            if (countryCounts[country] && countryValue[country]) {
                countryCounts[country]++;
                countryValue[country] = countryValue[country] + transaction.total_price;
            } else {
                countryCounts[country] = 1;
                countryValue[country] = transaction.total_price;
            }
        });

        // Sort country counts in descending order
        var sortedCountryCounts = Object.entries(countryCounts).sort(function(a, b) {
            return b[1] - a[1];
        });
        

        // Get top 5 country destinations
        top5Countries = sortedCountryCounts.slice(0, 5).map(function(entry) {
            return {
                country: entry[0],
                count: entry[1]
            };
        });

        top5Countries.forEach(function(entry) {
            var country = entry.country;
            var count = entry.count;

            // Check if the country exists in countryValue
            if (countryValue.hasOwnProperty(country)) {
                var totalPrice = countryValue[country];
                var ratio = totalPrice / count;

                top5_average[country] = ratio;
                top5_value[country] = countryValue[country];
            }
        });

        // Filter transactions_top5_item and filteredTransactions_charts array based on top 5 countries
        var filteredTransactions_item = transactions_top5_item.filter(function(transaction) {
            return top5Countries.find(function(countryObj) {
                return countryObj.country === transaction.ship_country;
            });
        });
        var filteredTransactions_charts = filteredTransactions_item
        

        // Calculate the quantity of each item sold for each top 5 country
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

        // Find the most sold item for each top 5 country
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

        var top_num = 1;

        top5Countries.forEach(function(country) {
            var li = document.createElement('li');
            li.classList.add('d-flex', 'mb-4', 'pb-1');

            var avatar = document.createElement('div');
            avatar.classList.add('avatar', 'flex-shrink-0', 'me-3');
            var img = document.createElement('img');
            img.src = '../assets/img/icons/unicons/paypal.png';
            img.alt = 'User';
            img.classList.add('rounded');
            avatar.appendChild(img);
            li.appendChild(avatar);

            var countryDetails = document.createElement('div');
            countryDetails.classList.add('d-flex', 'w-100', 'flex-wrap', 'align-items-center', 'justify-content-between', 'gap-2');

            var countryInfo = document.createElement('div');
            countryInfo.classList.add('me-2');

            var itemSmallTag = document.createElement('small');
            itemSmallTag.classList.add('text-muted', 'd-block', 'mb-1');
            itemSmallTag.innerText = 'Number ' + top_num + ' top country';
            countryInfo.appendChild(itemSmallTag)

            top_num = top_num + 1;

            var countryName = document.createElement('h6');
            countryName.innerText = country.country;
            countryInfo.appendChild(countryName);
            countryDetails.appendChild(countryInfo);

            var countryCount = document.createElement('h6');
            countryCount.classList.add('mb-0');
            countryCount.innerText = country.count;
            var countryQty = document.createElement('span');
            countryQty.classList.add('text-muted');
            countryQty.innerText = 'QTY';
            var userProgress = document.createElement('div');
            userProgress.classList.add('user-progress', 'd-flex', 'align-items-center', 'gap-1');
            userProgress.appendChild(countryCount);
            userProgress.appendChild(countryQty);
            countryDetails.appendChild(userProgress);

            li.appendChild(countryDetails);

            countryList.appendChild(li);
        });
            
    }

    function showChartPopup_country() {
        // Add the blur class to the body element
        document.body.classList.add('blur');
        var countryNum = 1;

        console.log(top5Countries);

        top5Countries.forEach(function(country) {
        
            var containerId = 'countryContainer-' + countryNum;
            countryNum = countryNum + 1;

            // Create a chart container element
            var chartContainer = document.createElement('div');
            chartContainer.id = containerId;

            // Create a heading element
            var heading = document.createElement('h2');
            heading.innerText = country.country; //

            // Append the heading to the chart container
            chartContainer.appendChild(heading);

            // Get most sold items
            var mostSoldItems = top5CountriesMostSoldItems.find(function(item) {
                return item.country === country.country;
            });

            if (mostSoldItems) {
                var mostSoldItem = mostSoldItems.mostSoldItem;
                var quantity = mostSoldItems.quantity;

                // Create a paragraph element for most bought items
                var mostBoughtItemsPara = document.createElement('h3');
                mostBoughtItemsPara.innerText = 'Most bought items: ' + mostSoldItem + ' - ' + quantity;

                // Append the most bought items paragraph to the chart container
                chartContainer.appendChild(mostBoughtItemsPara);
            }

            var averageTransactionValue = top5_average[country.country];

            if (averageTransactionValue) {
                // Create a paragraph element for the average transaction value
                var averageValuePara = document.createElement('h3');
                averageValuePara.innerText = 'Average Transaction Value: ' + averageTransactionValue;

                // Append the average transaction value paragraph to the chart container
                chartContainer.appendChild(averageValuePara);
            }

            // Append the chart container to the pop-up container
            var popupContainer = document.getElementById('popupContainer_country');
            popupContainer.appendChild(chartContainer);
        }); 

        // Show the pop-up container
        var popupContainer = document.getElementById('popupContainer_country');
        popupContainer.style.display = 'block';
    }

    function hideChartPopup_country() {
        // Remove the blur class from the body element
        document.body.classList.remove('blur');

        // Clear the chart containers inside the pop-up container
        var popupContainer = document.getElementById('popupContainer_country');
        popupContainer.innerHTML = '';

        // Create and style the close button
        var closeButton = document.createElement('button');
        closeButton.innerText = 'Close';
        closeButton.style.cssText = 'position: absolute; top: 10px; right: 10px; padding: 10px; background-color: #ffffff; border: none; border-radius: 4px; cursor: pointer;';

        // Add the event listener to the close button
        closeButton.addEventListener('click', hideChartPopup_country);

        // Add the close button to the pop-up container
        popupContainer.appendChild(closeButton);

        // Hide the pop-up container
        popupContainer.style.display = 'none';
    }

    // Button event listeners
    var last7DaysButton_country = document.getElementById('last7DaysButton_country');
    last7DaysButton_country.addEventListener('click', function() {
        filterTransactions('last7days');
    });

    var last4WeeksButton_country = document.getElementById('last4WeeksButton_country');
    last4WeeksButton_country.addEventListener('click', function() {
        filterTransactions('last4weeks');
    });

    var last8WeeksButton_country = document.getElementById('last8WeeksButton_country');
    last8WeeksButton_country.addEventListener('click', function() {
        filterTransactions('last8weeks');
    });

    var allTimeButton_country = document.getElementById('allTimeButton_country');
    allTimeButton_country.addEventListener('click', function() {
        filterTransactions('allTime');
    });

    var closeButton_country = document.getElementById('closeButton_country');
    closeButton_country.addEventListener('click', hideChartPopup_country);

    // Initially filter for the last 7 days
    filterTransactions('last7days');
</script>