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

def get_data(link, driver):
    driver.get(link)
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, 'main-footer')))
    soup = BeautifulSoup(driver.page_source, 'html.parser')
    main_content = soup.find(id = 'main-content')
    cards_containers = main_content.find_all('article', class_='item-multimedia-container')
    content = []

    for card in cards_containers:
        
        container = {}
        card_header = card.find('a', class_='item-link')
        container['card_title'] = card_header.text
        container['card_link'] = f"https://www.idealista.com{card_header['href']}"
        container['card_price'] = card.find('span', 'item-price').text
        card_details = card.find_all('span', class_='item-detail')
        card_detail = ''
        for detail in card_details:
            card_detail += f"{detail.text} "

        container['card_detail'] = card_detail.strip()
        container['card_description'] = card.find('div', class_='item-description').text.strip()
        try:
            container['card_contact'] = card.find('span', class_='icon-phone').text
        except:
            container['card_contact'] = ''
        
        try:
            img = card.find_all('img')
            if re.search('data-ondemand-img', str(img[0])):
                container['card_img'] = re.search('data-ondemand-img="(.*?)"', str(img[0])).group(1)
            else:
                container['card_img'] = img[0]['src']
        except:
            container['card_img'] = 'https://bitsofco.de/content/images/2018/12/Screenshot-2018-12-16-at-21.06.29.png'
        
        content.append(container)
        
    
    return content

if __name__ == '__main__':
    options = Options()
    options.add_argument('--headless')
    options.add_argument("--window-size=1920,1080")
    driver = webdriver.Firefox(executable_path=f"{os.path.dirname(__file__)}/geckodriver.exe", options=options)
    
    content = {}

    content['onRent'] = get_data(f"https://www.idealista.com/alquiler-viviendas/{sys.argv[1]}/", driver)
    content['onSale'] = get_data(f"https://www.idealista.com/venta-viviendas/{sys.argv[1]}/", driver)
    
    driver.quit()

    print(json.dumps(content))

'''
# Example of tripadvisor content we can return in the API
content = {
    onRent: [
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        },
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        },
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        }
    ],
    onSale: [
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        },
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        },
        {
            'card_title': 'Chalet adosado en San Pablo - Santa Teresa, Albacete',
            'card_detail': '4 hab. 330 m²',
            'card_price': '1.100€/mes',
            'card_description': 'MERAKI vende bonito adosado en vereda de Jaén!',
            'card_contact': '967 654 962',
            'card_link': 'https://www.idealista.com/inmueble/88407419/',
            'card_image': 'https://img3.idealista.com/blur/WEB_LISTING/0/id.pro.es.image.master/8b/2f/36/750930291.jpg'
        }
    ]
}

'''