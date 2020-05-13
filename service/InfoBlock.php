<?php


class InfoBlock
{
    public $photo;
    public $headline;
    public $text;

    public function __construct()
    {
        $this->photo = "";
        $this->headline = "";
        $this->text = "";
    }

    public function replaceInfo(&$main_temp)
    {
        $main_temp = str_replace('{photo}', $this->photo, $main_temp);
        $main_temp = str_replace('{headline}', $this->headline, $main_temp);
        $main_temp = str_replace('{text}', $this->text, $main_temp);
    }
}