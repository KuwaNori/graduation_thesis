<?php
  header('Expires: -1');
  header('Cache-Control:');
  header('Pragma:');
  date_default_timezone_set('Asia/Tokyo');

  #require section
  require_once("../control/getlist.php"); # get lists from DB
  require_once("../control/getimgurl.php"); #get img url

  # check token and get list of news
  if (isset($_POST['input_company_name'])){
    $company_name = $_POST['input_company_name'];
    // 変数companiesには企業名が０～複数入る、後に、{0の時、1の時、複数の時}で分岐を行う
    $companies = getComapnies($company_name);
  }
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/news.css">
    <link rel="stylesheet" href="./css/header.css">
    <title></title>
  </head>
  <body>
    <header>
      <!-- 検索フォーム -->
        <form class="header-top" method="post" action="#" name="word">
          <input type="text" class="text-input" name="input_company_name" placeholder="Search">
          <label for="search">
            <div class="search">
              <img class="search-img" src="../img/search.svg" alt="">
            </div>
          </label>
          <input type="submit" id="search" alt="search">
        </form>
    </header>

    <main>
    <!-- もし既にデータベースに登録済み、かつ候補の会社が1つの時 -->
    <?php if(count($companies) == 1): ?>
      <?php $news_list = getNewsList($companies[0]["company_id"]); ?>
      <!-- Falseでなければ企業名を表示 -->
      <div class="company_name">
        <h3><?php echo $companies[0]["company_name"]; ?></h3>
      </div>

      <div class="news">
        <!-- ニュース一覧の表示 -->
        <?php foreach ($news_list as $line) :?>
          <div class="newsbox">
              <a href="<?php echo $line["news_url"]; ?>" class="linkto">
                <div class="linkbutton">
                <img class="news_cate" src="<?php echo getImgUrl($line["category_id"]); ?>" alt="">
                <p class="title"><?php echo $line["news_title"]; ?></p>
              </div>
            </a>
          </div>
        <?php endforeach;?>
    <!-- もしデータがなかったら -->
    <?php  elseif (count($companies) == 0):?>
      <p>「<?php echo $company_name; ?>」に関する検索結果がありません</p>
      <form method="post" action="#" name="scrape" id="word<?php echo $company["company_id"]; ?>">
        <input type="hidden" name="input_company_name" value="<?php echo $company_name; ?>">
        <a href="javascript:scrape.submit()">「<?php echo $company_name; ?>」に関するニュースを取得する</a>
      </form>

    <!-- もし複数の企業データがあれば -->
    <?php else: ?>
      <p>「<?php echo $company_name; ?>」の検索結果</p>
      <ul>
        <?php foreach($companies as $company): ?>
          <form method="post" action="#" name="candi<?php echo $company["company_id"]; ?>" id="word<?php echo $company["company_id"]; ?>">
            <input type="hidden" name="input_company_name" value="<?php echo $company["company_name"]; ?>">
            <li>・<a href="javascript:candi<?php echo $company["company_id"];?>.submit()"><?php echo $company["company_name"]; ?></a></li>
          </form>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      </div>
    </main>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
