<?php

require '/../../common/class.common.php'; //very important include in every new page before using session globaluser

require 'header.php';
require 'menu.php';


session_start();

if (isset($_SESSION["globalUser"])){

	//retreving the logged user from the session 
	$globalUser = $_SESSION["globalUser"];
	//$id = $globalUser[0];
	//echo $id->getID();
	//finding the complete permission list
	$globalPermission = getAllPermissions($globalUser);
  	//echo $globalUser->getID();
  	//storing in the session
  	$_SESSION["globalPermission"] = $globalPermission;
  	//echo $globalPermission[1];
    //print_r($globalPermission);
  	echo 'Login successful<br>';
  	header("Location:../ques/view.question.php");
}




require 'footer.php';



//return only the unique permissions a user has on the system
function getAllPermissions($User){

	//get all roles from user
	$Roles = $User->getRoles();
	
	$AllPermissions=array();
	
	foreach ($Roles as $Role) {
		
		//get all the permissions available in a role
		$Permissions = $Role->getPermissions();

		//iterate over the permission list
		foreach ($Permissions as $Permission) {
			
			//if a permission not available in the global list then add it
			if(!in_array($Permission->getID(), $AllPermissions)){

				//adding the permission to the global permission list
				$AllPermissions[]=$Permission->getID();

			}
		}

	}

	return $AllPermissions;
}

?>