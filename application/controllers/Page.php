<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/17/2019
 * Time: 12:34 PM
 */

class Page extends CI_Controller
{
	public function test()
	{
		$data['title']="Hi From Controller";
		$data['content']="I will change on every page";
		$data['copyright']="No Copy Right Available";

		$this->load->view('header',$data);
		$this->load->view('test',$data);
		$this->load->view('footer',$data);
	}
	public function para($value)
	{
		$data['title']="Hi From Controller";
		$data['content']=$value;
		$data['copyright']="No Copy Right Available";

		$this->load->view('header',$data);
		$this->load->view('test',$data);
		$this->load->view('footer',$data);
	}
	public function twoPara($v1,$v2=5)
	{
		$data['title']="Hi From Controller";
		$data['content1']=$v1;
		$data['content2']=$v2;
		$data['copyright']="No Copy Right Available";

		$this->load->view('header',$data);
		$this->load->view('test2',$data);
		$this->load->view('footer',$data);
	}
	public function testPost()
	{
			//var_dump($this->input->get());
			var_dump($this->input->post('Name'));
	}
	public function response() {
		$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);

		//add the header here
		header('Content-Type: application/json');
		echo json_encode( $arr );
	}
}
