<?php

function genReferralCode($email, $id){
	$string = str_replace('_', '',str_replace('-', '',str_replace('.', '', $email)));
	$sub_email = strtoupper(substr($string, 0, 3));
	$sub_md5_id = strtoupper(substr(base_convert(md5($id), 16,32), 0, 12));
	return $sub_email . $sub_md5_id;
}

?>