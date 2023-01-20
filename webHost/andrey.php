<?php
include("connectAndrey.php");
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
                            <th scope="col">id</th>
                            <th scope="col">Предложение</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   while($bd = mysqli_fetch_assoc($result)) {?>
                            <tr>
                                <td><?php echo $bd['id_sentence'];?></td>
                                <td><?php echo $bd['text_sentence'];?></td>

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