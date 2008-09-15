<?php

class Letters extends Controller {

	function Letters()
	{
		parent::Controller();	
	}
	
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	
	
	/**
	 * Retrieves a list of entries
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	
	public function list()
	{
		# code...
	}
	
	
	/**
	 * Gets data for a single entry
	 *
	 * @param integet $id 
	 * @return void
	 * @author Ed Finkler
	 */
	public function single($id)
	{
		# code...
	}
	
	
	/**
	 * Adds an entry.
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	public function add()
	{
		# code...
	}
	
	
	/**
	 * takes a php structure (an array or object) and serves it as JSON
	 *
	 * @param object $data 
	 * @param string $status 
	 * @return void
	 * @author Ed Finkler
	 */
	private function _sendAsJSON($data, $status = '200 OK')
	{
		$rsJSON = json_encode($data);
		$this->output->set_header("HTTP/1.0 ".$status);
		$this->output->set_header("HTTP/1.1 ".$status);
		$this->output->set_header('Content-Type: application/json');
		$this->output->set_output($rsJSON);
	}

}