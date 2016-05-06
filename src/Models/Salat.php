<?php

namespace Buzzylab\Aip\Models;

use Buzzylab\Aip\Model;

class Salat extends Model
{
    /**
     * السنة
     * @ignore
     */
    protected $year = 1975;
    
    /**
     * الشهر
     * @ignore
     */
    protected $month = 8;
    
    /**
     * اليوم
     * @ignore
     */
    protected $day = 2;
    
    /**
     * فرق التوقيت العالمى
     * @ignore
     */
    protected $zone = 2;
    
    /**
     * خط الطول الجغرافى للمكان
     * @ignore
     */
    protected $long = 37.15861;
    
    /**
     * خط العرض الجغرافى
     * @ignore
     */
    protected $lat = 36.20278;
    
    /**
     * الارتفاع عن سطح البحر
     * @ignore
     */
    protected $elevation = 0;
    
    /**
     * زاوية الشروق والغروب
     * @ignore
     */
    protected $AB2 = -0.833333;

    /**
     * زاوية العشاء
     * @ignore
     */
    protected $AG2 = -18;
    
    /**
     * زاوية الفجر
     * @ignore
     */
    protected $AJ2 = -18;
    
    /**
     * المذهب
     * @ignore
     */
    protected $school = 'Shafi';
    
    /**
     * الطائفة
     * @ignore
     */
    protected $view = 'Sunni';

    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct(){}
        
    /**
     * Setting date of day for Salat calculation
     *      
     * @param integer $m Month of date you want to calculate Salat in
     * @param integer $d Day of date you want to calculate Salat in
     * @param integer $y Year (four digits) of date you want to calculate Salat in
     *      
     * @return object $this to build a fluent interface
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setDate($m = 8, $d = 2, $y = 1975)
    {
        if (is_numeric($y) && $y > 0 && $y < 3000) {
            $this->year = floor($y);
        }
        
        if (is_numeric($m) && $m >= 1 && $m <= 12) {
            $this->month = floor($m);
        }
        
        if (is_numeric($d) && $d >= 1 && $d <= 31) {
            $this->day = floor($d);
        }
        
        return $this;
    }
    
    /**
     * Setting location information for Salat calculation
     *      
     * @param decimal $l1 Latitude of location you want to calculate Salat time in
     * @param decimal $l2 Longitude of location you want to calculate Salat time in
     * @param integer $z  Time Zone, offset from UTC (see also Greenwich Mean Time)
     * @param integer $e  Elevation, it is the observer's height in meters.
     *      
     * @return object $this to build a fluent interface
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setLocation($l1 = 36.20278, $l2 = 37.15861, $z = 2, $e = 0)
    {
        if (is_numeric($l1) && $l1 >= -180 && $l1 <= 180) {
            $this->lat = $l1;
        }
        
        if (is_numeric($l2) && $l2 >= -180 && $l2 <= 180) {
            $this->long = $l2;
        }
        
        if (is_numeric($z) && $z >= -12 && $z <= 12) {
            $this->zone = floor($z);
        }
        
        if (is_numeric($e)) {
            $this->elevation = $e;
        }
        
        return $this;
    }
    
    /**
     * Setting rest of Salat calculation configuration
     * 
     * Convention                                 Fajr Angle  Isha Angle
     * 
     * Muslim World League                              -18       -17
     *      
     * Islamic Society of North America (ISNA)          -15       -15
     *      
     * Egyptian General Authority of Survey               -19.5     -17.5
     *      
     * Umm al-Qura University, Makkah                   -18.5   
     * Isha 90  min after Maghrib, 120 min during Ramadan
     *      
     * University of Islamic Sciences, Karachi          -18       -18
     *      
     * Institute of Geophysics, University of Tehran      -17.7     -14(*)
     *      
     * Shia Ithna Ashari, Leva Research Institute, Qum  -16       -14
     * 
     * (*) Isha angle is not explicitly defined in Tehran method
     * Fajr Angle = $fajrArc, Isha Angle = $ishaArc     
     *                 
     * - حزب العلماء في لندن لدول
     * أوروبا في خطوط عرض تزيد على 48
     *       
     *      $ishaArc = -17
     *      $fajrArc = -17
     *      
     * @param string  $sch        [Shafi|Hanafi] to define Muslims Salat 
     *                            calculation method (affect Asr time)
     * @param decimal $sunriseArc Sun rise arc (default value is -0.833333)
     * @param decimal $ishaArc    Isha arc (default value is -18)
     * @param decimal $fajrArc    Fajr arc (default value is -18)
     * @param string  $view       [Sunni|Shia] to define Muslims Salat calculation
     *                            method (affect Maghrib and Midnight time)
     *      
     * @return object $this to build a fluent interface
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setConf(
        $sch = 'Shafi', $sunriseArc = -0.833333, $ishaArc = -17.5, 
        $fajrArc = -19.5, $view = 'Sunni'
    ) {
        $sch = ucfirst($sch);
        
        if ($sch == 'Shafi' || $sch == 'Hanafi') {
            $this->school = $sch;
        }
        
        if (is_numeric($sunriseArc) && $sunriseArc >= -180 && $sunriseArc <= 180) {
            $this->AB2 = $sunriseArc;
        }
        
        if (is_numeric($ishaArc) && $ishaArc >= -180 && $ishaArc <= 180) {
            $this->AG2 = $ishaArc;
        }
        
        if (is_numeric($fajrArc) && $fajrArc >= -180 && $fajrArc <= 180) {
            $this->AJ2 = $fajrArc;
        }
        
        if ($view == 'Sunni' || $view == 'Shia') {
            $this->view = $view;
        }
        
        return $this;
    }
    
    /**
     * Alias for getPrayTime2 method
     *                        
     * @return array of Salat times + sun rise in the following format
     *               hh:mm where hh is the hour in local format and 24 mode
     *               mm is minutes with leading zero to be 2 digits always
     *               array items is [$Fajr, $Sunrise, $Dhuhr, $Asr, $Maghrib, 
     *               $Isha, $Sunset, $Midnight, $Imsak, array $timestamps]
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     * @author Hamid Zarrabi-Zadeh <zarrabi@scs.carleton.ca>
     * @source http://praytimes.org/calculation
     */
    public function getPrayTime()
    {
        $prayTime = $this->getPrayTime2();
        
        return $prayTime;
    }
    
