#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
import cgi
import cgitb
import time
sys.path.append('../../')
from graduation_paper.scrape import news_scrape as ns
from graduation_paper.scrape import scrape_morph as morph
cgitb.enable()
form = cgi.FieldStorage()
print("Content-Type: text/html\n")

if "input_company_name" not in form:
    message = "変数が引き渡されていません<br><a href='../view/news.php'>検索画面に戻る</a>"
else:
    message = "検索結果を表示するまで少々お待ちください。<br>"
    company = form['input_company_name'].value
    print(company)
    start = time.time()
    values = ns.getNewsUrls(company)
    total = time.time() - start
    print("<p>スクレイピング処理時間:{}</p>".format(total))
    start2 = time.time()
    for value in values:
        for url in value:
            nouns = morph.getNouns(values[0][0])
    total2 = time.time() - start2
    print("<p>名詞取得時間：{}</p>".format(total2))

print(message)
