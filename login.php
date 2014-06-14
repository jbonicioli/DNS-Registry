<?php
/*-----------------------------------------------------------------------------
* Domain Registry Control Panel                                               *
*                                                                             *
* Developed by Vaggelis Koutroumpas - vaggelis@koutroumpas.gr                 *
* www.koutroumpas.gr  (c)2014                                                 * 
*-----------------------------------------------------------------------------*/

require("includes/config.php");
require("includes/functions.php");


if (admin_logged()) {
    if ($_GET[action] == "logout") {
        admin_logout();
        if ($return = $_GET['return']){
            header("Location: ".urldecode($return));
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }    
} 

if (isset ($_GET['action']) && $_GET['action'] == "login") {

    if ($_POST['username'] && $_POST['password']) {
    
        if (admin_login($_POST['username'], $_POST['password'], $_POST['remember'])){
                    
            if ($return = $_GET['return']){
                header("Location: ".urldecode($return));
                exit;
            } else {
                header("Location: index.php");
                exit;
            }    
            
        } else {
            
            $msg = "Please check your username/password.";
        }
        
    } else {
        $msg = "Please enter your username/password.";
    }
    
// logout
} elseif (isset ($_GET['action']) && $_GET['action'] == "logout") {
    admin_logout();
    $msg = "You have been logged out successfully.";    
}

$maintitle_title = "Login";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- 
*******************************************************************************
* Domain Registry Control Panel                                               *
*                                                                             *
* Developed by Vaggelis Koutroumpas - vaggelis at koutroumpas.gr              *
* www.koutroumpas.gr  (c)<?=date("Y");?>                                                 * 
*******************************************************************************
-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$maintitle_title;?> - <?=$CONF['APP_NAME'];?></title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!-- INCLUDE STYLES & JAVASCRIPTS -->
<link href="./includes/css.php" rel="stylesheet" type="text/css"  media="screen" />
<script type="text/javascript" src="./includes/js.php?login=1"></script> 
<!-- INCLUDE STYLES & JAVASCRIPTS END -->

<script type="text/javascript">
$(function() {
    $('#username').focus();
    
    $("#forgot_dialog").dialog({
        resizable:false, autoOpen: false, modal:true, 'open': function(event, ui){ 
            $('body').css('overflow-x','hidden'); 
        } 
    });
    $(".forgot_trigger").click(function(){
        $("#forgot_dialog").dialog('open');
        return false;
    });
});
</script>

<? if (!1) { ?>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<? } ?>

</head>

<body id="login" style="height: auto;">

    <!-- NO JAVASCRIPT NOTIFICATION START -->
    <noscript>
        <div class="maintitle_nojs">This site needs Javascript enabled to function properly!</div>
    </noscript>
    <!-- NO JAVASCRIPT NOTIFICATION END -->

    <h1 id="login_title"><img src="images/logo.png" alt="<?=$CONF['APP_NAME'];?>" /></h1>
      

    <form id="login_form" name="login_form" method="POST" action="./login.php?action=login&return=<?=$return?>">
        <h1>Login</h1>
        
        <? if (isset ($msg)) { ?><p id="login_message"><?=$msg?></p><? } ?>

        <label for="username">Username:</label>
        <input name="username" id="username" type="text" size="20" maxlength="20" class="input_field" value="<?=$_POST['username']?>" />
        <label for="password">Password: </label>
        <input name="password" id="password" type="password" size="20" maxlength="20" class="input_field" />

        <input type="checkbox" name="remember" id="remember" value="1"<? if ($_POST['remember']) echo " checked=\"checked\"";?> /><label for="remember" style="display:inline"> Remember</label>
        <a href="#" class="forgot_trigger" style="padding-left:10px">Did you forget your password?</a>
        <div class="clr">&nbsp;</div>

        <input type="submit" name="go" id="go" value="Login" class="button_primary" />
    
        <a href="register.php" id="login_message" style="padding-left:10px">Click here to register a new account</a>
        <div class="clr">&nbsp;</div>

    </form>
    <?/*
    <div id="login_credits">
        Developed by <a href="http://www.cha0s.awmn/" target="_blank">Cha0s #2331</a>
    </div>
    */?>
    
    <div id="forgot_dialog" title="Did you forget your password?" style="display:none">
        <p>If you lost your password contact the Administrator on this email: <br /><br /><a href="mailto:<?=$CONF['MAIL_SUPPORT']?>"><?=$CONF['MAIL_SUPPORT']?></a>.</p>
    </div>
    
</body>
</html>