<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Twig
{
	private $CI;
	private $_twig;
	private $_template_dir;
	private $cache_dir;
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('twig');
	    
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries/Twig');
		
		require_once (string) "Autoloader" . EXT;
		log_message('debug', "Twig Autoloader Loaded");
		
		Twig_Autoloader::register();

		$this->_template_dir = $this->CI->config->item('template_dir');
		
		$this->_cache_dir = $this->CI->config->item('cache_dir');

		$loader = new Twig_Loader_FileSystem($this->_template_dir, $this->_cache_dir);

		$twig_env_options = array(
			'auto_reload' => true,
			'cache' => $this->_cache_dir,
			'debug' => true,
		);
		
		$this->_twig = new Twig_Environment($loader, $twig_env_options);
		
	}

	public function render($template, $data = array()) {
		
		if ($this->CI->uri->rsegment(1) != 'auth') {
		
			$this->CI->dx_auth->check_uri_permissions();
		}
		
		if($this->CI->dx_auth->is_logged_in()) {
			
			$this->CI->config->load('menu');
		
			$data['menu'] = $this->CI->config->item('topmenu');
		
			$data['segments'] = $this->CI->uri->segment_array();
			
			/*$topmenu = "<ul class='nav'>";
			
			foreach($data['menu'] as $i) {
				
				$topmenu .= "<li ";
				
				if($this->CI->uri->segment(2) === FALSE && trim($this->CI->uri->segment(1), "/") == trim($i['cpu'], "/")) $topmenu .= "class='active'";
				
				$topmenu .= "><a href='$i[cpu]' $i[self]>$i[name]</a></li>";
			}
			
			$topmenu .= "</ul>";
			
			$data['topmenu'] = $topmenu;*/
			
			$access = array();
			
			$permission = array();
			
			$this->CI->dx_auth->is_admin() ? $permission['0'] = array() : $permission = $this->CI->dx_auth->get_permissions_value('uri');
			
			if(isset($permission['0'])) {
				
				foreach($permission['0'] as $i) {
				
					$access[] = $i;
				}
			}
			
			$data['access'] = $this->CI->dx_auth->is_admin() ? 'admin' : $access;
			
			//var_dump($access);
			
			$user['id'] = $this->CI->dx_auth->get_user_id();
			
			$user['username'] = $this->CI->dx_auth->get_username();
			
			$user['role_id'] = $this->CI->dx_auth->get_role_id();
			
			$user['role_name'] = $this->CI->dx_auth->get_role_name();
			
			if(!isset($data['user']['name'])) $user['name'] = $this->CI->dx_auth->get_name();
			else $user['name'] = $data['user']['name'];
			
			$data['user'] = $user;
		}
		
		$template = $this->_twig->loadTemplate($template);

		return $template->render($data);
	}
}

?>