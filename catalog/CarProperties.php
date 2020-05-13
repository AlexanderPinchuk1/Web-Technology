<?php


class CarProperties
{
    public $photo;
    public  $carModel;
    public  $mileage;
    public  $year;
    public  $gearbox;
    public  $volume;
    public  $typeFuel;
    public  $body;
    public  $driveUnit;
    public  $price;
    public  $tel;

    public function __construct()
    {
        $this->photo = "";
        $this->carModel = "";
        $this->mileage = 0;
        $this->year = 0;
        $this->gearbox = "";
        $this->volume = 0.0;
        $this->typeFuel = "";
        $this->body = "";
        $this->driveUnit = "";
        $this->price = 0;
        $this->tel = "";
    }

    public function replaceInfo(&$main_temp)
    {
        $main_temp = str_replace('{photo}',$this->photo,$main_temp);
        $main_temp = str_replace('{car_model}',$this->carModel,$main_temp);
        $main_temp = str_replace('{mileage}',$this->mileage,$main_temp);
        $main_temp = str_replace('{year}',$this->year,$main_temp);
        $main_temp = str_replace('{gearbox}',$this->gearbox,$main_temp);
        $main_temp = str_replace('{volume}',$this->volume,$main_temp);
        $main_temp = str_replace('{type_fuel}',$this->typeFuel,$main_temp);
        $main_temp = str_replace('{body}',$this->body,$main_temp);
        $main_temp = str_replace('{drive_unit}',$this->driveUnit,$main_temp);
        $main_temp = str_replace('{price}',$this->price,$main_temp);
        $main_temp = str_replace('{tel}',$this->tel,$main_temp);
    }

}