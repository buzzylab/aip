<?php

/**
 * This file is part of the AIP package.
 *
 * (c) Khaled Al-Sham'aa <khaled@ar-php.org> && Maher El Gamil <maherbusnes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace Buzzylab\Aip\Models;

use Buzzylab\Aip\Model;

class MakeTime extends Model
{
    /**
     * Loads initialize values.
     *
     * @ignore
     */
    public function __construct()
    {
    }

    /**
     * This will return current Unix timestamp
     * for given Hijri date (Islamic calendar).
     *
     * @param int $hour       Time hour
     * @param int $minute     Time minute
     * @param int $second     Time second
     * @param int $hj_month   Hijri month (Islamic calendar)
     * @param int $hj_day     Hijri day   (Islamic calendar)
     * @param int $hj_year    Hijri year  (Islamic calendar)
     * @param int $correction To apply correction factor (+/- 1-2)
     *                        to standard Hijri calendar
     *
     * @return int Returns the current time measured in the number of
     *             seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function mktime($hour, $minute, $second, $hj_month, $hj_day, $hj_year, $correction = 0)
    {
        list($year, $month, $day) = $this->convertDate($hj_year, $hj_month, $hj_day);

        $unixTimeStamp = mktime($hour, $minute, $second, $month, $day, $year);

        $unixTimeStamp = $unixTimeStamp + 3600 * 24 * $correction;

        return $unixTimeStamp;
    }

    /**
     * This will convert given Hijri date (Islamic calendar) into Gregorian date.
     *
     * @param int $Y Hijri year (Islamic calendar)
     * @param int $M Hijri month (Islamic calendar)
     * @param int $D Hijri day (Islamic calendar)
     *
     * @return array Gregorian date [int Year, int Month, int Day]
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function convertDate($Y, $M, $D)
    {
        if (function_exists('GregorianToJD')) {
            $str = jdtogregorian($this->islamicToJd($Y, $M, $D));
        } else {
            $str = $this->jdToGreg($this->islamicToJd($Y, $M, $D));
        }

        list($month, $day, $year) = explode('/', $str);

        return [$year, $month, $day];
    }

    /**
     * This will convert given Hijri date (Islamic calendar) into Julian day.
     *
     * @param int $year  Hijri year
     * @param int $month Hijri month
     * @param int $day   Hijri day
     *
     * @return int Julian day
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function islamicToJd($year, $month, $day)
    {
        $jd = (int) ((11 * $year + 3) / 30) + (int) (354 * $year) + (int) (30 * $month)
            - (int) (($month - 1) / 2) + $day + 1948440 - 385;

        return $jd;
    }

    /**
     * Converts Julian Day Count to Gregorian date.
     *
     * @param int $julian A julian day number as integer
     *
     * @return int The gregorian date as a string in the form "month/day/year"
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function jdToGreg($julian)
    {
        $julian = $julian - 1721119;
        $calc1 = 4 * $julian - 1;
        $year = floor($calc1 / 146097);
        $julian = floor($calc1 - 146097 * $year);
        $day = floor($julian / 4);
        $calc2 = 4 * $day + 3;
        $julian = floor($calc2 / 1461);
        $day = $calc2 - 1461 * $julian;
        $day = floor(($day + 4) / 4);
        $calc3 = 5 * $day - 3;
        $month = floor($calc3 / 153);
        $day = $calc3 - 153 * $month;
        $day = floor(($day + 5) / 5);
        $year = 100 * $year + $julian;

        if ($month < 10) {
            $month = $month + 3;
        } else {
            $month = $month - 9;
            $year = $year + 1;
        }

        /*
        Just to mimic the PHP JDToGregorian output
        If year is less than 1, subtract one to convert from
        a zero based date system to the common era system in
        which the year -1 (1 B.C.E) is followed by year 1 (1 C.E.)
        */

        if ($year < 1) {
            $year--;
        }

        return $month.'/'.$day.'/'.$year;
    }

    /**
     * Calculate Hijri calendar correction using Um-Al-Qura calendar information.
     *
     * @param int $m Hijri month (Islamic calendar)
     * @param int $y Hijri year  (Islamic calendar), valid range [1420-1459]
     *
     * @return int Correction factor to fix Hijri calendar calculation using
     *             Um-Al-Qura calendar information
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function mktimeCorrection($m, $y)
    {
        if ($y >= 1420 && $y < 1460) {
            $calc = $this->mktime(0, 0, 0, $m, 1, $y);
            $content = file_get_contents(dirname(__FILE__).'/../../resources/data/um_alqoura.txt');

            $offset = (($y - 1420) * 12 + $m) * 11;

            $d = substr($content, $offset, 2);
            $m = substr($content, $offset + 3, 2);
            $y = substr($content, $offset + 6, 4);

            $real = mktime(0, 0, 0, $m, $d, $y);

            $diff = (int) (($real - $calc) / (3600 * 24));
        } else {
            $diff = 0;
        }

        return $diff;
    }

    /**
     * Calculate how many days in a given Hijri month.
     *
     * @param int  $m         Hijri month (Islamic calendar)
     * @param int  $y         Hijri year  (Islamic calendar), valid
     *                        range[1320-1459]
     * @param bool $umAlqoura Should we implement Um-Al-Qura calendar correction
     *                        in this calculation (default value is true)
     *
     * @return int Days in a given Hijri month
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function hijriMonthDays($m, $y, $umAlqoura = true)
    {
        if ($y >= 1320 && $y < 1460) {
            $begin = $this->mktime(0, 0, 0, $m, 1, $y);

            if ($m == 12) {
                $m2 = 1;
                $y2 = $y + 1;
            } else {
                $m2 = $m + 1;
                $y2 = $y;
            }

            $end = $this->mktime(0, 0, 0, $m2, 1, $y2);

            if ($umAlqoura === true) {
                $c1 = $this->mktimeCorrection($m, $y);
                $c2 = $this->mktimeCorrection($m2, $y2);
            } else {
                $c1 = 0;
                $c2 = 0;
            }

            $days = ($end - $begin) / (3600 * 24);
            $days = $days - $c1 + $c2;
        } else {
            $days = false;
        }

        return $days;
    }
}
