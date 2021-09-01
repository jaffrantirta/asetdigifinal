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