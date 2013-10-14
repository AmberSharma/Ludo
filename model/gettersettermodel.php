<?php
session_start ();
require_once 'model.php';
ini_set ( "display_error", 'on' );
class Register extends model {
	protected $user;
	protected $avatar;
	protected $turn;
	protected $method;
	protected $dice;
	
	/**
	 * @return the $random1
	 */
	


	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param field_type $random1
	 */
	public function setDice($dice) {
		$this->dice = $dice;
	}

	public function getDice() {
		return $this->dice;
	}

	/**
	 * @param field_type $random1
	 */
	public function setMethod($method) {
		$this->method = $method;
	}


	/**
	 *
	 * @return the $username
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 *
	 * @return the $password
	 */
	public function getAvatar() {
		return $this->avatar;
	}
	
	/**
	 *
	 * @param field_type $username        	
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 *
	 * @param field_type $password        	
	 */
	public function setTurn($turn) {
		$this->turn = $turn;
	}
	public function setAvatar($avatar) {
		$this->avatar = $avatar;
	}
	public function getTurn() {
		return $this->turn;
	}
	
	
/* 
   ---------------------------------------------------------------------------------------------------------------------------
         Function to insert new User into the database. It is called from either automatic.php or manual.php page on page load.
   ---------------------------------------------------------------------------------------------------------------------------
*/	
	
