<?php
include ("../x0x/db_class.php");
$sqlx = new db;
$sqlx -> db_SetErrorReporting(FALSE);
$sqlx -> db_Connect($MySQLHost, $MySQLUser, $MySQLPasswd, $MySQLDb);

if(isset($_GET['departement_id'])) {
	$sqlx -> db_Select("`3E_brands_dep` BD LEFT JOIN `3E_brands` B ON BD.brand_id=B.brand_id", "B.brand_id ID, B.name", "WHERE BD.departement_id ='{$_GET['departement_id']}'");
	if ($sqlx-> db_Rows()) {

	echo "<div class=\"form-group\">
          <label class=\"control-label col-sm-3 text-right\" for=\"brand\">Brand</label>
          <div class=\"col-sm-9 mbl\">
            <div class=\"col-sm-6\">
            <select id=\"brand\" name=\"brand\" class=\"form-control select select-primary\" data-toggle=\"select\">";
		while($rowx = $sqlx-> db_Fetch())
		{
		    (($_COOKIE['IN_brands'] == $rowx['ID']) ? $selected = " selected" : $selected = ""); //cookie
		    echo "<option value=\"{$rowx['ID']}\"{$selected}>{$rowx['name']}</option>";
		}
	echo"</select>
            </div>
          </div>
        </div>";
    }
}
?>