<!DOCTYPE html>
<?php
  date_default_timezone_set('Asia/Tokyo');

  #require section
  require_once("../control/getlist.php"); # get lists from DB
  require_once("../control/getimgurl.php"); # get img url
 
  # check 
  if (isset($_GET['input_company_name'])){
    $company_name = $_GET['input_company_name'];
    // 候補となる企業の入った配列を取得
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
                    <form method="get" action="./news.php" name="search<?php echo $i;?>"><input type='hidden' name="input_category" value="<?php echo $i;?>">
                        <a class="link<?php echo $i;?>" href="javascript:search<?php echo $i;?>.submit()">GAOL <?php echo $i;?></a>
                    </form>
                </li>
            <?php endfor;?>
                <li>
                    <form method="get" action="./news.php" name="companies">
                        <input type="hidden" name="companies" value="companies">
                        <a class="link" href="javascript:companies.submit()">企業一覧</a>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <main>
      <?php if(isset($_GET["input_company_name"])):?>
        <!-- もしデータがなかったら -->
        <?php if (count($companies) == 0):?>
          <p>「<?php echo $company_name; ?>」に関する検索結果がありません</p>
          <form method="post" action="../control/scrape.py" name="scrape" id="word<?php echo $company["company_id"]; ?>">
            <input type="hidden" name="input_company_name" value="<?php echo $company_name; ?>">
            <a href="javascript:scrape.submit()">「<?php echo $company_name; ?>」に関するニュースを取得する</a>
          </form>
        <p>※ニュースデータの取得、分類には非常に多くの処理が必要なため、最初の実行では504エラー（Gateway Timeout）が起こる可能性があります。<br>
        もしエラーが出ましたら、エラー画面でページをリロードしていただくと正常に実行されると思います。</p>
        <p>辛抱強くお待ちください。。。</p>
        <!-- もし複数の企業データがあれば -->
        <?php else: ?>
          <p>「<?php echo $company_name; ?>」の検索結果</p>
          <ul>
            <?php foreach($companies as $company): ?>
              <form method="get" action="news.php" name="candi<?php echo $company["company_id"]; ?>" id="word<?php echo $company["company_id"]; ?>">
                <input type="hidden" name="input_company_name" value="<?php echo $company["company_name"]; ?>">
                <li>・<a href="javascript:candi<?php echo $company["company_id"];?>.submit()"><?php echo $company["company_name"]; ?></a></li>
              </form>
            <?php endforeach; ?>
          </ul>
          <p>上にない場合は追加することができます</p>
          <form method="post" action="../control/scrape.py" name="scrape" id="word<?php echo $company["company_id"]; ?>">
            <input type="hidden" name="input_company_name" value="<?php echo $company_name; ?>">
            <a href="javascript:scrape.submit()">「<?php echo $company_name; ?>」に関するニュースを取得する</a>
          </form>
        <?php endif; ?>
      <?php endif;?>
    </main>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./js/hamburger.js"></script>
</html>
