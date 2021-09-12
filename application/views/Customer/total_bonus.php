 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0">Total_bonus</h1>
                 </div><!-- /.col -->
             </div><!-- /.row -->
         </div><!-- /.container-fluid -->
     </div>
     <section>
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-12 col-12">
                     <div class="small-box bg-warning">
                         <div class="inner">
                             <h3 id="amount"></h3>
                             <p>TOTAL BONUSES</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-users"></i>
                         </div>
                         <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
                     </div>
                 </div>
             </div>
         </div>
     </section>

 </div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- <script src="<?php echo base_url() ?>assets/build/js/customer/Totalbonus.js"></script> -->

 <script>
     var id = document.getElementById('id').innerHTML;
     console.log('oke')
     $.ajax({
         url: base_url + "api/total_bonus",
         type: "post",
         data: {
             'id': id
         },
         success: function(result) {
             $('.loader').attr('hidden', true);
             console.log('data : ' + result);
             var data = JSON.parse(result);
             document.getElementById('amount').innerHTML = data['balance'];
         },
         error: function(result, ajaxOptions, thrownError) {
             $('.loader').attr('hidden', true);
             // console.log('data : '+xhr.responseText);
             show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
             var string = JSON.stringify(result.responseText);
             var msg = JSON.parse(result.responseText);
             show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
         }
     });
 </script>