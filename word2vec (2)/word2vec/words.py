from pyspark.sql import SparkSession
from pyspark.ml.feature import Word2VecModel
from pyspark.sql import DataFrame

MODEL_PATH = "model"

spark = SparkSession \
    .builder \
    .appName("word2vec") \
    .getOrCreate()

model = Word2VecModel.load(MODEL_PATH)
count = 5

while(True):
    try:
        word = input("Введите слово из словаря: ")
        if(word == "--exit"):
            break
        elif(word == "--count"):
            count = int(input("Введите кол-во синонимов: "))
            print(count)
        else:
            model.findSynonyms(word, 10).show(n=10)
    except Exception as ex:
        print("Данного слова нет в словаре!")

spark.stop()
