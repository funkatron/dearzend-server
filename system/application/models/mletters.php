<?php
class MLetters extends Model {

    function MLetters()
    {
        parent::Model();
    }
	
	/**
	 * gets a single entry
	 *
	 * @param int $id 
	 * @return object
	 * @author Ed Finkler
	 */
	public function getOne($id)
	{
		$query = $this->db->select('body,id,posted')
							 ->where('id', (int)$id)
							 ->get('letters');
		if ($query->num_rows() == 1) {
			$row = $query->row();
			$row->posted = date(DATE_RFC822, strtotime($row->posted));
			$row->favorite_count = $this->getFavCount($id);
			return $row;
		} else {
			return false;
		}
	}
	
	
	
	/**
	 * retrieve an array of entries
	 *
	 * @param int $count default 10
	 * @param string $sortby a column name
	 * @param string $order ASC or DESC
	 * @param int $start where to start. default 0
	 * @return Array
	 * @author Ed Finkler
	 */
	public function getMany($count=10, $sortby='posted', $order='DESC', $start=0)
	{
		$query = $this->db->select('body, id, posted')
							 ->limit($count, $start)
							 ->order_by($sortby, $order)
							 ->get('letters');
		if ($query->num_rows() > 0) {
			// we need to make RFC 822 dates and get fav counts
			$results = array();
			foreach ($query->result() as $thisrow) {
				$thisrow->posted = date(DATE_RFC822, strtotime($thisrow->posted));
				$thisrow->favorite_count = $this->getFavCount($thisrow->id);
				$results[] = $thisrow;
			}
			return $results;
		} else {
			return false;
		}
	}
	
	
	
	/**
	 * retrieve an array of entries
	 *
	 * @param int $count default 10
	 * @param string $sortby a column name
	 * @param string $order ASC or DESC
	 * @param int $start where to start. default 0
	 * @return Array
	 * @author Ed Finkler
	 */
	public function getFavorites($count=10)
	{
		$sql = "
				FROM letters l, favorites f
				WHERE l.id = f.letters_id
				ORDER BY count DESC";
		
		$query = $this->db->select('l.body, l.id, l.posted, COUNT(f.id) as count')
							 ->from('letters l')
							 ->join('favorites f', 'l.id = f.letters_id')
							 ->limit($count)
							 ->group_by('l.body')
							 ->order_by('count', 'DESC')
							 ->get();
		if ($query->num_rows() > 0) {
			// we need to make RFC 822 dates and get fav counts
			$results = array();
			foreach ($query->result() as $thisrow) {
				$thisrow->posted = date(DATE_RFC822, strtotime($thisrow->posted));
				$thisrow->favorite_count = $this->getFavCount($thisrow->id);
				$results[] = $thisrow;
			}
			return $results;
		} else {
			return false;
		}
	}
	
	

	/**
	 * retrieve an array of entries. This could get ugly if the count gets big
	 *
	 * @param int $count default 10
	 * @param string $sortby a column name
	 * @param string $order ASC or DESC
	 * @param int $start where to start. default 0
	 * @return Array
	 * @author Ed Finkler
	 */
	public function getAll($sortby='posted', $order='DESC')
	{
		$query = $this->db->select('body, id, posted')
							 ->order_by($sortby, $order)
							 ->get('letters');
		if ($query->num_rows() > 0) {
			// we need to make RFC 822 dates and get fav counts
			$results = array();
			foreach ($query->result() as $thisrow) {
				$thisrow->posted = date(DATE_RFC822, strtotime($thisrow->posted));
				$thisrow->favorite_count = $this->getFavCount($thisrow->id);
				$results[] = $thisrow;
			}
			return $results;
		} else {
			return false;
		}
	}


	/**
	 * returns a random entry. This is wildly inefficient
	 *
	 * @return stdObj
	 * @author Ed Finkler
	 */
	public function getRandom()
	{
		$results = $this->getAll();
		$randkey = array_rand($results);
		return $results[$randkey];
	}


	
	/**
	 * add a new entry
	 *
	 * @param object $data 
	 * @return int|boolean
	 * @author Ed Finkler
	 */
	public function add($data)
	{
		$result = $this->db->insert('letters', array(
							'body'=>$data->letter,
							'ip'=>$data->ip
							));
		if ($result){
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	
	/**
	 * favorite an entry
	 *
	 * @param int $id
	 * @return int|boolean
	 * @author Ed Finkler
	 */
	public function favorite($data)
	{
		$result = $this->db->insert('favorites', array(
							'letters_id'=>$data->id,
							'ip'=>$data->ip
							));
		if ($result){
			return $this->getFavCount($data->id);
		} else {
			return false;
		}
	}
	
	
	/*
		retrieves the number of times an entry has been marked as a fav
	*/
	public function getFavCount($id)
	{
		return $this->db->select('COUNT(id) as count')
						->where('letters_id', $id)
						->get('favorites')
						->row()
						->count;
	}
	
}