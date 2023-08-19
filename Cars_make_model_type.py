""" Retrieves car data from online database """

import json
import urllib
import requests
import random
headers = {
    'X-Parse-Application-Id': 'hlhoNKjOvEhqzcVAJ1lxjicJLZNVv36GdbboZj3Z',
    'X-Parse-Master-Key': 'SNMJJF0CZZhTPhLDIqGhTlUNV9r60M2Z5spyWfXW' 
}

url = 'https://parseapi.back4app.com/classes/Car_Model_List_Mercedes_Benz?limit=1000&excludeKeys=Year'

data_mercedes = json.loads(requests.get(url, headers=headers).content.decode('utf-8'))['results'] # Here you have the data that you need

url = 'https://parseapi.back4app.com/classes/Car_Model_List_Land_Rover?excludeKeys=Year'

data_range = json.loads(requests.get(url, headers=headers).content.decode('utf-8'))['results'] # Here you have the data that you need

url = 'https://parseapi.back4app.com/classes/Car_Model_List_BMW?limit=1000&excludeKeys=Year'

data_BMW = json.loads(requests.get(url, headers=headers).content.decode('utf-8'))['results'] # Here you have the data that you need

url = 'https://parseapi.back4app.com/classes/Car_Model_List_Audi?limit=1000&excludeKeys=Year'

data_audi = json.loads(requests.get(url, headers=headers).content.decode('utf-8'))['results'] # Here you have the data that you need

url = 'https://parseapi.back4app.com/classes/Car_Model_List_Rolls_Royce?limit=1000&excludeKeys=Year'

data_rolls = json.loads(requests.get(url, headers=headers).content.decode('utf-8'))['results'] # Here you have the data that you need

# Creates list of all make/models
cars = open('cars.txt', 'w')
cars.write('# make model type\n')
for i in range(len(data_mercedes)):
    mileage = random.randint(1,10000)
    consump = random.randint(4,10)
    cars.write('"'+data_mercedes[i]['Make'] + '","' + data_mercedes[i]['Model']  + '","' + str(mileage) + '","' + str(consump) + '"\n')
for i in range(len(data_range)):
    mileage = random.randint(1,10000)
    consump = random.randint(4,10)
    cars.write('"'+data_range[i]['Make'] + '","' + data_range[i]['Model'] + '","' + str(mileage) + '","' + str(consump) + '"\n')
for i in range(len(data_BMW)):
    mileage = random.randint(1,10000)
    consump = random.randint(4,10)
    cars.write('"'+data_BMW[i]['Make'] + '","' + data_BMW[i]['Model']  + '","' + str(mileage) + '","' + str(consump) + '"\n')
for i in range(len(data_audi)):
    mileage = random.randint(1,10000)
    consump = random.randint(4,10)
    cars.write('"'+data_audi[i]['Make'] + '","' + data_audi[i]['Model'] + '","' + str(mileage) + '","' + str(consump) + '"\n')
for i in range(len(data_rolls)):
    mileage = random.randint(1,10000)
    consump = random.randint(4,10)
    cars.write('"'+data_rolls[i]['Make'] + '","' + data_rolls[i]['Model'] + '","' + str(mileage) + '","' + str(consump) + '"\n')

cars.close()

mileage = random.randint(1,10000)
consump = random.randint(4,10)


# Creates complete list of all make/models

models = [data_rolls[i]['Model'] for i in range(len(data_rolls))]; models = list(dict.fromkeys(models))

types = {"Coupe": 1, "Convertible": 2,"Sedan": 3,"SUV": 4, "Van/Minivan": 5, "Hatchback":6, "Wagon":7}

cars = open('cars_mer.txt', 'w')
for el in data_rolls:
    for mod in models:
        if el['Model'] in models:
            cars.write('"'+el['Make'] + '","'+ mod + '","' + str(random.randint(70,100))+ '","' + str(types[el['Category'].split(",")[0]]) + '"\n')
            models.remove(mod)
cars.close()

models = [data_mercedes[i]['Model'] for i in range(len(data_mercedes))]; models = list(dict.fromkeys(models))

cars = open('cars_mer.txt', 'a')
for el in data_mercedes:
    for mod in models:
        if el['Model'] in models:
            cars.write('"'+el['Make'] + '","'+ mod + '","'  + str(random.randint(70,100))+ '","' + str(types[el['Category'].split(",")[0]])+'"\n')
            models.remove(mod)
cars.close()

models = [data_audi[i]['Model'] for i in range(len(data_audi))]; models = list(dict.fromkeys(models))

cars = open('cars_mer.txt', 'a')
for el in data_audi:
    for mod in models:
        if el['Model'] in models:
            cars.write('"'+el['Make'] + '","'+ mod + '","' + str(random.randint(70,100))+ '","' + str(types[el['Category'].split(",")[0]])+'"\n')
            models.remove(mod)
cars.close()

models = [data_BMW[i]['Model'] for i in range(len(data_BMW))]; models = list(dict.fromkeys(models))

cars = open('cars_mer.txt', 'a')
for el in data_BMW:
    for mod in models:
        if el['Model'] in models:
            cars.write('"'+el['Make'] + '","'+ mod + '","'  + str(random.randint(70,100))+ '","' + str(types[el['Category'].split(",")[0]])+'"\n')
            models.remove(mod)
cars.close()

models = [data_range[i]['Model'] for i in range(len(data_range))]; models = list(dict.fromkeys(models))

cars = open('cars_mer.txt', 'a')
for el in data_range:
    for mod in models:
        if el['Model'] in models:
            cars.write('"'+el['Make'] + '","'+ mod + '","'  + str(random.randint(70,100))+ '","' + str(types[el['Category'].split(",")[0]])+'"\n')
            models.remove(mod)
cars.close()

# Creates all license numbers randomly

licence = open('LicenceNumbers.txt', 'w')
list1 = ["W", "G", "S", "VI"]
list2 = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
list_check = []
for i in range(1000):
    randint = random.randint(10000, 99999)
    rand2 = random.randint(0, len(list1)-1)
    rand3 = random.randint(0, 25)
    tup = '"'+list1[rand2]+str(randint) +list2[rand3].upper()+ '"\n'
    if (tup not in list_check):
        list_check.append(tup)
        licence.write(tup)

licence.close()

