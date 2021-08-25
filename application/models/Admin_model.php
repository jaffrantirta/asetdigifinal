<?php
class Admin_model extends CI_Model {
 function __construct(){
 parent::__construct();
 }
 
 
    public function sp_login($username, $password, $action){
        return $this->db->query(' 
            CALL `sp_login`(
            "'.$username.'", 
            "'.$password.'", 
            "'.$action.'");
            ');
    }
    public function update($data, $id_user)
    {
        $this->db->where('id_penumpang', $id_user);
        $this->db->update('penumpang', $data);
    }
    public function sp_pool($idpool, $id_type, $nama, $lat, $lng, $lokasi_pool, $keterangan, $logopool, $kuncipool, $in_st, $radius){
        return $this->db->query(' 
            CALL `sp_pool`(
            "'.$idpool.'", 
            "'.$id_type.'",
            "'.$nama.'",
            "'.$lat.'",
            "'.$lng.'",
            "'.$lokasi_pool.'",
            "'.$keterangan.'",
            "'.$logopool.'",
            "'.$kuncipool.'", 
            "'.$in_st.'", 
            "'.$radius.'");
            ');
    }
    public function checkRememberMeToken($cookie)
    {   
        $where = array (
                'remember_me_token' => $cookie
            );

        $this->db->select('*')->from('users')->where($where);
        $query = $this->db->get();

        if($query->num_rows() == 1) {

            return true;
        }
    }
    public function sp_driver($in_id_driver, $in_id_type, $in_nama_driver, $in_emaildriver, $in_nohpdriver, $in_npwp, $in_foto, $in_pool, $in_tgldaftar, $in_tglaktif, $in_statusaktif, $in_lat, $in_lng, $in_pass, $in_nopol, $in_st, $jumlah_deposit){
        return $this->db->query(' 
            CALL `sp_driver`(
            "'.$in_id_driver.'", 
            "'.$in_id_type.'",
            "'.$in_nama_driver.'",
            "'.$in_emaildriver.'",
            "'.$in_nohpdriver.'",
            "'.$in_npwp.'",
            "'.$in_foto.'",
            "'.$in_pool.'",
            "'.$in_tgldaftar.'", 
            "'.$in_tglaktif.'", 
            "'.$in_statusaktif.'", 
            "'.$in_lat.'", 
            "'.$in_lng.'", 
            "'.$in_pass.'", 
            "'.$in_nopol.'", 
            "'.$in_st.'", 
            "'.$jumlah_deposit.'");
            ');
    }
    public function sp_mitra($id_mitra, $nama_mitra, $lokasi_mitra, $lat_mitra, $lng_mitra, $in_st, $username_mitra, $password_mitra){
        return $this->db->query(' 
            CALL `sp_mitra`(
            "'.$id_mitra.'", 
            "'.$nama_mitra.'",
            "'.$lokasi_mitra.'",
            "'.$lat_mitra.'",
            "'.$lng_mitra.'",
            "'.$in_st.'",
            "'.$username_mitra.'", 
            "'.$password_mitra.'");
            ');
    }
    public function sp_job($in_no_telp_cust, $in_driver, $in_lokasi1, $in_kordinatlokasi1, $in_lokasi2, $in_kordinatlokasi2, $in_jarakjob, $in_ongkosjob, $in_jenisjob, $in_statusjob, $in_idalasan, $in_st, $in_nama_cust, $idjob){
        return $this->db->query(' 
            CALL `sp_job`(
            "'.$in_no_telp_cust.'", 
            "'.$in_driver.'",
            "'.$in_lokasi1.'",
            "'.$in_kordinatlokasi1.'",
            "'.$in_lokasi2.'",
            "'.$in_kordinatlokasi2.'",
            "'.$in_jarakjob.'",
            "'.$in_ongkosjob.'",
            "'.$in_jenisjob.'", 
            "'.$in_statusjob.'", 
            "'.$in_idalasan.'", 
            "'.$in_st.'",  
            "'.$in_nama_cust.'",  
            "'.$idjob.'");
            ');
    }
    public function sp_drivertype($type, $min_km, $max_km, $min_jam, $tarif_tetap, $tarif_diatas_max_km, $nilai_potongan, $in_st, $id_type){
        return $this->db->query(' 
            CALL `sp_drivertype`(
            "'.$type.'", 
            "'.$min_km.'",
            "'.$max_km.'",
            "'.$min_jam.'",
            "'.$tarif_tetap.'",
            "'.$tarif_diatas_max_km.'",
            "'.$nilai_potongan.'",
            "'.$in_st.'",  
            "'.$id_type.'");
            ');
    }
    public function sp_manajemen($username, $password, $type, $idpool, $wilayah, $pic, $nama, $alamat, $telepon, $email, $in_st){
        return $this->db->query(' 
            CALL `sp_manajemen`(
            "'.$username.'", 
            "'.$password.'",
            "'.$type.'",
            "'.$idpool.'",
            "'.$wilayah.'",
            "'.$pic.'",
            "'.$nama.'",
            "'.$alamat.'",  
            "'.$telepon.'",  
            "'.$email.'",  
            "'.$in_st.'");
            ');
    }
    public function sp_specialplace($idplace, $nama_place, $lokasi_place, $lat_place, $lng_place, $tarif_special, $nilai_potongan_special, $in_st, $radius){
        return $this->db->query(' 
            CALL `sp_specialplace`(
            "'.$idplace.'", 
            "'.$nama_place.'",
            "'.$lokasi_place.'",
            "'.$lat_place.'",
            "'.$lng_place.'",
            "'.$tarif_special.'",
            "'.$nilai_potongan_special.'",
            "'.$in_st.'",    
            "'.$radius.'");
            ');
    }
    public function param($var){
        if(count($var,1)<=1){ 
            $r='call '.$var['n'].'()';
        } else {
            $s='';$r='';$i=0;
            $jml=count($var,1)-3;
            foreach ($var['v'] as $v => $a){
                if($i<$jml) {
                    $s=$s.'"'.$a.'",';
                } else {
                    $s=$s.'"'.$a.'"';
                }
                $i++;
            }
            $r='call '.$var['n'].' ('.$s.')';
        }
        return $r;
    }

    public function sp($var){
        $this->db->close();
        $this->db->initialize();
        return $this->db->query($this->param($var)); 
    }

}

