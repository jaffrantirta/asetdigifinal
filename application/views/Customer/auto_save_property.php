<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Auto Save Property</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <button onclick="withdraw_asset()" class="btn btn-primary col-12">Withdraw</button>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <p hidden id='link'>datatable/get_properties/<?php echo $session['data']->id ?></p>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Auto Save Property</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js"></script>
            <script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>
            <script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
            <script src="<?php echo base_url() ?>assets/build/js/customer/DataTableOffline.js"></script>
            <script src="<?php echo base_url() ?>assets/build/js/customer/CustomerAjax.js"></script>
            <script src="<?php echo base_url() ?>assets/build/js/customer/ShowFileName.js"></script>
<script>
    $(document).ready(function() {
        var link = document.getElementById('base_url').innerHTML + document.getElementById('link').innerHTML;
        console.log(link);
        table = $('#table').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": link,
            "bSort":true,
            "bPaginate": true,
            "iDisplayLength": 10,
            "order": [[ 1, "desc" ]],
            "language": {
                "searchPlaceholder": "Search...",
                "search":""
            },
            "fnInitComplete": function(oSettings, json) {
                $('#table_filter :input').addClass('form-control').css({'width':'10em'});
            }
        });
    });

    function withdraw_asset() {
        Swal.fire({
        html:   
                '<div class="form-group">'+
                    '<label>Withdraw</label><br>'+
                    '<p style="color: red">Minimum withdraw is 25 USDT</p>'+
                    '<div class="m-1 input-group">'+
                        '<div class="custom-file">'+
                        '<input type="number" id="number" class="form-control" placeholder="enter the amount you want to withdraw">'+
                        '</div>'+
                    '</div>'+
                    '<div class="m-1 input-group">'+
                        '<div class="custom-file">'+
                        '<input type="password" id="secure_pin" class="form-control" placeholder="Secure PIN">'+
                        '</div>'+
                    '</div>'+
                    '<p style="color: red">example : if you enter "2", then 2 of your Auto Save Asset Digital will be withdrawn from the oldest one</p>'+
                '</div>',
            confirmButtonText: 'Withdraw Now!',
        }).then((result) => {
            if (result.isConfirmed) {
                withdraw_now()
            }
        })
    }
    function withdraw_now(){
                $.ajax({
                    url: base_url+"api/withdraw_auto_save_asset_digital",
                    type: "post",
                    data: {'type':'lisensi', 'secure_pin':secure_pin, 'id':id, 'lisensi_id':lisensi_id, 'recipient_username':recipient_username},
                    success: function(result){
                        $('.loader').attr('hidden', true);
                        console.log('data : '+result);
                        var data = JSON.parse(result);
                        show_message('success', data.response['message']['english'], '');
                        location.reload();
                    },
                    error: function (result, ajaxOptions, thrownError) {
                        $('.loader').attr('hidden', true);
                        // console.log('data : '+xhr.responseText);
                        show_message('error', 'Oops! something went wrong', 'kesalahan tidak diketahui');
                        var string = JSON.stringify(result.responseText);
                        var msg = JSON.parse(result.responseText);
                        show_message('error', 'Oops! something went wrong', msg.response.message['english']);
                    }
                });
    }
</script>