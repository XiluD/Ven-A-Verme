import sys
import requests
from bs4 import BeautifulSoup
import re
import json
from sentiment_analysis_spanish import sentiment_analysis
import numpy as np
from db_connector import insertIntoDB

def getSentiment(commentInfo):
    sentimentResults = []
    sentiment = sentiment_analysis.SentimentAnalysisSpanish()
    for realRating, commentInfo in zip(commentInfo['bubbles'], commentInfo['comments']):
        sentimentRes = round(sentiment.sentiment(commentInfo), 3)
        if (realRating - sentimentRes) < 0.3:
            sentimentResults.append(round((realRating + sentimentRes)/2, 3))
        else:
            sentimentResults.append(realRating)


    finalSentiment = np.mean(sentimentResults)
    if finalSentiment < 0.4:
        return round(finalSentiment*10, 3), 'pocoRecomendado'
    elif finalSentiment >= 0.4 and finalSentiment <= 0.6:
        return round(finalSentiment*10, 3), 'valoracionesVariadas'
    elif finalSentiment >= 0.6 and finalSentiment <= 0.8:
        return round(finalSentiment*10, 3), 'recomendado'
    else:
        return round(finalSentiment*10, 3), 'muyRecomendado'


        
def getAttraction(link):
    done = False
    i = 0
    while (not done) and (i < 5):
        contentData = {}
        page = requests.get(link, headers = {'User-agent': 'venaverme-scrapper-bot'})
        soup = BeautifulSoup(page.content, 'html.parser')
        try:
            title = re.search('{"name":"(.*?)"', soup.prettify()).group(1)
        except:
            title = soup.find('h1', class_="qf3QTY0F").text
        
        contentData['title'] = title
    
        ad1 = re.search('"addressLocality":"(.*?)"', soup.prettify()).group(1)
        ad2 = re.search('"streetAddress":"(.*?)"', soup.prettify()).group(1)
        
        address = f'{ad1}, {ad2}'
        contentData['address'] = address
        
        imgs = soup.find_all('meta', property='og:image', content=re.compile('jpg$'))
        contentData['images'] = [img['content'] for img in imgs]
        
        commentInfo = {'bubbles':[],
                       'comments':[]}
        
        if soup.find_all('div', class_='nf9vGX55'):
            for bubble in soup.find_all('div', class_='nf9vGX55'):
                if re.search(r"bubble_(\d)", str(bubble)) != None:
                    commentInfo['bubbles'].append(int(re.search(r"bubble_(\d)", str(bubble)).group(1))/5)
            commentInfo['comments'] = [f"{commentTitle.text} {commentBody.text[:-3] if commentBody.text[-3:]=='Más' else commentBody.text}"
                    for commentTitle, commentBody in zip(soup.find_all('a', class_='ocfR3SKN'),
                                                         soup.find_all('div', class_='cPQsENeY'))]
        elif soup.find('div', class_='_2rspOqPP') or soup.find('div', class_='_1c8_1ITO'):
            bubblesContainer = soup.find('div', class_='_2rspOqPP') if soup.find('div', class_='_2rspOqPP') else soup.find('div', class_='_1c8_1ITO')
            commentInfo['bubbles'] = [int(bubble['title'][:1])/5 for bubble in bubblesContainer.find_all('svg', class_='zWXXYhVR')]
            commentInfo['comments'] = [comment.text for comment in bubblesContainer.find_all('div', class_='_2nPM5Opx')]
        
        if commentInfo['bubbles'] and commentInfo['comments']:
            done=True
        i+=1
    if i < 5:
        sentimentPoints, sentimentFeed = getSentiment(commentInfo)
        contentData['sentimentPoints'] = sentimentPoints
        contentData['sentimentFeed'] = sentimentFeed
        return contentData
    

