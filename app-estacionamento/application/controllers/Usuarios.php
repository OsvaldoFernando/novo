<?php
defined('BASEPATH') OR exit('Acesso proibido');

class Usuarios extends CI_Controller
{
	public function index()
	{
		$data = array(
			'titulo' => 'Usuários cadastrados',
			'usuarios' => $this->ion_auth->users()->result(),

			'styles' => array(
				'assets/bundles/datatables/datatables.min.css',
				'assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
			),

			'scripts' => array(
				'assets/bundles/datatables/datatables.min.js',
				'assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
				'assets/bundles/jquery-ui/jquery-ui.min.js',
				'assets/js/page/datatables.js',

			),

//			Array
//			(
//				[0] => stdClass Object
//			(
//			 [id] => 1
//           [ip_address] => 127.0.0.1
//           [username] => administrator
//			 [password] => $2y$08$200Z6ZZbp3RAEXoaWcMA6uJOFicwNZaqk4oDhqTUiFXFe63MG.Daa
//			 [email] => admin@admin.com
//			   [activation_selector] =>
//            [activation_code] =>
//            [forgotten_password_selector] =>
//            [forgotten_password_code] =>
//            [forgotten_password_time] =>
//            [remember_selector] =>
//            [remember_code] =>
//            [created_on] => 1268889823
//            [last_login] => 1268889823
//            [active] => 1
//            [first_name] => Admin
//			[last_name] => istrator
//			[company] => ADMIN
//			[phone] => 0
//            [user_id] => 1
//        )
//
//)

		);

//		echo '<pre>';
//		print_r($data['usuarios']);
////		print_r($data);
//		exit();

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/index');
		$this->load->view('layout/footer');
	}

	public function core($usuario_id = NULL)
	{

//		Verifcando se usuário não foi passado, vai cadastrar.
		if (!$usuario_id) {
//			Cadastrar novo usuário
			exit('Pode cadastrar novo usuário');

		}else{
//			Editar o usuário
			if (!$this->ion_auth->user($usuario_id)->row()) {

				exit('Usuário não existe');

			} else {

//				Editar usuário

//				Form_validation
				$this->form_validation->set_rules('first_name','Nome','trim|required|min_length[5]|max_length[30]');
				$this->form_validation->set_rules('last_name','Sobrenome','trim|required|min_length[5]|max_length[30]');
				$this->form_validation->set_rules('username','Usuario','trim|required|min_length[5]|max_length[40]|callback_username_check');
				$this->form_validation->set_rules('email','E-mail','trim|valid_email|required|min_length[5]|max_length[200]|callback_email_check');
				$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
				$this->form_validation->set_rules('confirmacao', 'Confirma', 'trim|matches[password]');

				/*
				 * Array (
						[first_name] => Admin
						[last_name] => istrator
						[username] => administrator
						[email] => admin@admin.com
						[active] => 1

					)
				 */


//				Atualizar os dados vindo do POST

				$data = elements(

					array(
						'first_name',
						'last_name',
						'username',
						'email',
						'password',
						'active',
					), $this->input->post()
				);

				//recuperar o valor do meu input password
				$password = $this->input->post('password');

				//Não atualiza
				if (!$password) {
					unset($data['password']);
				}


				//Sanitizar array
				$data = html_escape($data);

				//Para atualizar
				if ($this->ion_auth->update($usuario_id, $data)) {

					$this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso!');

				}else{

					$this->session->set_flashdata('error', 'Não foi possível atualizar os dados');

				}
				//Meu controlador é usuário vai me renderizar ao método index
				redirect($this->router->fetch_class());

				if ($this->form_validation->run()) {

//					echo '<pre>';
//					print_r($data);
//					exit();

				}else{

//					Erro de validação, printando a minha view

					$data = array(
						'titulo' => 'Editar usuário',

//					Carregar os dados do usuário
						'usuario' => $this->ion_auth->user($usuario_id)->row(),
						'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
					);

//					echo "<pre>";
//					print_r($data['perfil_usuario']);
//					exit();


					$this->load->view('layout/header', $data);
					$this->load->view('usuarios/core'); //View que também vai se chamar de CORE
					$this->load->view('layout/footer');

				}
			}

		}
	}

	public function username_check($username)
	{
//		Recuperando o id do usuário

		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {

			$this->form_validation->set_message('username_check', 'Esse usuário ja existe');
			return FALSE;

		} else {

			return TRUE;
		}
	}

	public function email_check($email)
	{
//		Recuperando o id do usuário

		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {

			$this->form_validation->set_message('username_check', 'Esse E-mail ja existe');

			return FALSE;

		} else {

			return TRUE;
		}
	}
}
