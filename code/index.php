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

$NODE = "Dashboard";
@include ("con.php");
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
?>

<div class="page-header">
  <h3><div><img src="<?php echo x_IMG;?>/flask.svg" alt="" style="max-width:1.5em;" /> <?php echo $NODE_PARENT." <small>".$NODE."</small>";?></div></h3>
</div>

<div class="row">  
  <div class="col-sm-6 col-md-8">
    <div class="mbl pbm">
      <ul class="nav nav-pills">
        <li class="active"><a href="./">List Article</a></li>
        <li><a href="post">New Post</a></li>
        <li><a href="post">Category</a></li>
        <li><a href="post">Tags</a></li>
      </ul>
    </div>
  </div>
  <div class="col-sm-6 col-md-4 visible-sm visible-md visible-lg">
    <ul class="breadcrumb">
      <li><a href="<?php echo x_BASE;?>/">Home</a></li>
      <li class="active">Code</li>
    </ul>
  </div>
</div>

<?php

$sql2 = new db;
if(isset($_GET['filter'])) {
  $filter_brand = $_GET['filter'];
  $sql_all_filter = "WHERE brand_id='".$filter_brand."'";
  $brand_names = COMOT('3E_brands','name',"WHERE brand_id='".$filter_brand."'");
  $sql_list_filter = "WHERE R.brand_id='".$filter_brand."' ";

} 
$sql2 -> db_Select("3E_relation", "product_id", $sql_all_filter);
$TOTAL_DATA_TERQUERY = $sql2-> db_Rows();
?>
<div class="row">
  <div class="span7">
    <h3 id="pager"><?php echo $NODE;?> <span class="badge badge-warning"><?php echo ($sql_list_filter ? $brand_names." : ".$TOTAL_DATA_TERQUERY : "All : ".$TOTAL_DATA_TERQUERY);?></span></h3>
  </div>
  <div class="span5">
    <p></p>
    <div class="btn-group pull-right">
      <button class="btn btn-inverse"><?php echo ($sql_list_filter ? $brand_names : "Brands");?></button>
      <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li <?php echo ($sql_list_filter ? "" : "class=active");?>><a tabindex="-1" href="<?php echo x_XELF;?>">All Brands</a></li>
        <?php 
        $sql -> db_Select("3E_brands_dep R LEFT JOIN 3E_brands B ON R.brand_id = B.brand_id", "R.brand_id ID, B.name", "GROUP BY ID");
        while($row = $sql-> db_Fetch()){
          if($row['ID'] == $filter_brand) {$set_active = " class=active";}else{$set_active = "";}
          echo "<li".$set_active."><a tabindex=\"-1\" href=\"".x_XELF."?filter=".$row['ID']."\">".$row['name']."</a></li>";
        }
        ?>
      </ul>
    </div>
  </div>
</div>

  <div class="row">
    <div class="span12">

      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Model</th>
            <th>Brands - Departement</th>
            <th>#ID / <abbr title="Standard Subject Identification Codes">SSIC</abbr></th>
            <th></th>
            <th><i class="icon-time" title="Release Date"></i></th>
            <th><i class="icon-picture" title="Pictures"></i></th>
            <th><i class="icon-th-list" title="Specification"></i></th>
            <th><i class="icon-shopping-cart" title="Prices"></i></th>
            <th><i class="icon-book" title="User Manuals"></i></th>
            <th><i class="icon-download-alt" title="Drivers"></i></th>
            <th><i class="icon-facetime-video" title="Videos"></i></th>
            <th><i class="icon-comment" title="Review"></i></th>
          </tr>
        </thead>
        <tbody>
<?php
$TOTAL_VIEW_PER_HALAMAN = 20;
if(!empty($_GET['p'])) { 
  if($_GET['p']) {
    $CURRENT_PAGE= $_GET['p'];
    if($_GET['p'] == "1") {
      $HALAMAN = 0;
    }else {
      $HALAMAN = ($_GET['p']-1) * $TOTAL_VIEW_PER_HALAMAN;
    }
  }
}else {$HALAMAN = 0; $CURRENT_PAGE=1;}

