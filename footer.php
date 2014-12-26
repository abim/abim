<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     template-footer
*/
?>
</div> <!-- /container -->

<footer>
<div class="dialog dialog-success">
  <p>&copy;2015 <span class="text-primary">Abim Labs</span> <span class="label label-inverse"><?php echo x_APPVER;?></span></p>
</div> <!-- /dialog -->
</footer>

<script src="<?php echo x_BASE;?>/static/js/vendor/jquery.min.js"></script>
<script src="<?php echo x_BASE;?>/static/js/flat-ui-pro.min.js"></script>
<script src="<?php echo x_BASE;?>/static/js/application.js"></script>
<?php

if(isset($SCRIPT_FOOTER)) {
echo $SCRIPT_FOOTER;
}

if(!empty($nav)) {
echo "
<script>
$(document).ready(function(){
$('.navbar-nav li.$nav').addClass('active');
";
if(!empty($sub_nav)){
  echo "$('.dropdown-menu li.$sub_nav').addClass('active');";
}
echo "
});
</script>";
}
?>
</body>
</html>
<?php 
if(isset($sql)) { $sql->db_Close();}
//if(isset($sql2)) { $sql2->db_Close();}
//if(isset($xsql)) { $xsql->db_Close();}
?>