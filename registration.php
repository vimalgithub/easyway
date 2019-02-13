<?php
	include(dirname(__FILE__)."/connection.php");
	include(dirname(__FILE__)."/header.php");
	$pdo=new Connection;	
?>
<div class="container"><!-- container class is used to centered  the body of the browser with some decent width-->  
    <div class="row"><!-- row class is used for grid system in Bootstrap-->  
        <div class="col-md-4 col-md-offset-4"><!--col-md-4 is used to create the no of colums in the grid also use for medimum and large devices-->  
            <div class="login-panel panel panel-success">  
                <div class="panel-heading">  
                    <h3 class="panel-title">Registration</h3>  
                </div>  
                <div class="panel-body">  
                    <form role="form" method="post" action="get_val.php" enctype="multipart/form-data">  
                        <fieldset> 					
                            <div class="form-group">  
                                <input class="form-control" placeholder="Username" name="name" type="text" autofocus>  
                            </div>  
  
                            <div class="form-group">  
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>  
                            </div>  
                            <div class="form-group">  
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">  
                            </div>  
						    <div class="sections">
							  <div class="images">
								<input type="file" name="myfile">
								<div class="pic">
								  add
								</div>
							  </div>
						    </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="register" name="register" >  
  
                        </fieldset>  
                    </form>  
                    <center><b>Already registered ?</b> <br></b><a href="login.php">Login here</a></center><!--for centered text-->  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
<div class="col-md-12"><!--col-md-4 is used to create the no of colums in the grid also use for medimum and large devices-->  
	<div class="login-panel panel panel-success">  
		<div class="panel-heading">  
			<h3 class="panel-title">Registration</h3>  
		</div>   
				<table id="example" class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Photo</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$arguments=array(
								'table'=>'ease',
								'condition'=>1,
								);
								$row=$pdo->fetching($arguments);
								foreach($row as $value)
								{
									extract($value);
									$edit="<a href='get_val.php?id=".$id."'><button>Edit</button></a>";
									$delete="<a href='delete.php?id=".$id."'><button>Delete</button></a>";
									echo 
									"<tr>".
										"<td>".$name."</td>".
										"<td>".$email."</td>".
										"<td><img src=".$photo."></td>".
										"<td>".$edit.' '.$delete."</td>".									
									"</tr>";
								}
							?>						
				</table>
        </div>  
    </div>  
</div> 
<?php
	include(dirname(__FILE__)."/footer.php");
?>