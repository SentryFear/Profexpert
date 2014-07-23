<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Управление пользователями
 *
 * Class Users
 */
class Users extends CI_Controller
{
    /**
     * Инициализация
     */
    function __construct()
	{
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('DX_Auth');
		
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->helper('users');
	}

    /**
     * Стартовая страница
     */
    function index()
	{
		$this->users();
	}

    /**
     * Список пользователей
     */
    function users()
	{
		$this->load->model('dx_auth/users_model', 'users_model');
		
		$this->load->model('dx_auth/roles', 'roles');
		
		if ($this->input->post('add'))
		{
			// Create user
			$data = array(
				      'username' => $this->input->post('user'),
				      'password' => crypt($this->dx_auth->_encode($this->input->post('pass'))),
				      'name' => $this->input->post('name'),
				      'email' => $this->input->post('email'),
				      'role_id' => $this->input->post('role'),
				      );
			
			$this->users_model->create_user($data) ? $data['success'] = "Пользователь успешно добавлен!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
		}
		
		// Search checkbox in post array
		foreach ($_POST as $key => $value)
		{
			// If checkbox found
			if (substr($key, 0, 9) == 'checkbox_')
			{
				// If ban button pressed
				if (isset($_POST['ban']))
				{
					// Ban user based on checkbox value (id)
					$this->users_model->ban_user($value);
				}
				// If unban button pressed
				else if (isset($_POST['unban']))
				{
					// Unban user
					$this->users_model->unban_user($value);
				}
				else if (isset($_POST['reset_pass']))
				{
					// Set default message
					$data['reset_message'] = 'Reset password failed';
				
					// Get user and check if User ID exist
					if ($query = $this->users_model->get_user_by_id($value) AND $query->num_rows() == 1)
					{		
						// Get user record				
						$user = $query->row();
						
						// Create new key, password and send email to user
						if ($this->dx_auth->forgot_password($user->username))
						{
							// Query once again, because the database is updated after calling forgot_password.
							$query = $this->users_model->get_user_by_id($value);
							// Get user record
							$user = $query->row();
							
							// Reset the password
							if ($this->dx_auth->reset_password($user->username, $user->newpass_key))
							{							
								$data['reset_message'] = 'Reset password success';
							}
						}
					}
				}
				else if (isset($_POST['delete']))
				{
					$this->users_model->delete_user($value);
				}
			}
		}
		
		/* Showing page to user */
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 100;
		
		// Get all users
		$data['users'] = $this->users_model->get_all($offset, $row_count)->result_array();

        $data['stats'] = array('active' => 0, 'noactive' => 0);

        foreach($data['users'] as $k => $i) {

            $data['users'][$k]['last_login'] = users_time($i['last_login']);

            if($i['banned'] == 0) $data['stats']['active']++;
            else $data['stats']['noactive']++;
        }

		// Pagination config
		$p_config['base_url'] = '/users/';
		$p_config['uri_segment'] = 3;
		$p_config['num_links'] = 2;
		$p_config['total_rows'] = $this->users_model->get_all()->num_rows();
		$p_config['per_page'] = $row_count;
		
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links();
		
		$data['roles'] = $this->roles->get_all()->result();
		
		// Load view
		//$this->load->view('backend/users', $data);
		echo $this->twig->render('users/main.html', $data);
	}

    /**
     * Список не активированных пользователей
     */
    function unactivated_users()
	{
		$this->load->model('dx_auth/user_temp', 'user_temp');
		
		/* Database related */
		
		// If activate button pressed
		if ($this->input->post('activate'))
		{
			// Search checkbox in post array
			foreach ($_POST as $key => $value)
			{
				// If checkbox found
				if (substr($key, 0, 9) == 'checkbox_')
				{
					// Check if user exist, $value is username
					if ($query = $this->user_temp->get_login($value) AND $query->num_rows() == 1)
					{
						// Activate user
						$this->dx_auth->activate($value, $query->row()->activation_key);
					}
				}				
			}
		}
		
		/* Showing page to user */
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 10;
		
		// Get all unactivated users
		$data['users'] = $this->user_temp->get_all($offset, $row_count)->result();
		
		// Pagination config
		$p_config['base_url'] = '/backend/unactivated_users/';
		$p_config['uri_segment'] = 3;
		$p_config['num_links'] = 2;
		$p_config['total_rows'] = $this->user_temp->get_all()->num_rows();
		$p_config['per_page'] = $row_count;
		
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links();
		
		// Load view
		$this->load->view('backend/unactivated_users', $data);
	}

