import requests
from bs4 import BeautifulSoup
import re
import itertools
import json
import sys
from db_connector import insertIntoDB

link = f"https://www.tripadvisor.es{sys.argv[1]}"

page = requests.get(link)
soup = BeautifulSoup(page.content, 'html.parser')

main_content = soup.find(class_='_1HQROFP')

header_titles = main_content.find_all('h3', class_='_1QGef_ZJ')
cards_containers = main_content.find_all('ul', class_='_19Yovgro')
image_container = str(soup.find_all('script')[-1])

val = []
for header_title, cards_container in list(itertools.zip_longest(header_titles, cards_containers, fillvalue='')):
    for card in cards_container:
        content = []
        #cardLink
        try:
            cardLink = card.find('a', '_37QDe3gr')['href']
            content.append(cardLink)
        except:
            content.append(None)

        #placeLink
        content.append(sys.argv[1])

        #cardTitle
        content.append(card.find('div', 'VQlgmkyI').text)

        #cardSubtitle
        try:
            content.append(card.find('div', '_3gC8zGeY').text)
        except:
            content.append(None)

        #cardImage
        try:
            img_regex = cardLink + '.*?(https.*?)\\"}'
            img = re.search('\{img_regex}'.format(img_regex = img_regex), image_container).group(1)
            img = img[:-1].replace('w=100&h=100', 'w=800&h=800')
            content.append(img)
        except:
            content.append(None)

        #cardType
        if (header_title.text == 'Haz cosas'):
            content.append('queVisitar')
        elif (header_title.text == 'Alójate'):
            content.append('alojamiento')
        elif (header_title.text == 'Come'):
            content.append('dondeComer')
        else:
            content.append('otros')

        val.append(tuple(content))


sql = "INSERT INTO tripadvisorcards (cardLink, placeLink, cardTitle, cardSubtitle, cardImage, cardType) VALUES (%s, %s, %s, %s, %s, %s)"
insertIntoDB(sql, val)


'''
sql = "INSERT INTO tripadvisorcards (cardLink, placeLink, cardTitle, 
                                     cardSubtitle, cardImage, cardType) VALUES (%s, %s, %s,
                                                                                %s, %s, %s)"
                                                                                
val = [("/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html",
        "https://www.tripadvisor.es//Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html", "Bodega Cerrón",
        "Bodegas y viñedos", "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/e9/7e/bf/getlstd-property-photo.jpg?w=800&h=800&s=1",
        "queVisitar"),
        
        ("/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html",
        "https://www.tripadvisor.es//Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html", "Bodega Cerrón",
        "Bodegas y viñedos", "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/e9/7e/bf/getlstd-property-photo.jpg?w=800&h=800&s=1",
        "queVisitar"),

        ("/Attraction_Review-g1047902-d15619441-Reviews-Bodega_Cerron-Fuente_Alamo_Province_of_Albacete_Castile_La_Mancha.html",
        "https://www.tripadvisor.es//Tourism-g1435648-Bonete_Province_of_Albacete_Castile_La_Mancha-Vacations.html", "Bodega Cerrón",
        "Bodegas y viñedos", "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/e9/7e/bf/getlstd-property-photo.jpg?w=800&h=800&s=1",
        "queVisitar")
        ]
'''

'''
# Example of tripadvisor content we can return in the API
content = [
    {

        'header_title': 'Diviertete',
        'hearder_subtitle': 'Lugares que visitar, ...',
        'cards': [

            {
                'card_title': 'Pasaje de Lodares',
                'card_subtitle': 'Puntos emblemáticos y de interés',
                'card_link': '/Attraction_Review-g187486-d3177505-Reviews-Pasaje_de_Lodares-Albacete_Province_of_Albacete_Castile_La_Mancha.html'
                'card_img': 'https://dynamic-media-cdn.tripadvisor.com/media/photo-s/02/7b/5f/c7/pasaje-de-lodares.jpg?w=800&h=800&s=1'
            },
            {
                'card_title': 'Museo Municipal de la Chuchillería',
                'card_subtitle': 'Puntos emblemáticos y de interés',
                'card_link': '/Attraction_Review-g187486-d3177505-Reviews-Pasaje_de_Lodares-Albacete_Province_of_Albacete_Castile_La_Mancha.html'
                'card_img': 'https://dynamic-media-cdn.tripadvisor.com/media/photo-s/02/7b/5f/c7/pasaje-de-lodares.jpg?w=800&h=800&s=1'
            }

        ]

    },
    {

        'header_title': 'Diviertete',
        'hearder_subtitle': 'Lugares que visitar, ...',
        'cards': [

            {
                'card_title': 'Pasaje de Lodares',
                'card_subtitle': 'Puntos emblemáticos y de interés',
                'card_link': '/Attraction_Review-g187486-d3177505-Reviews-Pasaje_de_Lodares-Albacete_Province_of_Albacete_Castile_La_Mancha.html'
                'card_img': 'https://dynamic-media-cdn.tripadvisor.com/media/photo-s/02/7b/5f/c7/pasaje-de-lodares.jpg?w=800&h=800&s=1'
            },
            {
                'card_title': 'Museo Municipal de la Chuchillería',
                'card_subtitle': 'Puntos emblemáticos y de interés',
                'card_link': '/Attraction_Review-g187486-d3177505-Reviews-Pasaje_de_Lodares-Albacete_Province_of_Albacete_Castile_La_Mancha.html'
                'card_img': 'https://dynamic-media-cdn.tripadvisor.com/media/photo-s/02/7b/5f/c7/pasaje-de-lodares.jpg?w=800&h=800&s=1'
            }

        ]

    }

]
'''







