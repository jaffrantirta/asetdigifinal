function register_customer(){
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var re_password = document.getElementById('re_password').value;
    var secure_pin = document.getElementById('secure_pin').value;
    var re_secure_pin = document.getElementById('re_secure_pin').value;
    var sponsor_code = document.getElementById('sponsor_code').value;
    var pin_register = document.getElementById('pin_register').value;
    var position = document.getElementById('position').value;
    var top_id = document.getElementById('top_id').value;
    if(password == re_password){
        if(secure_pin == re_secure_pin){
            if(name != ''){
                if(email != ''){
                    if(username != ''){
                        if(sponsor_code != ''){
                            if(pin_register != ''){
                                Swal.fire({
                                    title: 'Loading...',
                                    text: 'May take a while',
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                })
                                $.ajax({
                                    url: base_url+"api/register_process",
                                    type: "post",
                                    data: {'top_id':top_id, 'position':position, 'name':name, 'email':email, 'username':username, 'password':password, 'secure_pin':secure_pin, 'pin_register':pin_register, 'sponsor_code':sponsor_code},
                                    success: function(result){
                                        Swal.close();
                                        // console.log('data : '+result);
                                        var data = JSON.parse(result);
                                        show_message('success', data.response['message']['english'], '');
                                        window.location.href = document.getElementById('base_url').innerHTML+'customer';
                                    },
                                    error: function (result, ajaxOptions, thrownError) {
                                        Swal.close();
                                        // console.log('data : '+xhr.responseText);
                                        show_message('error', 'Oops! something went wrong', 'kesalahan tidak diketahui');
                                        var msg = JSON.parse(result.responseText);
                                        show_message('error', 'Oops! something went wrong', msg.response.message['english']);
                                    }
                                });
                            }else{
                                show_message('warning', 'Oops! something went wrong', 'PIN register is empty');
                            }
                        }else{
                            show_message('warning', 'Oops! something went wrong', 'sponsor code is empty');
                        }
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