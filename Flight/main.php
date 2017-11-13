<?php
if (session_id() == "")
{
   session_start();
}
if (!isset($_SESSION['username']))
{
   header('Location: ./index.php');
   exit;
}
if (isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
   }
   else
   {
      unset($_SESSION['username']);
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      header('Location: ./index.php');
      exit;
   }
}
if (session_id() == "")
{
   session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_name']) && $_POST['form_name'] == 'logoutform')
{
   if (session_id() == "")
   {
      session_start();
   }
   unset($_SESSION['username']);
   unset($_SESSION['fullname']);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Page</title>
<meta name="generator" content="WYSIWYG Web Builder 12 Trial Version - http://www.wysiwygwebbuilder.com">
<link href="base/jquery-ui.min.css" rel="stylesheet">
<link href="Untitled1.css" rel="stylesheet">
<link href="main.css" rel="stylesheet">
<script src="jquery-1.12.4.min.js"></script>
<script src="jquery-ui.min.js"></script>
<script src="fancybox/jquery.easing-1.3.pack.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css">
<script src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script>
function displaylightbox(url, options)
{
   options.padding = 0;
   options.autoScale = true;
   options.href = url;
   options.type = 'iframe';
   $.fancybox(options);
}
</script>
<script>
$(document).ready(function()
{
   var jQueryDatePicker1Options =
   {
      dateFormat: 'mm/dd/yy',
      changeMonth: false,
      changeYear: false,
      showButtonPanel: false,
      showAnim: 'show'
   };
   $("#jQueryDatePicker1").datepicker(jQueryDatePicker1Options);
   $("#jQueryDatePicker1").datepicker("setDate", "");
   $("#jQueryDatePicker1").change(function()
   {
      $('#jQueryDatePicker1_input').attr('value',$(this).val());
   });
   var jQueryDatePicker2Options =
   {
      dateFormat: 'mm/dd/yy',
      changeMonth: false,
      changeYear: false,
      showButtonPanel: false,
      showAnim: 'show'
   };
   $("#jQueryDatePicker2").datepicker(jQueryDatePicker2Options);
   $("#jQueryDatePicker2").datepicker("setDate", "");
   $("#jQueryDatePicker2").change(function()
   {
      $('#jQueryDatePicker2_input').attr('value',$(this).val());
   });
});
</script>
</head>
<body>
<div id="container">
<a href="http://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb12.png" alt="WYSIWYG Web Builder" style="position:absolute;left:441px;top:967px;border-width:0;z-index:250"></a>
<div id="wb_Heading1" style="position:absolute;left:20px;top:10px;width:319px;height:44px;z-index:1;">
<h1 id="Heading1">Fight Reservation<br></h1></div>
<div id="wb_TabMenu1" style="position:absolute;left:3px;top:49px;width:978px;height:45px;z-index:2;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="javascript:displaylightbox('./main.php',{Loginbeforebooking})" target="_self" class="active">Book</a></li>
<li><a href="./Signup.php">Signup</a></li>
<li><a href="./index.php">Signin</a></li>
<li><a href="#">Contact us</a></li>
</ul>
</div>

<div id="wb_LoginName1" style="position:absolute;left:805px;top:34px;width:154px;height:60px;z-index:4;">
<span id="LoginName1">Welcome <?php
if (isset($_SESSION['username']))
{
   echo $_SESSION['username'];
}
else
{
   echo 'Not logged in';
}
?>!</span></div>
<div id="wb_Logout1" style="position:absolute;left:847px;top:54px;width:84px;height:18px;z-index:5;">
<form name="logoutform" method="post" action="<?php echo basename(__FILE__); ?>" id="logoutform">
<input type="hidden" name="form_name" value="logoutform">
<input type="submit" name="logout" value="Logout" id="Logout1">
</form>
</div>
<select name="Combobox1" size="1" id="Combobox1" style="position:absolute;left:20px;top:128px;width:171px;height:28px;z-index:6;">
<option>Jaipur</option>
<option>Delhi</option>
<option>Chennai</option>
<option>Hyderabad</option>
</select>
<label for="" id="Label1" style="position:absolute;left:20px;top:104px;width:53px;height:16px;line-height:16px;z-index:7;">From</label>
<select name="Combobox1" size="1" id="Combobox2" style="position:absolute;left:229px;top:128px;width:171px;height:28px;z-index:8;">
<option>Jaipur</option>
<option>Delhi</option>
<option>Chennai</option>
<option>Hyderabad</option>
</select>
<label for="" id="Label2" style="position:absolute;left:229px;top:104px;width:53px;height:16px;line-height:16px;z-index:9;">To</label>
<textarea name="TextArea2" id="TextArea2" style="position:absolute;left:466px;top:130px;width:29px;height:15px;z-index:10;" rows="1" cols="2" spellcheck="false"></textarea>
<label for="" id="Label3" style="position:absolute;left:441px;top:104px;width:80px;height:16px;line-height:16px;z-index:11;">Passenger(s)</label>
<input id="jQueryDatePicker1_input" name="jQueryDatePicker1" style="display:none" type="text" value="">
<div id="jQueryDatePicker1" style="position:absolute;left:20px;top:207px;width:238px;height:225px;z-index:12;">
</div>
<label for="" id="Label4" style="position:absolute;left:20px;top:177px;width:139px;height:16px;line-height:16px;z-index:13;">Departure Date</label>
<input id="jQueryDatePicker2_input" name="jQueryDatePicker2" style="display:none" type="text" value="">
<div id="jQueryDatePicker2" style="position:absolute;left:287px;top:207px;width:238px;height:225px;z-index:14;">
</div>
<label for="" id="Label5" style="position:absolute;left:287px;top:177px;width:139px;height:16px;line-height:16px;z-index:15;">Return Date</label>
<input type="button" id="Button1" name="Search" value="Search" style="position:absolute;left:40px;top:418px;width:96px;height:25px;z-index:16;">
</div>
</body>
</html>