def getHotel(link):
    done = False
    i = 0
    while (not done) and (i < 5):
        contentData = {}
        page = requests.get(link, headers = {'User-agent': 'venaverme-scrapper-bot'})
        soup = BeautifulSoup(page.content, 'html.parser')
        title = soup.find('h1', id='HEADING').text
        contentData['title'] = title

        address = soup.find('span', {'class':['_3ErVArsu', 'jke2_wbp']}).text
        contentData['address'] = address        
        
        img = soup.find('img', {'class':['_1a4WY7aS', 'RcPVTgNb']})['src']
        contentData['images'] = img
             
        commentInfo = {}
        
        commentInfo['bubbles'] = [int(re.search(r"bubble_(\d)", str(bubble)).group(1))/5 for bubble in soup.find_all('div', class_='nf9vGX55') if re.search(r"bubble_(\d)", str(bubble))  != None]
        
        commentInfo['comments'] = [f"{commentTitle.text} {commentBody.text[:-3] if commentBody.text[-3:]=='Más' else commentBody.text}"
                    for commentTitle, commentBody in zip(soup.find_all('a', class_='ocfR3SKN'),
                                                         soup.find_all('q', class_='IRsGHoPm'))]
        if commentInfo['bubbles'] and commentInfo['comments']:
            done=True
        i+=1
    if i < 5:
        sentimentPoints, sentimentFeed = getSentiment(commentInfo)
        contentData['sentimentPoints'] = sentimentPoints
        contentData['sentimentFeed'] = sentimentFeed
        return contentData
    
def getRestaurants(link):
    done = False
    i = 0
    while (not done) and (i < 5):
        contentData = {}
        page = requests.get(link, headers = {'User-agent': 'venaverme-scrapper-bot'})
        soup = BeautifulSoup(page.content, 'html.parser')
        try:
            title = soup.find('h1', class_='_3a1XQ88S').text
            contentData['title'] = title
            
            address = soup.find('span', class_='_2saB_OSe').text
            contentData['address'] = address

            imgs_container = soup.find('div', class_='mosaic_photos')
            imgs = imgs_container.find_all('img', class_='basicImg')
            contentData['images'] = [img['data-lazyurl'] for img in imgs[:6]]
                         
            commentInfo = {}
            
            commentInfo['bubbles'] = [int(re.search(r"bubble_(\d)", str(bubble)).group(1))/5 for bubble in soup.find_all('div', class_='ui_column is-9') if re.search(r"bubble_(\d)", str(bubble))  != None]
            commentInfo['comments'] = [f"{commentTitle.text} {commentBody.text[:-3] if commentBody.text[-3:]=='Más' else commentBody.text}"
                        for commentTitle, commentBody in zip(soup.find_all('span', class_='noQuotes'),
                                                             soup.find_all('div', class_='entry'))]
        except:
            pass
        if commentInfo['bubbles'] and commentInfo['comments']:
            done=True
        i+=1
    if i < 5:
        sentimentPoints, sentimentFeed = getSentiment(commentInfo)
        contentData['sentimentPoints'] = sentimentPoints
        contentData['sentimentFeed'] = sentimentFeed
        return contentData
        

if __name__ == '__main__':
    link = f"https://www.tripadvisor.es{sys.argv[1]}"
    contentData = None
    if re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Attraction':
        contentData = getAttraction(link)
    elif re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Hotel':
        contentData = getHotel(link)
        print(contentData)
    elif re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Restaurant':
        contentData = getRestaurants(link)
        print(contentData)

    #Full insert into tripadvisorinnercards
    sql = "INSERT INTO tripadvisorinnercard (cardLink, innerCardTitle, innerCardAddress, ratingSentimentPoints, ratingSentimentFeed) VALUES (%s, %s, %s, %s, %s)"
    val = [(sys.argv[1], contentData['title'], contentData['address'], float(contentData['sentimentPoints']), contentData['sentimentFeed'])]
    insertIntoDB(sql, val)


    # Full insert into tripinnercardimages
    sql = "INSERT INTO tripinnercardimages (imageLink, cardLink) VALUES (%s, %s)"
    val = [(image, sys.argv[1]) for image in contentData['images']]
    insertIntoDB(sql, val)




'''
sql = "INSERT INTO tripadvisorcards (cardLink, innerCardTitle, innerCardDireccion, 
                                     sentimentAnalysis) VALUES (%s, %s, %s, %s)"
                                                                                
val = [("/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html",
        "Burrolandia", "Tres Cantos, Camino de la Moraleja", "muyRecomendado")
        ]

sql = "INSERT INTO innercardimages (imageLink, cardLink) VALUES (%s, %s)"
                                                                                
val = [(https://media-cdn.tripadvisor.com/media/photo-o/0b/b3/41/34/paseo-en-carro.jpg,
        "/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html"),
        
        (https://media-cdn.tripadvisor.com/media/photo-o/0b/b3/41/34/paseo-en-carro.jpg,
        "/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html"),
        
        (https://media-cdn.tripadvisor.com/media/photo-o/0b/b3/41/34/paseo-en-carro.jpg,
        "/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html")]
'''