#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
スクレイピングしてデータ集める
"""

import scrape_morph as morph
import xl_control as xl


xlfile = 'excel/category13.xlsx'
urls = xl.getURLs(xlfile)
i = 1
for url in urls:
    words_list = morph.getNouns(url)
    xl.addData(words_list,xlfile)
    print(str(i)+" : Add New Data:")
    print(url)
    i+=1

# xl.test()
print("Complete")
