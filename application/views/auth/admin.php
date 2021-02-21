<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form method="post" action="<?php echo site_url('giveme-access');?>" style="position: absolute;
    top: 30%;left: 50%;margin-left: -150px;">
	<input type="text" name="username" id="username" autocomplete="off" style="width: 100%;
	height: 30px;font-size: 20px;border: 3px solid;"><br><br>
	<input type="password" name="password" id="password" autocomplete="off" style="width: 100%;
	height: 30px;font-size: 30px;border: 3px solid;">
	<input type="submit" style="position: absolute; left: -9999px"/>
</form>
