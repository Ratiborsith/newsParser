# импорт библиотек
from bs4 import BeautifulSoup   # библиотека для парсинга
import pymysql  # для связи с mysql
import datetime
import requests
import re

from time import sleep
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By

from selenium.webdriver.chrome.options import Options

import lxml

def insert_link(col1):
    # вставка в таблицу бд
    con = pymysql.connect(host='localhost', user='root', password='Sidiham',
                          database='news')  # подключим базу данных
    with con:
        cursor = con.cursor()
        data_list = (col1)
        cursor.execute("""
                        INSERT INTO links (link) 
                        VALUES (%s);
                            """, data_list)
        con.commit()
        cursor.close()


def check_news(title):
    # проверка статьи на наличие в базе
    con = pymysql.connect(host='localhost', user='root', password='Sidiham',
                          database='news')  # подключим базу данных
    with con:
        cursor = con.cursor()
        cursor.execute("""SELECT title FROM news WHERE title = %s """, (title,))
        result = cursor.fetchall()
        if len(result) == 0:
            #print('[INFO] Такой записи нет')
            return 0
        else:
            print('[X] Такая запись существует')
            return 1


def get_data_from_db():
    # получение данных из бд
    con = pymysql.connect(host='localhost', user='root', password='Sidiham',
                          database='news')  # подключим базу данных
    with con:
        cursor = con.cursor()
        cursor.execute("""SELECT link FROM links""")
        # вывод всех новостей
        data_set = cursor.fetchall()
        return data_set


if __name__ == '__main__':
    # основная часть кода
    # -------------------------------------
    # нажмем на кнопку "посмотреть еще" 600 раз

    driver = webdriver.Firefox()
    link = "https://vlg-media.ru/"
    driver.get(link)
    count = 0
    while count < 1800:
        # работает!!!!
        button_element = driver.find_element(By.CLASS_NAME, "alm-load-more-btn")
        driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        button_element.click()
        # alm-load-more-btn more


        count = count + 1
        sleep(1)
        print(count)


    #  блок с новостями
    news = driver.find_elements(By.TAG_NAME, "a")

    # создаем список ссылок на новости
    link_news = []
    for new in news:
        try:
            link = new.get_attribute("href")
        except Exception as ex:
            print(ex)
            link = 'не найдена'

        # чтобы отбросить лишние, поставим ограничение по длине
        if link == None:
            link = 'нет'
        if len(link) > 60 and (link not in link_news):
            link_news.append(link)
            insert_link(link)       # добавим новость в список новостей
        # print(link)
    print(f'Найдено {len(link_news)} новостей')