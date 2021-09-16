var lisensi_price_global
function count(){
    var current_licence_price = document.getElementById('current_licence_price').innerHTML;
    var lisensi = document.getElementById('lisensi').value;
    var lisensi_price = document.getElementById('lisensi_'+lisensi).innerHTML;
    var total_payment = lisensi_price - current_licence_price;
    lisensi_price_global = total_payment
    document.getElementById('total_payment').value = total_payment;
}
function upload_process_lisensi(fd, id){
    $.ajax({
        url: document.getElementById('base_url').innerHTML + 'api/upload_receipt_upgrade/' + id,
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                show_message('success', 'Requested', '');
                document.getElementById('secure_pin').value = '';
                document.getElementById('total_payment').value = '';
            }else{
                Swal.fire(
                    'File not upload',
                    'Your file failed to upload, please re-upload in detail order',
                    'error'
                )
            }
        },
    });
}
function payment_method(){
    var lisensi = document.getElementById('lisensi').value;
    var amount = 1;
    var secure_pin = document.getElementById('secure_pin').value;
    var id = document.getElementById('id').innerHTML;
    var currency = document.getElementById('currency').value;

    if(amount != ''){
        if(secure_pin != ''){
            if(lisensi != 'not_select_yet'){
                $('.loader').attr('hidden', false);
                $.ajax({
                    url: base_url+"api/balance",
                    type: "post",
                    data: {'id':id},
                    success: function(result){
                        $('.loader').attr('hidden', true);
                        var data = JSON.parse(result)
                        var link = data['balance']
                        console.log('data : '+lisensi_price_global);
                        Swal.fire({
                            html:   '<strong>Please choose payment method</strong>'+
                                    '<div class="row">'+
                                        '<div class="col-6 col-md-6">'+
                                            '<button onclick="transfer()" style="margin: 0.2em"style="margin: 0.2em" class="col-12 btn btn-primary">Transfer</button>'+
                                        '</div>'+
                                        '<div class="col-6 col-md-6">'+
                                            '<button onclick="bonus_balance('+link+')" style="margin: 0.2em" class="col-12 btn btn-primary">Bonus Balance ('+data['balance']+' '+currency+')</button>'+
                                        '</div>'+
                                    '</div>', 
                            showConfirmButton: false
                        })
                        
                    },
                    error: function (result, ajaxOptions, thrownError) {
                        $('.loader').attr('hidden', true);
                        // console.log('data : '+xhr.responseText);
                        show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                        var string = JSON.stringify(result.responseText);
                        var msg = JSON.parse(result.responseText);
                        show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
                    }
                });
            }else{
                show_message('warning', 'Oops! sepertinya ada kesalahan', 'please choose lisensi');
            }
        }else{
            show_message('warning', 'Oops! sepertinya ada kesalahan', 'secure PIN is empty');
        }
    }else{
        show_message('warning', 'Oops! sepertinya ada kesalahan', 'amount is empty');
    }
}
function bonus_balance(balance){
    if(balance >= lisensi_price_global){
        var lisensi = document.getElementById('lisensi').value;
        var user_id = document.getElementById('id').innerHTML;
        var secure_pin = document.getElementById('secure_pin').value;
          $.ajax({
            url: document.getElementById('base_url').innerHTML + 'api/upgrade_licence_with_balance',
            type: 'post',
            data: {'lisensi_id': lisensi,'id': user_id, 'secure_pin':secure_pin},
            success: function(result){
                $('.loader').attr('hidden', true);
                var d = JSON.parse(result);
                show_message('success', d.response.message['english'], '');
                location.reload();
            },
            error: function(error, x, y){
                $('.loader').attr('hidden', true);
                show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                var msg = JSON.parse(error.responseText);
                show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
            }
          })
    }else{
        Swal.fire('Your balance is not enough')
    }
}
function transfer(){
    Swal.fire({
        html:   
                '<div class="form-group">'+
                    '<label>Upload Receipt of Payment</label><br>'+
                    '<div class="m-1 input-group">'+
                        '<div class="custom-file">'+
                        '<input type="file" id="file" class="custom-file-input">'+
                        '<label id="file_name_view" class="custom-file-label" for="exampleInputFile">Choose file receipt</label>'+
                        '</div>'+
                    '</div>'+
                '</div>',
            confirmButtonText: 'Upload',
    }).then((result) => {
        if (result.isConfirmed) {
            create_order(1)
        }
    })
}
function create_order(vPayment){
    var payment = vPayment
    var lisensi = document.getElementById('lisensi').value;
    var amount = 1;
    var secure_pin = document.getElementById('secure_pin').value;
    var id = document.getElementById('id').innerHTML;
    var fd = new FormData();
    var files = $('#file')[0].files;

    if(files.length > 0 ){
        if(amount != ''){
            if(secure_pin != ''){
                if(lisensi != 'not_select_yet'){
                    fd.append('file',files[0]);
                    $('.loader').attr('hidden', false);
                    $.ajax({
                        url: base_url+"api/upgrade_licence",
                        type: "post",
                        data: {'secure_pin':secure_pin, 'id':id, 'payment':payment, 'upgrade_to':lisensi},
                        success: function(result){
                            $('.loader').attr('hidden', true);
                            console.log('data : '+result);
                            var data = JSON.parse(result);
                            if(payment == 1){
                                upload_process_lisensi(fd, data.data['id']);
                            }
                        },
                        error: function (result, ajaxOptions, thrownError) {
                            $('.loader').attr('hidden', true);
                            // console.log('data : '+xhr.responseText);
                            show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                            var string = JSON.stringify(result.responseText);
                            var msg = JSON.parse(result.responseText);
                            show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
                        }
                    });
                }else{
                    show_message('warning', 'Oops! sepertinya ada kesalahan', 'please choose lisensi');
                }
            }else{
                show_message('warning', 'Oops! sepertinya ada kesalahan', 'secure PIN is empty');
            }
        }else{
            show_message('warning', 'Oops! sepertinya ada kesalahan', 'amount is empty');
        }
    }else{
        Swal.fire(
            'Choose file before',
            '',
            'warning'
        )
    }
}
