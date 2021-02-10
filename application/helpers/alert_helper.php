<?php

function alert($message, $type = 'primary') {
	$CI =& get_instance();
	$CI->load->library('session');

	if (!$CI->session->flashdata('alerts')) {
		$CI->session->set_flashdata('alerts', []);
	}

	$alerts = $CI->session->flashdata('alerts');
	$alerts[] = ['message' => $message, 'type' => $type];
	$CI->session->set_flashdata('alerts', $alerts);
}
