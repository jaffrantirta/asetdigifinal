<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Datatable extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('api_model');
		$this->load->library('Ssp');
		$this->load->library('mailer');
		$this->load->library('pdf');
		$this->load->library('pdf2');
        $this->load->library('email_template');
        $this->load->helper('string');
	}
    public function index()
    {
        echo '404 - Not Found';
    }
    public function get_order_pin_register($id)
    {
        $columns = array(
            array(
                'db' => 'order_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'amount',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'total_payment',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'currency',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'id',  'dt' => 5,
                'formatter' => function($d, $row){
                    $link = base_url('customer/pin?action=order_detail&id='.$d);
                    return '
                    <center>
                        <a href="'.$link.'">
                            <i title="detail" class="fa fa-edit"></i>
                        </a>
                    </center>
                    ';
                }
            ),
          );
          $ssptable='orders';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='orders.order_number LIKE "%PR%" AND orders.requested_by = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_order_lisensi_register($id)
    {
        $columns = array(
            array(
                'db' => 'order_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'amount',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'total_payment',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'currency',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'id',  'dt' => 5,
                'formatter' => function($d, $row){
                    $link = base_url('customer/lisensi?action=order_detail&id='.$d);
                    return '
                    <center>
                        <a href="'.$link.'">
                            <i title="detail" class="fa fa-edit"></i>
                        </a>
                    </center>
                    ';
                }
            ),
          );
          $ssptable='orders';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='orders.order_number LIKE "L%" AND orders.requested_by = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_all_order_pin_register()
    {
        $columns = array(
            array(
                'db' => 'order_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'amount',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'total_payment',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'currency',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'is_reject',  'dt' => 5,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'is_finish',  'dt' => 6,
                'formatter' => function($d, $row){
                    if($d){
                        $y = '<p style="color:green">FINISH</p>';
                    }else if($row[5]){
                        $y = '<p style="color:red">REJECTED</p>';
                    }else{
                        $y = '<p style="color:yellow">PENDING</p>';
                    }
                    return $y;
                }
            ),
            array(
                'db' => 'id',  'dt' => 7,
                'formatter' => function($d, $row){
                    $link = base_url('admin/request?action=order_detail&id='.$d);
                    return '
                    <center>
                        <a href="'.$link.'">
                            <i title="detail" class="fa fa-edit"></i>
                        </a>
                    </center>
                    ';
                }
            ),
          );
          $ssptable='orders';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='orders.order_number LIKE "%PR%"';
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_all_order_lisensi()
    {
        $columns = array(
            array(
                'db' => 'order_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'amount',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'total_payment',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'currency',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'is_reject',  'dt' => 5,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'is_finish',  'dt' => 6,
                'formatter' => function($d, $row){
                    if($d){
                        $y = '<p style="color:green">FINISH</p>';
                    }else if($row[5]){
                        $y = '<p style="color:red">REJECTED</p>';
                    }else{
                        $y = '<p style="color:yellow">PENDING</p>';
                    }
                    return $y;
                }
            ),
            array(
                'db' => 'id',  'dt' => 7,
                'formatter' => function($d, $row){
                    $link = base_url('admin/request?action=order_detail_lisensi&id='.$d);
                    return '
                    <center>
                        <a href="'.$link.'">
                            <i title="detail" class="fa fa-edit"></i>
                        </a>
                    </center>
                    ';
                }
            ),
          );
          $ssptable='orders';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='orders.order_number LIKE "%L%"';
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_pin($id)
    {
        $columns = array(
            array(
                'db' => 'pin',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'registered_date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'user_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = 'UNUSED';
                    }else{
                        $result = $d;

                    }
                    return $result;
                }
            ),
            array(
                'db' => 'is_active',  'dt' => 3,
                'formatter' => function($d, $row){
                    if($d){
                        $result = '<strong style="color:green">ACTIVE</strong>';
                    }else{
                        $result = '<strong style="color:red">NOT ACTIVE</strong>';
                    }
                    return $result;
                }
            )
          );
          $ssptable='pin_register_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='registered_by = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_lisensi($id)
    {
        $columns = array(
            array(
                'db' => 'lisensi_name',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'is_active',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == 0){
                        $result = 'NOT ACTIVE';
                    }else{
                        $result = 'ACTIVE';

                    }
                    return $result;
                }
            )
          );
          $ssptable='user_lisensies_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='owner = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_all_lisensi()
    {
        $columns = array(
            array(
                'db' => 'name',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'price',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return number_format($d);
                }
            ),
            array(
                'db' => 'percentage',  'dt' => 2,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return $d;
                }
            ),
            array(
                'db' => 'id',  'dt' => 3,
                'formatter' => function($d, $row){
                    $link = base_url('admin/licence_detail/'.base64_encode($d));
                    return '
                    <center>
                        <a href="'.$link.'">
                            <i title="detail" class="fa fa-edit"></i>
                        </a>
                    </center>
                    ';
                }
            ),
          );
          $ssptable='lisensies';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='id>=0';
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_all_members()
    {
        $columns = array(
            array(
                'db' => 'name',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'register_date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'code',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'balance',  'dt' => 3,
                'formatter' => function($d, $row){
                    $currency = $this->api_model->get_data_by_where('settings', array('key'=>'lisensi_currency'))->result()[0]->content;
                    if($d!=null){
                        $y = $d;
                    }else{
                        $y = 0;
                    }
                    $admin = base64_encode('admin');
                    $hash = base64_encode($row[7].'/'.$row[2]);
                    $route = "bonus/sponsor_code/$admin?token=$hash";
                    $url = base_url($route);
                    return '<a href="'.$url.'">'.$y.' '.$currency.'</a>';
                }
            ),
            array(
                'db' => 'left_belance',  'dt' => 4,
                'formatter' => function($d, $row){
                    $turnover_percentage = $this->api_model->get_data_by_where('settings', array('key'=>'turnover_percentage'))->result()[0]->content;
                    $currency = $this->api_model->get_data_by_where('settings', array('key'=>'lisensi_currency'))->result()[0]->content;
                    if($d!=null){
                        $y = ($d / 100) * $turnover_percentage;
                        $x = $d;
                    }else{
                        $y = 0;
                        $x = 0;
                    }
                    $admin = base64_encode('admin');
                    $id_and_position = base64_encode($row[7].'/1');
                    $hash = base64_encode($id_and_position.'////LEFT');
                    $route = "bonus/turnover/$admin?token=$hash";
                    $url = base_url($route);
                    return '<a href="'.$url.'">'.$y.' '.$currency.' ('.$x.' '.$currency.')</a>';
                }
            ),
            array(
                'db' => 'right_belance',  'dt' => 5,
                'formatter' => function($d, $row){
                    $turnover_percentage = $this->api_model->get_data_by_where('settings', array('key'=>'turnover_percentage'))->result()[0]->content;
                    $currency = $this->api_model->get_data_by_where('settings', array('key'=>'lisensi_currency'))->result()[0]->content;
                    if($d!=null){
                        $y = ($d / 100) * $turnover_percentage;
                        $x = $d;
                    }else{
                        $y = 0;
                        $x = 0;
                    }
                    $admin = base64_encode('admin');
                    $id_and_position = base64_encode($row[7].'/2');
                    $hash = base64_encode($id_and_position.'////RIGHT');
                    $route = "bonus/turnover/$admin?token=$hash";
                    $url = base_url($route);
                    return '<a href="'.$url.'">'.$y.' '.$currency.' ('.$x.' '.$currency.')</a>';
                }
            ),
            array(
                'db' => 'lisensi_name',  'dt' => 6,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = '<a style="color: red">not have licence</a>';
                    }else{
                        $result = '<a style="color: green">'.$d.'</a>';

                    }
                    return $result;
                }
            ),
            array(
                'db' => 'id',  'dt' => 7,
                'formatter' => function($d, $row){
                    return $d;
                }
            )
          );
          $ssptable='customer_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='role = "customer"';
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_bonus_sponsor_code($id)
    {
        $columns = array(
            array(
                'db' => 'user_name',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'lisensi_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'belance',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'percentage_at_the_time',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'id',  'dt' => 5,
                'formatter' => function($d, $row){
                    $y = ($row[3] / 100) * $row[4];
                    return $y;
                }
            ),
          );
          $ssptable='sponsor_code_bonus_details_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='sponsor_code_bonus_id ='.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_bonus_turnover($hash)
    {
        $split = explode("/", base64_decode($hash));
        $id = $split[0];
        $position = $split[1];
        $columns = array(
            array(
                'db' => 'register_name',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'position',  'dt' => 2,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'lisensi_name',  'dt' => 3,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'price_at_the_time',  'dt' => 4,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'id',  'dt' => 5,
                'formatter' => function($d, $row){
                    $percentage = $this->api_model->get_data_by_where('settings', array('key'=>'turnover_percentage'))->result()[0]->content;
                    return $percentage;
                }
            ),
            array(
                'db' => 'id',  'dt' => 6,
                'formatter' => function($d, $row){
                    $percentage = $this->api_model->get_data_by_where('settings', array('key'=>'turnover_percentage'))->result()[0]->content;
                    $y = $row[4] / 100 * $percentage;
                    return $y;
                }
            ),
          );
          $ssptable='turnover_details_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='position = '.$position.' AND owner_id ='.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_transfer_history($id)
    {
        $columns = array(
            array(
                'db' => 'transfer_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'receiver_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = 'UNUSED';
                    }else{
                        $result = $d;

                    }
                    return $result;
                }
            )
          );
          $ssptable='transfer_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='transfer_number LIKE "LT%" AND send_by = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_receive_history($id)
    {
        $columns = array(
            array(
                'db' => 'transfer_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'sender_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = 'UNUSED';
                    }else{
                        $result = $d;

                    }
                    return $result;
                }
            )
          );
          $ssptable='transfer_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='transfer_number LIKE "LT%" AND receive_by = '.$id ;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_transfer_pin_history($id)
    {
        $columns = array(
            array(
                'db' => 'transfer_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'receiver_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = 'UNUSED';
                    }else{
                        $result = $d;

                    }
                    return $result;
                }
            )
          );
          $ssptable='transfer_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='transfer_number LIKE "PT%" AND send_by = '.$id;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
    public function get_receive_pin_history($id)
    {
        $columns = array(
            array(
                'db' => 'transfer_number',  'dt' => 0,
                'formatter' => function($d, $row){
                    return $d;
                }
            ),
            array(
                'db' => 'date',  'dt' => 1,
                'formatter' => function($d, $row){
                    $date = date_create($d);
                    return date_format($date,"l, d M Y H:m:s");
                }
            ),
            array(
                'db' => 'sender_name',  'dt' => 2,
                'formatter' => function($d, $row){
                    if($d == null){
                        $result = 'UNUSED';
                    }else{
                        $result = $d;

                    }
                    return $result;
                }
            )
          );
          $ssptable='transfer_complate_data';
          $sspprimary='id';
          $sspjoin='';
          $sspwhere='transfer_number LIKE "PT%" AND receive_by = '.$id ;
          $go=SSP::simpleCustom($_GET,$this->datatable_config(),$ssptable,$sspprimary,$columns,$sspwhere,$sspjoin);
          echo json_encode($go);
    }
}

