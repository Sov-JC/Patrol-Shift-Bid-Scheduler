<?php

class Auth {
	public function auth() {
		$CI =& get_instance();

		if ($CI->router->class == 'user' && $CI->router->method == 'login'
				|| $CI->router->class == 'migrate') {
			return;
		}

		$user_id = $CI->session->userdata('user_id');

		if (!$user_id) {
			redirect('user/login');
		}

		$CI->load->model('user_model');
		$CI->session_user = $CI->user_model->get_user($user_id);

		if ($CI->router->class == 'admin' && !$CI->session_user->is_admin) {
			show_404();
		}
	}
}
