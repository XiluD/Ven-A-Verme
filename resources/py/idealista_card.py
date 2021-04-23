import os
import sys
from bs4 import BeautifulSoup
import re
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.firefox.options import Options
import json


link = sys.argv[1]

options = Options()
options.add_argument('--headless')
options.add_argument("--window-size=1920,1080")
driver = webdriver.Firefox(executable_path=f"{os.path.dirname(__file__)}/geckodriver.exe", options=options)

driver.get(link)

WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, 'idealista-banner-wrapper')))

soup = BeautifulSoup(driver.page_source, 'html.parser')

main_content = soup.find(class_ = 'detail-container')

content = {}

content['inner_card_title'] = main_content.find('span', class_='main-info__title-main').text
content['inner_card_place'] = main_content.find('span', class_='main-info__title-minor').text
content['inner_card_detail'] = main_content.find('div', class_='info-features').text.strip('\n').replace('\n', ' ')
content['inner_card_price'] = main_content.find('span', class_='info-data-price').text
content['inner_card_description'] = main_content.find('div', class_= 'adCommentsLanguage').text.strip('\n').replace('\n', ' ')
content['inner_card_contact'] = main_content.find('p', class_= '_browserPhone').text.strip('\n')
content['inner_card_link'] = link

card_features_container = main_content.find('section', id = 'details')

features_containers = card_features_container.find_all(class_ = 'details-property_features')

try:
    content['inner_card_feautures'] = {'basic_fe': [feature.text.strip('\n').strip() for feature in features_containers[0].find_all('li')]}
    content['inner_card_feautures'].update({'building_fe': [feature.text.strip('\n') for feature in features_containers[1].find_all('li')]})
    content['inner_card_feautures'].update({'equipment_fe': [feature.text.strip('\n') for feature in features_containers[2].find_all('li')]})
except:
    pass

imgs_container = main_content.find('div', id = 'main-multimedia')
imgs_src = imgs_container.find_all('img', class_='detail-image-gallery')
card_images = []
for img in imgs_src:
    card_images.append(img['data-ondemand-img'])
content['inner_card_images'] = card_images

driver.quit()

print(json.dumps(content))

'''
# Example of tripadvisor content we can return in the API
content =
    {
        'inner_card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
        'inner_card_place': 'La Munchuela, Albacete', 
        'inner_card_detail': '4 hab. 330 m²',
        'inner_card_price': '1.100€/mes',
        'inner_card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
        
        'inner_card_feautures': {
                                    'basic_fe': [],
                                    'building_fe': [],
                                    'equipment_fe': []
                                },
        
        'inner_card_contact': '967 654 962',
        'inner_card_link': 'https://www.idealista.com/inmueble/88407419/',
        'inner_card_images': ['https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg']
    }

'''