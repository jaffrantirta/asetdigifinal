var base_url = document.getElementById('base_url').innerHTML;
function show_message($icon, $title, $message){
    Swal.fire({
        icon: $icon,
        html:
        '<div class="col-12">'+
        '<center>'+
        '<strong>'+$title+'</strong><br>'+
        '<small>'+$message+'</small>'+
        '</center>'+
        '</div>',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: true
    });
}
function update_status_order(act){
    $('.loader').attr('hidden', false);
    var action = act;
    var id = document.getElementById('order_id').innerHTML;
      $.ajax({
        url: document.getElementById('base_url').innerHTML + 'api/update_status_order',
        type: 'post',
        data: {'action':action, 'id':id},
        success: function(result){
            $('.loader').attr('hidden', true);
            var data = JSON.parse(result);
            show_message('success', data.response['message']['english'], '');
            location.reload();
        },
        error: function(error, x, y){
            $('.loader').attr('hidden', true);
            show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
            var msg = JSON.parse(error.responseText);
            show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
        }
      })
    }

    function update_status_order_pin(act){
        $('.loader').attr('hidden', false);
        var action = act;
        var id = document.getElementById('order_id').innerHTML;
          $.ajax({
            url: document.getElementById('base_url').innerHTML + 'api/update_status_order_pin',
            type: 'post',
            data: {'action':action, 'id':id},
            success: function(result){
                $('.loader').attr('hidden', true);
                var data = JSON.parse(result);
                show_message('success', data.response['message']['english'], '');
                location.reload();
            },
            error: function(error, x, y){
                $('.loader').attr('hidden', true);
                show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                var msg = JSON.parse(error.responseText);
                show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
            }
          })
        }
    
    function update_profile_company(){
      var sistem_name = document.getElementById('sistem_name').value
      var phone_number = document.getElementById('phone_number').value
      var email = document.getElementById('email').value
      var address = document.getElementById('address').value

      if(sistem_name != ''){
        if(phone_number != ''){
          if(email != ''){
            if(address != ''){
              $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/update_status_company_profile',
                type: 'post',
                data: {'sistem_name':sistem_name, 'phone_number':phone_number, 'email':email, 'address':address},
                success: function(result){
                    $('.loader').attr('hidden', true);
                    var data = JSON.parse(result);
                    show_message('success', data.response['message']['english'], '');
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
              show_message('warning', 'Address is Empty', '');
            }
          }else{
            show_message('warning', 'Email is Empty', '');
          }
        }else{
          show_message('warning', 'Phone Number is Empty', '');
        }
      }else{
        show_message('warning', 'Sistem Name is Empty', '');
      }
    }

    function update_pin_register_settings(){
      var price = document.getElementById('price').value
      var currency = document.getElementById('currency').value

          if(price != ''){
            if(currency != ''){
              $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/update_pin_register',
                type: 'post',
                data: {'price':price, 'currency':currency},
                success: function(result){
                    $('.loader').attr('hidden', true);
                    var data = JSON.parse(result);
                    show_message('success', data.response['message']['english'], '');
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
              show_message('warning', 'Currency is Empty', '');
            }
          }else{
            show_message('warning', 'Price is Empty', '');
          }
    }

    function update_licence_setting(){
      var name = document.getElementById('name').value
      var price = document.getElementById('price').value
      var percentage = document.getElementById('percentage').value
      var id = document.getElementById('id_licence').value
      // console.log(id);
      if(name != ''){
          if(price != ''){
            if(percentage != ''){
              $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/update_licence_setting',
                type: 'post',
                data: {'price':price, 'percentage':percentage, 'name':name, 'id':id},
                success: function(result){
                    $('.loader').attr('hidden', true);
                    var data = JSON.parse(result);
                    show_message('success', data.response['message']['english'], '');
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
              show_message('warning', 'Percentage is Empty', '');
            }
          }else{
            show_message('warning', 'Price is Empty', '');
          }
        }else{
          show_message('warning', 'Name is Empty', '');
        }
    }

    function update_instruction(){
      var instruction = document.getElementById('instruction').value
      // console.log(id);
      if(instruction != ''){
              $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/update_instruction',
                type: 'post',
                data: {'instruction':instruction},
                success: function(result){
                    $('.loader').attr('hidden', true);
                    var data = JSON.parse(result);
                    show_message('success', data.response['message']['english'], '');
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
          show_message('warning', 'Instruction is Empty', '');
        }
    }

    function change_logo(){
      var fd = new FormData();
      var files = $('#file')[0].files;
      if(files.length > 0 ){  
        fd.append('file',files[0]);
        $.ajax({
          url: document.getElementById('base_url').innerHTML + 'api/update_logo',
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
              if(response != 0){
                  show_message('success', 'Logo has been changed', '');
                  location.reload();
              }else{
                  Swal.fire(
                      'File not upload',
                      '',
                      'error'
                  )
              }
          },
          error: function(error, x, y){
            console.log(error);
          }
        });
      }else{
        show_message('warning', 'Logo is Empty', '');
      }
    }