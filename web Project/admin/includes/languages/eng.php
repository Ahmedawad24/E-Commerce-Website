<?php
	
	function lang($phrase)
	{
		static $lang = array (

			//navbar links

			'home_admin' => 'Home',
			'CATEGORIES' => 'Categories',
			'MEMBER' => 'Member',
			'COMMENTS'=> 'Comments',
			'STATISTICS' => 'Statistics',
			'LOGS' => 'Logs',
			'COURSES'=> 'Courses',
			'Accounting KU' =>'Accounting KU',
			'Finance KU' => 'Finance KU',
			'Accounting SU' =>'Accounting SU',
			'Finance SU' => 'Finance SU',
			'ESLAM'=> 'Eslam',
			'PROFILE'=>'Profile',
			'SETTING'=> 'Setting',
			'LOGOUT'=> 'Logout'


		);

		return $lang[$phrase];

	}


