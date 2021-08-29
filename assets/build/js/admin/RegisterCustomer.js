function register_customer(){
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var re_password = document.getElementById('re_password').value;
    var secure_pin = document.getElementById('secure_pin').value;
    var re_secure_pin = document.getElementById('re_secure_pin').value;
    if(password == re_password){
        if(secure_pin == re_secure_pin){
            if(name != ''){
                if(email != ''){
                    if(username != ''){
                        $('.loader').attr('hidden', false);
                        $.ajax({
                            url: base_url+"api/register_process",
                            type: "post",
                            data: {'name':name, 'email':email, 'username':username, 'password':password, 'secure_pin':secure_pin},
                            success: function(result){
                                $('.loader').attr('hidden', true);
                                console.log('data : '+result);
                                var data = JSON.parse(result);
                                show_message('success', data.response['message']['english'], '');
                                window.location.href = document.getElementById('base_url').innerHTML;
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
                        show_message('warning', 'Oops! something went wrong', 'username is empty');
                    }
                }else{
                    show_message('warning', 'Oops! something went wrong', 'email is empty');
                }
            }else{
                show_message('warning', 'Oops! something went wrong', 'name is empty');
            }
        }else{
            show_message('warning', 'Oops! something went wrong', 'secure PIN is different');
        }
    }else{
        show_message('warning', 'Oops! something went wrong', 'password is different');
    }
}