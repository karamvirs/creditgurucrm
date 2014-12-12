<?php
echo $_REQUEST['actionfunction']."::::";
echo $data['page'];
/*
if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];

 call_user_func($actionfunction,$_REQUEST,$con,$limit);
}
function showData($data,$con,$limit){
 $page = $data['page'];
 if($page==1){
 $start = 0;
 }
 else{
 $start = ($page-1)*$limit; 
 }
*/
?>