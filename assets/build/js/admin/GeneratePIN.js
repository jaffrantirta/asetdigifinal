function generate_pin(){
    $('.loader').attr('hidden', false);
    var id = document.getElementById('order_id').innerHTML;
      $.ajax({
        url: document.getElementById('base_url').innerHTML + 'api/generate_pin',
        type: 'post',
        data: {'id':id},
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