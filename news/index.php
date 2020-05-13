<?php

    require_once ("NewsBlock.php");

    $news_info = new NewsBlock();

    $main_temp = file_get_contents('../templates/main_temp.html');
    $main_temp = str_replace('{main_block}',file_get_contents('../templates/main_block_temp.html'),$main_temp);
    $title = "News";

    $news_description = "";
    $info_temp = file_get_contents('../templates/news/news_block_temp.html');

    try {
        $dbh = new PDO("mysql:host=127.0.0.1;port=3308;dbname=news","root","");
        $sth = $dbh->prepare("SELECT * FROM `news`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++)
        {
            $news_description .= $info_temp;
            $news_info->photo = $array[$i]['photo'];
            $news_info->headline = $array[$i]['headline'];
            $news_info->first_par = $array[$i]['first_par'];
            $news_info->second_par = $array[$i]['second_par'];
            $news_info->replaceInfo($news_description);
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $main_temp = str_replace('{main_content}',$news_description,$main_temp);

    $main_temp = str_replace('{title}',$title,$main_temp);
    $main_temp = str_replace('{header}',file_get_contents('../templates/header_temp.html'),$main_temp);
    $main_temp = str_replace('{links}',file_get_contents('../templates/links_temp.html'),$main_temp);
    $main_temp = str_replace('{footer}',file_get_contents('../templates/footer_temp.html'), $main_temp);
    $main_temp = str_replace('{year}',date('Y'),$main_temp);
    $main_temp = str_replace('{style}',file_get_contents('../templates/news/news_style.html'),$main_temp);

    echo $main_temp;