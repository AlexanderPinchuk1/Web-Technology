<?php


class FilterBlockProperties
{
    public $label;
    public $settings;

    public function  __construct()
    {
        $this->label="";
        $this->settings="";
    }

    public function replaceInfo(&$main_temp)
    {
        $main_temp = str_replace('{label}',$this->label,$main_temp);
        $main_temp = str_replace('{settings}',$this->settings,$main_temp);
    }
}