    /**
     * Calculate Salat times for the date set in setSalatDate methode, and 
     * location set in setSalatLocation.
     *                        
     * @return array of Salat times + sun rise in the following format
     *               hh:mm where hh is the hour in local format and 24 mode
     *               mm is minutes with leading zero to be 2 digits always
     *               array items is [$Fajr, $Sunrise, $Dhuhr, $Asr, $Maghrib, 
     *               $Isha, $Sunset, $Midnight, $Imsak, array $timestamps]
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     * @author Hamid Zarrabi-Zadeh <zarrabi@scs.carleton.ca>
     * @source http://praytimes.org/calculation
     */
    public function getPrayTime2()
    {
        $unixtimestamp = mktime(0, 0, 0, $this->month, $this->day, $this->year);

        // Calculate Julian date
        if ($this->month <= 2) {
            $year  = $this->year - 1;
            $month = $this->month + 12;
        } else {
            $year  = $this->year;
            $month = $this->month;
        }
        
        $A = floor($year / 100);
        $B = 2 - $A + floor($A / 4);

        $jd = floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) 
                + $this->day + $B - 1524.5;
        
        // The following algorithm from U.S. Naval Observatory computes the 
        // Sun's angular coordinates to an accuracy of about 1 arcminute within 
        // two centuries of 2000. 
        $d = $jd - 2451545.0;  // jd is the given Julian date 

        // The following algorithm from U.S. Naval Observatory computes the Sun's 
        // angular coordinates to an accuracy of about 1 arcminute within two 
        // centuries of 2000
        // http://aa.usno.navy.mil/faq/docs/SunApprox.php
        // Note: mod % in PHP ignore decimels!
        $g = 357.529 + 0.98560028 * $d;
        $g = $g % 360 + ($g - ceil($g) + 1);
        
        $q = 280.459 + 0.98564736 * $d;
        $q = $q % 360 + ($q - ceil($q) + 1);
        
        $L = $q + 1.915 * sin(deg2rad($g)) + 0.020 * sin(deg2rad(2 * $g));
        $L = $L % 360 + ($L - ceil($L) + 1);

