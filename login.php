<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     login_pages
*/
?>

<style>
.form-signin{max-width:330px;padding:15px;margin:0 auto}.form-signin .checkbox,.form-signin .form-signin-heading{margin-bottom:10px}.form-signin .checkbox{font-weight:400}.form-signin .form-control{position:relative;font-size:16px;height:auto;padding:10px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.form-signin .form-control:focus{z-index:2}.form-signin input[type=text]{margin-bottom:-1px;border-bottom-left-radius:0;border-bottom-right-radius:0}.form-signin input[type=password]{margin-bottom:10px;border-top-left-radius:0;border-top-right-radius:0}.account-wall{margin-top:20px;padding:40px 0 20px;background-color:#f7f7f7;-moz-box-shadow:0 2px 2px rgba(0,0,0,.3);-webkit-box-shadow:0 2px 2px rgba(0,0,0,.3);box-shadow:0 2px 2px rgba(0,0,0,.3)}.login-title{color:#555;font-size:18px;font-weight:400;display:block}.profile-img{width:96px;height:96px;margin:0 auto 10px;display:block;-moz-border-radius:50%;-webkit-border-radius:50%;border-radius:50%}.back-home{display:block;margin-top:10px}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo $isiteks;?></h1>
            <div class="account-wall">
                <img class="profile-img" src="<?php echo x_IMG;?>/avatar.jpg" alt="">
                <form class="form-signin" action="<?php echo x_XELF;?>" method="post">
                  <input name="authnama" type="text" class="form-control" placeholder="Username" required autofocus>
                  <input name="authsandi" type="password" class="form-control" placeholder="Password" required>
                  <button name="LoginSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                  <label class="checkbox pull-left"><input name="autologin" type="checkbox" value="remember-me">Remember me</label>
                  <span class="clearfix"></span><input name="redirect_to" type="hidden" value="<?php echo x_XELF;?>" />
                </form>
            </div>
            <a href="/" class="text-center back-home">Back To Home</a>
        </div>
    </div>
</div>
</body>
</html>