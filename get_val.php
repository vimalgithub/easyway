<?php
	include(dirname(__FILE__)."/connection.php");
	$pdo=new Connection;
	$checker=array_pop($_POST);
	$data=($_POST);	
	$data['photo']=$pdo->file_upload($_FILES);
	switch($checker)
	{
		case 'register':
			$tablename="ease";
			$other=array(
				'message'=>'Hai',
				'page'=>'registration'	
			);
		break;
		default:
			echo 'No Button Click';
	}
	//$ins=new Insertion($tablename,$data,$other);
	$pdo->Insert($tablename,$data,$other);
	$pdo->Close();		
?>