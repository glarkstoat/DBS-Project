# -*- coding: utf-8 -*-
"""
Created on Sat May 30 13:13:51 2020

@author: Christian Wiskott
"""
import numpy as np
import random

# Creates all phone numbers randomly
phone = "+43"
numbers = open('PhoneNumbers.txt', 'w')
list_check = []

for i in range(1000):
    randint = random.randint(1e+7, 1e+8)
    tup = '"'+phone + str(randint) + '"\n'
    if (tup not in list_check):
        list_check.append(tup)
        numbers.write(tup)
    #numbers.write('"'+phone + str(randint) + '"\n')

numbers.close()



# Creates all names randomly

first = np.loadtxt('FirstNames.txt', dtype=np.str)
last = np.loadtxt('LastNames.txt', dtype=np.str)

names = open('names_data.txt', 'w')

for f in first:
    r = random.randint(0, len(last))
    names.write('"'+ f + '","' + last[r] + '"\n')

names.close()


# Creates all locations

zip_code = np.genfromtxt('plz.txt', usecols=0)
city = np.genfromtxt('plz.txt', usecols=1, dtype=str)
zips = []; cities = []
data = open('zip_code_cites.txt', 'w')

for i in range(len(city)):
    if (zip_code[i] % 10 == 0):
        data.write('"'+str(int(zip_code[i]))+'","'+city[i]+'"\n')
        
data.close()


# Creates all employees randomly

phones = np.genfromtxt('PhoneNumbers.txt', dtype=str)
first = np.loadtxt('FirstNames.txt', dtype=np.str)
last = np.loadtxt('LastNames.txt', dtype=np.str)
employees = open('employees.txt', 'w')
for i in range(len(phones)):
    r = random.randint(0, len(last)-1)
    r2 = random.randint(0, len(first)-1)
    r3 = random.randint(0, len(phones)-1)
    employees.write('"' + first[r2] + '","'+ last[r] +'",'+phones[r3]+'\n')

employees.close()


# Creates all customers randomly

phones = np.genfromtxt('PhoneNumbers.txt', dtype=str)
first = np.loadtxt('FirstNames.txt', dtype=np.str)
last = np.loadtxt('LastNames.txt', dtype=np.str)
license_nr = np.genfromtxt('LicenceNumbers.txt', dtype=str)
customers = open('customers.txt', 'w')
gender = ["m", "f"]

for i in range(len(license_nr)):
    a = random.randint(0,1)
    r = random.randint(0, len(last)-1)
    r2 = random.randint(0, len(first)-1)
    customers.write(license_nr[i] + ',"' + first[r2] + '","'+ last[r] + '",' + phones[i] + ',"' + gender[a] + '"\n')
   
customers.close()


# Creates all order dates randomly

days = {1:31, 2:28, 3:31, 4:30, 5:31, 6:30, 7:31, 8:31, 9:30, 10:31, 11:30, 12:31}
times = open('times.txt', 'w')

for i in range(2000):
    r_hour = random.randint(0,23); r_minute = random.randint(0,59); r_sec = random.randint(0,59)
    
    r_month = random.randint(1,11);
    r_day = random.randint(1,days[r_month])
    rented = random.randint(1,21)
    times.write('"2020-'+str(r_month)+'-'+str(r_day)+' '+str(r_hour)+':'+str(r_minute)+':'+str(r_sec)+'"')
    
    if r_day+rented > days[r_month]:
        r_day = (r_day+rented)-days[r_month]
        r_month = r_month + 1
    else:
        r_day = r_day + rented
        
    times.write(',"2020-'+str(r_month)+'-'+str(r_day)+' '+str(r_hour)+':'+str(r_minute)+':'+str(r_sec)+'"\n')

times.close()
