<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
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
  </head>

  <!-- Fetch Top 5 Customer -->
  <?php

    require '../../vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->projek_pds->new_list;
    $transactions = $collection->find()->toArray();

  ?>

  <?php
      include('../connections.php');

      $sql = "SELECT * FROM product_list_2";
      $result = $conn->query($sql);

      $row = [];

      if ($result->num_rows > 0) {
        $row = $result->fetch_all(MYSQLI_ASSOC);
      }
  ?>

  <body>
    <!-- Pop up Container -->
    <div id="popupContainer" class="popup-container">
      <div class="popup-content">
        <button id="closeButton">Close</button>
      </div>
    </div>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Side Navbar -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">

            <!-- Logo -->
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg
                  width="25"
                  viewBox="0 0 25 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <defs>
                    <path
                      d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                      id="path-1"
                    ></path>
                    <path
                      d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                      id="path-3"
                    ></path>
                    <path
                      d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                      id="path-4"
                    ></path>
                    <path
                      d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                      id="path-5"
                    ></path>
                  </defs>
                  <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                      <g id="Icon" transform="translate(27.000000, 15.000000)">
                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                          <mask id="mask-2" fill="white">
                            <use xlink:href="#path-1"></use>
                          </mask>
                          <use fill="#696cff" xlink:href="#path-1"></use>
                          <g id="Path-3" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-3"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                          </g>
                          <g id="Path-4" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-4"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                          </g>
                        </g>
                        <g
                          id="Triangle"
                          transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                        >
                          <use fill="#696cff" xlink:href="#path-5"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">PDS</span>
            </a>
            <!-- /Logo -->

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Tables -->
            <li class="menu-item">
              <a href="tables-basic.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Product List</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="ui-collapse.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Transactions</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="ui-buttons.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Buttons">Buttons</div>
              </a>
            </li>
            
          </ul>
        </aside>
        <!-- / Side Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="auth-login-basic.html">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->


            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <!-- Top 5 Customer -->
                <div class="col-md-6 col-lg-4 order-0 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Top 5 Items</h5>
                      <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="transactionID"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                          <a id="last7DaysButton" class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
                          <a id="last4WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 4 Weeks</a>
                          <a id="last8WeeksButton" class="dropdown-item" href="javascript:void(0);">Last 8 Weeks</a>
                          <a id="allTimeButton" class="dropdown-item" href="javascript:void(0);">Show All</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0" id="itemList">
                        <!-- <li class="d-flex mb-4 pb-1">
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
                        </li> -->

                      </ul>
                      <button id="showPopupButton" onclick="showChartPopup()" class="btn btn-primary">Show details</button>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0" id="countryList">
                        <!-- daftar country -->

                      </ul>
                      <button id="showPopupButton" onclick="showChartPopup()" class="btn btn-primary">Show details</button>
                    </div>
                  </div>
                </div>
                <!--/ Top 5 Customer -->

              </div>
            </div>

            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Charts Analytics JS-->
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

          // top5Items.forEach(function(item) {
          //     var li = document.createElement('li');
          //     li.innerText = 'Item: ' + item.itemName + ', Quantity: ' + item.itemCount;
          //     itemList.appendChild(li);
          // });

          var top_num = 1;
          
          top5Items.forEach(function(item) {
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

              var itemDetails = document.createElement('div');
              itemDetails.classList.add('d-flex', 'w-100', 'flex-wrap', 'align-items-center', 'justify-content-between', 'gap-2');

              var itemInfo = document.createElement('div');
              itemInfo.classList.add('me-2');

              var itemSmallTag = document.createElement('small');
              itemSmallTag.classList.add('text-muted', 'd-block', 'mb-1');
              itemSmallTag.innerText = 'Number ' + top_num + ' top item';
              itemInfo.appendChild(itemSmallTag);

              top_num = top_num + 1;

              var itemName = document.createElement('h6');
              itemName.innerText = item.itemName;
              itemInfo.appendChild(itemName);
              itemDetails.appendChild(itemInfo);

              var itemCount = document.createElement('h6');
              itemCount.innerText = item.itemCount;
              itemCount.classList.add('mb-0');
              var itemQty = document.createElement('span');
              itemQty.classList.add('text-muted');
              itemQty.innerText = 'QTY';

              var userProgress = document.createElement('div');
              userProgress.classList.add('user-progress', 'd-flex', 'align-items-center', 'gap-1');
              userProgress.appendChild(itemCount);
              userProgress.appendChild(itemQty);
              itemDetails.appendChild(userProgress);

              li.appendChild(itemDetails);

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
  </body>
</html>
