<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends MY_Controller {

	public function __construct()
    {
            parent::__construct();
			$this->load->helper(array('url', 'html', 'form'));
			$this->load->model('ArticlesModel', 'articles');

    }

	public function index()
	{

		$this->load->library('pagination');

		$number_articles = $this->articles->allCategoryCount();

		$config = array();
		$config['base_url'] = base_url('UserController');
		$config['per_page'] = 5;
		$config['total_rows'] = $number_articles;
		$config['full_tag_open']= "<div class='pagination'>";
		$config['full_tag_close']= "</div>";
		/*$config['next_tag_open']= "<a>";
		$config['next_tag_close']= "</a>";
		$config['pre_tag_open']= "<a>";
		$config['pre_tag_close']= "</a>";
		$config['num_tag_open']= "<a>";
		$config['num_tag_close']= "</a>";*/
		$config['cur_tag_open']= "<a class='active'>";
		$config['cur_tag_close']= "</a>";

		//$this->print($config);
		$this->pagination->initialize($config);

		$articles = $this->articles->allCategory($config['per_page'], $this->uri->segment(3));

		//$this->print($articles);

		$this->load->view('users/view_users', compact('articles'));
	}

	public function print($post)
	{
		echo "<pre>"; print_r($post); exit();
	}

	/*public function searchCategory()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('search_category', 'Query', 'required');

		$checkValidation = $this->form_validation->run();

		//$this->print($checkValidation);

		if ($checkValidation) {
			$query = $this->input->post('search_category');

			$this->load->model('ArticlesModel', 'articles');
			$articles = $this->articles->searchCategory($query);
			$this->load->view('users/search_results', compact('articles'));

			//$this->print($articles);
		} else {
			// Error Message Show Using $this keyword.
			$this->index();
		}

	}*/

	public function searchCategory()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('search_category', 'Query', 'required');

		$checkValidation = $this->form_validation->run();

		//$this->print($checkValidation);

		if ($checkValidation) {
			$query = $this->input->post('search_category');

			//$this->load->model('ArticlesModel', 'articles');
			//$articles = $this->articles->searchCategory($query);
			//$this->load->view('users/search_results', compact('articles'));

			//return $this->flashMessage($articles, 'Searched Query...', '');
			//$this->print($articles);


			return redirect("UserController/searchCategoryResults/$query");
		} else {
			// Error Message Show Using flashdata 
			return $this->flashMessage($checkValidation, '', 'Query is required...');
			/*
			Of course flashdata doesn't work on the current $this->load->view();, as it sets a session value only seen on the next page load by the browser (not the current one). If you want to pass data to view(), just pass it to the view($page, $data) call itself as the second parameter.
			*/
		}

	}

	public function flashMessage($isSuccessful, $successfulMessage, $failureMessage)
	{
		if ($isSuccessful) {
			$this->session->set_flashdata('success_message', $successfulMessage);
			$this->load->view('users/search_results', ['articles' => $isSuccessful]);

		} else {
			$this->session->set_flashdata('failed_message', $failureMessage);		
			return redirect('UserController');
		}
		
	}

	public function searchCategoryResults( $query )
	{
		$this->load->library('pagination');

		$number_articles = $this->articles->countSearchCategoryResults( $query );

		$config = array();
		$config['base_url'] = base_url("UserController/searchCategoryResults/$query");
		$config['per_page'] = 5;
		$config['total_rows'] = $number_articles;
		$config['full_tag_open']= "<div class='pagination'>";
		$config['full_tag_close']= "</div>";
		/*$config['next_tag_open']= "<a>";
		$config['next_tag_close']= "</a>";
		$config['pre_tag_open']= "<a>";
		$config['pre_tag_close']= "</a>";
		$config['num_tag_open']= "<a>";
		$config['num_tag_close']= "</a>";*/
		$config['cur_tag_open']= "<a class='active'>";
		$config['cur_tag_close']= "</a>";
		/*$config['uri_segment'] = 4;*/ /* By Default Uri Segment is 3. */

		//$this->print($config);
		$this->pagination->initialize($config);
		$articles = $this->articles->searchCategory($query, $config['per_page'], $this->uri->segment(4));
		$this->load->view('users/search_results', compact('articles'));

		
	}

	public function categoryDetails( $value )
	{
		$articles = $this->articles->find( $value );


		$this->load->view('users/view_articles_details', compact('articles'));

	}

	public function getAllCategory()
	{
		$articles = $this->articles->getAllCategory();
		$this->print($articles);

	}

	

}
