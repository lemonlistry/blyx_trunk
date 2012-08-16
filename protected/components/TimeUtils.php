<?php


class TimeUtils {

    //format like YYYY-MM-DD
    public static function isValidDateString($dateString)
    {
        list($year, $month, $day) = explode("-", $dateString);
        if (is_numeric($year) && is_numeric($month) && is_numeric($day))
        {
            return checkdate($month, $day, $year);
        }
        return false;
    }

    public static function calcDateRanges($start, $end)
    {
       $dates = array();
       if (!(TimeUtils::isValidDateString($start) && TimeUtils::isValidDateString($end)))
       {
           return $dates;
       }
       $startDate = strtotime($start);
       $endDate = strtotime($end);
       while ($startDate <= $endDate)
       {
           $dates[] = date("Y-m-d", $startDate);
           $startDate = strtotime("+1 day", $startDate); 
       }
       return $dates;
    }

    public static function getEndOfToday()
    {
        return mktime(23, 59, 59, date('m'), date('d'), date('Y'));
    }

    public static function getStartOfToday()
    {
        return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    }

    public static function getYesterday()
    {
        return date("Y-m-d", strtotime("-1 day"));
    }

    public static function getTomorow()
    {
        return date("Y-m-d", strtotime("+1 day"));
    }
}
?>
