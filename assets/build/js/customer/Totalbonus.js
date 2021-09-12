
// totalbonus();
var id = document.getElementById('id').innerHTML;
console.log('oke')
$.ajax({
    url: base_url + "api/total_bonus",
    type: "post",
    data: { 'id': id },
    success: function (result) {
        $('.loader').attr('hidden', true);
        console.log('data : ' + result);
        var data = JSON.parse(result);
        document.getElementById('amount').innerHTML = data['balance'];
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
// function totalbonus() {
    
// }