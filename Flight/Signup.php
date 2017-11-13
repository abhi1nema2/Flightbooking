<?php
$mysql_server = 'localhost';
$mysql_username = 'root';
$mysql_password = '';
$mysql_database = 'flight';
$mysql_table = 'login';
$success_page = './index.php';
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_name']) && $_POST['form_name'] == 'signupform')
{
   $newusername = $_POST['username'];
   $newemail = $_POST['email'];
   $newpassword = $_POST['password'];
   $confirmpassword = $_POST['confirmpassword'];
   $newfullname = $_POST['fullname'];
   $code = 'NA';
   if ($newpassword != $confirmpassword)
   {
      $error_message = 'Password and Confirm Password are not the same!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$]{1,50}$/", $newusername))
   {
      $error_message = 'Username is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$]{1,50}$/", $newpassword))
   {
      $error_message = 'Password is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $newfullname))
   {
      $error_message = 'Fullname is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^.+@.+\..+$/", $newemail))
   {
      $error_message = 'Email is not a valid email address. Please check and try again.';
   }
   if (empty($error_message))
   {
      $db = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
      if (!$db)
      {
         die('Failed to connect to database server!<br>'.mysqli_error($db));
      }
      mysqli_select_db($db, $mysql_database) or die('Failed to select database<br>'.mysqli_error($db));
      mysqli_set_charset($db, 'utf8');
      $sql = "SELECT username FROM ".$mysql_table." WHERE username = '".$newusername."'";
      $result = mysqli_query($db, $sql);
      if ($data = mysqli_fetch_array($result))
      {
         $error_message = 'Username already used. Please select another username.';
      }
   }
   if (empty($error_message))
   {
      $crypt_pass = md5($newpassword);
      $newusername = mysqli_real_escape_string($db, $newusername);
      $newemail = mysqli_real_escape_string($db, $newemail);
      $newfullname = mysqli_real_escape_string($db, $newfullname);
      $sql = "INSERT `".$mysql_table."` (`username`, `password`, `fullname`, `email`, `active`, `code`) VALUES ('$newusername', '$crypt_pass', '$newfullname', '$newemail', 1, '$code')";
      $result = mysqli_query($db, $sql);
      mysqli_close($db);
      $subject = 'Your new account';
      $message = 'A new account has been setup.';
      $message .= "\r\nUsername: ";
      $message .= $newusername;
      $message .= "\r\nPassword: ";
      $message .= $newpassword;
      $message .= "\r\n";
      $header  = "From: "."\r\n";
      $header .= "Reply-To: "."\r\n";
      $header .= "MIME-Version: 1.0"."\r\n";
      $header .= "Content-Type: text/plain; charset=utf-8"."\r\n";
      $header .= "Content-Transfer-Encoding: 8bit"."\r\n";
      $header .= "X-Mailer: PHP v".phpversion();
      mail($newemail, $subject, $message, $header);
      header('Location: '.$success_page);
      exit;
   }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<title>Untitled Page</title>

<link href="Untitled1.css" rel="stylesheet">
<link href="Signup.css" rel="stylesheet">
</head>
<body>
<script>

	function validateform()

	{

		var name=document.myform.name.value;

		var password=document.myform.password.value;

		

		if(name==null||name=="")

		{

			document.getElementById("pic").src="unchecked.png";

			document.getElementById("demo").innerHTML = "Name can't be blank";

			return false;

		}

		else

		{

			document.getElementById("pic").src="checked.png";

			document.getElementById("demo").innerHTML = "Correct";

		}

		

		if(password.length<6)

		{

			alert("Password must be at least 6 characters long");

			return false;	

		} 

		

		var secondpassword=document.myform.password2.value;

		if(password!=secondpassword)

		{

			alert("Password must be same!");

			return false;

		}

		

		var x=document.myform.email.value;

		var atposition=x.indexOf("@");

		var dotposition=x.lastIndexOf(".");

		if(atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length)

		{

			alert("Please enter a valid email address");

			return false;

		}

		alert("Successfully registered!");

	}

</script>

<div id="container">
<a href="http://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb12.png" alt="WYSIWYG Web Builder" style="position:absolute;left:441px;top:967px;border-width:0;z-index:250"></a>
<div id="wb_Signup1" style="position:absolute;left:14px;top:91px;width:277px;height:396px;z-index:1;">
<form name="signupform" method="post" accept-charset="UTF-8" action="<?php echo basename(__FILE__); ?>" id="signupform">
<input type="hidden" name="form_name" value="signupform">
<table id="Signup1">
<tr>
   <td class="header">Sign up for a new account</td>
</tr>
<tr>
   <td class="label"><label for="fullname">Full Name</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="fullname" type="text" id="fullname"></td>
</tr>
<tr>
   <td class="label"><label for="username">User Name</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="username" type="text" id="username"></td>
</tr>
<tr>
   <td class="label"><label for="password">Password</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="password" type="password" id="password"></td>
</tr>
<tr>
   <td class="label"><label for="confirmpassword">Confirm Password</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="confirmpassword" type="password" id="confirmpassword"></td>
</tr>
<tr>
   <td class="label"><label for="email">E-mail</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="email" type="text" id="email"></td>
</tr>
<tr>
   <td><?php echo $error_message; ?></td>
</tr>
<tr>
   <td style="text-align:center;vertical-align:bottom"><input class="button" type="submit" name="signup" value="Create User" id="signup"></td>
</tr>
</table>
</form>
</div>
<div id="wb_TabMenu1" style="position:absolute;left:3px;top:49px;width:978px;height:45px;z-index:2;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="#">Book</a></li>
<li><a href="./Signup.php" class="active">Signup</a></li>
<li><a href="./index.php">Signin</a></li>
<li><a href="#">Contact us</a></li>
</ul>
</div>
<div id="wb_Heading1" style="position:absolute;left:20px;top:10px;width:319px;height:44px;z-index:3;">
<h1 id="Heading1">Fight Reservation<br></h1></div>
</div>
</body>
</html>