$sql -> db_Select(
  "`3E_relation` R 
  LEFT JOIN `3E_products` P ON R.product_id = P.ID 
  LEFT JOIN `3E_departement` D ON R.departement_id = D.departement_id 
  LEFT JOIN `3E_brands` B ON R.brand_id = B.brand_id", 
  "R.*, P.ID, P.code, P.name, P.status, P.model, P.release, B.name brands, D.name departement", 
  $sql_list_filter." LIMIT ".$HALAMAN.",".$TOTAL_VIEW_PER_HALAMAN);

$hitung_row = $HALAMAN+1;
while($row = $sql-> db_Fetch()){
  $no_row = $hitung_row++;
  echo "
  <tr>
    <td>{$no_row}.</td>
    <td><a href=\"".x_BASE."/landing/?id={$row['ID']}\">{$row['name']}</a></td>
    <td>{$row['model']}</td>
    <td class=\"text-center\"><span class=\"badge badge-info\">{$row['brands']}</span> <span class=\"badge badge-inverse\">{$row['departement']}</span></td>
    <td><code>{$row['ID']}</code> <code>{$row['code']}</code> <code>{$row['status']}</code></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" class=\"btn btn-mini btn-inverse\"><i class=\"icon-wrench icon-white\"></i></a></td>
    <td class=\"text-center\">".($row['release'] != "0000-00-00" ? "<a class=\"top\"><i class=\"icon-ok\" title=\"{$row['release']}\"></i></a>" : "<a href=\"".x_BASE."/landing/attr.php?action=release&amp;id={$row['ID']}\" data-original-title=\"Release Date\" class=\"top\"><i class=\"icon-remove\"></i></a>")."</td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/images/?id={$row['ID']}\" data-original-title=\"Images\" class=\"top\">".$row['images']."</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" data-original-title=\"Specification\" class=\"top\">".$row['specs']."</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" data-original-title=\"Prices\" class=\"top\">0</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/usermanuals/?id={$row['ID']}\" data-original-title=\"Usermanuals\" class=\"top\">".$row['usermanuals']."</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" data-original-title=\"Drivers\" class=\"top\">".$row['drivers']."</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" data-original-title=\"Videos\" class=\"top\">".$row['videos']."</a></td>
    <td class=\"text-center\"><a href=\"".x_BASE."/landing/?id={$row['ID']}\" data-original-title=\"Review\" class=\"top\">".$row['review_count']."</a></td>
  </tr>
  ";
}
echo "</tbody></table>";

require_once x_PATH.'/x0x/np.class.php';
$page = isset($_GET['p']) ? ((int) $_GET['p']) : 1;
$pagination = (new Pagination());
$pagination->setCurrent($page);
$pagination->setRPP($TOTAL_VIEW_PER_HALAMAN);
$pagination->setTotal($TOTAL_DATA_TERQUERY);
echo "<div class=\"pull-right\">".$pagination->parse()."</div>";
?>
      
      <h4>Legend</h4>
      <p><code><i class="icon-wrench"></i> Edit Product</code></p>
      <p><code><i class="icon-calendar"></i> Release Date</code></p>
      <p><code><i class="icon-picture"></i> Product Images</code></p>
      <p><code><i class="icon-th-list"></i> Product Specifications</code></p>
      <p><code><i class="icon-shopping-cart"></i> Product Price</code></p>
      <p><code><i class="icon-book"></i> User Manuals</code></p>
      <p><code><i class="icon-download-alt"></i> Driver Downloads</code></p>
      <p><code><i class="icon-facetime-video"></i> Product Videos</code></p>
      <p><code>SSIC: Standard Subject Identification Codes</code></p>

      <h4>Development Status</h4>
        <ul class="unstyled">
          <li><i class="icon-pencil"></i> edit</li>
          <li><i class="icon-remove"></i> delete</li>
        </ul>

    </div>
  </div>
</section>
<?php
@include (x_PATH."/footer.php");
?> 