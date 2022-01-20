import news_scrape as ns
def test_date():
    company = input("社名：")
    news_in_db = []
    arrays = ns.getNewsUrls(company,news_in_db)
    for i in arrays:
        print(i)
test_date()

