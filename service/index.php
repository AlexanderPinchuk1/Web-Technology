<?php

    require_once( "InfoBlock.php" );
    $info = new InfoBlock();

    $main_temp = file_get_contents('../templates/main_temp.html');
    $main_temp = str_replace('{main_block}',file_get_contents('../templates/main_block_temp.html'),$main_temp);
    $title = "Service";
    $promise_headline = "We promise";

    $service_content = file_get_contents('../templates/service/promise_info_temp.html');
    $service_content = str_replace("{headline}",$promise_headline,$service_content);

    $service_content .= file_get_contents('../templates/service//services_content.html');

    $service_blocks="";
    $service_block_temp = file_get_contents('../templates/service/service_block_temp.html');
    $block_promise_temp = file_get_contents('../templates/service/block_promise_temp.html');
    $promise_content = "";

    try {
        $dbh = new PDO("mysql:host=127.0.0.1;port=3308;dbname=service","root","");

        $sth = $dbh->prepare("SELECT * FROM `arguments`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        for($i=0;$i<count($array);$i++)
        {
            $promise_content .= $block_promise_temp;
            $promise_content = str_replace('{first_arg}',$array[$i]['first_arg'],$promise_content);
            $promise_content = str_replace('{second_arg}',$array[$i]['second_arg'],$promise_content);
            $promise_content = str_replace('{third_arg}',$array[$i]['third_arg'],$promise_content);
        }

        $sth = $dbh->prepare("SELECT * FROM `service`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++)
        {
            $service_blocks .= $service_block_temp;
            $info->photo = $array[$i]['photo'];
            $info->headline = $array[$i]['headline'];
            $info->text = $array[$i]['text'];
            $info->replaceInfo($service_blocks);
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
    
    $service_content = str_replace("{promise_content}",$promise_content,$service_content);
    $service_content = str_replace('{service_blocks}',$service_blocks,$service_content);

    $service_content .= file_get_contents('../templates/service/contact_info.html');

    $main_temp = str_replace('{main_content}',$service_content,$main_temp);
    $main_temp = str_replace('{title}',$title,$main_temp);
    $main_temp = str_replace('{header}',file_get_contents('../templates/header_temp.html'),$main_temp);
    $main_temp = str_replace('{links}',file_get_contents('../templates/links_temp.html'),$main_temp);
    $main_temp = str_replace('{footer}',file_get_contents('../templates/footer_temp.html'), $main_temp);
    $main_temp = str_replace('{year}',date('Y'),$main_temp);
    $main_temp = str_replace('{style}',file_get_contents('../templates/service/service_style.html'),$main_temp);

    echo $main_temp;