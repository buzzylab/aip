<?php

namespace Buzzylab\Aip\Models;

use Buzzylab\Aip\Model;

class Date extends Model
{
    /**
     * @var int
     */
    private $_mode = 1;

    /**
     * @var null
     */
    private $_xml  = null;

    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct()
    {
        $this->_xml = simplexml_load_file(dirname(__FILE__).'/../../resources/data/ArDate.xml');
    }
    
    /**
     * Setting value for $mode scalar
     *      
     * @param integer $mode Output mode of date function where:
     *                       1) Hijri format (Islamic calendar)
     *                       2) Arabic month names used in Middle East countries
     *                       3) Arabic Transliteration of Gregorian month names
     *                       4) Both of 2 and 3 formats together
     *                       5) Libya style
     *                       6) Algeria and Tunis style
     *                       7) Morocco style          
     *                       8) Hijri format (Islamic calendar) in English
     *                                   
     * @return object $this to build a fluent interface
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setDateMode($mode = 1)
    {
        $mode = (int) $mode;
        
        if ($mode > 0 && $mode < 9) {
            $this->_mode = $mode;
        }
        
        return $this;
    }
    
    /**
     * Getting $mode value that refer to output mode format
     *               1) Hijri format (Islamic calendar)
     *               2) Arabic month names used in Middle East countries
     *               3) Arabic Transliteration of Gregorian month names
     *               4) Both of 2 and 3 formats together
     *               5) Libyan way
     *               6) Algeria and Tunis style
     *               7) Morocco style          
     *               8) Hijri format (Islamic calendar) in English
     *                           
     * @return Integer Value of $mode properity
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getDateMode()
    {
        return $this->_mode;
    }
    
    /**
     * Format a local time/date in Arabic string
     *      
     * @param string  $format     Format string (same as PHP date function)
     * @param integer $timestamp  Unix timestamp
     * @param integer $correction To apply correction factor (+/- 1-2) to
     *                            standard hijri calendar
     *                    
     * @return string Format Arabic date string according to given format string
     *                using the given integer timestamp or the current local
     *                time if no timestamp is given.
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function date($format, $timestamp, $correction = 0)
    {
        if ($this->_mode == 1 || $this->_mode == 8) {
            if ($this->_mode == 1) {
                foreach ($this->_xml->ar_hj_month->month as $month) {
                    $hj_txt_month["{$month['id']}"] = (string)$month;
                } 
            }
            
            if ($this->_mode == 8) {
                foreach ($this->_xml->en_hj_month->month as $month) {
                    $hj_txt_month["{$month['id']}"] = (string)$month;
                } 
            }
            
            $patterns     = [];
            $replacements = [];
            
            array_push($patterns, 'Y');
            array_push($replacements, 'x1');
            array_push($patterns, 'y');
            array_push($replacements, 'x2');
            array_push($patterns, 'M');
            array_push($replacements, 'x3');
            array_push($patterns, 'F');
            array_push($replacements, 'x3');
            array_push($patterns, 'n');
            array_push($replacements, 'x4');
            array_push($patterns, 'm');
            array_push($replacements, 'x5');
            array_push($patterns, 'j');
            array_push($replacements, 'x6');
            array_push($patterns, 'd');
            array_push($replacements, 'x7');
            
            if ($this->_mode == 8) {
                array_push($patterns, 'S');
                array_push($replacements, '');
            }
            
            $format = str_replace($patterns, $replacements, $format);
            
            $str = date($format, $timestamp);
            if ($this->_mode == 1) {
                $str = $this->en2ar($str);
            }

            $timestamp       = $timestamp + 3600*24*$correction;
            list($Y, $M, $D) = explode(' ', date('Y m d', $timestamp));
            
            list($hj_y, $hj_m, $hj_d) = $this->hjConvert($Y, $M, $D);
            
            $patterns     = [];
            $replacements = [];
            
            array_push($patterns, 'x1');
            array_push($replacements, $hj_y);
            array_push($patterns, 'x2');
            array_push($replacements, substr($hj_y, -2));
            array_push($patterns, 'x3');
            array_push($replacements, $hj_txt_month[$hj_m]);
            array_push($patterns, 'x4');
            array_push($replacements, $hj_m);
            array_push($patterns, 'x5');
            array_push($replacements, sprintf('%02d', $hj_m));
            array_push($patterns, 'x6');
            array_push($replacements, $hj_d);
            array_push($patterns, 'x7');
            array_push($replacements, sprintf('%02d', $hj_d));
            
            $str = str_replace($patterns, $replacements, $str);
        } elseif ($this->_mode == 5) {
            $year  = date('Y', $timestamp);
            $year -= 632;
            $yr    = substr("$year", -2);
            
            $format = str_replace('Y', $year, $format);
            $format = str_replace('y', $yr, $format);
            
            $str = date($format, $timestamp);
            $str = $this->en2ar($str);

        } else {
            $str = date($format, $timestamp);
            $str = $this->en2ar($str);
        }
        
        if (0) {
            if ($outputCharset == null) { 
                $outputCharset = $main->getOutputCharset(); 
            }
            $str = $main->coreConvert($str, 'utf-8', $outputCharset);
        }

        return $str;
    }
    
    /**
     * Translate English date/time terms into Arabic langauge
     *      
     * @param string $str Date/time string using English terms
     *      
     * @return string Date/time string using Arabic terms
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function en2ar($str)
    {
        $patterns     = [];
        $replacements = [];
        
        $str = strtolower($str);
        
        foreach ($this->_xml->xpath("//en_day/mode[@id='full']/search") as $day) {
            array_push($patterns, (string)$day);
        } 

        foreach ($this->_xml->ar_day->replace as $day) {
            array_push($replacements, (string)$day);
        } 

        foreach (
            $this->_xml->xpath("//en_month/mode[@id='full']/search") as $month
        ) {
            array_push($patterns, (string)$month);
        } 

        $replacements = array_merge(
            $replacements, 
            $this->arabicMonths($this->_mode)
        );
        
        foreach ($this->_xml->xpath("//en_day/mode[@id='short']/search") as $day) {
            array_push($patterns, (string)$day);
        } 

        foreach ($this->_xml->ar_day->replace as $day) {
            array_push($replacements, (string)$day);
        } 

        foreach ($this->_xml->xpath("//en_month/mode[@id='short']/search") as $m) {
            array_push($patterns, (string)$m);
        } 
        
        $replacements = array_merge(
            $replacements, 
            $this->arabicMonths($this->_mode)
        );
    
        foreach (
            $this->_xml->xpath("//preg_replace[@function='en2ar']/pair") as $p
        ) {
            array_push($patterns, (string)$p->search);
            array_push($replacements, (string)$p->replace);
        } 

        $str = str_replace($patterns, $replacements, $str);
        
        return $str;
    }

    /**
     * Add Arabic month names to the replacement array
     *      
     * @param integer $mode Naming mode of months in Arabic where:
     *                       2) Arabic month names used in Middle East countries
     *                       3) Arabic Transliteration of Gregorian month names
     *                       4) Both of 2 and 3 formats together
     *                       5) Libya style
     *                       6) Algeria and Tunis style
     *                       7) Morocco style          
     *                                   
     * @return array Arabic month names in selected style
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function arabicMonths($mode)
    {
        $replacements = [];

        foreach (
            $this->_xml->xpath("//ar_month/mode[@id=$mode]/replace") as $month
        ) {
            array_push($replacements, (string)$month);
        } 

        return $replacements;
    }
    
    /**
     * Convert given Gregorian date into Hijri date
     *      
     * @param integer $Y Year Gregorian year
     * @param integer $M Month Gregorian month
     * @param integer $D Day Gregorian day
     *      
     * @return array Hijri date [int Year, int Month, int Day](Islamic calendar)
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function hjConvert($Y, $M, $D)
    {
        if (function_exists('GregorianToJD')) {
            $jd = GregorianToJD($M, $D, $Y);
        } else {
            $jd = $this->gregToJd($M, $D, $Y);
        }
        
        list($year, $month, $day) = $this->jdToIslamic($jd);
        
        return array($year, $month, $day);
    }
    
    /**
     * Convert given Julian day into Hijri date
     *      
     * @param integer $jd Julian day
     *      
     * @return array Hijri date [int Year, int Month, int Day](Islamic calendar)
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function jdToIslamic($jd)
    {
        $l = (int)$jd - 1948440 + 10632;
        $n = (int)(($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $j = (int)((10985 - $l) / 5316) * (int)((50 * $l) / 17719) 
            + (int)($l / 5670) * (int)((43 * $l) / 15238);
        $l = $l - (int)((30 - $j) / 15) * (int)((17719 * $j) / 50) 
            - (int)($j / 16) * (int)((15238 * $j) / 43) + 29;
        $m = (int)((24 * $l) / 709);
        $d = $l - (int)((709 * $m) / 24);
        $y = (int)(30 * $n + $j - 30);
        
        return [$y, $m, $d];
    }
    
    /**
     * Convert given Hijri date into Julian day
     *      
     * @param integer $year  Year Hijri year
     * @param integer $month Month Hijri month
     * @param integer $day   Day Hijri day
     *      
     * @return integer Julian day
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function islamicToJd($year, $month, $day)
    {
        $jd = (int)((11 * $year + 3) / 30) + (int)(354 * $year) + (int)(30 * $month) 
            - (int)(($month - 1) / 2) + $day + 1948440 - 385;
        return $jd;
    }
    
    /**
     * Converts a Gregorian date to Julian Day Count
     *      
     * @param integer $m The month as a number from 1 (for January) 
     *                   to 12 (for December) 
     * @param integer $d The day as a number from 1 to 31
     * @param integer $y The year as a number between -4714 and 9999
     *       
     * @return integer The julian day for the given gregorian date as an integer
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function gregToJd ($m, $d, $y)
    {
        if ($m < 3) {
            $y--;
            $m += 12;
        }
        
        if (($y < 1582) || ($y == 1582 && $m < 10) 
            || ($y == 1582 && $m == 10 && $d <= 15)
        ) {
            // This is ignored in the GregorianToJD PHP function!
            $b = 0;
        } else {
            $a = (int)($y / 100);
            $b = 2 - $a + (int)($a / 4);
        }
        
        $jd = (int)(365.25 * ($y + 4716)) + (int)(30.6001 * ($m + 1)) 
            + $d + $b - 1524.5;
        
        return round($jd);
    }

    /**
     * Calculate Hijri calendar correction using Um-Al-Qura calendar information
     *      
     * @param integer $time Unix timestamp
     *       
     * @return integer Correction factor to fix Hijri calendar calculation using
     *                 Um-Al-Qura calendar information     
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function dateCorrection ($time)
    {
        $calc = $time - $this->date('j', $time) * 3600 * 24;

        $content = file_get_contents(dirname(__FILE__).'/../../resources/data/um_alqoura.txt');

        $y      = $this->date('Y', $time);
        $m      = $this->date('n', $time);
        $offset = (($y-1420) * 12 + $m) * 11;
        
        $d = substr($content, $offset, 2);
        $m = substr($content, $offset+3, 2);
        $y = substr($content, $offset+6, 4);
        
        $real = mktime(0, 0, 0, $m, $d, $y);
        
        $diff = (int)(($calc - $real) / (3600 * 24));
        
        return $diff;
    }
}