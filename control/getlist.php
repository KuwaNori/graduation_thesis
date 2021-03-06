<?php
# functions in this file connects database and return results of SQL executions

require_once("../control/personal.php");

$personal = personal();
$dbconn = pg_connect("host=$personal[0] dbname=$personal[1] user=$personal[2] password=$personal[3]") or die('Could not connect: ' . pg_last_error());

# function for get news

function getNewsList($company_id){
  $sql_getnews = "select * from news where company_id like '%{$company_id}%' order by category_id asc;";
  $result = pg_query($sql_getnews) or die('Query failed: ' . pg_last_error());
  $news_list = pg_fetch_all($result);
  return $news_list;
}

#function for get companies

function getComapnies($company_name){
  $sql_getcompanyid = "select * from companies where company_name like '%{$company_name}%';";
  $result = pg_query($sql_getcompanyid) or die('Query failed: ' . pg_last_error());
  $case = pg_fetch_all($result);
  return $case;
}

function find_category($category){
  $sql = "select * from news where category_id = {$category};";
  $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
  $case = pg_fetch_all($result);
  return $case;
}

function getCompanyName($id){
  $sql = "select company_name from companies where company_id = {$id} ;";
  $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
  $case = pg_fetch_all($result);
  return $case;
}

function getAllCompanies(){
  $sql = "select * from companies order by company_name;";
  $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
  $case = pg_fetch_all($result);
  return $case;
}

function getTop3($id){
    $id = intval($id);
    $sql = "select category_id from news where company_id like '%{$id}%';";
    $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
    $case = pg_fetch_all_columns($result,0);
    $number = count($case);
    $count_values = array_count_values($case);
    asort($count_values);
    return [array_keys($count_values),$number];
    
}

 ?>
