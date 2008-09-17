<?php

class DZApi extends Controller {

	function DZApi()
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
		echo "hi! you requested $id";
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
		// Get the post data
		$letter_json = $this->_cleanInput($this->input->post('letter'));
		
		if ($letter_json) {
			$letter = json_decode($letter_json);
		} else {
			$response = new stdClass();
			$response->msg = 'Input was invalid';
			$this->_sendAsJSON($response, '400 Bad Request');
			return;
		}
		
		
		$data = new stdClass();
		$data->letter = $letter;
		$data->ip     = $_SERVER['REMOTE_ADDR'];
		$result = $this->mletters->add($data);
		
		if ($result !== false) {
			$data = new stdClass();
			$response->msg = 'Post added';
			$response->id  = $result;
			$this->_sendAsJSON($response, '200 OK');
		} else {
			$data = new stdClass();
			$response->msg = 'There was a problem adding your post';
			$this->_sendAsJSON($response, '500 Internal Server Error');
		}
		return;
	}
	
	
	
	
	public function favorite($id)
	{
		$data = new stdClass();
		$data->id = (int)$id;
		$data->ip = $_SERVER['REMOTE_ADDR'];

		$result = $this->mletters->favorite($data);
		
		if ($result !== false) {
			$data = new stdClass();
			$response->msg = 'Favorited post';
			$response->favorite_count = $result;
			$this->_sendAsJSON($response, '200 OK');
		} else {
			$data = new stdClass();
			$response->msg = 'There was a problem favoriting your post';
			$this->_sendAsJSON($response, '500 Internal Server Error');
		}
		return;
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