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
                                    <b>Requested By</b> <a id="name" href="#" onclick="member_detail()" class="float-right"></a>
                                    <p hidden id="user_id"></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Amount to transfer</b> <a id="withdraw_amount" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Auto Save Property</b> <a id="auto_amount" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> <a id="status" class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>USDT Wallet</b>
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button onclick="myFunction()" type="button" class="btn btn-info">Copy</button>
                                    </div>
                                    <input disabled id="usdt_wallet" class="form-control" value="">
                                    </div>
                                    <!-- <b>USDT Wallet</b> <input disabled class="col-4 form-control" id="usdt_wallet" value=""> <button class="btn btn-info" onclick="myFunction()"><i class="fa fa-copy" aria-hidden="true"></i></button> -->

                                </li>
                            </ul>
                            <div id="button_action" class="col-12">
                                
                            </div>

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
    function update_status(status) {
        var id_order = document.getElementById('id_order').innerHTML;
        var base_url = document.getElementById('base_url').innerHTML;
        var vstatus = status;
        $.ajax({
            url: base_url + "api/update_status_withdraw",
            type: "post",
            data: {
                'id': id_order,
                'status': vstatus
            },
            success: function(result) {
                $('.loader').attr('hidden', true);
                // console.log('data : ' + result);
                var d = JSON.parse(result);
                show_message('success', d.response.message['english'], '');
                location.reload();

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
            // console.log('data : ' + result);
            var d = JSON.parse(result);
            document.getElementById('order_number').innerHTML = d.data.withdraw['order_number'];
            document.getElementById('date').innerHTML = d.data.withdraw['date'];
            document.getElementById('withdraw_amount').innerHTML = d.data.transfer['withdraw_amount'];
            document.getElementById('name').innerHTML = d.data.user['name'];
            document.getElementById('user_id').innerHTML = d.data.user['id'];
            document.getElementById('auto_amount').innerHTML = d.data.transfer['auto_amount'];
            if (d.data.withdraw['status'] == 1) {
                document.getElementById('status').innerHTML = 'PENDING';
                document.getElementById('button_action').innerHTML = '  <button onclick="update_status(2)" class="btn btn-warning btn-block"><b>Update Status to Finish</b></button>'+
                                                                        '<button onclick="update_status(3)" class="btn btn-danger btn-block"><b>Reject</b></button>';
            } else if (d.data.withdraw['status'] == 2) {
                document.getElementById('status').innerHTML = 'ACCEPTED';
            } else {
                document.getElementById('status').innerHTML = 'REJECTED';
            }
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
        Swal.fire('Copied', '', 'success')
        // alert("Copied the text: " + copyText.value);
    }
    function member_detail(){
        var user_id = document.getElementById('user_id').innerHTML
        window.location.replace(document.getElementById('base_url').innerHTML+'admin/members?action=detail&id='+user_id)
    }
</script>