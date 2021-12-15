<?php
function echo_companies($all_companies){
    foreach($all_companies as $value){
        echo "<form method='get' action='./candidates.php' name='candi{$value['company_id']}' id='word{$value['company_id']}'>";
        echo "<input type='hidden' name='input_company_name' value='{$value['company_name']}'>";
        echo "・<a href='javascript:candi{$value['company_id']}.submit()'>{$value["company_name"]}</a></form>";
    }
}

function echo_cate_news($category_results,$category_id){
        $img_url = getImgUrl($category_id);
        foreach ($category_results as $line){
            $current_id = $line["company_id"];
            if($current_id != $last_id){
                $result = getCompanyName($current_id);
                $company_name_ct = $result[0]["company_name"];
                $last_id = $line["company_id"];
            }
          echo "<div class='newsbox'><a href='{$line['news_url']}' class='linkto'><div class='linkbutton'>";
          echo "<img class='news_cate' src='{$img_url}'>";
          echo "<p class='title'>{$company_name_ct}<br>{$line['news_title']}<br>{$line['news_date']}</p></div></a></div>";
        }
}

function echo_news($news_list){
    foreach ($news_list as $line){
        $img_url = getImgUrl($line["category_id"]);
        echo "<div class='newsbox'><a href='{$line['news_url']}' class='linkto'><div class='linkbutton'>";
        echo "<img class='news_cate' src='{$img_url}' alt=''>";
        echo "<p class='title'>{$line["news_title"]}<br>{$line['news_date']}</p></div></a></div>";
    }
}


?>
