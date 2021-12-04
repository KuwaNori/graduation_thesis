#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
import cgi
import cgitb
import time
from collections import Counter
sys.path.append('../../')
from graduation_paper.scrape import news_scrape as ns
from graduation_paper.scrape import scrape_morph as morph
from graduation_paper.classify import classify_news as cn
cgitb.enable()
form = cgi.FieldStorage()
print("Content-Type: text/html\n")

if "input_company_name" not in form:
    message = "うまく情報が引き渡されませんでした。<br><a href='../view/news.php'>検索画面に戻る</a>"
else:
    message = "検索結果を表示するまで少々お待ちください。<br>"
    company = form['input_company_name'].value
    print(company)
    arrays = ns.getNewsUrls(company)
    for array in arrays:
        for i,values in zip(range(len(array)),array):
            morph_result = morph.getNouns(values[0])
            nouns = Counter(morph_result)
            coun = nouns[company]
            if coun < 3:
                print("few key words")
                continue
            scores = cn.get_category(nouns)
            if sum(scores) < 3000:
                print("score low ")
                continue
            category = scores.index(max(scores))
            print("<br>カテゴリー： "+str(category) + "　回数："+str(coun)+" :最大 " + str(max(scores))+" :合計 "+str(sum(scores))+" :タイトル "+values[1])
print(message)
