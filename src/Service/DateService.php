<?php


namespace App\Service;

class DateService extends \DateTime
{
    public function formatFromDb($dateToFormat)
    {
        $date = new \DateTime($dateToFormat);
        $time = $date->format('H:i');
        $date = $date->format('d-m-Y');

        return array($date, $time);
    }
}
