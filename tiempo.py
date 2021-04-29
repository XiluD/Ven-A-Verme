import tweepy
import webbrowser
import time
import schedule
import requests #Por la API del tiempo
import json
from datetime import datetime


def get_municipio(municipio):
    response = requests.get("https://www.el-tiempo.net/api/json/v2/municipios")
    print(response.status_code) #Comprobamos el status de la respuesta que hemos recibido
    #Sale 200 por lo que la recibimos bien
    #response.JSON es lo que nosotros queremos leer.
    data = response.json() 
    print(type(data))
    longitud = len(data)
    #print(data)
    x = 0
    while x < longitud:
        codigo_municipio = data[x]['COD_GEO']
        codigo_provincia = data[x]['CODPROV']
        nombre_municipio = data[x]['NOMBRE']
        if nombre_municipio == municipio:
            datos = {}
            response = requests.get('https://www.el-tiempo.net/api/json/v2/provincias/' + codigo_provincia +'/municipios/' + codigo_municipio, data = datos)
            print(response.status_code)
            data = response.json()
            #print(data)
            #print(data['stateSky']['description'])
            estado_tiempo = data['stateSky']['description']
            temp_actual = data['temperatura_actual']
            temp_max = data['temperaturas']['max']
            temp_min = data['temperaturas']['min']
    
            print('Estado: ' + estado_tiempo + '\n' +  'Temperatura actual: ' + temp_actual + '\n' + 'Temperatura maxima: ' + temp_max + '\n' +'Temperatura minima: ' + temp_min)
            break
        x = x+1

#Esta funcion ya esta metida en la de encima por lo que en si mismo ya no hace falta
def get_tiempo(comunidad, municipio):
    datos = {}
    response = requests.get('https://www.el-tiempo.net/api/json/v2/provincias/' + comunidad +'/municipios/' + municipio, data = datos)
    print(response.status_code)
    data = response.json()
    #print(data)
    #print(data['stateSky']['description'])
    estado_tiempo = data['stateSky']['description']
    temp_actual = data['temperatura_actual']
    temp_max = data['temperaturas']['max']
    temp_min = data['temperaturas']['min']
    
    print('Estado: ' + estado_tiempo + '\n' +  'Temperatura actual: ' + temp_actual + '\n' + 'Temperatura maxima: ' + temp_max + '\n' +'Temperatura minima: ' + temp_min)


if __name__ == '__main__':
    municipio = 'Vitoria-Gasteiz'
    get_municipio(municipio)
    #get_tiempo(cod_municipio, cod_provincia)
    
        