        $R = 1.00014 - 0.01671 * cos(deg2rad($g)) - 0.00014 * cos(deg2rad(2 * $g));
        $e = 23.439 - 0.00000036 * $d;
        
        $RA = rad2deg(atan2(cos(deg2rad($e))* sin(deg2rad($L)), cos(deg2rad($L))))
            / 15;
        
        if ($RA < 0) {
            $RA = 24 + $RA;
        }

        // The declination of the Sun is the angle between the rays of the sun and 
        // the plane of the earth equator. The declination of the Sun changes 
        // continuously throughout the year. This is a consequence of the Earth's 
        // tilt, i.e. the difference in its rotational and revolutionary axes. 
        // declination of the Sun
        $D = rad2deg(asin(sin(deg2rad($e))* sin(deg2rad($L))));  
        
        // The equation of time is the difference between time as read from sundial 
        // and a clock. It results from an apparent irregular movement of the Sun 
        // caused by a combination of the obliquity of the Earth's rotation axis 
        // and the eccentricity of its orbit. The sundial can be ahead (fast) by 
        // as much as 16 min 33 s (around November 3) or fall behind by as much as 
        // 14 min 6 s (around February 12), as shown in the following graph:
        // http://en.wikipedia.org/wiki/File:Equation_of_time.png 
        $EqT = ($q/15) - $RA;  // equation of time
        
        // Dhuhr
        // When the Sun begins to decline after reaching its highest point in the sky
        $Dhuhr = 12 + $this->zone - ($this->long/15) - $EqT;
        if ($Dhuhr < 0) {
            $Dhuhr = 24 + $Dhuhr;
        }
        
        // Sunrise & Sunset 
        // If the observer's location is higher than the surrounding terrain, we 
        // can consider this elevation into consideration by increasing the above 
        // constant 0.833 by 0.0347 × sqrt(elevation), where elevation is the  
        // observer's height in meters. 
        $alpha = 0.833 + 0.0347 * sqrt($this->elevation);
        $n = -1 * sin(deg2rad($alpha)) - sin(deg2rad($this->lat)) * sin(deg2rad($D));
        $d = cos(deg2rad($this->lat)) * cos(deg2rad($D));

        // date_sun_info Returns an array with information about sunset/sunrise 
        // and twilight begin/end
        $Sunrise = $Dhuhr - (1/15) * rad2deg(acos($n / $d));
        $Sunset  = $Dhuhr + (1/15) * rad2deg(acos($n / $d));
        
        // Fajr & Isha
        // Imsak: The time to stop eating Sahur (for fasting), slightly before Fajr.
        // Fajr:  When the sky begins to lighten (dawn).
        // Isha:  The time at which darkness falls and there is no scattered light 
        //        in the sky. 
        $n     = -1 * sin(deg2rad(abs($this->AJ2))) - sin(deg2rad($this->lat)) 
                * sin(deg2rad($D));
        $Fajr  = $Dhuhr - (1/15) * rad2deg(acos($n / $d));
        $Imsak = $Fajr - (10/60);
        
        $n    = -1 * sin(deg2rad(abs($this->AG2))) - sin(deg2rad($this->lat)) 
                * sin(deg2rad($D));
        $Isha = $Dhuhr + (1/15) * rad2deg(acos($n / $d));
        
        // Asr
        // The following formula computes the time difference between the mid-day 
        // and the time at which the object's shadow equals t times the length of 
        // the object itself plus the length of that object's shadow at noon
        if ($this->school == 'Shafi') {
            $n = sin(atan(1/(1 + tan(deg2rad($this->lat - $D))))) 
                - sin(deg2rad($this->lat)) * sin(deg2rad($D));
        } else {
            $n = sin(atan(1/(2 + tan(deg2rad($this->lat - $D))))) 
                - sin(deg2rad($this->lat)) * sin(deg2rad($D));
        }
        $Asr = $Dhuhr + (1/15) * rad2deg(acos($n / $d));
        
        // Maghrib
        // In the Sunni's point of view, the time for Maghrib prayer begins once 
        // the Sun has completely set beneath the horizon, that is, Maghrib = Sunset 
        // (some calculators suggest 1 to 3 minutes after Sunset for precaution)
        $MaghribSunni = $Sunset + 2/60;
        
