function count(){
    var amount = document.getElementById('amount').value;
    var price = document.getElementById('price').value;
    var total_payment = amount * price;
    document.getElementById('total_payment').value = total_payment;
}
function upload_process(fd, order_number, data){
    $.ajax({
        url: document.getElementById('base_url').innerHTML + 'api/upload_receipt/' + order_number,
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                show_message('success', data.response['message']['english'], '');
                document.getElementById('amount').value = '';
                document.getElementById('secure_pin').value = '';
                document.getElementById('total_payment').value = '';
                document.getElementById('file_name_view').innerHTML = 'Choose file receipt';
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
function create_order(){
    var amount = document.getElementById('amount').value;
    var secure_pin = document.getElementById('secure_pin').value;
    var id = document.getElementById('id').innerHTML;
    var currency = document.getElementById('currency').value;

    var fd = new FormData();
    var files = $('#file')[0].files;

    if(files.length > 0 ){
        if(amount != ''){
            if(secure_pin != ''){
                fd.append('file',files[0]);
                $('.loader').attr('hidden', false);
                $.ajax({
                    url: base_url+"api/create_order",
                    type: "post",
                    data: {'type':'pin', 'secure_pin':secure_pin, 'id':id, 'amount':amount, 'currency':currency},
                    success: function(result){
                        $('.loader').attr('hidden', true);
                        var data = JSON.parse(result);
                        console.log('data : '+result);
                        upload_process(fd, data.data['order_number'], data);
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
