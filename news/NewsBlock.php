<?php


class NewsBlock
{
    public $photo;
    public $headline;
    public $first_par;
    public $second_par;

    public function __construct()
    {
        $this->photo = "";
        $this->headline = "";
        $this->first_par = "";
        $this->second_par = "";
    }

    public function replaceInfo(&$main_temp)
    {
        $main_temp = str_replace('{photo}', $this->photo, $main_temp);
        $main_temp = str_replace('{headline}', $this->headline, $main_temp);
        $main_temp = str_replace('{first_par}',$this->first_par,$main_temp);
        $main_temp = str_replace('{second_par}',$this->second_par,$main_temp);
    }
}