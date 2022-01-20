#!/usr/bin/python3.6
# -*- coding: utf-8 -*-
def head():
    head ="""
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../view/css/news.css">
    <link rel="stylesheet" href="../view/css/header.css">
    <title></title>
  </head>
  <body>
    <header>
      <!-- 検索フォーム -->
        <form class="header-top" method="get" action="../view/candidates.php" name="word">
          <input type="text" class="text-input" name="input_company_name" placeholder="Search">
          <label for="search">
            <div class="search">
              <img class="search-img" src="../img/search.svg" alt="">
            </div>
          </label>
          <input type="submit" id="search" alt="企業名を検索">
        </form>
    </header>
"""
    return head

def foot():
    foot="""
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
"""
    return foot

def news(url,img,title,company,time):
    news = """<div class='newsbox'>
            <a href='{0}' class='linkto'>
            <div class='linkbutton'>
                <div class='newsleft'>
                    <img class='news_cate' src='{1}'>
                    <p class='news_time'>{2}</p>
                </div>
                <div class='newsright'>
                    <div class='news_company'>{3}</div>
                    <p class='title'>{4}</p>
                </div></div></a></div>""".format(url,img,time,company,title)
    return news
