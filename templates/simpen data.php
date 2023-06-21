
?php if (count($result) > 0) { ?>
    <?php foreach ($result as $data){ ?>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <h3 class="card-header" style="font-weight: bold;">Item: <?php echo $data -> transaction_id ?> </h3>
            <div class="card-body">
              <h4 class="card-text, col-sm-5 col-form-label">Date: <?php echo $data -> date ?> </h4>
              <h4 class="card-text, col-sm-5 col-form-label">Customer ID: <?php echo $data -> cust_id ?> </h4>
              <h4 class="card-text, col-sm-5 col-form-label">Product Name: <?php echo $array_doc[0]->item ?> </h4>
              <h4 class="card-text, col-sm-5 col-form-label">Quantity: <?php echo $array_doc[0]->qty ?> </h4>
              <h4 class="card-text, col-sm-5 col-form-label">Price: <?php echo $array_doc[0]->price ?> </h4>
  
              <p class="demo-inline-spacing">
                <button
                  class="btn btn-primary me-1"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target=".multi-collapse"
                  aria-expanded="false"
                  aria-controls="multiCollapseExample1 multiCollapseExample2"
                >
                  Show Details
                </button>
              </p>

              <!-- Details Per-Transaksi -->
              <div class="row">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                  <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <!-- Ordered Product -->
                    <div class="my-3">
                      <div class="card shadow-none bg-transparent border border-secondary mb-3">
                        <div class="card-body">
                          <h5 class="card-title">Product Title</h5>
                          <p class="card-text">1 x RP 25.000</p>
                        </div>
                      </div>
                    </div>
                    
                    <div class="my-3">
                      <div class="card shadow-none bg-transparent border border-secondary mb-3">
                        <div class="card-body">
                          <h5 class="card-title">Product Title</h5>
                          <p class="card-text">1 x RP 25.000</p>
                        </div>
                      </div>
                    </div>

                    <div class="my-3">
                      <div class="card shadow-none bg-transparent border border-secondary mb-3">
                        <div class="card-body">
                          <h5 class="card-title">Product Title</h5>
                          <p class="card-text">1 x RP 25.000</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="my-3">
                      <div class="card shadow-none bg-transparent border border-secondary mb-3">
                        <div class="card-body">
                          <h5 class="card-title">Shipment</h5>
                          <p class="card-text">info about shipment</p>
                        </div>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    <?php echo "<br/>";}?> 
    <?php echo "<br/>";}?> 