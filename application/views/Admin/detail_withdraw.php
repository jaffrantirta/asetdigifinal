<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Withdraw Detail</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <strong>ORDER NUMBER</strong><br>
                            </div>

                            <h3 id="order_number" class="profile-username text-center"></h3>
                            <p hidden id="id_order"><?php echo $id_order ?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Date</b> <a id="date" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Requested By</b> <a id="name" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Amount to transfer</b> <a id="withdraw_amount" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Auto Save Property</b> <a id="auto_amount" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>USDT Wallet</b><button class="btn btn-info" onclick="myFunction()">Copy</button>
                                    <input disabled class="form-control" id="usdt_wallet" value="">
                                </li>
                            </ul>
                            <button class="btn btn-warning btn-block"><b>Update Status to Finish</b></button>
                            <button class="btn btn-danger btn-block"><b>Reject</b></button>

                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
              
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js"></script>
<script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/build/js/customer/Totalbonus.js"></script> -->

<script>
    var id_order = document.getElementById('id_order').innerHTML;
    var base_url = document.getElementById('base_url').innerHTML;
    $.ajax({
        url: base_url + "api/withdraw_detail",
        type: "post",
        data: {
            'id': id_order
        },
        success: function(result) {
            $('.loader').attr('hidden', true);
            //console.log('data : ' + result);
            var d = JSON.parse(result);
            document.getElementById('order_number').innerHTML = d.data.withdraw['order_number'];
            document.getElementById('date').innerHTML = d.data.withdraw['date'];
            document.getElementById('withdraw_amount').innerHTML = d.data.transfer['withdraw_amount'];
            document.getElementById('name').innerHTML = d.data.user['name'];
            document.getElementById('auto_amount').innerHTML = d.data.transfer['auto_amount'];
            document.getElementById('usdt_wallet').value = d.data.user['usdt_wallet'];
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
</script>
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("usdt_wallet");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    }
</script>