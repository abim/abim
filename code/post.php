<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     template-landing
*/
@include ("../x0x/render.php");

$NODE = "Post";
@include ("con.php");
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
?>

<div class="page-header">
  <h3><div><img src="<?php echo x_IMG;?>/flask.svg" alt="" style="max-width:1.5em;" /> <?php echo $NODE_PARENT." <small>".$NODE."</small>";?></div></h3>
</div>



<section id="tables">
  <div class="row">
    <div class="col-md-2">
      <ul class="nav nav-list">
        <li class="nav-header">Code Menus</li>
        <li><a href="./">List Article<span class="badge pull-right">19</span></a></li>
        <li class="active"><a href="#post">New Post<span class="badge pull-right">add</span></a></li>
        <li class="divider"></li>
        <li class="nav-header">Attribute</li>
        <li><a href="#fakelink">Category<span class="badge pull-right">69</span></a></li>
        <li><a href="#fakelink">Tags<span class="badge pull-right">21</span></a></li>
        <li><a href="#fakelink">Settings<span class="fui-gear pull-right"></span></a></li>
      </ul>
    </div> <!-- /nav-list -->

    <div class="col-md-10">
<?php
/**
add new
*/
if(isset($_POST['FormSubmit']) && !empty($_POST['name'])) {
  $code = createCode();
  $slug = createSlug(trim($_POST['name']));
  $slug_model = createSlug(trim($_POST['model']));

  $insert_id = $sql -> db_Insert("3E_products", "'0', '".$code."', '".$_POST['desc']."', '".trim($_POST['name'])."', 'approve', '".$slug."', '".trim($_POST['model'])."', '".$slug_model."', '0000-00-00' , '0', '".DATE("Y-m-d H:i:s")."', '0', '' ");
  $sql -> db_Insert("3E_codebank", "'0', '".$code."', '".$insert_id."' ");
  $sql -> db_Insert("3E_relation", "'".$insert_id."', '".$_POST['brand']."', '".$_POST['departement']."', '".USERID."', '0', '0', '0', '0', '0', '0', '0' ");

  $sql -> db_Insert("3E_meta_product", "'0','".$insert_id."', 'post_date', '".DATE("Y-m-d H:i:s")."' ");

  setcookie ("IN_product", $_POST['name'], (time()+100)); //add cookie

  setcookie ("IN_departement", $_POST['departement'], (time()-900)); //delete cookie
  setcookie ("IN_departement", $_POST['departement'], (time()+900)); //add cookie
  setcookie ("IN_brands", $_POST['brand'], (time()-900)); //delete cookie
  setcookie ("IN_brands", $_POST['brand'], (time()+900)); //add cookie

  return _redirect ( "?sip" );
}
if(x_QUERY == "sip"){
  echo "
    <div class=\"alert alert-success\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      <strong>Success</strong>. <span class=\"label label-success\">{$_COOKIE['IN_product']}</span>
    </div>
    ";
    setcookie ("IN_product", $_POST['name'], (time()-100)); //delete cookie
}
?>
      <h6>Add Code Article</h6>
      <form class="form-horizontal" method='post' action='<?php echo x_SELF;?>'>
      <fieldset>
        <div class="col-md-7">
          <div class="form-group">
            <div class="col-sm-12">
              <input type="text" id="name" name="name" placeholder="Title Article" class="form-control input-lg" >
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <textarea type="text" id="desc" name="desc" rows="10" class="form-control" placeholder="Article Contents"></textarea>
            </div>
          </div>

          
        </div>

        <div class="col-md-4 pull-right">
          <div class="form-group">
            <label class="control-label" for="departement">Category</label>
            <div class="mbl">
              <select id="departement" name="departement" class="col-sm-3 form-control select select-primary" data-toggle="select">
                <?php
                $sql -> db_Select("3E_departement D", "D.departement_id ID, D.name", "WHERE D.parent='0' GROUP BY ID");
                while($row = $sql-> db_Fetch()){
                  (($_COOKIE['IN_departement'] == $row['ID']) ? $selected = " selected" : $selected = ""); //cookie
                  echo "<option value=\"{$row['ID']}\"{$selected}>{$row['name']}</option>\n";
                  view_child($row['ID'], 1, $_COOKIE['IN_departement']);
                }
                ?>
              </select>
            </div>
          </div>

          <div id="ajax_select_brand"></div>

          <div class="form-group">
            <label class="control-label" for="departement">Tags</label>
            <div class="tagsinput-primary">
              <input name="tagsinput-02" class="tagsinput" data-role="tagsinput" value="School, Teacher, Colleague" />
            </div>
          </div>
          
          <div class="form-group">
            <button type="submit" name="FormSubmit" value="submit" class="btn btn-large btn-info">Add New</button>
          </div>

        </div>
        </fieldset>
      </form>
    
    </div>
  </div>
</section>
<?php
/**

*/
function view_child($parent="0", $level="0", $cookie="") {
  $sqld = new db;
  $sqld -> db_Select("3E_departement", "departement_id ID,name", "WHERE parent='{$parent}'");
  while ($row = $sqld-> db_Fetch()) {
    (($cookie == $row['ID']) ? $selected = " selected" : $selected = ""); //cookie
    echo "<option value=\"{$row['ID']}\"{$selected}>".str_repeat('├',$level)." {$row['name']}</option>\n";
    view_child($row['ID'], $level+1, $cookie);

  }
}
/**
jquery
*/

$SCRIPT_FOOTER = "
<script type=\"text/javascript\">
$(document).ready(function() {
  $(\"#departement\").change(function() { 
    var id=$(this).val();
    var dataString = 'departement_id='+ id;

    $.ajax({
      type: \"GET\",
      url: \"ajax_select_brands.php\",
      data: dataString,
      cache: false,
      success: function(html){
        $(\"#ajax_select_brand\").html(html);
      } 

    });
  });
});

$(document).ready(function() {  
    $('#departement').change();
});
</script>";
?>
<!--<script type="text/javascript" src="date.js"></script>-->
<?php
@include (x_PATH."/footer.php");
?> 