

<section  id="menu" class="ftco-section">
      <div class="container">

        

<?php if($this->cart->total_items() != 0){ ?>

	<div class="row no-gutters justify-content-center mb-5 pb-2">
          <div class="col-md-12 text-center heading-section ftco-animate">
            <!-- <span class="subheading">Cart</span> -->
            <h2 class="mb-4">Cart</h2>
          </div>

          <div class="col-md-12 text-center heading-section ftco-animate">
          </div>

          <div class="col-md-12 text-center heading-section ftco-animate">
          	<strong onclick="actionOption()" class="btn btn-primary" id="act_view">DELIVERY</strong>
          </div>

          <div class="col-md-12 text-center heading-section ftco-animate">
          	<small id="desc_view">pesanan anda akan diantarkan ke alamat anda</small>
          </div>

        </div>
		<input type="hidden" id="action_get_it" value="delivery">
        <div class="row no-gutters d-flex align-items-stretch justify-content-center">




         <!--Section: Block Content-->
            <section id="items_found">

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-lg-8">

                  <!-- Card -->
                  <div class="card wish-list mb-3">
                     <strong style="text-align: center; margin: 1em" id="items_all" class="mb-4 text-center">Cart (<span></span><?php echo $this->cart->total_items() ?></span> items)</strong>
                      

                      <input type="hidden" value="<?php echo count($this->cart->contents()) ?>" id="count_items">
                     <?php $i = 0; ?>

                    <div class="row card-body">

                     
                      
                      <?php foreach ($this->cart->contents() as $items){ ?>


                      	<div style="padding: 0;" class="hvr-grow round reload row col-12 col-md-3">
                      		<input type="hidden" value="<?php echo $items['id'] ?>">
	                        <input type="hidden" id="rowid" value="<?php echo $items['rowid'] ?>">
	                        <input type="hidden" id="id_menu" value="<?php echo $items['id']; ?>">
	                        <input type="hidden" value="<?php echo $items['note'] ?>" id="note">

	                        <?php $cart['amount']=$items['qty']; ?>
	                        <?php $cart['idMenu']=$items['id']; ?>
	                        <?php $cart['note']= $items['note']; ?>
	                        <?php $array[]= $cart ?>
                          <div class="col-4 col-md-12 text-center" style="padding: 0;">
                          	
                            <img style="border-radius: 25px;" src="https://jagoanqr.s3-id-jkt-1.kilatstorage.id/images/menu/<?php echo $items['picture'] ?>" width="100%" height="100%">
                         </div>
                          <div class="col-8 col-md-12 text-center">

                          	<strong><?php echo $items['name']; ?></strong><br>
                            <small>Rp. <?php echo number_format($items['price'],0); ?></small>
                            <small id="note<?php echo $i ?>" class="form-text text-muted text-center"><?php echo $items['note']; ?></small>
                            <strong id="qty_v_<?php echo $i ?>">x<?php echo $items['qty']; ?></strong><br>
                            <input id="qty<?php echo $i ?>" style="text-align: center;" class="col-12" min="0" name="quantity" value="<?php echo $items['qty']; ?>" type="hidden" disabled>
                          	<button onclick="popup_edit_menu('<?php echo $items['rowid'] ?>', document.getElementById('qty'+<?php echo $i ?>).value, '<?php echo $i ?>', document.getElementById('note'+<?php echo $i ?>).innerHTML, '<?php echo $items['picture']; ?>', '<?php echo $items['name']; ?>', '<?php echo $items['price']; ?>')" class="btn btn-primary">edit</button>
                          </div>
                        </div>


                      <?php 
                      $i++;
                    } ?>
                      <input type="hidden" name="" id="json">


                      <hr class="mb-4">
                      <!-- <p class="text-primary mb-0"><i class="fas fa-info-circle mr-1"></i> Do not delay the purchase, adding -->
                        <!-- items to your cart does not mean booking them.</p> -->

                    </div>
                    <div class="col-12 text-center">
                    	<strong class="col-6 btn btn-danger" style="margin: 1em" onclick="hapus_item('clear_cart')">Hapus semua</strong>
                    </div>
                    

                  </div>
                  <!-- Card -->

                </div>
                <!--Grid column-->

                 <!--Grid column-->
                <div class="col-lg-4">

                  <!-- Card -->
                  <div class="card mb-3">
                    <div id="rincian" class="card-body">

                      <h5 class="mb-3">Total biaya</h5>

                     

                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                          Total
                          <input id="total_biaya1_value" type="hidden" value="<?php echo $this->cart->total() ?>">
                          <span id="total_biaya1">Rp. <?php echo number_format($this->cart->total()) ?></span>
                        </li>
                        <input type="hidden" id="jarak_final">
                        <li id="ongkir_view" class="d-flex justify-content-between align-items-center px-0">
                          Ongkir
                          <span id="ongkir"></span>
                          <div id="loading_ongkir" style="height: 2em; width: 2em" class="loader"></div>
                        </li>
                         <li id="text_tax" class="d-flex justify-content-between align-items-center px-0">
                          Tax
                          <div id="loading_tax" style="height: 2em; width: 2em" class="loader"></div>
                        </li>
                        <span id="tax_value"></span>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                          <div>
                            <strong>Total Biaya</strong>
                          </div>
                          <span><strong id="total_biaya"></strong></span>
                          <div id="loading_total" style="height: 2em; width: 2em" class="loader"></div>
                        </li>
                      </ul>

                     
                    </div>
                  </div>
                  <!-- Card -->

                  <!-- Card -->
                  <div id="alamat_pengiriman" class="card mb-3">
                    <div class="card-body">

                      <center>
                      <input type="hidden" id="loc_lat_shop" value="<?php echo $latitude_shop ?>" />
                      <input type="hidden" id="loc_long_shop" value="<?php echo $longitude_shop ?>" />

                       <input type="hidden" id="loc_lat_dest" value="<?php echo $latitude_dest ?>" />
                      <input type="hidden" id="loc_long_dest" value="<?php echo $longitude_dest ?>" />

                      <h6>Pesanan akan dikirim ke alamat</h6>
                      <a href="#lokasi_perangkat"><strong id="lokasi_perangkat"><?php echo $lokasi_antar ?></strong></a>
                      <br>
                      <button onclick="ubahLokasi()" class="btn btn-primary"><i class="fa fa-edit"></i> ganti alamat</button>
                      <input style="text-align: center;" placeholder="masukan alamat" name="search_input" autocomplete="off" type="hidden" id="search_input" class="form-control">
                      <div style="margin-top: 1em" hidden="hidden" class="col-6" id="map"></div>

                      <a class="dark-grey-text d-flex justify-content-between" data-toggle="collapse" href="#collapseExample12"
                        aria-expanded="false" aria-controls="collapseExample1">
                        Catatan lokasi
                        <span><i class="fa fa-chevron-down pt-1"></i></span>
                      </a>
                        <div class="collapse" id="collapseExample12">
                        <div class="mt-3">
                          <div class="md-form md-outline mb-0">
                            <input maxlength="100" type="text" id="note_alamat" class="form-control font-weight-light"
                              placeholder="(contoh : sebelah minimarket)">
                          </div>
                        </div>
                      </div>
                      <button id="btn_order_delivery" hidden="true" style="margin-top: 2em" class="btn btn-primary col-12" onclick="addOrder()">Order Sekarang</button>
                      </center>
                    </div>
                  </div>
                  <!-- Card -->

                  <!-- button -->
                  <div id="btn_order_pickup">
                  		<a hidden="true" class="dark-grey-text d-flex justify-content-between" data-toggle="collapse" href="#collapseExample1"
                        aria-expanded="false" aria-controls="collapseExample1">
                        Catatan untuk resto
                        <span><i class="fa fa-chevron-down pt-1"></i></span>
                      </a>
                      <div class="collapse" id="collapseExample1">
                        <div class="mt-3">
                          <div class="md-form md-outline mb-0">
                            <input maxlength="100" type="text" id="note_alamat_pickup" class="form-control font-weight-light"
                              placeholder="(contoh : saya ambil jam 10)">
                          </div>
                        </div>
                      </div>
                  <button style="margin-top: 2em" class="btn btn-primary col-12" onclick="addOrderPickups()">Order Sekarang</button>
                </div>

                </div>
                <!--Grid column-->

              </div>
              <!--Grid row-->

            </section>
            <!--Section: Block Content-->

            <?php }else{ ?>
            	<div class="row no-gutters justify-content-center mb-5 pb-2">
          <div class="col-md-12 text-center heading-section ftco-animate">
            <!-- <span class="subheading">Cart</span> -->
            <h2 class="mb-4">Cart</h2>
          </div>
        </div>
        <div class="row no-gutters d-flex align-items-stretch">

              <div class="col-12" id="items_not_found">
                <center>
                        <lottie-player src="<?php echo base_url('asset/JS/Lottie/not_found.json') ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
                        <strong id="txt_kosong">Keranjang Kosong</strong>
                     </center>
              </div>


                     
                        
                          

                      <hr class="mb-4">
                      <!-- <p class="text-primary mb-0"><i class="fas fa-info-circle mr-1"></i> Do not delay the purchase, adding -->
                        <!-- items to your cart does not mean booking them.</p> -->

                    </div>
                  </div>
                  <!-- Card -->

                </div>
                <!--Grid column-->

                    <?php } ?>





        </div>
        
      </div>
    </section>
    <input type="hidden" id="hp_staff" value="<?php echo $staff['hp'] ?>">

    <script type="text/javascript">
      var drivers = new Array();
      var interfal;
      var staff = document.getElementById('hp_staff').value;
      var token_bearer = "Bearer <?php echo $this->session->userdata('token_bearer') ?>";

      if(staff == 'not_found'){
          var no_staff = null;
          var nama_shop = null;
      }else{
          var hp_staff = staff.substring(1);
          var no_staff = '62'+hp_staff;
          
      }
      
    
      console.log('staff : '+staff);

        $(document).ready(function(){
          var count_items = document.getElementById('count_items').value;
          var lat_dest = document.getElementById('loc_lat_dest').value;
          var lng_dest = document.getElementById('loc_long_dest').value;
          console.log('count_items :'+count_items);
          if(count_items != 0){
            cekOngkir();
            getJsonItems();
            setMapPotition(lat_dest, lng_dest);
          }
        });

        function popup_edit_menu(rowid, qty, count, note, picture, name, price){
        	console.log('popup : '+rowid+' || '+qty+' || '+count+' || '+note+' || '+picture+' || '+name+' || '+price);
        	var minus ="'minus'";
        	var plus ="'plus'";
        	Swal.fire({
                          title: 'Detail',
                           html: 
                           '<input type="hidden" id="rowid_p" value="'+rowid+'">'+
                           '<input type="hidden" id="count_p" value="'+count+'">'+
                              '<div class="row">'+
                                '<div class="col-12 col-md-6"><img style="border-radius: 25px;" class="col-12" src="https://jagoanqr.s3-id-jkt-1.kilatstorage.id/images/menu/'+picture+'"></div>'+
                                '<div class="col-12 col-md-6">'+

                                '<div class="align-items-center">'+
                                '<div>'+
                                  '<div>'+
                                    '<div class="one-forth">'+
                                      '<strong>'+name+'</strong>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="one-forth">'+
                                      '<small class="price">Rp. '+price+'</small><br>'+
                                    '</div>'+
                                  '<div class="col-12"><button onclick="kurangQty()" class="btn btn-primary">-</button> <input class="col-4" style="text-align: center" value="'+qty+'" type="number" id="qty_p" disabled> <button id="btn_plus" onclick="tambahQty()" class="btn btn-primary">+</button></div><br>'+
                                  '<input class="form-control col-12" style="text-align: left" placeholder="catatan..." id="note_p" value="'+note+'">'+
                                  '<button style="margin-top: 0.5em" onclick="updateItem()" class="btn btn-primary">Update</button>'+
                                '</div>'+
                              '</div>'+

                                '</div>'+
                              '</div>',
                          showCloseButton: true,
                          showCancelButton: false,
                          showConfirmButton: false,
                        });

        }

        function tambahQty(){
	        var jml = parseInt(document.getElementById('qty_p').value);
	        //console.log('tambah : '+jml);
	        var hasil = jml + 1;
	        document.getElementById('qty_p').value = hasil;

	      }
	      function kurangQty(){
	        var jml = parseInt(document.getElementById('qty_p').value);
	        //console.log('tambah : '+jml);
	        var hasil = jml - 1;
	        if(hasil <= 0){
	          document.getElementById('qty_p').value = 0;
	        }else{
	          document.getElementById('qty_p').value = hasil;
	        }
	      }

        function togglePick(act){
        	if(act == 'delivery'){
            Swal.close();
        		document.getElementById('action_get_it').value = 'pickup';
        		document.getElementById('act_view').innerHTML = 'PICKUP';
        		document.getElementById('desc_view').innerHTML = 'anda akan mengambil pesanan anda ke resto ketika sudah selesai';
	        	console.log('hhh : pickup');
	        	cekOngkir();
        	}else if(act == 'pickup'){
            Swal.close();
        		document.getElementById('action_get_it').value = 'delivery';
        		document.getElementById('act_view').innerHTML = 'DELIVERY';
        		document.getElementById('desc_view').innerHTML = 'pesanan anda akan diantarkan ke alamat anda';
	        	console.log('hhh2 : delivery');
	        	cekOngkir();
        	}
        }

        function ubahLokasi(){
         var y = document.getElementById("search_input");
          if(y.type == 'hidden'){
            $("#map").show(500);
            y.type = 'text';
            $("#map").attr("hidden",false);
          }else if(y.type == 'text'){
            $("#map").hide(500);
            y.type = 'hidden';
            $("#map").attr("hidden",true);
          }
        }

        function actionOption(){
          var delivery = "'delivery'";
          var pickup = "'pickup'";
          var img_pickup = "'<?php echo base_url('asset/no_image/pickup.jpg') ?>'";
          var img_delivery = "'<?php echo base_url('asset/no_image/delivery.jpg') ?>'";
          Swal.fire({
            html:
            '<strong id="title_act">pilih cara anda<br> mendapatkan pesanan anda</strong>'+
            '<div class="row text-center">'+
            '<div onclick="togglePick('+pickup+')" class="col-12 col-md-6 center">'+
              '<div class="property-card">'+
                  '<div style="background-image:url('+img_delivery+');" class="col-12 property-image">'+
                  '</div>'+
                '<div class="property-description">'+
                  '<strong>DELIVERY</strong><br>'+
                  '<small>pesanan anda akan diantarkan ke alamat yang sudah anda tentukan</small>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="pickup_div" onclick="togglePick('+delivery+')" class="col-12 col-md-6 center">'+
              '<div class="property-card">'+
                  '<div style="background-image:url('+img_pickup+');" class="col-12 property-image">'+
                  '</div>'+
                '<div id="dest_pickup" class="property-description">'+
                  '<strong id="dest_small">PICKUP</strong><br>'+
                  '<small>anda akan mengambil pesanan anda ke resto ketika sudah selesai</small>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '</div>',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false
          });
          if(staff == 'not_found'){
            $('#pickup_div').attr('onclick', 'pickup_not_found()');
            $('#pickup_div').attr('class', 'cursor col-12 col-md-6 center');
            $('#dest_pickup').attr('class', 'bg_gray property-description');
            $('#pickup_div').attr('style', 'opacity: 0.5;');
            $('#dest_small').html('<strong style="color: red">PICKUP TIDAK TERSEDIA</strong>');
          }
        }

        function pickup_not_found(){
        	document.getElementById('title_act').innerHTML = 'pilih cara anda<br> mendapatkan pesanan anda<br><small style="color: red">pickup tidak tersedia di resto ini</small>'
        }

        function cekOngkir(){
        	var y = document.getElementById('action_get_it').value;

        	if( y == 'pickup' ){
        		document.getElementById('ongkir_view').innerHTML = '';
        		$('#alamat_pengiriman').hide();
        		$("#btn_order_pickup").attr("hidden",false);
        	}else if(y == 'delivery'){
        		$('#alamat_pengiriman').show();
        		$("#btn_order_pickup").attr("hidden",true);
        		document.getElementById('ongkir_view').innerHTML = 'Ongkir'+
                          '<span id="ongkir"></span>'+
                          '<div id="loading_ongkir" style="height: 2em; width: 2em" class="loader"></div>';
        	}
       	  $('#loading_ongkir').show();
          $('#ongkir').hide();
          $('#loading_ongkir2').show();
          $('#loading_tax').show();
          $('#loading_total').show();
          $('#total_biaya').hide();
          $('#tax_view').hide();
          var directionsService = new google.maps.DirectionsService();
                var asal = new google.maps.LatLng(document.getElementById('loc_lat_shop').value, document.getElementById('loc_long_shop').value);
                var tujuan = document.getElementById('lokasi_perangkat').innerHTML;

                console.log('tujuan : '+tujuan);
                console.log('asal : '+asal);

                
                var request = {
                  origin: asal,
                  destination: tujuan,
                  travelMode: 'DRIVING'
                };
                directionsService.route(request, function(result, status) {
                  var jarak = result.routes[0].legs[0].distance.value;
                  document.getElementById('jarak_final').value = jarak;
                  var id_menu = document.getElementById('id_menu').value;
                  var ids = '['+id_menu+']';
                  console.log('token : '+token_bearer);
                  $.ajax({
                    url: "https://api.jagoanqr.com/api/food_order/total",
                    headers: {
                                  'Authorization': token_bearer,
                                  'Accept': 'application/json'
                              },
                    type: "post",
                    data: {"ids":ids, "qtys":ids, "distance":jarak},
                    success: function(result){
                      var data = JSON.stringify(result);
                       var data2 = JSON.parse(data);
                      console.log('hahaha : '+data);
                      if(y=='delivery'){
			        		document.getElementById('ongkir').innerHTML ='Rp. '+ribu(data2.transport_price);
                      		document.getElementById('ongkir').value = data2.transport_price;
			        	}
                      

                      var total_biaya = parseInt(document.getElementById('total_biaya1_value').value);
                      var tax_db = data2.tax_amount;
                      var tax_percent = tax_db.replace('%', '');
                      console.log("persen : "+tax_percent);
                      var tax_fix = (parseInt(tax_percent)/100) * total_biaya;
                      console.log("total tax : "+tax_fix);
                      document.getElementById('text_tax').innerHTML = 'Tax '+data2.tax_amount+'<span id="tax_view">Rp. '+ribu(tax_fix)+'</span><div id="loading_ongkir2" style="height: 2em; width: 2em" class="loader"></div>';
                      document.getElementById('tax_value').value = tax_fix;

                      grandTotal();
			          $('#loading_ongkir').hide();
			          $('#ongkir').show();
                      $('#loading_ongkir2').hide();
                      $('#loading_tax').hide();
                      $('#loading_total').hide();
                      $('#total_biaya').show();
                      $('#tax_view').show();

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                      var message = JSON.stringify(xhr.responseText);
                      var getMessage = JSON.parse(message);
                      Swal.fire({
                        title: 'Kesalahan sistem'
                      });
                      console.log(xhr.status);
                      console.log(xhr.responseText);
                          
                    }
                  });
                });
        }



      function updateItem(){
      	var qty = document.getElementById('qty_p').value;
      	var rowid = document.getElementById('rowid_p').value;
      	var note = document.getElementById('note_p').value;
      	var count = document.getElementById('count_p').value;

      	console.log('popup : '+rowid+' || '+qty+' || '+count+' || '+note);
        var param = 'qty'+count;
        document.getElementById(param).value = qty;
          $.ajax({
                      url: "<?php echo base_url('food/updateCart') ?>",
                      type: "post",
                      data: {'rowid':rowid ,'qty':qty, 'note':note},
                      success: function(result){
                      console.log(result);
                         var data = JSON.parse(result);
                      console.log(data.status);
                         if(data.status === 'oke'){
                          document.getElementById('note'+count).innerHTML = note;
                          document.getElementById('qty'+count).innerHTML = qty;
                          document.getElementById('qty_v_'+count).innerHTML = 'x'+qty;
                          document.getElementById('total_biaya1').innerHTML = 'Rp. '+ribu(data.total_biaya);
                          document.getElementById('total_biaya1_value').value = data.total_biaya;
                          document.getElementById('items_all').innerHTML = 'Cart '+'('+data.items+' items)';
                          cekOngkir();
                          getJsonItems();
                          Swal.close();
                         }else{
                            Swal.fire({
                              title: 'Kesalahan sistem',
                              icon: 'danger'
                            });
                         }
                      }
                    });
          if(qty == 0){
            window.location.reload();
          }
        
      }
      function getJsonItems(){
        $.ajax({
                      url: "<?php echo base_url('food/json_items') ?>",
                      success: function(result){
                      console.log('result json : '+result);
                      $('#json').val(result);
                      }
                    });
      }
      function grandTotal(){
      	var act = document.getElementById('action_get_it').value;

      	var grand_total = 0;
      	var tax = parseInt(document.getElementById('tax_value').value);
        var total_biaya = parseInt(document.getElementById('total_biaya1_value').value);

      	if(act == 'pickup'){
      		var grand_total = total_biaya + tax;
      	}else if(act == 'delivery'){
      		var ongkir = parseInt(document.getElementById('ongkir').value);
      		var grand_total = total_biaya + ongkir + tax;
      	}
        
        document.getElementById('total_biaya').innerHTML = 'Rp. '+ribu(grand_total);
        console.log('total : '+grand_total, 'total_biaya : '+total_biaya, 'ongkir : '+ongkir);

        $('#btn_order_delivery').attr('hidden', false);
      }
      function saatUbah(){
        cekOngkir();
        console.log('oke');
       }
      function addOrder(){
        startTimer(15);
        Swal.fire({
          html:
          '<div class="col-12">'+
          '<center>'+
          '<lottie-player src="<?php echo base_url('asset/JS/Lottie/pencarian_driver.json') ?>"  background="transparent"  speed="1"  loop  autoplay></lottie-player>'+
          '<strong>Mencari driver</strong>'+
          '</center>'+
          '</div>',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          allowOutsideClick: false
        });
        lat = document.getElementById('loc_lat_shop').value;
        lng = document.getElementById('loc_long_shop').value;
        console.log('latlang : '+lat+','+lng);
        getDriver(lat, lng);

     
      }

      function sendPersonalWA(phone, text){
        var message = text.replace(' ','%20');
        var link_wa = 'https://api.whatsapp.com/send?phone='+phone+'&text='+message;
        window.open(link_wa, "_blank");
      }

      function addOrderPickups(){
        Swal.fire({
          title: 'Yakin memesan ?',
          showCloseButton: false,
          showCancelButton: true,
          showConfirmButton: true,
          allowOutsideClick: false
        }).then((result) => {
		  if (result.isConfirmed) {
		  	var json = document.getElementById('json').value;
	        var note = document.getElementById('note_alamat_pickup').value;
	        var id_user = document.getElementById('id_user').value;
		  	$.ajax({
                    url: "<?php echo base_url('food/cekIdShopReady') ?>",
                    success: function(result){
                    	var data2 = JSON.parse(result);
                    	console.log('id shop : '+data2.idshop);
                     	var idshop = data2.idshop;

                     	$.ajax({
		                    url: "https://api.jagoanqr.com/api/pickup",
		                    headers: {
		                                  'Authorization': token_bearer,
		                                  'Accept': 'application/json'
		                              },
		                    type: "post",
		                    data: {'payment_method':1, 'id_shop':idshop, 'id_user':id_user, 'note':note, 'order_detail':json},
		                    success: function(result){
		                      clearCart('send_req');
		                      var data = JSON.stringify(result);
		                      var data2 = JSON.parse(data);
		                      console.log('data : '+data);
		                      Swal.fire({
		                      	title: 'Sukses',
		                      	icon: 'success',
		                      	showConfirmButton: false,
		                      });
		                      console.log('id new : '+data2['pickup'].id);
                              var link = btoa('pickup/'+data2['pickup'].id);
                              setTimeout(function () {
                                sendPersonalWA(no_staff, 'Halo saya memiliki pesanan di resto anda dengan *order number : '+data2.order_number+'* tolong dikonfirmasi ya..');
                                window.location.href = '<?php echo base_url('food/history/') ?>'+link;
                                }, 1200);

		                    },
		                    error: function (xhr, ajaxOptions, thrownError) {
		                      clearInterval(interfal);
		                      var string = JSON.stringify(xhr.responseText);
		                      var msg = JSON.parse(xhr.responseText);
		                      Swal.fire({
		                        html:
		                        '<div class="col-12">'+
		                        '<center>'+
		                        '<strong>Kesalahan sistem</strong><br>'+
		                        '<small>'+msg.message+'</small>'+
		                        '</center>'+
		                        '</div>',
		                        showCloseButton: false,
		                        showCancelButton: false,
		                        showConfirmButton: true
		                      });
		                    }
		                  });
                     }
            });
		  }
		})
      }

    </script>

     <script>
      
      function showPosition(position) {
        displayLocation(position.coords.latitude, position.coords.longitude);
      }

      

      function stopPage(){
        Swal.fire({
          title: "Driver tidak ditemukan di area anda"
        })
      }

        function startTimer(duration) {
        var timer = duration, minutes, seconds;
       interfal = setInterval(function () {
            seconds = parseInt(timer % 60, 10);
            seconds = seconds < 10 ? "0" + seconds : seconds;
            console.log('waktu : '+seconds);

            // display.textContent = seconds;

            if (--timer == 0) {
                clearInterval(interfal);
                stopPage();
            }
        }, 1000);
    }

   

      function pick_driver(){
        var xxx = '['+drivers+']';
        console.log('array driver : '+xxx);
        $.ajax({
                    url: "https://api.jagoanqr.com/api/driverQr/filter",
                    headers: {
                                  'Authorization': token_bearer,
                                  'Accept': 'application/json'
                              },
                    type: "post",
                    data: {"found_drivers":xxx, "id_type":1},
                    success: function(result){
                      console.log('hasi driver : '+result);
                      var data = JSON.stringify(result);
                      console.log('hasi driver 2 : '+data);
                       var data2 = JSON.parse(data);
                      console.log('id shop : '+data2.iddriver);
                      send_req(data2.iddriver);
                      // var idshop = data2.idshop; 

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                      clearInterval(interfal);
                      var string = JSON.stringify(xhr.responseText);
                      var msg = JSON.parse(xhr.responseText);
                      Swal.fire({
                        html:
                        '<div class="col-12">'+
                        '<center>'+
                        '<strong>Pencarian dihentikan</strong><br>'+
                        '<small>'+msg.message+'</small>'+
                        '</center>'+
                        '</div>',
                        showCloseButtno: false,
                        showCancelButton: false,
                        showConfirmButton: true
                      });
                    }
                  });
        
      }
      function hapus_item(x){
      	var y = x;
      	Swal.fire({
		  title: 'Hapus semua item ?',
		  showCloseButton: false,
          showDenyButton: true,
          showCancelButton: true,
          showConfirmButton: false,
		  cancelButtonText: 'Batal',
		  denyButtonText: 'Hapus',
		}).then((result) => {
		  if (result.isDenied) {
		    clearCart(y);
		  }
		})
      }
      function clearCart(x){
        var y = x;
         $.ajax({
            url: "<?php echo base_url('food/clearCart') ?>",
            success: function(result1){
              console.log('clear cart sukses'); 
              if(y=='clear_cart'){
                window.location.href = '<?php echo base_url('food/cart') ?>';
              }          
            }
          });
      }
      function send_req(x){
        var json = document.getElementById('json').value;
        var dest = document.getElementById('lokasi_perangkat').innerHTML;
        var lat = document.getElementById('loc_lat_dest').value;
        var lng = document.getElementById('loc_long_dest').value;
        var note = document.getElementById('note_alamat').value;
        var id_user = document.getElementById('id_user').value;
        var jarak = document.getElementById('jarak_final').value;
        var driver = x;
        console.log('driver send req id_user : '+jarak);
        if(typeof driver !== 'undefined'){
            clearInterval(interfal);
            console.log(json);
            $.ajax({
                    url: "<?php echo base_url('food/cekIdShopReady') ?>",
                    success: function(result){
                       var data2 = JSON.parse(result);
                     console.log('id shop : '+data2.idshop);
                      var idshop = data2.idshop; 
                         $.ajax({
                              url: "https://api.jagoanqr.com/api/food_order",
                              headers: {
                                  'Authorization': token_bearer,
                                  'Accept': 'application/json'
                              },
                              type: "post",
                              data: {'id_driver':driver ,'distance_in_meter':jarak, 'payment_method':1, 'id_shop':idshop, 'dest_name':dest, 'lng_dest':lng, 'lat_dest':lat, 'id_user':id_user, 'note':note, 'order_detail':json},
                              success: function(result2){

                                clearCart('send_req');

                               
                                 var data = JSON.stringify(result2);
                                 var data2 = JSON.parse(data);
                              console.log('return : '+data);
                              console.log('id order :'+data2['food_order_online']['driver'].iddriver);
                              Swal.fire({
                                title: "Driver ditemukan",
                                html:
                                '<div class="container">'+
                                  '<div class="row">'+
                                    '<div class="col-md-12 col-sm-12">'+
                                      '<img style="border-radius: 50%; height: 10em; width: 10em" src="'+data2['food_order_online']['driver'].foto+'" class="img-responsive" alt="templatemo easy profile">'+
                                      '<hr>'+
                                      '<h1 class="tm-title bold shadow">'+data2['food_order_online']['driver'].namadriver+'</h1>'+
                                      '<h1 class="white bold shadow">'+data2['food_order_online']['driver'].nopol+'</h1>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>',
                                closeOnClickOutside: true,
                                showCloseButton: false,
                                showCancelButton: false,
                                showConfirmButton: false
                              });
                              console.log('id new : '+data2.id);
                              var link = btoa('delivery/'+data2.id);
                              setTimeout(function () {
                                   window.location.href = '<?php echo base_url('food/history/') ?>'+link;
                                }, 3000);


                              },
                              error: function (xhr, ajaxOptions, thrownError) {
                                clearInterval(interfal);
                                var string = JSON.stringify(xhr.responseText);
                                var msg = JSON.parse(xhr.responseText);
                                Swal.fire({
                                  html:
                                  '<div class="col-12">'+
                                  '<center>'+
                                  '<strong>Kesalahan</strong><br>'+
                                  '<small>'+msg.message+'</small>'+
                                  '</center>'+
                                  '</div>',
                                  showCloseButton: false,
                                  showCancelButton: false,
                                  showConfirmButton: true
                                });
                              }
                            });

                    }
                  });
        }else{
          console.log('driver tidak tersedia');
        }
        
      
      }

      function getDriver(lat, lng){
        var lat1 = parseFloat(lat);
        var lng1 = parseFloat(lng);
        var database = firebase.database().ref("supir");
        var geoFire = new GeoFire(database);
            console.log(lat + " dan " + lng);
        
        var geoQuery = geoFire.query({
          center: [lat1 , lng1],
          radius: 3
        });

        var driver_pick_random;


        var onReadyRegistration = geoQuery.on("ready", function() {
          console.log("GeoQuery has loaded and fired all other events for initial data");
          pick_driver();
        });

        var onKeyEnteredRegistration = geoQuery.on("key_entered", function(key, location, distance) {
          drivers.push(key);
          console.log(key + " entered query at " + location + " (" + distance + " km from center)");
        });
        
      }
      // Your web app's Firebase configuration
      var firebaseConfig = {
        // apiKey: "AIzaSyCB5UWrBmvdpLMKnHpe3fvfMiBdo9b1K9M",
        apiKey: "AIzaSyD8DbJYs2hg2nKF-Z2UQ-narX7yb2MKt28",
        authDomain: "qrtaxiclub-f0328.firebaseapp.com",
        databaseURL: "https://qrtaxiclub-f0328.firebaseio.com",
        projectId: "qrtaxiclub-f0328",
        storageBucket: "qrtaxiclub-f0328.appspot.com",
        messagingSenderId: "20189394882",
        appId: "1:20189394882:web:eec7744b2c49fa0f89485b",
        measurementId: "G-JGCZT9D3ZK"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      firebase.analytics();
    </script>


   
      


