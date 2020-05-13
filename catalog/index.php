<?php
    require_once( "CarProperties.php" );
    require_once ("FilterBlockProperties.php");

    $car_properties = new CarProperties();
    $filter_block_properties = new FilterBlockProperties();

    $title = "Catalog";
    $main_temp = file_get_contents('../templates/main_temp.html');
    $main_temp =str_replace('{main_block}', file_get_contents('../templates/main_block_temp.html'),$main_temp);
    $car_block_temp = file_get_contents('../templates/catalog/car_block_temp.html');
    $block_in_filter_temp = file_get_contents('../templates/catalog/block_in_filter_temp.html');
    $main_content = file_get_contents('../templates/catalog/catalog_content.html');

    $filter_description = "";

    $car_description="";

    try {
        $dbh = new PDO("mysql:host=127.0.0.1;port=3308;dbname=catalog","root","");

        $sth = $dbh->prepare("SELECT * FROM `filter`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++) {
            $filter_description .= $block_in_filter_temp;
            $filter_block_properties->label = $array[$i]['label'];
            $filter_block_properties->settings = $array[$i]['settings'];
            $filter_block_properties->replaceInfo($filter_description);
        }

        $sth = $dbh->prepare("SELECT * FROM `cars`");
        $sth->execute();
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

        for($i=0;$i<count($array);$i++)
        {
            if ((!empty($_POST["SPrice"])) && ($_POST['SPrice'] != ""))
                if ($array[$i]['price']<$_POST['SPrice'])
                    continue;

            if ((!empty($_POST["FPrice"])) && ($_POST['FPrice'] != ""))
                if ($array[$i]['price']>$_POST['FPrice'])
                    continue;

            if ((!empty($_POST["SYear"])) && ($_POST['SYear'] != ""))
                if ($array[$i]['year']<$_POST['SYear'])
                    continue;

            if ((!empty($_POST["FYear"])) && ($_POST['FYear'] != ""))
                if ($array[$i]['year']>$_POST['FYear'])
                    continue;

            if ((!empty($_POST["TypeBody"])) && ($_POST['TypeBody'] != ""))
                if (strcasecmp($array[$i]['body'],$_POST['TypeBody']) != 0)
                    continue;

            if ((!empty($_POST["Gearbox"])) &&($_POST['Gearbox'] != ""))
                if (strcasecmp($array[$i]['gearbox'],$_POST['Gearbox']) != 0)
                    continue;

            if ((!empty($_POST["TypeEngine"])) && ($_POST['TypeEngine'] != ""))
                if (strcasecmp($array[$i]['fuel'],$_POST['TypeEngine']) != 0)
                    continue;

            if ((!empty($_POST["SVolume"]))&&($_POST['SVolume'] != ""))
                if ($array[$i]['volume']<$_POST['SVolume'])
                    continue;

            if ((!empty($_POST["FVolume"]))&&($_POST['FVolume'] != ""))
                if ($array[$i]['volume']>$_POST['FVolume'])
                    continue;

            if ((!empty($_POST["SMileage"]))&&($_POST['SMileage'] != ""))
                if ($array[$i]['mileage']<$_POST['SVolume'])
                    continue;

            if ((!empty($_POST["FMileage"]))&&($_POST['FMileage'] != ""))
                if ($array[$i]['mileage']>$_POST['FMileage'])
                    continue;


            $car_description .= $car_block_temp;
            $car_properties->photo = $array[$i]['photo'];
            $car_properties->carModel = $array[$i]['headline'];
            $car_properties->mileage = $array[$i]['mileage'];
            $car_properties->year = $array[$i]['year'];
            $car_properties->gearbox = $array[$i]['gearbox'];
            $car_properties->volume = $array[$i]['volume'];
            $car_properties->typeFuel = $array[$i]['fuel'];
            $car_properties->body = $array[$i]['body'];
            $car_properties->driveUnit = $array[$i]['drive_unit'];
            $car_properties->price = $array[$i]['price'];
            $car_properties->tel = $array[$i]['tel'];
            $car_properties->replaceInfo($car_description);
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $main_content = str_replace('{car_description}',$car_description,$main_content);
    $main_content = str_replace('{filter_description}',$filter_description,$main_content);
    
    $main_temp = str_replace('{main_content}',$main_content,$main_temp);

    $main_temp = str_replace('{title}', $title, $main_temp);
    $main_temp = str_replace('{header}', file_get_contents('../templates/header_temp.html'), $main_temp);
    $main_temp = str_replace('{links}', file_get_contents('../templates/links_temp.html'), $main_temp);
    $main_temp = str_replace('{footer}', file_get_contents('../templates/footer_temp.html'), $main_temp);
    $main_temp = str_replace('{style}',file_get_contents('../templates/catalog/catalog_style.html'),$main_temp);
    $main_temp = str_replace('{year}',date('Y'),$main_temp);

echo $main_temp;