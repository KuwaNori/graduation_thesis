#!/usr/bin/python3.6
# -*- coding: utf-8 -*-

import sys
sys.path.append("/home/h0/kuwanori/.local/lib/python3.6/site-packages")
sys.path.append("/home/h0/kuwanori/.local/share/pyppeteer")
import requests
import MeCab
from bs4 import BeautifulSoup
from requests_html import HTMLSession


def prtimes(soup,news_in_db):
    newstags = soup.find_all(class_="list-article__link")
    field = []
    for news in newstags:
        absolute_url = "https://prtimes.jp{}".format(news.attrs['href'])
        if absolute_url in news_in_db:
            continue
        title = news.find('h3').get_text().strip()
        dtime = news.find('time').get_text().strip()
        field.append([absolute_url,title,dtime,"PRTIMES"])
    return field

def yahoo(soup,news_in_db):
    newstags = soup.find_all(class_="newsFeed_item_link")
    field = []
    for news in newstags:
        url = news.attrs['href']
        if url in news_in_db:
            continue
        title = news.find(class_="newsFeed_item_title").get_text().strip()
        dtime = news.find('time').get_text().strip()
        field.append([url,title,dtime,"Yahooニュース"])
    return field

def susbrands(url,news_in_db):
    field = []
    session = HTMLSession()
    r = session.get(url)
    r.html.render(timeout=10)
    divs = r.html.find('._record > ._title')
    urls = r.html.find('._url > a')
    dates = r.html.find('._date')
    for div,tag,date in zip(divs,urls,dates):
        url = tag.attrs['href']
        if url in news_in_db:
            continue
        long_title = div.text
        title = long_title.split('|')[0]
        dtime = date.text
        field.append([url,title,dtime,"サスティナブル・ブランド ジャパン"])
    return field

def insider(url,news_in_db):
    field = []
    session = HTMLSession()
    r = session.get(url)
    r.html.render(timeout=10)
    divs = r.html.find('.p-cardList-cardTitle')
    tags = r.html.find('.p-cardList-cardTitle > a')
    dates = r.html.find('.p-cardList-cardDate')
    for div,tag,date in zip(divs,tags,dates):
        url = tag.attrs['href']
        if url in news_in_db:
            continue
        title = div.text
        dtime = date.text
        field.append([url,title,dtime,"ビジネスインサイダー"])
    return field

def getNewsUrls(company,news_in_db):
    company_name = company
    main_urls = ["https://prtimes.jp/main/action.php?run=html&page=searchkey&search_word={}".format(company_name),"https://news.yahoo.co.jp/search?p={}&ei=utf-8".format(company_name),"https://www.sustainablebrands.jp/search/index.html?q={}&p=1&c=20&o=0".format(company_name),"https://www.businessinsider.jp/search/?q={}".format(company_name)]
    urls = []
    for i,url in zip(range(4),main_urls):
        if i == 2:
            sb_news = susbrands(url,news_in_db)
            urls.append(sb_news)
        elif i ==3:
            bi_news = insider(url,news_in_db)
            urls.append(bi_news)
        else:
            html = requests.get(url).text
            soup = BeautifulSoup(html, "html.parser")
            if i == 0:
                pr_news = prtimes(soup,news_in_db)
                urls.append(pr_news)
            else:
                yh_news = yahoo(soup,news_in_db)
                urls.append(yh_news)
    return urls
