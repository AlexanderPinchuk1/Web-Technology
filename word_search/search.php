<?php
    if (!empty($_FILES["file"]))
    {
        if ($_FILES["file"]["tmp_name"] != "")
        {
            $str = file_get_contents($_FILES["file"]["tmp_name"]);
            $file = fopen('text.txt',"w");
            fwrite($file,$str);
            fclose($file);
        }
    }

    if (file_exists('text.txt'))
        $str = file_get_contents('text.txt');
    else
        $str = "";

    if (!empty($_POST["search"]))
    {
        $expStr = explode(" ", $_POST["search"]);
        if (substr($_POST["search"], 0, 1) == "\"")
        {
            $word = str_replace("\"", "", $_POST["search"]);
            $patterns = "/$word/";
            $replacements = "<span>$word</span>";
            $str = preg_replace($patterns, $replacements, $str);
        }
        else if (is_array($expStr))
        {
            for ($i = 0; $i < count($expStr); $i++)
            {
                $patterns = "/$expStr[$i]/";
                $replacements = "<span>$expStr[$i]</span>";
                $str = preg_replace($patterns, $replacements, $str);
            }
        }
    }