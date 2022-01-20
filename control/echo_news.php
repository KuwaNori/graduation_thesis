<?php
function echo_companies($all_companies){
    foreach($all_companies as $value){
        $results = getTop3($value['company_id']);
        $top3 = $results[0];
        $number = $results[1];
        echo "<div class='companybox'>
            <form method='get' class='cateform' action='./news.php' name='candi{$value['company_id']}' id='word{$value['company_id']}'>
            <input type='hidden' name='input_company_name' value='{$value['company_name']}'>
            <a href='javascript:candi{$value['company_id']}.submit()' class='linkto'>
            <div class='linkbutton'>
                    <div class='news_company'>{$value['company_name']}</div>
                    <div class='under'>
                        <div class='cate_imgs'>";
        if (count($top3) > 0 ){
        echo "<img class='cate' src='../img/sdg_icon_{$top3[0]}_ja_2-290x290.png'>";
        } else{
        echo "<p>ニュースが登録されていません</p>";
        }

        if (count($top3) > 1 ){
        echo "<img class='cate' src='../img/sdg_icon_{$top3[1]}_ja_2-290x290.png'>";
        }
        if (count($top3) > 2 ){
        echo "<img class='cate' src='../img/sdg_icon_{$top3[2]}_ja_2-290x290.png'>";
        }
        echo "</div>
                <div class='news_num'>ニュース数<span class='number'> {$number}</span> 件</div>
                </div>
                </div></a></form></div>";
    }
}


function echo_news($news_list){
    foreach($news_list as $line){
        $img_url = getImgUrl($line['category_id']);
        $current_id = $line["company_id"];
        if($current_id != $last_id){
            $result = getCompanyName($current_id);
            $company = $result[0]["company_name"];
            $last_id = $line["company_id"];
        }
        echo "<div class='newsbox'>
            <a href='{$line['news_url']}' class='linkto'>
            <div class='linkbutton'>
                <div class='newsleft'>
                    <img class='news_cate' src='{$img_url}'>
                    <p class='news_time'>{$line['news_date']}</p>
                </div>
                <div class='newsright'>
                    <div class='news_company'>{$company}</div>
                    <p class='title'>{$line['news_title']}</p>
                </div></div></a></div>";
    }
}

?>
