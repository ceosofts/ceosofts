<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Force down load
 */
class File extends CRUD_Controller {
	
	private $product_code;
	
	public function __construct()
	{
		parent::__construct();
	}
		
	public function index($file='')
	{
		$this->preview($file);
	}
	
	public function preview($file='')
	{
		$file = ci_decrypt($file);

		if($file){
			$image_type = array('image/bmp' ,'image/png', 'image/pjpeg', 'image/jpeg');

			$mime = get_mime_by_extension($file);
			if(in_array($mime, $image_type)){
				echo '<image src="'.base_url($file).'" />';
			}elseif($mime == 'application/pdf'){
				// Header content type 
				header('Content-type: application/pdf'); 
				header('Content-Disposition: inline; filename="' . $filename . '"'); 
				header('Content-Transfer-Encoding: binary'); 
				header('Accept-Ranges: bytes'); 
				// Read the file 
				@readfile($file); 
			}else{
				// Header content type 
				header('Content-type: '. $mime); 
				header('Content-Disposition: inline; filename="' . $filename . '"'); 
				header('Content-Transfer-Encoding: binary'); 
				header('Accept-Ranges: bytes'); 
				// Read the file 
				@readfile($file); 
			}

		}else{
			echo '<h2>ขออภัย ไม่พบไฟล์</h2>';
		}
	}


}
