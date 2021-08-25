function count(){
    var amount = document.getElementById('amount').value;
    var price = document.getElementById('price').value;
    var total_payment = amount * price;
    document.getElementById('total_payment').value = total_payment;
}
function create_order(){
    var amount = document.getElementById('amount').value;
    var secure_pin = document.getElementById('secure_pin').value;
    var id = document.getElementById('id').innerHTML;
    var currency = document.getElementById('currency').value;
    if(amount != ''){
        if(secure_pin != ''){
            $('.loader').attr('hidden', false);
            $.ajax({
                url: base_url+"api/create_order",
                type: "post",
                data: {'secure_pin':secure_pin, 'id':id, 'amount':amount, 'currency':currency},
                success: function(result){
                    $('.loader').attr('hidden', true);
                    console.log('data : '+result);
                    var data = JSON.parse(result);
                    show_message('success', data.response['message']['english'], '');
                    document.getElementById('amount').value = '';
                    document.getElementById('secure_pin').value = '';
                    document.getElementById('total_payment').value = '';
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
}
