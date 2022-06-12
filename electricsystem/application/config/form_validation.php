<?php

$config = [
	'add_category_rules' => 	[
							[
								'field' => 'category_name',
								'label' => 'Category Name',
								'rules' => 'required'

							],
							[
								'field' => 'category_description',
								'label' => 'Category Description',
								'rules' => 'required'

							]
						],

	'admin_login_rules' => 	[
							[
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'required|trim'

							],
							[
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim'

							]
						],


];


?>