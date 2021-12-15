#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
import cgi
import cgitb
import time
# import add_database
import connectSql as dbconn
from collections import Counter
sys.path.append('../../')
from graduation_thesis.scrape import news_scrape as ns
from graduation_thesis.scrape import scrape_morph as morph
from graduation_thesis.classify import classify_news as cn
from graduation_thesis.view import htmls

cgitb.enable()
form = cgi.FieldStorage()
print("Content-Type: text/html\n")
head = htmls.head()
foot = htmls.foot()
print(head)
print("<main>")
if "input_company_name" not in form:
    message = "うまく情報が引き渡されませんでした。<br><a href='../view/news.php'>検索画面に戻る</a>"
else:
    message = "<br><a href='../view/news.php'>検索画面に戻る</a>"
    company = form['input_company_name'].value
    conn = dbconn.connection()
    cur = conn.cursor()
    cur.execute("select company_id from companies where company_name like '%{}%';".format(company))
    rows = cur.fetchall()
    if len(rows) == 0:
        cur.execute("insert into companies (company_name) values('{}');".format(company))
        conn.commit()
        cur.execute("select max(company_id) from companies;")
        rows = cur.fetchall()
    company_id = rows[0][0]
    news_in_db = []
    cur.execute("select news_url from news where company_id = {}".format(company_id))
    rows = cur.fetchall()
    for row in rows:
        news_in_db.append(row[0])
    arrays = ns.getNewsUrls(company,news_in_db)
    news_count = 0
    print("<p class='cent'>新たに取得したニュースは下に表示されます</p>")
    print("<div class='news'>")
    for array in arrays:
        for i,values in zip(range(len(array)),array):
            morph_result = morph.getNouns(values[0])
            nouns_count = len(Counter(morph_result))
            nouns = Counter(morph_result)
            a = cn.get_category(nouns)
            scores,relates = a[0],a[1]
            category = scores.index(max(scores))
            category+=1
            img = "../img/sdg_icon_{}_ja_2-290x290.png".format(category)
            rating = 100*relates/nouns_count
            if rating < 5:
                cur.execute("insert into out_news (added_date,category_id,company_id,news_url,news_title,news_date,rating) values (current_date,{0},{1},'{2}','{3}','{4}',{5})".format(category,company_id,values[0],values[1],values[2],rating))
                conn.commit()
                # 以下のコードはテスト用
                # print("<br>カテゴリー： "+str(category+1) + "　関連語率："+str(ritu)+" 最大: " + str(max(scores))+" :合計 "+str(sum(scores))+" :タイトル "+values[1])
                continue
            # 以下2行はテスト用のコード（関連度のチェック,URL表示）
            # print("<br>カテゴリー： "+str(category+1) + "　関連語率："+str(ritu)+" 最大: " + str(max(scores))+" :合計 "+str(sum(scores))+" :タイトル "+values[1])
            # print(values[0]+"<br>")
            news_count+=1
            print(htmls.news(values[0],img,values[1],values[2]))
            if values[0] not in news_in_db:
                if "'" in values[1]:
                    continue
                cur.execute("insert into news (added_date,category_id,company_id,news_url,news_title,news_date,rating) values (current_date,{0},{1},'{2}','{3}','{4}',{5})".format(category,company_id,values[0],values[1],values[2],rating))
                conn.commit()
    cur.close()
    conn.close()
    if news_count == 0:
        print("<p class='cent'>{}に関するSDGsのニュースを見つけることができませんでした</p>".format(company))
    print("</div>")
print(message)
print("</main>")
print(foot)