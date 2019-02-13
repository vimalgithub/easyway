<?php
	include(dirname(__FILE__)."/connection.php");
	$pdo=new Connection;
	if(isset($_GET['id']))
	{
		$tablename="ease";
		$condition='id='.$_GET['id'];		
		$other=array(
			'message'=>'Hai',
			'page'=>'registration'	
		);
		$pdo->deletion($tablename,$condition,$other);
	}
	else if(isset($_GET['pid']))
	{
		$pdo->deletion(ease,$_GET['id'],"Item Deleted");		
	}
?>