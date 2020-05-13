<?php

    require_once( "InfoBlock.php" );

    $info = new InfoBlock();
    $main_temp = file_get_contents('../templates/main_temp.html');
    $info_content = file_get_contents('../templates/info/info_content.html');
    $info_block_temp = file_get_contents('../templates/info/info_block_temp.html');
    $main_temp = str_replace('{main_block}',file_get_contents('../templates/main_block_temp.html'),$main_temp);

    $title = "Information";
    $info_description = "";

    try {
        $dbh = new PDO("mysql:host=127.0.0.1;port=3308;dbname=info","root","");
        $sth = $dbh->prepare("SELECT * FROM `advice`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++){
            $info_description .= $info_block_temp;
            $info->photo = $array[$i]['photo'];
            $info->headline = $array[$i]['headline'];
            $info->text = $array[$i]['text'];
            $info->replaceInfo($info_description);
        }

        $sth = $dbh->prepare("SELECT * FROM `description`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++)
        {
            $info_content  = str_replace('{first_par}',$array[$i]['first_par'],$info_content);
            $info_content  = str_replace('{second_par}',$array[$i]['second_par'],$info_content);
            $info_content  = str_replace('{third_par}',$array[$i]['third_par'],$info_content);
        }

    }catch (PDOException $e) {
        die($e->getMessage());
    }
    $info_content = str_replace('{info_description}',$info_description,$info_content);
    $main_temp = str_replace('{main_content}',$info_content,$main_temp);

    $main_temp = str_replace('{title}',$title,$main_temp);
    $main_temp = str_replace('{header}',file_get_contents('../templates/header_temp.html'),$main_temp);
    $main_temp = str_replace('{links}',file_get_contents('../templates/links_temp.html'),$main_temp);
    $main_temp = str_replace('{footer}',file_get_contents('../templates/footer_temp.html'), $main_temp);
    $main_temp = str_replace('{year}',date('Y'),$main_temp);
    $main_temp = str_replace('{style}',file_get_contents('../templates/info/info_style.html'),$main_temp);
    
    echo $main_temp;