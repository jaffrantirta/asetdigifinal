var base_url = $('#base_url').text();
function login_page(){
    Swal.fire({
        title: 'Login',
        html:
        '<div class="justify-content-center">'+
            '<div class="col-12">'+
                '<div class="form-group">'+
                    '<input id="phone_user" type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" class="form-control" placeholder="Masukan nomor telepon">'+
                '</div>'+
                '<div class="form-group">'+
                    '<input id="password_user" type="password" class="form-control" placeholder="Masukan password">'+
                '</div>'+
                '<div class="form-group">'+
                    '<button onclick="login_process()" class="btn btn-primary">Login</button>'+
                '</div>'+
            '</div>'+
        '</div>',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false
    });
}

function message($icon, $title, $message){
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

function login_process(){
    var phone = $('#phone_user').val();
    var password = $('#password_user').val();
    $('.loader').attr('hidden', false);
    $.ajax({
        url: base_url+"api/login_user",
        type: 'post',
        data: {'phone':phone, 'password':password},
        success: function(result){
            $('.loader').attr('hidden', true);
            console.log('login : '+result);
            var data = JSON.parse(result);
            var d = data.data[0];
            set_session(d.id, d.role_id, d.name, d.nik, d.sub_district_id, d.community_unit, d.email, d.date_of_birth, d.sex, d.occupation_id, d.profile_photo, d.ktp_photo, d.whatsapp_number);
        },
        error: function(error, x, y){
            $('.loader').attr('hidden', true);
            // console.log('error : '+error);
            message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
            var msg = JSON.parse(error.responseText);
            if(msg.response.status == false){
                message('error', 'Oops! sepertinya ada kesalahan', msg.response.message.indonesia);
            }
        }
    })
}

function insert_comment(){
    var email = $('#email').val();
    var name = $('#name').val();
    var comment = $('#comment').val();
    if(email != '' && name != '' && comment != ''){
        $('.loader').attr('hidden', false);
        $.ajax({
            url: base_url+"api/insert_comment",
            type: 'post',
            data: {'email':email, 'name':name, 'comment':comment},
            success: function(result){
                $('.loader').attr('hidden', true);
                var data = JSON.parse(result);
                // console.log('insert : '+data.response['message']['indonesia']);
                if(data.response['status'] == true){
                    document.getElementById('email').value = '';
                    document.getElementById('name').value = '';
                    document.getElementById('comment').value = '';
                    message('success', data.response['message']['indonesia'], '');
                }
            },
            error: function(error, x, y){
                $('.loader').attr('hidden', true);
                // console.log('error : '+error);
                message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                var msg = JSON.parse(error.responseText);
                if(msg.response.status == false){
                    message('error', 'Oops! sepertinya ada kesalahan', msg.response.message.indonesia);
                }
            }
        })
    }else{
        message('warning', 'Oops! sepertinya masih ada kolom yang kosong', 'mohon isi semua kolom');
    }
}

function profile(){
    Swal.fire({
        html:
        '<button onclick="logout()" class="btn btn-danger">Logout</button>',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false
    })
}
function search_page(){
    Swal.fire({
        html: 
        '<input placeholder="Ketik kata kunci yang ingin dicari ..." type="search" id="keyword" class="form-control col-12">'+
        '<button style="margin-top: 0.5em" onclick="search_process()" class="btn btn-primary col-12">Cari</button>',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false
    })
}
function search_process(){
    var keyword = $('#keyword').val()
    window.location.replace(base_url+'news/search/'+keyword);
}
function logout(){
    Swal.fire({
        title: 'Yakin logout ?',
        confirmButtonText:'Ya, logout'
    }).then((result) => {
        if (result.isConfirmed) {
            $('.loader').attr('hidden', false);
            $.ajax({
                url: base_url+'api/logout',
                type: 'get',
                success: function(result){
                    $('.loader').attr('hidden', true);
                    message('success', 'Logout berhasil', '');
                    location.reload();
                },
                error: function(error, x, y){
                    $('.loader').attr('hidden', true);
                    message('error', 'Logout gagal', '');
                }
            })
        }
      });
}
function set_session(id, role_id, user_name, nik, sub_district_id, community_unit, email, date_of_birth, sex, occupation_id, profile_photo, ktp_photo, whatsapp_number){
    $('.loader').attr('hidden', false);
    $.ajax({
        url: base_url+"api/set_session",
        type: "post",
        data: 
        {
            'id':id, 
            'role_id':role_id, 
            'name':user_name,
            'nik':nik,
            'sub_district_id':sub_district_id,
            'community_unit':community_unit,
            'email':email,
            'date_of_birth':date_of_birth,
            'sex':sex,
            'occupation_id':occupation_id,
            'profile_photo':profile_photo,
            'ktp_photo':ktp_photo,
            'whatsapp_number':whatsapp_number,
            'user_auth':'authenticated_user'
        },
        success: function(result){
            $('.loader').attr('hidden', true);
            message('success', 'Login berhasil', '');
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            // console.log('data : '+xhr.responseText);
            message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
            var msg = JSON.parse(xhr.responseText);
            if(msg.response.status != false){
                message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
            }
        }
    });
}