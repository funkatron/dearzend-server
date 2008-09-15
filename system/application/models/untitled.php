<?php
class Letters extends Model {

    function Letters()
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
		# code...
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
	public function getMany($count=10, $sortby=null, $order=null, $start=0)
	{
		# code...
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
		# code...
	}
}