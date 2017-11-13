<?php
   session_start();
   error_reporting(0);
   define('ADMIN_PASS', '5f4dcc3b5aa765d61d8327deb882cf99');
   $session_timeout = 600;
   $mysql_server = 'localhost';
   $mysql_username = 'root';
   $mysql_password = '';
   $mysql_database = 'flight';
   $mysql_table = 'login';
   $admin_password = isset($_COOKIE['admin_password']) ? $_COOKIE['admin_password'] : '';
   if (empty($admin_password))
   {
      if (isset($_POST['admin_password']))
      {
         $admin_password = md5($_POST['admin_password']);
         if ($admin_password == ADMIN_PASS)
         {
            setcookie('admin_password', $admin_password, time() + $session_timeout);
         }
      }
   }
   else
   if ($admin_password == ADMIN_PASS)
   {
      setcookie('admin_password', $admin_password, time() + $session_timeout);
   }
   $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
   $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $active = isset($_POST['active']) ? $_POST['active'] : 0;
   $db = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
   if (!$db)
   {
      die('Failed to connect to database server!<br>'.mysqli_error($db));
   }
   mysqli_select_db($db, $mysql_database) or die('Failed to select database<br>'.mysqli_error($db));
   mysqli_set_charset($db, 'utf8');
   mysqli_query($db, 'SET NAMES "UTF8"');
   mysqli_query($db, "SET collation_connection='utf8_general_ci'");
   mysqli_query($db, "SET collation_server='utf8_general_ci'");
   mysqli_query($db, "SET character_set_client='utf8'");
   mysqli_query($db, "SET character_set_connection='utf8'");
   mysqli_query($db, "SET character_set_results='utf8'");
   mysqli_query($db, "SET character_set_server='utf8'");
   if (!empty($action))
   {
      if ($action == 'delete')
      {
         $sql = "DELETE FROM ".$mysql_table." WHERE `username` = '$id'";
         mysqli_query($db, $sql);
         mysqli_close($db);
         header('Location: '.basename(__FILE__));
         exit;
      }
      else
      if ($action == 'update')
      {
         $sql = "UPDATE `".$mysql_table."` SET `username` = '$username', ";
         if (!empty($_POST['password']))
         {
            $crypt_pass = md5($_POST['password']);
            $sql = $sql . "`password` = '$crypt_pass',";
         }
         $sql = $sql . " `fullname` = '$fullname', `email` = '$email', `active` = $active WHERE `username` = '$id'";
         mysqli_query($db, $sql);
         mysqli_close($db);
         header('Location: '.basename(__FILE__));
         exit;
      }
      else
      if ($action == 'create')
      {
         $sql = "SELECT username FROM ".$mysql_table." WHERE username = '".$_POST['username']."'";
         $result = mysqli_query($db, $sql);
         if ($data = mysqli_fetch_array($result))
         {
            echo 'User already exists!';
            exit;
         }
         $crypt_pass = md5($_POST['password']);
         $sql = "INSERT `".$mysql_table."` (`username`, `password`, `fullname`, `email`, `active`) VALUES ('$username', '$crypt_pass',  '$fullname', '$email', $active)";
         mysqli_query($db, $sql);
         mysqli_close($db);
         header('Location: '.basename(__FILE__));
         exit;
      }
      else
      if ($action == 'logout')
      {
         session_unset();
         session_destroy();
         setcookie('admin_password', '', time() - 3600);
         header('Location: '.basename(__FILE__));
         exit;
      }
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User Administrator Login</title>
<style type="text/css">
body
{
   background-color: #FFFFFF;
   margin: 0;
}
p
{
   font-size: 13px;
   font-family: Arial;
   font-weight: normal;
   text-decoration: none;
   color: #000000;
}
th
{
   font-size: 13px;
   font-family: Arial;
   font-weight: normal;
   text-decoration: none;
   background-color: #878787;
   color: #FFFFFF;
   text-align: left;
}
td
{
   font-size: 13px;
   font-family: Arial;
   font-weight: normal;
   text-decoration: none;
   color: #000000;
}
input, select
{
   font-size: 13px;
   font-family: Arial;
   font-weight: normal;
   text-decoration: none;
   color: #000000;
   border:1px #000000 solid;
}
</style>
</head>
<body>
<?php
   if ($admin_password != ADMIN_PASS)
   {
      echo "<center>\n";
      echo "<p>User Administrator Login</p>\n";
      echo "<form method=\"post\" accept-charset=\"UTF-8\" action=\"" .basename(__FILE__) . "\">\n";
      echo "<input type=\"password\" name=\"admin_password\" size=\"20\" />\n";
      echo "<input type=\"submit\" value=\"Login\" name=\"submit\" />\n";
      echo "</form>\n";
      echo "</center>\n";
   }
   else
   {
      if (!empty($action))
      {
         if (($action == 'edit') || ($action == 'new'))
         {
            $username_value = '';
            $fullname_value = '';
            $email_value = '';
            $active_value = '';
            $sql = "SELECT * FROM ".$mysql_table." WHERE username = '".$id."'";
            $result = mysqli_query($db, $sql);
            if ($data = mysqli_fetch_array($result))
            {
               $username_value = $data['username'];
               $fullname_value = $data['fullname'];
               $email_value = $data['email'];
               $active_value = $data['active'];
            }
            echo "<center>\n";
            echo "<form action=\"" . basename(__FILE__) . "\" accept-charset=\"UTF-8\" method=\"post\">\n";
            echo "<table border=\"0\">\n";
            if ($action == 'new')
            {
               echo "<input type=\"hidden\" name=\"action\" value=\"create\">\n";
            }
            else
            {
               echo "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
            }
            echo "<input type=\"hidden\" name=\"id\" value=\"". $id . "\">\n";
            echo "<tr><td>Username:</td>\n";
            echo "<td><input type=\"text\" size=\"50\" name=\"username\" value=\"" . $username_value . "\"></td></tr>\n";
            echo "<tr><td>Password:</td>\n";
            echo "<td><input type=\"password\" size=\"50\" name=\"password\" value=\"\"></td></tr>\n";
            echo "<tr><td>Fullname:</td>\n";
            echo "<td><input type=\"text\" size=\"50\" name=\"fullname\" value=\"" . $fullname_value . "\"></td></tr>\n";
            echo "<tr><td>Email:</td>\n";
            echo "<td><input type=\"text\" size=\"50\" name=\"email\" value=\"" . $email_value . "\"></td></tr>\n";
            echo "<tr><td>Active:</td>\n";
            echo "<td style=\"text-align:left\"><select name=\"active\" size=\"1\"><option " . ($active_value == "0" ? "selected " : "") . "value=\"0\">Not active</option><option " . ($active_value != "0" ? "selected " : "") . "value=\"1\">Active</option></select></td></tr>\n";
            echo "<tr><td>&nbsp;</td><td style=\"text-align:left\"><input type=\"submit\" name=\"cmdSubmit\" value=\"Save\">";
            echo "&nbsp;&nbsp;";
            echo "<input type=\"reset\" name=\"cmdReset\" value=\"Reset\">&nbsp;&nbsp;";
            echo "<input type=\"button\" name=\"cmdBack\" value=\"Back\" onclick=\"location.href='" . basename(__FILE__) . "'\"></td></tr>\n";
            echo "</table>\n";
            echo "</form>\n";
            echo "</center>\n";
         }
      }
      else
      {
         echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">\n";
         echo "<tr><th>Username</th>\n";
         echo "<th>Fullname</th>\n";
         echo "<th>Email</th>\n";
         echo "<th>Active</th>\n";
         echo "<th>Action</th></tr>\n";
         $sql = "SELECT * FROM ".$mysql_table;
         $result = mysqli_query($db, $sql);
         while ($data = mysqli_fetch_array($result))
         {
            echo "<tr>\n";
            echo "<td>" . $data['username'] . "</td>\n";
            echo "<td>" . $data['fullname'] . "</td>\n";
            echo "<td>" . $data['email'] . "</td>\n";
            echo "<td>" . ($data['active'] == "0" ? "not active" : "active") . "</td>\n";
            echo "<td>\n";
            echo "   <a href=\"" . basename(__FILE__) . "?action=edit&id=" . $data['username'] . "\">Edit</a> | \n";
            echo "   <a href=\"" . basename(__FILE__) . "?action=delete&id=" . $data['username'] . "\">Delete</a>\n";
            echo "</td>\n";
            echo "</tr>\n";
         }
         echo "</table>\n";
         echo "<p><a href=\"" . basename(__FILE__) . "?action=new\">Create new user</a>&nbsp;&nbsp;<a href=\"" . basename(__FILE__) . "?action=logout\">Logout</a></p>\n";
      }
   }
?>
</body>
</html>
