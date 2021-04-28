import requests
from bs4 import BeautifulSoup
import re
import json

'''
Attraction

Nombre y direccion de Attraction: {"name":"(.*?)"
Imagen: meta con property class="_39RSYxGX"
Comentarios: div class="cPQsENeY"
'''

'''
Hotel

Nombre: h1 id="HEADING"
Direccion: span class _3ErVArsu jke2_wbp
Imagen: _1a4WY7aS RcPVTgNb
Comentarios: div class="cPQsENeY"
'''

'''
Restaurants

Nombre: h1 class _3a1XQ88S
Direccion: span class _2saB_OSe
Imagen:
Comentarios Todos:
Comentario:
'''

def getAttraction(link):
    page = requests.get(link)
    soup = BeautifulSoup(page.content, 'html.parser')
    title = re.search('{"name":"(.*?)"', soup.prettify()).group(1)
    print(title)

    ad1 = re.search('"addressLocality":"(.*?)"', soup.prettify()).group(1)
    ad2 = re.search('"streetAddress":"(.*?)"', soup.prettify()).group(1)
    
    address = f'{ad1}, {ad2}'
    print(address)
    
    imgs = soup.find_all('meta', property='og:image', content=re.compile('jpg$'))
    for img in imgs:
        print(img['content'])
    
    comments = soup.find_all('div', class_='cPQsENeY')
    for comment in comments:
        print(comment.text)

def getHotel(link):
    page = requests.get(link)
    soup = BeautifulSoup(page.content, 'html.parser')
    title = soup.find('h1', id='HEADING').text
    print(title)

    
    address = soup.find('span', {'class':['_3ErVArsu', 'jke2_wbp']}).text
    print(address)
    
    
    img = soup.find('img', {'class':['_1a4WY7aS', 'RcPVTgNb']})['src']
    print(img)
    
    comments = soup.find_all('div', class_='cPQsENeY')
    for comment in comments:
        print(comment.text)
        
def getRestaurants(link):
    page = requests.get(link)
    soup = BeautifulSoup(page.content, 'html.parser')
    title = soup.find('h1', class_='_3a1XQ88S').text
    print(title)

    
    address = soup.find('span', class_='_2saB_OSe').text
    print(address)
    
    imgs_container = soup.find('div', class_='mosaic_photos')
    imgs = imgs_container.find_all('img', class_='basicImg')
    for img in imgs[:6]:
        print(img['data-lazyurl'])
    
    comments = soup.find_all('div', class_='entry')
    for comment in comments:
        print(comment.text[:-3])
    
    
links = ['https://www.tripadvisor.es/Attraction_Review-g562662-d10021149-Reviews-Burrolandia-Tres_Cantos.html',
         'https://www.tripadvisor.es/Attraction_Review-g562662-d4232311-Reviews-Castillo_de_Soto_de_Vinuelas-Tres_Cantos.html',
         'https://www.tripadvisor.es/Attraction_Review-g187486-d3177505-Reviews-Pasaje_de_Lodares-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Attraction_Review-g187486-d3973259-Reviews-Museo_Municipal_de_la_Cuchilleria-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Hotel_Review-g562662-d11737621-Reviews-Eurostars_Madrid_Foro-Tres_Cantos.html',
         'https://www.tripadvisor.es/Hotel_Review-g562662-d234295-Reviews-VP_Jardin_de_Tres_Cantos-Tres_Cantos.html',
         'https://www.tripadvisor.es/Hotel_Review-g187486-d277396-Reviews-Parador_de_Albacete-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Hotel_Review-g187486-d2277221-Reviews-B_B_Hotel_Albacete-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Restaurant_Review-g187486-d5614491-Reviews-La_Posadica_Horno_de_Lena-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Restaurant_Review-g187486-d17756652-Reviews-Restaurante_Jimena-Albacete_Province_of_Albacete_Castile_La_Mancha.html',
         'https://www.tripadvisor.es/Restaurant_Review-g562662-d2724132-Reviews-Casa_Emeterio-Tres_Cantos.html',
         'https://www.tripadvisor.es/Restaurant_Review-g562662-d2315133-Reviews-La_Terraza_De_Alba-Tres_Cantos.html']

for link in links:
    if re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Attraction':
        print('Attraction')
        getAttraction(link)
    elif re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Hotel':
        print('Hotel')
        getHotel(link)
    elif re.search('tripadvisor.es\/(.*)_Review', link).group(1) == 'Restaurant':
        print('Restaurant')
        getRestaurants(link)


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