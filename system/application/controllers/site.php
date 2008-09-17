<?php

class Site extends Controller {

	function Site()
	{
		parent::Controller();
		
		$this->load->library('session');	
	}
	
	
	function index()
	{
		
		$rows = $this->mletters->getMany(10);
		
		$data['rows'] = $rows;
		
		$this->load->view('index', $data);
		
	}
	
	
	public function rss()
	{
		$this->load->helper('xml');
		
		$data['encoding'] = 'utf-8';
		$data['feed_name'] = 'DearZend.com';
		$data['feed_url'] = 'http://dearend.com';
		$data['page_language'] = 'en-us';
		$data['posts'] = $this->mletters->getMany(20);    
		header("Content-Type: application/rss+xml");
		$this->load->view('rss', $data);
	}
	
	function all()
	{
		
		$rows = $this->mletters->getAll();
		
		$data['rows'] = $rows;
		
		$this->load->view('all', $data);
		
	}
	
	function favorites()
	{
		
		$rows = $this->mletters->getFavorites(10);
		
		$data['rows'] = $rows;
		
		$this->load->view('favorites', $data);
		
	}
	
	
	/**
	 * Retrieves a list of entries
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	
	public function newest($count=10)
	{
		$count  = (int)$count;
		
		$result = $this->mletters->getMany($count);

		if ($result !== false) {
			$response->letters= $result;
			$response->msg    = 'Retrieved newest posts';
			$response->count  = count($result);
			$this->_sendAsJSON($response, '200 OK');
		} else {
			$response->msg = 'There was a problem adding your post';
			$this->_sendAsJSON($response, '500 Internal Server Error');
		}
		return;
		
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
		$id  = (int)$id;
		
		$row = $this->mletters->getOne($id);

		if ($row !== false) {

			$data['row'] = $row;

			$this->load->view('single', $data);


		} else {
			$this->session->set_flashdata('flash_msg', 'I couldn\t find that post');
			redirect('/site/index');
		}
		return;
	}
	
	
	/**
	 * Adds an entry.
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	public function add()
	{
		// Get the post data
		$letter = $this->_cleanInput($this->input->post('letter'));
		
		if (empty($letter)) {
			$this->session->set_flashdata('flash_msg', 'You need to enter something');
			redirect('/site/index');
		}
		
		$data = new stdClass();
		$data->letter = $letter;
		$data->ip     = $_SERVER['REMOTE_ADDR'];
		$result = $this->mletters->add($data);
		
		if ($result !== false) {
			$this->session->set_flashdata('flash_msg', 'Your submission has been added');
			redirect('/site/index');
		} else {
			$this->session->set_flashdata('flash_msg', 'There was a problem processing your submission');
			redirect('/site/index');
		}
	}
	
	
	
	
	public function favorite($id)
	{
		$data = new stdClass();
		$data->id = (int)$id;
		$data->ip = $_SERVER['REMOTE_ADDR'];

		$result = $this->mletters->favorite($data);
				
		if ($result !== false) {
			$this->session->set_flashdata('flash_msg', 'Thanks!');
			redirect('/site/index');
		} else {
			$this->session->set_flashdata('flash_msg', 'There was a problem marking the entry as one you like');
			redirect('/site/index');
		}
	}
	
	
	
	/**
	 * A really simple method to clean input of tags, encode special chars, etc
	 *
	 * @param string $input 
	 * @return string
	 * @author Ed Finkler
	 */
	private function _cleanInput($input)
	{
		$input = trim($input);
		$input = strip_tags($input);
		$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
		return $input;
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
		return;
	}

}