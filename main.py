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

def insert_news(col1, col2, col3, col4, col5, col6, col7):
    # вставка в таблицу бд
    con = pymysql.connect(host='localhost', user='root', password='Sidiham',
                          database='news')  # подключим базу данных
    with con:
        cursor = con.cursor()
        data_list = (col1, col2, col3, col4, col5, col6, col7)
        cursor.execute("""
                        INSERT INTO news (link, title, content, publish_date, author, category, count_comments) 
                        VALUES (%s, %s, %s, %s, %s, %s, %s);
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
        cursor.execute("""SELECT title, link, publish_date FROM news""")
        # вывод всех новостей
        data_set = cursor.fetchall()
        return data_set


def get_link_from_db(id):
    # получение данных из бд
    con = pymysql.connect(host='localhost', user='root', password='Sidiham',
                          database='news')  # подключим базу данных
    with con:
        cursor = con.cursor()
        cursor.execute("""SELECT link FROM links WHERE title = %s """, (id,))
        # вывод всех новостей
        data_set = cursor.fetchall()
        return data_set

def get_links_from_db():
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
    # -------------------------------------

    # выгрузим все статьи
    # -------------------------------------
    headers = {
        'User-Agent': 'Mozilla/5.0 ',
        'Accept': '*/*'
    }

    # 2 часть
    # создаем список ссылок на новости. Выгрузим это из таблицы ссылок
    link_news = get_links_from_db()

    # 3 часть
    # забираем контент новостей перебирая ссылки
    count = 1
    for link in link_news:
        if count <=2827:
            count +=1
            continue


        r = requests.get(url=link[0], headers=headers)
        soup = BeautifulSoup(r.content, 'html.parser')
        # получаем название статьи, текст статьи, дату публикации
        title = soup.h1.get_text(strip=True)

        # получим текст статьи

        content = soup.find('div', class_='entry-content').get_text(strip=True)

        # получим дату публикации
        publish_date = soup.find('time').get_text(strip=True)

        # получим автора
        author = soup.find('div', class_='uk-text-meta').get_text(strip=True)

        # получим категорию
        category = soup.find('span', class_='category-name').get_text(strip=True)

        # получим количество комментариев

        count_comments = soup.find("span", class_='wpdtc').get_text(strip=True)

        # !!! дополнить полями из задания семы !!!

        print(f'Парсим страницу с новостью:\nЗаголовок: "{title[:30]}..." ({count} из {len(link_news)})')
        count += 1

        # вставляем запись в бд
        try:
            insert_news(link, title, content, publish_date, author, category, count_comments)
            print('[INFO] Новость добавлена в БД')
        except Exception as ex:
            print('[X] Ошибка вставки данных в бд: ', ex)
            continue

    # вывод данных с бд
    data_set = get_data_from_db()
    for data in data_set:
        print(data)