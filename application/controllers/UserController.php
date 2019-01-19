<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/17/2019
 * Time: 5:11 PM
 */

class UserController extends CI_Controller
{
	public function __construct(){

		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('user');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('laravel');

	}

	public function index()
	{
		$this->load->view("register.php");
	}

	public function register_user(){

		$this->form_validation->set_rules('user_name', 'Username', 'required|min_length[3]');
		$this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[user.user_email]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('user_age', 'Age', 'required|max_length[3]|less_than_equal_to[120]');
		$this->form_validation->set_rules('user_mobile', 'Mobile', 'required|exact_length[10]');
		//$this->laravel->dd($this->form_validation->run());
		if ($this->form_validation->run()==false)
			{
				$this->session->set_flashdata('error_msg', validation_errors());
				$this->load->view('register.php');
			}
		else
			{
				$user=array(
					'user_name'=>$this->input->post('user_name'),
					'user_email'=>$this->input->post('user_email'),
					'user_password'=>md5($this->input->post('user_password')),
					'user_age'=>$this->input->post('user_age'),
					'user_mobile'=>$this->input->post('user_mobile')
				);
				$this->laravel->dd($user);
				$email_check=$this->user->email_check($user['user_email']);
				if($email_check){
					$this->user->register_user($user);
					$this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
					redirect('usercontroller/login_view');
				}
				else{

					$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
					redirect('usercontroller');
				}
			}

	}
	public function login_view(){
		$this->load->view("login.php");
	}
	function login_user(){
		$user_login=array(
			'user_email'=>$this->input->post('user_email'),
			'user_password'=>md5($this->input->post('user_password'))
		);
//$user_login['user_email'],$user_login['user_password']
		$data['users']=$this->user->login_user($user_login);
		if($data)
		{
			$this->session->set_userdata('user_id',$data['users']['user_id']);
			$this->session->set_userdata('user_email',$data['users']['user_email']);
			$this->session->set_userdata('user_name',$data['users']['user_name']);
			$this->session->set_userdata('user_age',$data['users']['user_age']);
			$this->session->set_userdata('user_mobile',$data['users']['user_mobile']);
			redirect('usercontroller/user_profile');
		}else{
			$this->session->set_flashdata('error_msg', 'Your credentials do not Match.');
			redirect('usercontroller/login_view');
		}
	}

	function user_profile(){
		$id= $this->session->userdata('user_id');
		$data = $this->user->getProfile($id);
		//var_dump($data);
		$this->load->view('user_profile.php',$data);

	}
	public function user_logout(){

		$this->session->sess_destroy();
		redirect('usercontroller/login_view', 'refresh');
	}


}
