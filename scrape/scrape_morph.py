#!/usr/bin/python3.6
# -*- coding: utf-8 -*-

import requests
from bs4 import BeautifulSoup
import MeCab

def getNouns(url):
    html = requests.get(url).text
    soup = BeautifulSoup(html, "html.parser")
    article = soup.article
    for script in article(["script", "style","a"]):
        script.decompose()
    plain = article.get_text()
    mecab = MeCab.Tagger("-Ochasen")
    lines = mecab.parse(plain).splitlines()
    nouns = []
    for line in lines:
        feature = line.split('\t')
        if len(feature) >= 3:
            word = feature[0]
            parse = feature[3]
            if '名詞' in parse:
                nouns.append(word)
    return nouns
