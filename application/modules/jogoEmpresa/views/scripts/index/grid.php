<?php
require_once 'jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
//$grid->SelectCommand = 'SELECT CustomerID, CompanyName, Phone, PostalCode, City FROM customers';
$grid->SelectCommand = 'SELECT cid_cod, e.est_nome, cid_nome FROM cidade as c, estado as e where c.est_cod = e.est_cod';
// Set the table to where you add the data
//$grid->table = 'customers';
//$grid->setPrimaryKeyId('CustomerID');
$grid->table = 'cidade';
$grid->setPrimaryKeyId('cid_cod');
$grid->serialKey = false;
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
//    "sortname"=>"CustomerID"
    "sortname"=>"cid_cod"
));
// The primary key should be entered
//$grid->setColProperty('CustomerID', array("editrules"=>array("required"=>true)));
$grid->setColProperty('cid_cod', array("editrules"=>array("required"=>true)));
// Enable navigator
$grid->navigator = true;
// Enable only deleting
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>true,"edit"=>true,"del"=>true,"view"=>false, "search"=>true));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
