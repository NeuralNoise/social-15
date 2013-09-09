<?php 

/**
* All the users data
*/
class person
{	
	private $dao,
			$user,
			$useroptions;

	// Users
	private $username,
			$password,
			$email,
			$signup,
			$online,
			$last_login,
			$notif_check,
			$activated,
			$ip,
			$permission,

	// Useroptions
			$background,
			$avatar,
			$question,
			$answer,
			$hometown,
			$curr_location,
			$high_school,
			$university,
			$job_title,
			$job_firm,
			$first_name,
			$last_name,
			$full_name,
			$country,
			$gender,
			$birth_date,
			$temp_pass,
			$friend_count,
			$avatar_id;
	

	public function __construct($name) {
		$this->user = User::find($name);
		$this->useroptions = Useroptions::find($name);

		$this->username = $this->user->username;
		$this->password = $this->user->password;
		$this->email = $this->user->email;
		$this->signup = $this->user->signup;
		$this->online = $this->user->online;
		$this->last_login = $this->user->last_login;
		$this->notif_check = $this->user->notif_check;
		$this->activated = $this->user->activated;
		$this->ip = $this->user->ip;
		$this->permission = $this->user->permission;

		$this->background = $this->useroptions->background;
		$this->avatar_id = $this->useroptions->avatar_id;
		if (!empty($this->avatar_id) ) {
			$this->avatar = Photos::find($this->avatar_id)->path;
		} else {
			$this->avatar = 'img/default_avatar.jpg';
		}
		$this->question = $this->useroptions->question;
		$this->answer = $this->useroptions->answer;
		$this->hometown = $this->useroptions->hometown;
		$this->curr_location = $this->useroptions->curr_location;
		$this->high_school = $this->useroptions->high_school;
		$this->university = $this->useroptions->university;
		$this->job_title = $this->useroptions->job_title;
		$this->job_firm = $this->useroptions->job_firm;
		$this->first_name = $this->useroptions->first_name;
		$this->last_name = $this->useroptions->last_name;
		$this->full_name = mb_convert_case($this->first_name . ' ' . $this->last_name, MB_CASE_TITLE, "UTF-8");
		$this->country = $this->useroptions->country_id;
		$this->country = Country::find_by_country_id($this->country)->name;
		$this->gender = $this->useroptions->gender;
		if ($this->gender === 'm') {
			$this->gender = 'male';
		} else {
			$this->gender = 'female';
		}
		$this->birth_date = $this->useroptions->birth_date;
		$this->temp_pass = $this->useroptions->temp_pass;

		$this->dao = new person_DAO($this);

	}

	

	public function __get($property) {
		if (property_exists($this, $property) ) {
			return $this->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the PERSON CLASS does not exist", 1);
		}
	}


	/*
	***********************
	** =Singleton
	***********************
	*/

	// public static function Instance()
 //    {
 //        static $inst = null;
 //        if ($inst === null) {
 //            $inst = new person();
 //        }
 //        return $inst;
 //    }

 //    private function __construct()
 //    {

 //    }

}

?>