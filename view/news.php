<!DOCTYPE html>
<?php
  date_default_timezone_set('Asia/Tokyo');

  #require section
  require_once("../control/getlist.php"); # get lists from DB
  require_once("../control/getimgurl.php"); # get img url
  require_once("../control/echo_news.php"); # echo news
  # check 
  if (isset($_GET['input_company_name'])){
    $company_name = $_GET['input_company_name'];
    // 変数companiesには企業名が０～複数入る、後に、{0の時、複数の時}で分岐を行う
    $companies = getComapnies($company_name);
  }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/news.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/hamburger.css">
    <style>
    <?php for($i=1;$i<=16;$i++):?>
    .link<?php echo $i;?>:hover{
        background-image:url("../img/sdg_icon_<?php echo $i;?>_ja_2-290x290.png");
        background-color:rgba(255,255,255,0.4);
        background-blend-mode:lighten;
        background-repeat:none;
        background-size:cover;
        background-position:center center;
        color: #444;
    }
    <?php endfor;?>
    </style>
    <title></title>
  </head>
  <body>
    <header>
      <!-- 検索フォーム -->
        <form class="header-top" method="get" action="candidates.php" name="word">
          <input type="text" class="text-input" name="input_company_name" placeholder="企業名で検索">
          <label for="search">
            <div class="search">
              <img class="search-img" src="../img/search.svg" alt="">
            </div>
          </label>
          <input type="submit" id="search" alt="search">
        </form>

        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div> 
        <nav class="globalMenuSp">
            <ul>
            <?php for($i=1;$i<=16;$i++):?>
                <li>
                    <form method="get" action="#" name="search<?php echo $i;?>"><input type='hidden' name="input_category" value="<?php echo $i;?>">
                        <a class="link<?php echo $i;?>" href="javascript:search<?php echo $i;?>.submit()">GAOL <?php echo $i;?></a>
                    </form>
                </li>
            <?php endfor;?>
                <li>
                    <form method="get" action="#" name="companies">
                        <input type="hidden" name="companies" value="companies">
                        <a class="link" href="javascript:companies.submit()">企業一覧</a>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <main>
    <!--　企業の表示-->
    <?php if (isset($_GET["companies"])):?>
    <?php $all_companies = getAllCompanies();
        echo_companies($all_companies);
    ?> 
    <?php endif;?>
    <!-- カテゴリー検索 -->
    <?php if (isset($_GET["input_category"])) :?>
        <?php
            $input_category = $_GET["input_category"];
            $category_results = find_category($input_category);
            $last_id = 0;
            if(count($category_results) == 0){
                echo "お探しのゴールに関するニュースはまだありません";
            }
        ?>
        <div class="news">
        <?php 
            echo_cate_news($category_results,$input_category);
        ?>
        </div>
    <?php endif;?>
    <!-- もし既にデータベースに登録済み、かつ候補の会社が1つの時 -->
    <?php if(isset($_GET["input_company_name"])):?>
    <?php if(count($companies) == 1): ?>
      <?php $news_list = getNewsList($companies[0]["company_id"]); ?>
      <!-- Falseでなければ企業名を表示 -->
      <div class="company_name">
        <h3><?php echo $companies[0]["company_name"]; ?></h3>
      </div>

      <div class="news">
        <!-- ニュース一覧の表示 -->
    <?php 
        echo_news($news_list);
    ?>
    <!-- もしデータがなかったら -->
    <?php  elseif (count($companies) == 0):?>
      <p>「<?php echo $company_name; ?>」に関する検索結果がありません</p>
      <form method="post" action="../control/scrape.py" name="scrape" id="word<?php echo $company["company_id"]; ?>">
        <input type="hidden" name="input_company_name" value="<?php echo $company_name; ?>">
        <a href="javascript:scrape.submit()">「<?php echo $company_name; ?>」に関するニュースを取得する</a>
      </form>

    <!-- もし複数の企業データがあれば -->
    <?php else: ?>
      <p>「<?php echo $company_name; ?>」の検索結果</p>
      <ul>
        <?php foreach($companies as $company): ?>
          <form method="get" action="./candidates.php" name="candi<?php echo $company["company_id"]; ?>" id="word<?php echo $company["company_id"]; ?>">
            <input type="hidden" name="input_company_name" value="<?php echo $company["input_company_name"]; ?>">
            <li>・<a href="javascript:candi<?php echo $company["company_id"];?>.submit()"><?php echo $company["company_name"]; ?></a></li>
          </form>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    <?php endif;?>
      </div>
    </main>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="./js/hamburger.js"></script>
</html>
