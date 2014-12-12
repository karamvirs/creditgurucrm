<?php
include('login.php');//includes login script
?>

<!DOCTYPE html>
<html class="bg-black">

    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="" method="post">
			<span><?php echo $error; ?></span>
                <div class="body bg-gray">
                    <div class="form-group">
					
                        <input type="text" name="username" id="name" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
				
                        <input type="password" name="password"  id="password" class="form-control" placeholder="**********"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer"> 
					<input type="submit" value=" Login " name="submit" class="btn bg-olive btn-block"/>				
                   <!-- <p><a href="#">I forgot my password</a></p>-->
                    
                </div>
            </form>

        </div>


    </body>
</html>