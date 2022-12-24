<?php
include("connect.php");
?>
<?php
    session_start();
?>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        
    </head>
    <body>

        <!-- основная часть -->
        <div class="FormCenter">   
        <div class="mx-auto">   
            <!-- разворачиваемая кнопка с поиском -->
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Фильтр поиска записям
            </button></div>
        </div>
 
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <!-- правильный фильтр -->
            <section class="sort container">


                <form action="" method="get">
                    <div class="row">
                        <h5 class="txt_white">Заголовок:</h5>
                        <input type="text" placeholder="Введите заголовок" name="title" value="<?php echo $title_print ?>">

                        <h5 class="txt_white">Автор:</h5>
                        <input type="text" placeholder="Введите автора" name="author" value="<?php echo $author_print ?>">

                        <h5 class="txt_white">Содержание:</h5>
                        <input type="text" placeholder="Введите часть содержания" name="content" value="<?php echo $content_print ?>">
                        
                        <h5 class="txt_white">Категория:</h5>
                        <select name="category_name" id="" selected="<?php echo $category_print ?>">
                            <option value="" >Не выбрано</option>
                            <option value="Происшествия" <?php if($category_print == 'Происшествия'){ ?> selected="selected"<?php }?>>Происшествия</option>
                            <option value="Общество"<?php if($category_print == 'Общество'){ ?> selected="selected"<?php }?>>Общество</option>
                            <option value="ЖКХ"<?php if($category_print == 'ЖКХ'){ ?> selected="selected"<?php }?>>ЖКХ</option>
                            <option value="Инфраструктура"<?php if($category_print == 'Инфраструктура'){ ?> selected="selected"<?php }?>>Инфраструктура</option>
                            <option value="Экология"<?php if($category_print == 'Экология'){ ?> selected="selected"<?php }?>>Экология</option>
                            <option value="Транспорт"<?php if($category_print == 'Транспорт'){ ?> selected="selected"<?php }?>>Транспорт</option>
                            <option value="Здравоохранение"<?php if($category_print == 'Здравоохранение'){ ?> selected="selected"<?php }?>>Здравоохранение</option>
                            <option value="Фотогалереи"<?php if($category_print == 'Фотогалереи'){ ?> selected="selected"<?php }?>>Фотогалереи</option>
                            <option value="Коронавирус"<?php if($category_print == 'Коронавирус'){ ?> selected="selected"<?php }?>>Коронавирус</option>
                            <option value="Религия"<?php if($category_print == 'Религия'){ ?> selected="selected"<?php }?>>Религия</option>
                        </select>

                        <h5 class="txt_white">Количество комментариев:</h5>
                        <input type="text" placeholder="От" name="min_count" value="<?php echo $min_print ?>">
                        <input type="text" placeholder="До" name="max_count" value="<?php echo $max_print ?>">
                            
                        <h5 class="txt_white">Количество строк:</h5>
                        <input type="number" step="1" min="1" max="20000" value="<?php echo $limitRows_print ?>" name="limitRows">

                            
                    
                    </div>

                    <div class="row"> 
                            <button type="submit" name="action" value="set">Применить</button>  
                            <button type="submit" name="action" value="clear">Очистить</button>          
                    </div>
                </form>
            </section>

        </div>
    </div>

    <!-- выведем таблицу -->

    <div class="container text-center mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ссылка</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Содержание</th>
                            <th scope="col">Дата публикации</th>
                            <th scope="col">Автор</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Количество комментариев</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   while($bd = mysqli_fetch_assoc($result)) {?>
                            <tr>
                                <td><a href = "<?php echo $bd['link'];?>"><?php echo $bd['link'];?></a></td>
                                <td><?php echo $bd['title'];?></td>
                                <td> 
                                <!-- <div class="col text-truncate" style="max-width: 150px;"> -->
                                    <?php echo $bd['content'];?>
                                <!-- </div> -->
                                </td>
                                <td> <?php echo $bd['publish_date'];?></td>
                                <td> <?php echo $bd['author'];?></td>
                                <td><?php echo $bd['category']; ?></td>
                                <td> <?php echo $bd['count_comments'];?></td>
                            </tr>
                            <?php 
                            }
                            ?>
                    </tbody>
                </table>
        </div>


        <!-- конец основной части -->

        <!-- подключим скрипт-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>

</html>