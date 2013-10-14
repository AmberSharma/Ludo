<?php
require_once getcwd()."/../libraries/constant.php";
require_once getcwd().'/../libraries/validate.php';

ini_set("display_errors", "1");

$route = array();

class MyClass 
{
	
    
/* 
   -----------------------------------------------------------------------------------------------------------------------------------------
         Function to delete user when the game finishes. It is called automatically when the any of the user either looses of wins the game
   -----------------------------------------------------------------------------------------------------------------------------------------
*/
    
	public function deleteUser ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$objInitiateUser->setUser($_REQUEST['user']);
		$b=$objInitiateUser->deleteUser() ;
		
	}

/* 
   --------------------------------------------------------------------------------------------------------------
         Function to find whether user is unique or not. It is called from bendrules.php page on every key press.
   --------------------------------------------------------------------------------------------------------------
*/

	public function uniqueUser ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$objInitiateUser->setUser($_REQUEST['user']);
		$b=$objInitiateUser->uniqueUser() ;
		if(count($b) > 0)
		{
			echo  "0";
		}
		else
		{
			echo "1";
		}
	}
	
/* 
   ---------------------------------------------------------------------------------------------------------------------------
         Function to insert new User into the database. It is called from either automatic.php or manual.php page on page load.
   ---------------------------------------------------------------------------------------------------------------------------
*/	
	
	public function insertUser ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$objInitiateUser->setUser($_REQUEST['user']);
		$objInitiateUser->setTurn($_REQUEST['turn']);
		$objInitiateUser->setAvatar($_REQUEST['avatar']);
		$objInitiateUser->setMethod($_REQUEST['method1']);
		$objInitiateUser->setDice($_REQUEST['dice']);
		$b = $objInitiateUser->insertUser () ;
		if($b)
		{
			die("1");
		}
		else
		{
			die("-1");
		}
	
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch required number of opponents for a user. 
	 It is called from either automatic.php or manual.php at regular interval until the required number of opponents are available.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function fetchUser ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$objInitiateUser->setUser($_REQUEST['user']);
		$objInitiateUser->setTurn($_REQUEST['turn']);
		$objInitiateUser->setAvatar($_REQUEST['avatar']);
		$objInitiateUser->setMethod($_REQUEST['method1']);
		$objInitiateUser->setDice($_REQUEST['dice']);
		$b = $objInitiateUser->fetchUser () ;
		if($b)
		{
			if(count($b) >= $_REQUEST['opponent'])
			{
				for($i = 0 ; $i < $_REQUEST['opponent'] ; $i ++ )
				{
					$arr[] = $b[$i]['name'];
					$arr[] = $b[$i]['avatar'];
				}
				echo json_encode($arr);
			}
			else
			{
				die("1");
			}
		}
		else
		{
			die("1");
		}
	
	}


/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to assign a random number to a fetch group of users. 
	 It is called from either automatic.php or manual.php page after the required number of opponents are available and finalized.
   ------------------------------------------------------------------------------------------------------------------------------------
*/
	
	public function updateUser ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$abc = explode("," , $_REQUEST['users']);
		$b = $objInitiateUser->updateUser ($abc) ;
		die($b);
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to update user positions at regular interval. 
	 It is called from either automatic.php or manual.php at session user finishes his/her turn.
   ------------------------------------------------------------------------------------------------------------------------------------
*/
	public function updateUserPosition ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$abc = explode("," , $_REQUEST['users']);
		$b = $objInitiateUser->updateUserPosition ($abc ,  $_REQUEST['user'] , $_REQUEST['pos']) ;
		die($b);
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch the user who is having the turn to roll the dice.
	 It is called from either automatic.php or manual.php page at regular interval.
   ------------------------------------------------------------------------------------------------------------------------------------
*/
	
	public function getChance ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$b = $objInitiateUser->getChance () ;
		if(!empty($b[0]['name']))
		{
			echo json_encode($b[0]['name']);
		}
		else
		{
			return "-1" ;
		}
	
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to fetch the positions of all the opponents. 
	 It is called from either automatic.php or manual.php page at a regular time interval.
   ------------------------------------------------------------------------------------------------------------------------------------
*/

	public function getPosition ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$objInitiateUser->setUser($_REQUEST['user']);
		$b = $objInitiateUser->getPosition () ;
		if(!empty($b[0]['name']))
		{
			for($i = 0 ; $i < count($b) ; $i++)
			{
				$arr[] = $b[$i]['name'];
				$arr[] = $b[$i]['avatar'];
				$arr[] = $b[$i]['position'];
			}
			echo json_encode($arr);
		}
		else
		{
			return "-1" ;
		}
	
	}

/* 
   ------------------------------------------------------------------------------------------------------------------------------------
         Function to set the turn for the first time to start the game. 
	 It is called from either automatic.php or manual.php page once the required opponents are available.
   ------------------------------------------------------------------------------------------------------------------------------------
*/
	public function setChance ()
	{
		require_once SITE_PATH.'/../model/gettersettermodel.php';
		$objInitiateUser = new Register ();
		$abc = explode("," , $_REQUEST['users']);
		$objInitiateUser->setChance ($abc) ;	
	}
	
	


}


$request = "";
if (isset($_GET["method"])) {

    $request = $_GET["method"];
}

$obj = new MyClass();

if (!empty($request)) {
    $obj->$request();
}

?>
