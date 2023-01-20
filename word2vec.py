PATH = '*.txt'
from pyspark.sql import SparkSession
from pyspark.ml.feature import Tokenizer
from pyspark.ml.feature import StopWordsRemover
from pyspark.ml.feature import Word2Vec
import re
import string
import datetime


def remove_punctuation(text):

   # Удаление пунктуации из текста

    return text.translate(str.maketrans('', '', string.punctuation))


def get_only_words(tokens):
    #Получение списка токенов, содержащих только слова
    return list(filter(lambda x: re.match('[а-яёА-Я]+', x), tokens))


def create_w2v_model():
    spark = SparkSession \
        .builder \
        .appName("SimpleApplication") \
        .config("spark.executor.memory", "6g") \
        .config("spark.driver.memory", "6g") \
        .config("spark.memory.offHeap.enabled", True) \
        .config("spark.memory.offHeap.size", "6g") \
        .getOrCreate()

    input_file = spark.sparkContext.wholeTextFiles(PATH)

    #Подготовка данных
    prepared_data = input_file.map(lambda x: (x[0], remove_punctuation(x[1])))
    df = prepared_data.toDF()
    prepared_df = df.selectExpr('_2 as text')

    #Разбитие на токены
    tokenizer = Tokenizer(inputCol='text', outputCol='words')
    words = tokenizer.transform(prepared_df)

    #Очистка от стоп-слов
    stop_words = StopWordsRemover.loadDefaultStopWords('russian')
    remover = StopWordsRemover(inputCol="words", outputCol="filtered", stopWords=stop_words)

    #Построение модели
    word2Vec = Word2Vec(vectorSize=50, inputCol='words', outputCol='result', minCount=2)
    model = word2Vec.fit(words)

    #Сохранение модели
    today = datetime.datetime.today()
    model_name = today.strftime("model")
    print("""

    Model  """ + model_name + """  saved

    """)
    model.write().overwrite().save(model_name)

    spark.stop()


create_w2v_model()
