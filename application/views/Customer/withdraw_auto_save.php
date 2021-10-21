  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-6">
                      <h1 class="m-0">Widraw Auto Save Asset Digital</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <div class="container">
          <div class="card card-warning">
              <div class="card-header">
                  <h3 class="card-title">WITHDRAW</h3>
              </div>
              <div class="card-body">
              <p style="color: red">Minimum withdraw is 25 USDT</p>
              <p style="color: red">example : if you enter "2", then 2 of your Auto Save Asset Digital will be withdrawn from the oldest one</p>
                  <div class="form-group">
                      <label>Amount</label><br>
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                          </div>
                          <input id="amount_withdraw" type="number" class="form-control" placeholder="enter amount to withdraw ..">
                      </div>
                  </div>
                  <div class="form-group">
                      <label>Secure PIN</label><br>
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                          </div>
                          <input id="secure_pin" type="password" class="form-control" placeholder="enter your secure PIN ..">
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <button class="col-12 col-md-6 btn btn-warning" onclick="request()">Submit</button>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="<?php echo base_url() ?>assets/build/js/customer/Totalbonus.js"></script> -->


  <script>
      function request() {
          var id = document.getElementById('id').innerHTML;
          var base_url = document.getElementById('base_url').innerHTML;
          var amount = document.getElementById('amount_withdraw').value;
          var secure_pin = document.getElementById('secure_pin').value;
          console.log(amount)
          $.ajax({
              url: base_url + "api/withdraw_asad",
              type: "post",
              data: {
                  'id': id,
                  'amount': amount,
                  'secure_pin': btoa(secure_pin)

              },
              success: function(result) {
                  $('.loader').attr('hidden', true);
                  console.log('data : ' + result);
                  var d = JSON.parse(result);
                  show_message('success', d.response.message['english'], '');
              },
              error: function(result, ajaxOptions, thrownError) {
                  $('.loader').attr('hidden', true);
                  // console.log('data : '+xhr.responseText);
                  show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                  var string = JSON.stringify(result.responseText);
                  var msg = JSON.parse(result.responseText);
                  show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
              }
          });
      }
  </script>