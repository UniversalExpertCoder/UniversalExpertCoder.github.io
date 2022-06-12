<?php


/**
 * 
 */
class ArticlesModel extends CI_Model
{

	public function getAllCategory()
	{
		$articles = $this->db->select('*')
							 ->from('table_category')
							 ->get();

		return $articles->result();
	}
	
	public function articles($limit, $offset)
	{
		$user_id = $this->session->userdata('user_id');
		/*$articles = $this->db->select('*')
							 ->from('articles')
							 ->where('user_id', $user_id)
							 ->get();*/

		/*$articles = $this->db->select('title')
							 ->from('articles')
							 ->where('user_id', $user_id)
							 ->get();*/

		/*$articles = $this->db->select('title')
							 ->select('id')
							 ->from('articles')
							 ->where('user_id', $user_id)
							 ->get();*/

		$articles = $this->db->select(['title', 'id'])
							 ->from('articles')
							 ->where('user_id', $user_id)
							 ->limit($limit, $offset)
							 ->get();

		/*$articles = $this->db->query('SELECT id, title FROM articles');*/

		//print_r($articles->result()); die;
		return $articles->result();
	}

	public function allCategory($limit, $offset)
	{
		$articles = $this->db->select(['id', 'title', 'created_at'])
					 ->from('articles')
					 ->limit($limit, $offset)
					 ->order_by('created_at', 'DESC')
					 ->get();

		return $articles->result();		
	}

	public function allCategoryCount()
	{
		$articles = $this->db->select(['title', 'id'])
					 ->from('articles')
					 ->get();

		return $articles->num_rows();		
	}

	public function numberOfRows()
	{
		$user_id = $this->session->userdata('user_id');
		$articles = $this->db->select(['title', 'id'])
							 ->from('articles')
							 ->where('user_id', $user_id)
							 ->get();
		return $articles->num_rows();		
	}

	public function addCategory($data)
	{
		//$query = $this->db->query("SELECT * FROM articles");
		//print_r($query);

		//$data = array('title' => $this->input->post('category_title'),'body' => $this->input->post('category_body'));
		//print_r($data); exit();
		return $this->db->insert('articles', $data);
	}


	public function findCategory($article_id)
	{
		$article_query = $this->db->select(['id', 'title', 'body'])
							 ->from('articles')
							 ->where('id', $article_id)
							 ->get();

		return $article_query->row();
	}

	public function updateCategory($article_id, $articles)
	{
		//echo "<pre>"; print_r($this->input->post());
		$data = array('title' => $this->input->post('category_title'),'body' => $this->input->post('category_body'));
		//echo "<pre>"; print_r($data);

		return $this->db->where('id', $article_id)
				 		->update('articles', $data);
	}

	public function deleteCategory($article_id)
	{
		return $this->db->delete('articles', ['id' => $article_id]);

	}

	public function searchCategory($query, $limit, $offset)
	{
		$query_find = $this->db->from('articles')->like('title', $query)->limit( $limit, $offset )->get();
		return $query_find->result();
	}

	public function countSearchCategoryResults( $query )
	{
		$query_find = $this->db->from('articles')->like('title', $query)->get();
		return $query_find->num_rows();
	}

	public function find( $id )
	{
		$query = $this->db->from('articles')->where( ['id' => $id] )->get();
		if ($query->num_rows() ) {
			return $query->row();
		}

		return false;
	}

}