$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $('#file_name_view').html(fileName);
});