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

    public function setToFormat(array $arr) :array
    {
        foreach ($arr as $key => $data) {
            $output = $this->formatFromDb($data['date_resa']);
            list($date, $time) = $output;
            $arr[$key]['date'] = $date;
            $arr[$key]['arrival'] = $time;
        }

        return $arr;
    }
}
