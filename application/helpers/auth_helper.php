<?php

	function logged_in()
	{
		$CI =& get_instance();
		if (!$CI->session->login) {
			redirect('login');
		}
	}

	function logout()
	{
		$CI =& get_instance();
		if ($CI->session->login) {
			redirect('home');
		}
	}


/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */
