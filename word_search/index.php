<?php


    $main_temp = file_get_contents('../templates/main_temp.html');
    $main_temp = str_replace('{main_block}',file_get_contents('../templates/main_block_temp.html'),$main_temp);
    $title = "Founder words";
    $main_temp = str_replace('{title}',$title,$main_temp);
    $main_temp = str_replace('{header}',file_get_contents('../templates/header_temp.html'),$main_temp);
    $main_temp = str_replace('{links}',file_get_contents('../templates/links_temp.html'),$main_temp);
    $main_temp = str_replace('{footer}',file_get_contents('../templates/footer_temp.html'), $main_temp);
    $main_temp = str_replace('{year}',date('Y'),$main_temp);
    $main_temp = str_replace('{style}',file_get_contents('../templates/word_search/word_search_style.html'),$main_temp);

    $str = "";

    include 'search.php';
    
    $main_content = file_get_contents('../templates/word_search/forms.html');
    $main_content = str_replace('{text}',$str,$main_content);

    $main_temp = str_replace('{main_content}',$main_content,$main_temp);

    echo $main_temp;