        // In the Shia's view, however, the dominant opinion is that as long as 
        // the redness in the eastern sky appearing after sunset has not passed 
        // overhead, Maghrib prayer should not be performed.
        $n = -1 * sin(deg2rad(4)) - sin(deg2rad($this->lat)) * sin(deg2rad($D));
        $MaghribShia = $Dhuhr + (1/15) * rad2deg(acos($n / $d));
        
        if ($this->view == 'Sunni') {
            $Maghrib = $MaghribSunni;
        } else {
            $Maghrib = $MaghribShia;
        }

        // Midnight
        // Midnight is generally calculated as the mean time from Sunset to Sunrise
        $MidnightSunni = $Sunset + 0.5 * ($Sunrise - $Sunset);
        if ($MidnightSunni > 12) {
            $MidnightSunni = $MidnightSunni - 12;
        }
        
        // In Shia point of view, the juridical midnight (the ending time for 
        // performing Isha prayer) is the mean time from Sunset to Fajr
        $MidnightShia = 0.5 * ($Fajr - $Sunset);
        if ($MidnightShia > 12) {
            $MidnightShia = $MidnightShia - 12;
        }
        
        if ($this->view == 'Sunni') {
            $Midnight = $MidnightSunni;
        } else {
            $Midnight = $MidnightShia;
        }

        // Result.ThlthAkhir:= Result.Fajr-(24-Result.Maghrib + Result.Fajr)/3;
        // Result.Doha      := Result.Sunrise+(15/60);
        // if isRamadan then (Um-Al-Qura calendar)
        // Result.Isha := Result.Maghrib+2 
        // else Result.Isha := Result.Maghrib+1.5;
        
        $times = [$Fajr, $Sunrise, $Dhuhr, $Asr, $Maghrib, $Isha, $Sunset, $Midnight, $Imsak];
        
        // Convert number after the decimal point into minutes 
        foreach ($times as $index => $time) {
            $hours   = floor($time);
            $minutes = round(($time - $hours) * 60);
            
            if ($minutes < 10) {
                $minutes = "0$minutes";
            }
            
            $times[$index] = "$hours:$minutes";
            
            $times[9][$index] = $unixtimestamp + 3600 * $hours + 60 * $minutes;
            
            if ($index == 7 && $hours < 6) {
                $times[9][$index] += 24 * 3600;
            }
        }
        
        return $times;
    }

    /**
     * Determine Qibla direction using basic spherical trigonometric formula 
     *                        
     * @return float Qibla Direction (from the north direction) in degrees
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     * @author S. Kamal Abdali <k.abdali@acm.org>
     * @source http://www.patriot.net/users/abdali/ftp/qibla.pdf
     */
    public function getQibla () 
    {
        // The geographical coordinates of the Ka'ba
        $K_latitude  = 21.423333;
        $K_longitude = 39.823333;
        
        $latitude  = $this->lat;
        $longitude = $this->long;

        $numerator   = sin(deg2rad($K_longitude - $longitude));
        $denominator = (cos(deg2rad($latitude)) * tan(deg2rad($K_latitude))) -
                       (sin(deg2rad($latitude)) 
                       * cos(deg2rad($K_longitude - $longitude)));

        $q = atan($numerator / $denominator);
        $q = rad2deg($q);
        
        if ($this->lat > 21.423333) {
            $q += 180;
        }
        
        return $q;
    }
    
    /**
     * Convert coordinates presented in degrees, minutes and seconds 
     * (i.e. 12°34'56"S formula) into usual float number in degree unit scale 
     * (i.e. -12.5822 value)
     *      
     * @param string $value Coordinate presented in degrees, minutes and seconds
     *                      (i.e. 12°34'56"S formula)     
     *      
     * @return float Equivalent float number in degree unit scale
     *               (i.e. -12.5822 value)     
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function coordinate2deg ($value) 
    {
        $pattern = "/(\d{1,2})°((\d{1,2})')?((\d{1,2})\")?([NSEW])/i";
        
        preg_match($pattern, $value, $matches);
        
        $degree = $matches[1] + ($matches[3] / 60) + ($matches[5] /3600);
        
        $direction = strtoupper($matches[6]);
        
        if ($direction == 'S' || $direction == 'W') {
            $degree = -1 * $degree;
        }
        
        return $degree;
    }
}
