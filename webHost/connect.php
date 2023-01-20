<?php
$par1_ip = "localhost";
$par2_name = "root";
$par3_p = "";
$par4_db = "newsHost";

$induction = mysqli_connect($par1_ip, $par2_name, $par3_p, $par4_db);
if($induction == false){
    echo "Ошибка подкл";
}



function konken($value_1, $value_2) {   
    
    $res = $value_1 . $value_2;

    return   $res    ; 
}

$min_print=NULL;
$max_print=NULL;
$title_print=NULL;
$author_print=NULL;
$limitRows_print=NULL;
$countComments_print=NULL;
$content_print=NULL;
$category_print="";
$act="";

#$skript='select photo, FIO, protected_area.name as protected_area, biography, year_of_birth from guards inner join protected_area on guards.id_protected_area=protected_area.id';

$skript ='SELECT news.id, link, title, content, publish_date, author, category, count_comments FROM news';

if(isset($_GET['action'])){
$act=$_GET['action'];
}


$value=0;

if($act == 'set'){
    if($_GET['title']){
        $title_print=$_GET['title'];
        $title=mysqli_real_escape_string($induction, $_GET['title']);

        $script_1 ="news.title LIKE '%" . $title . "%'";

        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }


    if($_GET['author']){
        $author_print=$_GET['author'];
        $author=mysqli_real_escape_string($induction, $_GET['author']);

        $script_1 ="news.author LIKE '%" . $author . "%'";

        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }

    if($_GET['content']){
        $content_print=$_GET['content'];
        $content= mysqli_real_escape_string($induction, $_GET['content']);
        
        $script_1 ="news.content LIKE '%" . $content . "%'";

        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }

    if($_GET['category_name']){
        $category_print=$_GET['category_name'];
        $category=mysqli_real_escape_string($induction,$_GET['category_name']);

        $script_1='news.category="' . $category . '"';

        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }

    if($_GET['min_count']){
        $min_print=$_GET['min_count'];
        $min=(int)$_GET['min_count'];
    
        $script_1 ='count_comments>=' . $min;
    
        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }
    
    if($_GET['max_count']){
        $max_print=$_GET['max_count'];
        $max=(int)$_GET['max_count'];
    
        $script_1 ='count_comments<=' . $max;
    
        if($value == 0){
            $skript .= konken(' WHERE ', $script_1);
            $value=1;
        }
        else{
        $skript .= konken(' AND ', $script_1);
        }
    }

    if($_GET['limitRows']){
        $limitRows_print=$_GET['limitRows'];
        $limitRows = $_GET['limitRows'];
        $skript .= konken(' limit ', $limitRows);
        
    }
    else{
        $skript .= konken(' limit ', 20);
    }

}
else{
    $skript .= konken(' limit ', 20);
}


$result = mysqli_query($induction, $skript);

?>