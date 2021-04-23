import requests
from bs4 import BeautifulSoup
import re
import itertools
import json
import sys

link = f"https://www.tripadvisor.es{sys.argv[1]}"

page = requests.get(link)
soup = BeautifulSoup(page.content, 'html.parser')

main_content = soup.find(class_='_1HQROFP')

header_titles = main_content.find_all('h3', class_='_1QGef_ZJ')
header_subtitles = main_content.find_all('div', class_='_3U8VGyWC')
cards_containers = main_content.find_all('ul', class_='_5Vb6a0_6')
image_container = str(soup.find_all('script')[-1])

content = []

for header_title, header_subtitle, cards_container in list(itertools.zip_longest(header_titles, header_subtitles, cards_containers, fillvalue='')):

    container = {}
    container['header_title'] = header_title.text
    # print(header_title.text)
    try:
        container['hearder_subtitle'] = header_subtitle.text
        # print(header_subtitle.text)
    except:
        container['hearder_subtitle'] = ''

    card_list = []
    for card in cards_container:
        card_obj = {}

        card_obj['card_title'] = card.find('div', 'VQlgmkyI').text
        #print(card.find('div', 'VQlgmkyI').text)
        try:
            card_obj['card_subtitle'] = card.find('div', '_3gC8zGeY').text
            #print(card.find('div', '_3gC8zGeY').text)
        except:
            card_obj['card_subtitle'] = ''
        try:
            card_link = card.find('a', '_37QDe3gr')['href']
            card_obj['card_link'] = card_link
            #print(card.find('a', '_37QDe3gr')['href'])
        except:
            card_obj['card_link'] = ''
        try:
            img_regex = card_link + '.*?(https.*?)\\"}'
            img = re.search(f'\{img_regex}', image_container).group(1)
            img = img[:-1].replace('w=100&h=100', 'w=800&h=800')
            card_obj['card_img'] = img
        except:
            card_obj['card_img'] = ''

        card_list.append(card_obj)

    container['cards'] = card_list

    content.append(container)


print(json.dumps(content))


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







