<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head></head>
  <title></title>
  <body>
<?php
if(isset($_POST['input_company_name'])){
    $company_name = $_POST['input_company_name'];
    if($company_name != Null){     
        $command = "export LANG=ja_JP.UTF-8; /usr/bin/python3 ../scrape/scrape_main.py {$company_name} 2>&1";           
        exec($command, $output, $return_var);
        # sleep(10);
        foreach($output as $v){
                echo("{$v}<br>");
        }
        # 1 なら失敗
        echo($return_var);
    } else {
        echo("company_name is null");
    }
} else{
        echo("we cannot get post<br>");
        echo("<a href='../view/news.php'>検索画面へ</a>");
}
    ?>
  </body>
</html>