    /**
     * Список отделов
     */
    function roles()
	{
        $this->load->model('dx_auth/users_model', 'users_model');

		$this->load->model('dx_auth/roles', 'roles');
		
		/* Database related */
		
		// If Add role button pressed
		if ($this->input->post('add'))
		{
			// Create role
			$this->roles->create_role($this->input->post('role_name'), $this->input->post('role_parent'));
		}
		else if ($this->input->post('delete'))
		{				
			// Loop trough $_POST array and delete checked checkbox
			foreach ($_POST as $key => $value)
			{
				// If checkbox found
				if (substr($key, 0, 9) == 'checkbox_')
				{
					// Delete role
					$this->roles->delete_role($value);
				}				
			}
		}
		
		/* Showing page to user */
		
		// Get all roles from database
		$data['roles'] = $this->roles->get_all()->result_array();

        $data['users'] = $this->users_model->get_all()->result_array();

        $roles = array();

        $pn = array();

        foreach($data['roles'] as $i) {

            $i['users'] = 0;

            $i['parent_name'] = 0;

            $pn = $this->roles->get_role_by_id($i['parent_id'])->row_array();

            if(!empty($pn)) $i['parent_name'] = $pn['name'];

            foreach($data['users'] as $q) {

                if($i['id'] == $q['role_id'] && $q['banned'] != 1) $i['users']++;
            }

            $roles[] = $i;
        }

        $data['roles'] = $roles;

		echo $this->twig->render('users/roles.html', $data);
		
		// Load view
		//$this->load->view('backend/roles', $data);
	}

    /**
     * Доступы по uri
     */
    function permissions()
	{
		function trim_value(&$value) 
		{ 
			$value = trim($value); 
		}
	
		$this->load->model('dx_auth/roles', 'roles');

		$this->load->model('dx_auth/permissions', 'permissions');
		
		if ($this->input->post('save'))
		{
			// Convert back text area into array to be stored in permission data
			$allowed_uris = explode("\n", $this->input->post('allowed_uris'));
			
			// Remove white space if available
			array_walk($allowed_uris, 'trim_value');
		
			// Set URI permission data
			// IMPORTANT: uri permission data, is saved using 'uri' as key.
			// So this key name is preserved, if you want to use custom permission use other key.
			$this->permissions->set_permission_value($this->input->post('role'), 'uri', $allowed_uris);

            $permission_data = $this->permissions->get_permission_data($this->input->post('role'));

            // Set value in permission data array
            $permission_data['add'] = $this->input->post('add');
            $permission_data['edit'] = $this->input->post('edit');
            $permission_data['delete'] = $this->input->post('delete');
            $permission_data['print'] = $this->input->post('print');
            $permission_data['request'] = $this->input->post('request');

            // Set permission data for role_id
            $this->permissions->set_permission_data($this->input->post('role'), $permission_data);
		}
		
		/* Showing page to user */		
		
		// Default role_id that will be showed
		$role_id = $this->input->post('role');
		
		if(empty($role_id)) $role_id = $this->uri->segment('3') ? $this->uri->segment('3') : 1;

		$data['trole'] = $role_id;
		// Get all role from database
		$data['roles'] = $this->roles->get_all()->result();
		// Get allowed uri permissions
		$data['allowed_uris'] = $this->permissions->get_permission_value($role_id, 'uri');

        $data['roles'] = $this->roles->get_all()->result();

        $data['trole'] = $role_id;
        // Get edit and delete permissions
        $data['add'] = $this->permissions->get_permission_value($role_id, 'add');
        $data['edit'] = $this->permissions->get_permission_value($role_id, 'edit');
        $data['delete'] = $this->permissions->get_permission_value($role_id, 'delete');
        $data['print'] = $this->permissions->get_permission_value($role_id, 'print');
        $data['request'] = $this->permissions->get_permission_value($role_id, 'request');

		// Load view
		echo $this->twig->render('users/permissions.html', $data);
		//$this->load->view('backend/uri_permissions', $data);
	}

