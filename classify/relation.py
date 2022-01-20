#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
import xl_control as xl
import final_score  as fs
import classify_news as cn
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import matplotlib.ticker as ptick
from collections import Counter
sys.path.append('../../')
from graduation_thesis.scrape import scrape_morph as morph

file = "category100.xlsx"
urls = xl.getURLs("excel/"+file)

sc_c = []
re_c = []

sc_n = []
re_n = []

for url,i in zip(urls,range(336)):
    print(i)
    morph_result = morph.getNouns(url)
    nouns_count = len(Counter(morph_result))
    nouns = Counter(morph_result)
    a = cn.get_category(nouns)
    scores = a[0]
    relates = a[1]
    rela = round(100*relates/nouns_count,2)
    if i < 112:
        sc_c.append(nouns_count)
        re_c.append(rela)
    else:
        sc_n.append(nouns_count)
        re_n.append(rela)
#相関係数の計算
x = np.array(sc_c)
y = np.array(re_c)
xt= np.array(sc_n)
yt= np.array(re_n)
y_yt = np.append(y,yt)
#xl.addRatio(y_yt)

#グラフの描写
plt.xlabel("count of nouns", fontsize=15)
plt.ylabel("relate word ratio(%)", fontsize=15)
plt.scatter(x,y,s=15,c="r",marker="D")
plt.scatter(xt,yt,s=15,c="b",marker="D")
plt.ticklabel_format(style='sci',axis='x')
plt.show()
