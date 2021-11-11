<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//pagination.php

$config['uri_segment'] = 4;
$config['per_page'] = 20;
$config['num_links'] = 5;

/*
// Bootstrap 3
$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
$config['full_tag_close'] = '</ul></nav>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';
$config['cur_tag_open'] ='<li class="page-item active"><span class="page-link"><a>'; 
$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></a></li>';
$config['first_link'] = 'หน้าแรก';
$config['last_link'] = 'หน้าสุดท้าย';
$config['prev_link'] = '&lt;';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';
$config['next_link'] = '&gt;';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';
*/

//Bootstrap 4
$config['full_tag_open']	= '<ul class="pagination">';
$config['full_tag_close']   = '</ul>';
$config['num_tag_open']		= '<li class="page-item">';
$config['num_tag_close']   	= '</li>';
$config['cur_tag_open']   	= '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close']   	= '<span class="sr-only">(current)</span></span></li>';
$config['next_tag_open']   	= '<li class="page-item">';
$config['next_tagl_close']	= '<span aria-hidden="true">&raquo;</span></li>';
$config['prev_tag_open']   	= '<li class="page-item">';
$config['prev_tagl_close']	= '</li>';
$config['first_tag_open']   = '<li class="page-item">';
$config['first_tagl_close'] = '</li>';
$config['last_tag_open']   	= '<li class="page-item">';
$config['last_tagl_close']	= '</li>';

$config['first_link'] = 'หน้าแรก';
$config['last_link'] = 'หน้าสุดท้าย';
?>