    /**
     * Пользовательские разрешения
     */
    function custom_permissions()
	{
		// Load models
		$this->load->model('dx_auth/roles', 'roles');
		$this->load->model('dx_auth/permissions', 'permissions');
	
		/* Get post input and apply it to database */
		
		// If button save pressed
		if ($this->input->post('save'))
		{
			// Note: Since in this case we want to insert two key with each value at once,
			// it's not advisable using set_permission_value() function						
			// If you calling that function twice that means, you will query database 4 times,
			// because set_permission_value() will access table 2 times, 
			// one for get previous permission and the other one is to save it.
			
			// For this case (or you need to insert few key with each value at once) 
			// Use the example below
		
			// Get role_id permission data first. 
			// So the previously set permission array key won't be overwritten with new array with key $key only, 
			// when calling set_permission_data later.
			$permission_data = $this->permissions->get_permission_data($this->input->post('role'));
		
			// Set value in permission data array
			$permission_data['add'] = $this->input->post('add');
			$permission_data['edit'] = $this->input->post('edit');
			$permission_data['delete'] = $this->input->post('delete');
			$permission_data['print'] = $this->input->post('print');
			$permission_data['request'] = $this->input->post('request');
			
			// Set permission data for role_id
			$this->permissions->set_permission_data($this->input->post('role'), $permission_data);
		}
	
		/* Showing page to user */		
		
		// Default role_id that will be showed
		$role_id = $this->input->post('role');

        if(empty($role_id)) $role_id = $this->uri->segment('3') ? $this->uri->segment('3') : 1;

		// Get all role from database
		$data['roles'] = $this->roles->get_all()->result();

        $data['trole'] = $role_id;
		// Get edit and delete permissions
		$data['add'] = $this->permissions->get_permission_value($role_id, 'add');
		$data['edit'] = $this->permissions->get_permission_value($role_id, 'edit');
		$data['delete'] = $this->permissions->get_permission_value($role_id, 'delete');
		$data['print'] = $this->permissions->get_permission_value($role_id, 'print');
		$data['request'] = $this->permissions->get_permission_value($role_id, 'request');

		// Load view
        echo $this->twig->render('users/custom_permissions.html', $data);
		//$this->load->view('backend/custom_permissions', $data);
	}

    function profile() {

        $id = intval($this->uri->segment(3));

        $this->load->model('dx_auth/users_model', 'users_model');

        $this->load->model('dx_auth/roles', 'roles');

        if(!empty($id)) {

            $data = array();

            $data['result'] = $this->users_model->get_user_by_id($id)->row_array();

            if(!empty($data['result'])) {

                if($this->input->post('save')) {

                    $save = array(
                        'name' => $this->input->post('name'),
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email'),
                        'role_id' => $this->input->post('role_id'),
                    );

                    $config['upload_path'] = './uploads/img/sign/';
                    //$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|txt|jpg|gif|jpeg';
                    $config['max_size']	= '10000';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);

                    if($this->upload->do_upload('signature')) {

                        $signature = $this->upload->data();

                        $save['signature'] = $signature['file_name'];
                    }

                    if($this->db->update('users', $save, array('id' => $id))) $data['success'] = "Профиль изменён!";
                    else $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
                }

                $data['result'] = $this->users_model->get_user_by_id($id)->row_array();

                $data['roles'] = $this->roles->get_all()->result();

                echo $this->twig->render('users/profile.html', $data);

            } else redirect("/users/");

        } else redirect("/users/");


    }
}
?>