<?php

class PmLogikHook {
  

	function createSubject($bean , $event, $arguments){
		global $db;
		//echo"hello";
		if(strlen($bean->description) > 250)
		 $bean->description = substr($bean->description, 0,250).'...';

		

		

	}
	
}

?>