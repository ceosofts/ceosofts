<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH."third_party/tcpdf/tcpdf.php";
require_once APPPATH."third_party/fpdi/fpdi.php";

class Product_sale_list_pdf extends FPDI{
 
    public function __construct(){
        parent::__construct();
    }
}