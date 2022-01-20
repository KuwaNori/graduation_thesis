#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
import xl_control as xl
import final_score  as fs
import classify_news as cn
import numpy as np
import matplotlib.pyplot as plt
from collections import Counter
sys.path.append('../../')
from graduation_thesis.scrape import scrape_morph as morph

score_file = []

file = "random_test.xlsx"
urls = xl.getURLs("excel/"+file)
anss = xl.getAnswer("excel/"+file)
result = np.array([0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0])
counter = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
counter2= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
counter3= [15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15]
counter4= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
ftotal = 0
count = 0
miss = 0
dataset = []
l = []

for url,ans,i in zip(urls,anss,range(1,241)):
    if i%24 == 0:
        print(str((i*100)/240)+"%")
    morph_result = morph.getNouns(url)
    nouns_count = len(Counter(morph_result))
    nouns = Counter(morph_result)
    a = cn.get_category(nouns)
    scores = a[0]
    relates = a[1]
    total = sum(scores)
    mx = scores.index(max(scores))
    secondl = sorted(scores)
    second = secondl[-2]
    secondi = scores.index(second)
    ansscore = scores[ans-1]
    dataset.append(mx+1)
    if mx != ans-1:
        count+=1
    if secondi == ans-1:
        counter4[secondi] = counter4[secondi]+1
    if sum(scores) == 0:
        print(str(i)+": somethign wrong happend: "+str(scores))
        miss +=1
        continue
    if i <= 127:
        continue
    #if round(100*relates/nouns_count) < 5 or round(100*relates/nouns_count) > 8:
    #    print(Counter(morph_result))
    left = np.array(["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16"])
    height = np.array(scores)
    # height2= np.array(counter2)
    plt.title("news:"+str(i)+" top:" + str(round((scores[mx]/sum(scores))*100))+"% next:"+ str(round((second/sum(scores))*100)) +"% term ratio:" + str(round(100*relates/nouns_count,2)) +"%")
    p1 = plt.bar(left,height,align="edge")
    # p2 = plt.bar(left,height3,align="edge", width=-0.3)
    plt.show()
    #print("関連語率:"+str(round(100*relates/nouns_count))+"%" )
    #print("関連語出現回数:"+str(relates) + " 最大:"+str(max(scores))+" 合計:"+str(sum(scores)))
    #print(str(i) + ". 判定 = "+ str(mx+1)+ " 確率: " +str(round((scores[mx]/sum(scores))*100)) + "%" + str(scores))
    #print("    正解 = "+ str(ans) + " 確率：" +str(round((ansscore/sum(scores))*100))+"%" + "順位：" + str(16 - secondl.index(ansscore)) + "位")
    #print(" 　2番目： = "+str(secondi + 1) +" 確率：" + str(round((second/sum(scores))*100))+"%")
    result = result + scores
    ftotal += total
    #print("-----------------------------------")
# dictdata = Counter(dataset)
# left = np.array(["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16"])

# average = np.round((result*100) /ftotal, decimals= 2)
#height3= np.array(counter3)
#height4= np.array(counter4)
#plt.title(" accuracy: " + str(round(((240-count)/240)*100)) + "%")
#p3 = plt.bar(left,height, align="edge", width=0.3)
#p4 = plt.bar(left,height4, align="edge", width=0.3)
#plt.hlines(15,0,16,colors="red", linestyle='dashed')
#plt.legend((p1[0], p2[0],p3[0],p4[0]), ("Correct", "False","Second","Second False"))
#plt.show()

