#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
名詞を取得
"""

import requests
import pandas as pd
from bs4 import BeautifulSoup
import MeCab

def getNouns(url):
    html = requests.get(url).text
    soup = BeautifulSoup(html, "html.parser")
    for script in soup(["script", "style","a"]):
        script.decompose()
    plain = soup.get_text()
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
