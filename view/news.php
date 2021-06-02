<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/news.css">
    <link rel="stylesheet" href="./css/header.css">
    <title></title>
  </head>
  <body>
    <header>
        <form class="header-top" method="post" action="#" name="word">
          <input type="text" class="text-input" name="company_name">
          <label for="search">
            <div class="search">
              <img class="search-img" src="../img/search.svg" alt="">
            </div>
          </label>
          <input type="submit" id="search" alt="search">
        </form>
    </header>

    <main>
      <div class="company_name">
        <h2><?php echo $compmany_name; ?></h2>
      </div>

      <div class="news">
        <?php foreach $line in $list: ?> -->
          <img class="news_img" src="<?php echo $img_url; ?>" alt="">
          <h3><?php echo $news_title; ?></h3>
        <?php endforeach ;?>
      </div>
    </main>
  </body>
</html>
