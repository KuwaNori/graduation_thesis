<?php
# functions in this file connects database and return results of SQL executions

require_once("../control/personal.php");

$personal = personal();
$dbconn = pg_connect("host=$personal[0] dbname=$personal[1] user=$personal[2] password=$personal[3]") or die('Could not connect: ' . pg_last_error());

# function for get news

function getNewsList($company_name){
  $rel = getComapnyId($company_name);
  $company_id = $rel["company_id"];
  if($company_id != ""){
    $sql_getnews = "select * from news where company_id = {$company_id};";
    $result = pg_query($sql_getnews) or die('Query failed: ' . pg_last_error());
    return $result;
  }
  return "No news are there";
}

#function for get company ID

function getComapnyId($company_name){
  $sql_getcompanyid = "select * from companys where company_name like '%{$company_name}%'";
  $result = pg_query($sql_getcompanyid) or die('Query failed: ' . pg_last_error());
  $case = pg_fetch_all($result);
  var_dump(count($case));
  if (count($case) == 1){
    return $case[0];
  }
  return $case;
}

 ?>
