function create_transfer(){
    var lisensi_id = document.getElementById('lisensi').value;
    var secure_pin = document.getElementById('secure_pin').value;
    var id = document.getElementById('id').innerHTML;
    var recipient_username = document.getElementById('recipient_username').value;
    if(lisensi_id != ''){
        if(secure_pin != ''){
            if(recipient_username != ''){
                $('.loader').attr('hidden', false);
                $.ajax({
                    url: base_url+"api/create_transfer",
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
            }else{
                show_message('warning', 'Oops! something went wrong', 'username PIN is empty');
            }
        }else{
            show_message('warning', 'Oops! something went wrong', 'secure PIN is empty');
        }
    }else{
        show_message('warning', 'Oops! something went wrong', 'lisensi not select yet');
    }
}