	public function insertUser() {
		$this->db->Fields ( array ("name" =>  $this->getUser () ,"turn" => $this->getTurn ()  ,"avatar" => $this->getAvatar () , "playing" => "N" , "chance" => "N" , "position" => "-1" , "method" => $this->getMethod () , "dice" =>  $this->getDice ()));
		$this->db->From ( "user" );
		$result = $this->db->Insert ();
		return $result;
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch required number of opponents for a user. 
	 It is called from either automatic.php or manual.php at regular interval until the required number of opponents are available.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function fetchUser() {
		$this->db->Fields (array("playing"));
		$this->db->From ( "user");
		$this->db->Where (array("name" => $this->getUser ()));
		$this->db->Select ();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		$_SESSION['user'] = $this->getUser ();
		
		if($result[0]['playing'] != "0")
		{
			$_SESSION['play'] = $result[0]['playing'] ;
			$this->db->Fields (array("avatar" , "name"));
			$this->db->From ("user where playing =  ". $result[0]['playing'] ." and name != '".$this->getUser () . "' and dice = ".$this-> getDice());
			$this->db->Select ();
			$result = $this->db->resultArray();
			//echo $this->db->lastQuery();
			return $result;
		}
		else
		{
			$this->db->Fields (array("avatar" , "name"));
			$this->db->From ( "user where name != '".$this->getUser (). "' and turn = '".$this->getTurn ()."' and  avatar != '".$this->getAvatar () ."' and playing = '0' and chance = 'N' and method = '". $this->getMethod () . "' and dice = ".$this-> getDice());
			$this->db->Select ();
			//echo $this->db->lastQuery();
			$result = $this->db->resultArray();
			return $result;
		}
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to assign a random number to a fetch group of users. 
	 It is called from either automatic.php or manual.php page after the required number of opponents are available and finalized.
   ------------------------------------------------------------------------------------------------------------------------------------
*/
	public function updateUser($users) 
	{
		$this->db->Fields (array("playing"));
		$this->db->From ( "user");
		$this->db->Where (array("name" => $_SESSION['user']));
		$this->db->Select ();
		$result = $this->db->resultArray();
		if($result[0]['playing'] == "0")
		{
			$arr = rand(1, 500);
			$_SESSION['play'] = $arr;
			for($i =0 ; $i < count($users) ; $i ++)
			{
				$this->db->Fields (array("Playing"=>$arr));
				$this->db->From ( "user" );
				$this->db->Where (array("name" => $users[$i]));
				$this->db->Update ();
			}
			if($i == count($users))
			return "1";
		}
		else
			return "-1";
		
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to update user positions at regular interval. 
	 It is called from either automatic.php or manual.php at session user finishes his/her turn.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function updateUserPosition($users , $user , $pos) 
	{

		$this->db->Fields (array("chance"=>"N" , "position" => $pos));
		$this->db->From ( "user" );
		$this->db->Where (array("name" => $user));
		$result = $this->db->Update ();
		if ($result)
		{
			$a = 0;
			
			sort($users);
			for($i =0 ; $i < count($users) ; $i ++)
			{
				if(($users[$i] == $user) && ($i != (count($users) - 1)))
				{
					$a = 1;
				}
				if($users[$i] != $user && ($a == 1))
				{
					$this->db->Fields (array("chance" => "Y"));
					$this->db->From ( "user" );
					$this->db->Where (array("name" => $users[$i]));
					$result1 = $this->db->Update ();
					break;
				}
				if(($i == (count($users) - 1)) && ($a == 0))
				{
					$this->db->Fields (array("chance" => "Y"));
					$this->db->From ( "user" );
					$this->db->Where (array("name" => $users[0]));
					$result1 = $this->db->Update ();
					break;
				}
			}
			
		}
		if($result && $result1)
		{
			return $result1 ;
		}
		
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch the user who is having the turn to roll the dice.
	 It is called from either automatic.php or manual.php page at regular interval.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function getChance() 
	{
		

		$this->db->Fields (array("name"));
		$this->db->From ( "user" );
		$this->db->Where (array("chance" => 'Y' , "playing" => $_SESSION['play']));
		$this ->db->Limit("1");
		$this->db->Select ();
		$result1 = $this->db->resultArray();
		return $result1;
		
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch the positions of all the opponents. 
	 It is called from either automatic.php or manual.php page at a regular time interval.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function getPosition() 
	{
		$this->db->Fields (array("playing"));
		$this->db->From ( "user" );
		$this->db->Where (array("name" => $_SESSION['user']));
		$this->db->Select ();
		$result = $this->db->resultArray();
		
		$this->db->Fields (array("position" , "name" , "avatar"));
		$this->db->From ( "user where name != '" . $this->getUser () ."'  and playing = '" . $result[0]['playing'] . "'");
		$this->db->Select ();
		$result1 = $this->db->resultArray();
		
		return $result1;
		
	}

/* 
   -----------------------------------------------------------------------------------------------------------------------------------------
         Function to delete user when the game finishes. It is called automatically when the any of the user either looses of wins the game
   -----------------------------------------------------------------------------------------------------------------------------------------
*/

	public function deleteUser() 
	{
		$this->db->From ( "user");
		$this->db->Where (array("name" => $this->getUser()));
		$this->db->Delete ();		
		echo $this->db->lastQuery(); 
	}
	

/* 
   --------------------------------------------------------------------------------------------------------------
         Function to find whether user is unique or not. It is called from bendrules.php page on every key press.
   --------------------------------------------------------------------------------------------------------------
*/
	public function uniqueUser() 
	{
		$this->db->Fields (array("name"));
		$this->db->From ("user");
		$this->db->Where (array("name" => $this->getUser()));
		$this->db->Select ();
		$result = $this->db->resultArray();		
		return $result;
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to set the turn for the first time to start the game. 
	 It is called from either automatic.php or manual.php page once the required opponents are available.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function setChance($users) 
	{
		sort($users);
		for($i =0 ; $i < count($users) ; $i ++)
		{
			$this->db->Fields (array("chance" , "name"));
			$this->db->From ( "user" );
			$this->db->Where (array("name" => $users[$i]));
			$this->db->Select ();
			$result = $this->db->resultArray();
			if($result[0]['chance'] == "Y")
			{
				break;
			}
		}
		if($i == count($users))
		{
			$this->db->Fields (array("chance" => "Y"));
			$this->db->From ( "user" );
			$this->db->Where (array("name" => $users[0]));
			$this->db->Update ();
			
		}		
	}

	
	
	
}


?>
