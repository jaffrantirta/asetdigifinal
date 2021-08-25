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
                            <i title="edit" class="fa fa-edit"></i>
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
}

