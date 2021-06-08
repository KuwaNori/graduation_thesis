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
    $company_data = getComapnyId($company_name);
    $news_list = getNewsList($company_name);
  }
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/news.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title></title>
  </head>
  <body>
    <header>
        <form class="header-top" method="post" action="#" name="word">
          <input type="text" class="text-input" name="input_company_name">
          <label for="search">
            <div class="search">
              <img class="search-img" src="../img/search.svg" alt="">
            </div>
          </label>
          <input type="submit" id="search" alt="search">
        </form>
    </header>

    <main>
    <!-- もし既にデータベースに登録済みなら -->
    <?php if( $news_list != "No news are there"): ?>
      <div class="company_name">
        <h2><?php echo $company_data[1]; ?></h2>
      </div>

      <div class="news">
        <?php while($line = pg_fetch_row($news_list)): ?>
          <img class="news_img" src="<?php echo getImgUrl($line[2]); ?>" alt="">
          <h3><?php  ?></h3>
        <?php endwhile;?>
    <!-- もしデータがなかったら -->
    <?php else: ?>
          <p>There are no article about <?php echo $_POST['input_company_name']; ?></p>
    <?php endif; ?>
      </div>
    </main>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
