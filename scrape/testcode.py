#!/usr/bin/python3.6
# -*- coding: utf-8 -*-

import sys
sys.path.append("/home/h0/kuwanori/.local/lib/python3.6/site-packages")
sys.path.append("/home/h0/kuwanori/.local/share/pyppeteer")
import requests
import MeCab
from bs4 import BeautifulSoup
from requests_html import HTMLSession

def testcode(company, check = 0):
    company_name = company
    main_urls = ["https://prtimes.jp/main/action.php?run=html&page=searchkey&search_word={}".format(company_name),"https://news.yahoo.co.jp/search?p={}&ei=utf-8".format(company_name),"https://www.sustainablebrands.jp/search/index.html?q={}&p=1&c=20&o=0".format(company_name),"https://www.businessinsider.jp/search/?q={}".format(company_name)]
    urls = []
    if check == 1:
        html = requests.get(main_urls[0]).text
        soup = BeautifulSoup(html, "html.parser")
        pr_news = prtimes(soup)
        urls.append(pr_news)
        return urls
    elif check == 2:
        html = requests.get(main_urls[1]).text
        soup = BeautifulSoup(html, "html.parser")
        yh_news = yahoo(soup)
        urls.append(yh_news)
        return urls
    elif check == 3:
        sb_news = susbrands(main_urls[2])
        urls.append(sb_news)
        return urls
    elif check == 4:
        bi_news = insider(main_urls[3])
        urls.append(bi_news)
        return urls
    else:
        for i,url in zip(range(4),main_urls):
            if i == 2:
                sb_news = susbrands(url)
                urls.append(sb_news)
            elif i ==3:
                bi_news = insider(url)
                urls.append(bi_news)
            else:
                html = requests.get(url).text
                soup = BeautifulSoup(html, "html.parser")
                if i == 0:
                    pr_news = prtimes(soup)
                    urls.append(pr_news)
                else:
                    yh_news = yahoo(soup)
                    urls.append(yh_news)
        return urls

if __name__ == "__main__":
    company = input("company:")
    tool = int(input("tool:"))
    results = testcode(company,tool)
    for i in results:
        print(i)
