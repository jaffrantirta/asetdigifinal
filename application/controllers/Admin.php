<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Admin_model');
		$this->load->model('api_model');
		$this->load->library('Ssp');
		$this->load->library('mailer');
		$this->load->library('pdf');
		$this->load->library('pdf2');
	}
	public function delete_member($id)
	{
		if($this->session->userdata('authenticated_admin')){
			if($this->api_model->update_data(array('id'=>$id), 'users', array('is_active'=>false))){
				echo "Success delete, <a href='".base_url('admin/members')."'>back</a>";
			}else{
				echo "Failed delete, <a href='".base_url('admin/members')."'>back</a>";
			}
		}else{
			$this->login();
		}
	}
	public function index(){
        if($this->session->userdata('authenticated_admin')){
			$this->dashboard();
		}else{
			$this->login();
		}
	}
	public function dashboard(){
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['page'] = 'Dashboard';
			$data['session'] = $this->session->all_userdata();
			// echo json_encode($data);
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/dashboard', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	
	public function login(){
		$data['sistem_name'] = $this->api_model->sistem_name();
		$this->load->view('Admin/login', $data);
	}
	public function show_session(){
		$session = $this->session->all_userdata();
    	echo json_encode($session);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin');
    }
	public function register()
	{
		$data['sistem_name'] = $this->api_model->sistem_name();
		$this->load->view('Admin/register');
	}
	public function request()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$action = $this->input->get('action');
			$data['session'] = $this->session->all_userdata();
			switch($action){
				case "pin":
					$data['page'] = 'Request PIN Register';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/balance_pin_register', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "withdraw":
					$data['page'] = 'Request Withdraw';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/withdraw', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "lisensi":
					$data['page'] = 'Request Lisensi';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/balance_lisensi', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "upgrade":
					$data['page'] = 'up Lisensi';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/upgrade_licence', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail($order_id);
					break;
				case "detail_withdraw":
					$data['page'] = 'Withdraw';
					$data['id_order']= $this->input->get('id');
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/detail_withdraw', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "order_detail_lisensi":
					$order_id = $this->input->get('id');
					$this->get_order_detail_lisensi($order_id);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function members()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$action = $this->input->get('action');
			$data['session'] = $this->session->all_userdata();
			if(isset($action)){
				switch($action){
					case "detail":
						$id = $this->input->get('id');
						$data['member'] = $this->api_model->get_data_by_where('users', array('id'=>$id))->result()[0];
						$data['page'] = 'Detail Member';
						$this->load->view('Admin/Template/header', $data);
						$this->load->view('Admin/detail_member', $data);
						$this->load->view('Admin/Template/footer', $data);
						break;
					default :
						echo "404";
						break;
				}
			}else{
				$data['page'] = 'Members';
				$data['members_count'] = count($this->api_model->get_data_by_where('users', array('role'=>'customer'))->result()); 
				$this->load->view('Admin/Template/header', $data);
				$this->load->view('Admin/members', $data);
				$this->load->view('Admin/Template/footer', $data);
				// echo json_encode($data);
			}
			
		}
	}
	public function settings()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$action = $this->input->get('action');
			switch($action){
				case "company-profile":
					$this->company_profile();
					break;
				case "pin-register":
					$this->pin_register_settings();
					break;
				case "licences":
					$this->licences();
					break;
				case "instruction":
					$this->instruction();
					break;
				case "banner":
					$this->banner();
					break;
				case "reward":
					$this->reward();
					break;
				case "minwidtraw":
					$this->minwid();
					break;
				default :
					echo "404";
			}
		}
	}
	public function minwid(){
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Minimum Widthdraw';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/minimum_widthdraw', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function delete_reward($id)
	{
		if($this->db->query("DELETE FROM `rewards` WHERE `rewards`.`id` = $id")){
			echo "deleted";
		}else{
			echo "failed";
		}
	}
	public function add_reward_process()
	{
		if (!$this->session->userdata('authenticated_admin')) {
			$this->login();
		} else {
			$input = array(
				'name'=>$this->input->post('name'),
				'left'=>$this->input->post('left'),
				'right'=>$this->input->post('right'),
				'achievement'=>'-',
				'bonus'=>$this->input->post('bonus')
			);
			if($this->api_model->insert_data('rewards', $input)){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}
	public function add_reward()
	{
		if (!$this->session->userdata('authenticated_admin')) {
			$this->login();
		} else {
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'add reward';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/add_reward', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function banner()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Banner';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/list_banner', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function addbanner()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Banner';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/banner', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function detailbanner($id)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['banner'] = $this->api_model->get_data_by_where('banners', array('id'=>$id))->result();
			if(count($data['banner'])){
				$data['sistem_name'] = $this->api_model->sistem_name();
				$data['session'] = $this->session->all_userdata();
				$data['page'] = 'Reward';
				$this->load->view('Admin/Template/header', $data);
				$this->load->view('Admin/detail_banner', $data);
				$this->load->view('Admin/Template/footer', $data);
			}else{
				echo "detail not found";
			}
		}
	}
	public function video_tutorial()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Video Tutorial';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/video_tutorial', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function reward()
	{
		if (!$this->session->userdata('authenticated_admin')) {
			$this->login();
		} else {
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Reward';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/reward', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function vdasboard()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Vidio dashboard';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/vidio_dashboard', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function icon()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Icon';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/icon_wa', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function licences()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Licences';
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/lisensies', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}	
	public function licence_detail($hash)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$id = base64_decode($hash);
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Licences';
			$data['licence'] = $this->api_model->get_data_by_where('lisensies', array('id'=>$id))->result()[0];
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/licences_detail', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function pin_register_settings()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'PIN Register Settings';
			$setting = json_decode($this->api_model->get_data_by_where('settings', array('key'=>'pin_register_price'))->result()[0]->content);
			$data['price'] = $setting->price;
			$data['currency'] = $setting->currency;
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/pin_register_settings', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function instruction()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Change Instraction Payment';
			$data['instruction'] = $this->api_model->get_data_by_where('settings', array('key'=>'payment_tutorial'))->result()[0]->content;
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/instruction', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function company_profile()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Company Profile';
			$data['sistem_name'] = $this->api_model->get_data_by_where('settings', array('key'=>'sistem_name'))->result()[0]->content;
			$data['phone_number'] = $this->api_model->get_data_by_where('settings', array('key'=>'phone_number'))->result()[0]->content;
			$data['email'] = $this->api_model->get_data_by_where('settings', array('key'=>'email'))->result()[0]->content;
			$data['logo'] = $this->api_model->get_data_by_where('settings', array('key'=>'logo'))->result()[0]->content;
			$data['address'] = $this->api_model->get_data_by_where('settings', array('key'=>'address'))->result()[0]->content;
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/company_profile', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	public function get_order_detail($order_id)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Request PIN Register';
			$data['order'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM orders a INNER JOIN users b ON b.id = a.requested_by WHERE a.id = $order_id")->result()[0];
			$data['pin']['data'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM pin_register a INNER JOIN users b ON b.id = a.registered_by WHERE a.order_id = $order_id")->result();
			if(count($data['pin']['data']) != 0){
				$data['pin']['status'] = true;
			}else{
				$data['pin']['status'] = false;
			}
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/order_detail', $data);
			$this->load->view('Admin/Template/footer', $data);
			// echo json_encode($data);
			
		}
	}
	public function get_order_detail_lisensi($order_id)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Request Lisensi';
			$data['order'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM orders a INNER JOIN users b ON b.id = a.requested_by WHERE a.id = $order_id")->result()[0];
			$data['lisensi']['data'] = $this->db->query("SELECT a.*, b.name as lisensi_name, b.id as lisensi_id, b.price as lisensi_price, b.is_active as lisensi_is_active, u.id as userid, u.name as username FROM orders a INNER JOIN user_lisensies l ON l.order_id = a.id INNER JOIN lisensies b ON b.id = l.lisensi_id INNER JOIN users u ON u.id = a.requested_by WHERE a.id = $order_id")->result();
			if(count($data['lisensi']['data']) != 0){
				$data['lisensi']['status'] = true;
			}else{
				$data['lisensi']['status'] = false;
			}
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/order_detail_lisensi', $data);
			$this->load->view('Admin/Template/footer', $data);
			// echo json_encode($data);
			
		}
	}
	public function upgrade()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$action = $this->input->get('action');
			$id_order = $this->input->get('id');
			$data['sistem_name'] = $this->api_model->sistem_name();
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Detail Upgrade Licence';
			switch($action){
				case "licence":
					$data['order'] = $this->db->query("SELECT a.* , b.name AS user_name, c.name AS current_lisensi_name, d.name AS upgrade_lisensi_name
					FROM lisensi_upgrades a 
					LEFT JOIN users b ON b.id=a.request_by
					LEFT JOIN lisensies c ON c.id=a.current_lisensi
					LEFT JOIN lisensies d ON d.id=a.upgrade_to WHERE a.id = $id_order")->result()[0];
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/upgrade_licence_detail', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
			}
		}
	}
	public function export(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('My Notes Code')
					 ->setLastModifiedBy('My Notes Code')
					 ->setTitle("Data Member")
					 ->setSubject("Member")
					 ->setDescription("Laporan Semua Data Member")
					 ->setKeywords("Data Member");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
		  'font' => array('bold' => true), // Set font nya jadi bold
		  'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		  'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MEMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "EMAIL"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "REGISTER DATE"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "USDT WALLET"); // Set kolom E3 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$member = $this->api_model->get_customer();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($member as $data){ // Lakukan looping pada variabel siswa
		  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
		  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->name);
		  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->email);
		  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->register_date);
		  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->usdt_wallet);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Data Member");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Member.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	  }
	  public function export_member()
	  {
		// $spreadsheet = new Spreadsheet();
		// $sheet = $spreadsheet->getActiveSheet();

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Data Pegawai.xlsx");
		$print = $this->api_model->get_data_by_where('members', array('id>='=>'0'))->result();
		$i=1;
		foreach($print as $data){ 
			$content = '
			<tr>
				<th>'.$i++.'</th>
				<th>'.$data->name.'</th>
				<th>'.$data->code.'</th>
				<th>'.$data->sponsor_bonus.'</th>
				<th>'.$data->total_omset.'</th>
				<th>'.$data->total_omset.'</th>
				<th>'.$data->lisensi_name.'</th>
			</tr>
			';
		}
		$view = '
		<center>
			<h1>Export Data Ke Excel Dengan PHP <br/> www.malasngoding.com</h1>
		</center>
		<table border="1">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Sponsor Code</th>
				<th>Sponsor Code Bonus</th>
				<th>Total Omset</th>
				<th>Total Pairing Bonus</th>
				<th>Licence</th>
			</tr>
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Sponsor Code</th>
				<th>Sponsor Code Bonus</th>
				<th>Total Omset</th>
				<th>Total Pairing Bonus</th>
				<th>Licence</th>
			</tr>
		</table>
		';

		// $sheet->setCellValue('A1', 'Name');
		// $sheet->setCellValue('A3', 'Register Date');
		// $sheet->setCellValue('B3', 'Sponsor Code');
		// $sheet->setCellValue('C3', 'Sponsor Code Bonus');
		// $sheet->setCellValue('D3', 'Total Omset');
		// $sheet->setCellValue('E3', 'Total Pairing Bonus');
		// $sheet->setCellValue('F3', 'Licence');

		// foreach($print as $data){ 
		// 	$col = $i+4;
		// 	$sheet->setCellValue('A'.$col, $data->kodepool);
		// 	$sheet->setCellValue('B'.$col, $data->type);
		// 	$sheet->setCellValue('C'.$col, $data->nama);
		// 	$sheet->setCellValue('D'.$col, $data->lokasi_pool);
		// 	$sheet->setCellValue('E'.$col, $data->keterangan);
		// 	$sheet->setCellValue('F'.$col, $data->lat);
		// }
		
		// $writer = new Xlsx($spreadsheet);
		$filename = 'list-members-'.date('d-M-y');

		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		// header('Cache-Control: max-age=0');

		
		
		// $writer->save('php://output');
	  }
}
