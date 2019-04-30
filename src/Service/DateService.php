<?php


namespace App\Service;

class DateService extends \DateTime
{
    public function formatFromDb(string $dateToFormat) :array
    {
        $date = new \DateTime($dateToFormat);
        $time = $date->format('H:i');
        $date = $date->format('d-m-Y');

        return array($date, $time);
    }

    public function daysToNow($date)
    {
        $now = new \DateTime('now');
        $date = new \DateTime($date);
        $diff = $now->diff($date);

        return $diff->format('%d');
    }

    public function setToFormat(array $arr) :array
    {
        foreach ($arr as $key => $data) {
            $output = $this->formatFromDb($data['date_resa']);
            list($date, $time) = $output;
            $arr[$key]['date'] = $date;
            $arr[$key]['arrival'] = $time;
            $arr[$key]['daysToDate'] = $this->daysToNow($date);
        }

        return $arr;
    }
}
