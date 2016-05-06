<?php

namespace Buzzylab\Aip\Models;

use Buzzylab\Aip\Model;

class Transliteration extends Model
{
    /**
     * @var array
     */
    private $_arFinePatterns     = ["/'+/u", "/([\- ])'/u", '/(.)#/u'];

    /**
     * @var array
     */
    private $_arFineReplacements = ["'", '\\1', "\\1'\\1"];

    /**
     * @var array
     */
    private $_en2arPregSearch  = [];

    /**
     * @var array
     */
    private $_en2arPregReplace = [];

    /**
     * @var array
     */
    private $_en2arStrSearch   = [];

    /**
     * @var array
     */
    private $_en2arStrReplace  = [];

    /**
     * @var array
     */
    private $_ar2enPregSearch  = [];

    /**
     * @var array
     */
    private $_ar2enPregReplace = [];

    /**
     * @var array
     */
    private $_ar2enStrSearch   = [];

    /**
     * @var array
     */
    private $_ar2enStrReplace  = [];

    /**
     * @var array
     */
    private $_diariticalSearch  = [];

    /**
     * @var array
     */
    private $_diariticalReplace = [];

    /**
     * @var array
     */
    private $_iso233Search  = [];

    /**
     * @var array
     */
    private $_iso233Replace = [];

    /**
     * @var array
     */
    private $_rjgcSearch  = [];

    /**
     * @var array
     */
    private $_rjgcReplace = [];

    /**
     * @var array
     */
    private $_sesSearch  = [];

    /**
     * @var array
     */
    private $_sesReplace = [];

    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct()
    {
        $xml = simplexml_load_file(dirname(__FILE__).'/../../resources/data/Transliteration.xml');

        foreach ($xml->xpath("//preg_replace[@function='ar2en']/pair") as $pair) {
            array_push($this->_ar2enPregSearch, (string)$pair->search);
            array_push($this->_ar2enPregReplace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//str_replace[@function='diaritical']/pair") as $pair) {
            array_push($this->_diariticalSearch, (string)$pair->search);
            array_push($this->_diariticalReplace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//str_replace[@function='ISO233']/pair") as $pair) {
            array_push($this->_iso233Search, (string)$pair->search);
            array_push($this->_iso233Replace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//str_replace[@function='RJGC']/pair") as $pair) {
            array_push($this->_rjgcSearch, (string)$pair->search);
            array_push($this->_rjgcReplace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//str_replace[@function='SES']/pair") as $pair) {
            array_push($this->_sesSearch, (string)$pair->search);
            array_push($this->_sesReplace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//str_replace[@function='ar2en']/pair") as $pair) {
            array_push($this->_ar2enStrSearch, (string)$pair->search);
            array_push($this->_ar2enStrReplace, (string)$pair->replace);
        }

        foreach ($xml->xpath("//preg_replace[@function='en2ar']/pair") as $pair) {
            array_push($this->_en2arPregSearch, (string)$pair->search);
            array_push($this->_en2arPregReplace, (string)$pair->replace);
        }
    
        foreach ($xml->xpath("//str_replace[@function='en2ar']/pair") as $pair) {
            array_push($this->_en2arStrSearch, (string)$pair->search);
            array_push($this->_en2arStrReplace, (string)$pair->replace);
        }
    }
        
    /**
     * Transliterate English string into Arabic by render them in the 
     * orthography of the Arabic language
     *         
     * @param string $string English string you want to transliterate
     * @param string $locale Locale information (e.g. 'en_GB' or 'de_DE')
     *                    
     * @return String Out of vocabulary English string in Arabic characters
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function en2ar($string, $locale='en_US')
    {
        setlocale(LC_ALL, $locale);
        $string = iconv("UTF-8", "ASCII//TRANSLIT", $string);
        $string = preg_replace('/[^\w\s]/', '', $string);
        
        $string = strtolower($string);
        $words  = explode(' ', $string);
        $string = '';
        
        foreach ($words as $word) {
            $word = preg_replace($this->_en2arPregSearch, $this->_en2arPregReplace, $word);
            $word = str_replace($this->_en2arStrSearch, $this->_en2arStrReplace, $word);

            $string .= ' ' . $word;
        }
        
        return $string;
    }

    /**
     * Transliterate Arabic string into English by render them in the 
     * orthography of the English language
     *           
     * @param string $string   Arabic string you want to transliterate
     * @param string $standard Transliteration standard, default is UNGEGN 
     *                         and possible values are [UNGEGN, UNGEGN+, RJGC, 
     *                         SES, ISO233]
     *                    
     * @return String Out of vocabulary Arabic string in English characters
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function ar2en($string, $standard='UNGEGN')
    {
        //$string = str_replace('ة ال', 'tul', $string);

        $words  = explode(' ', $string);
        $string = '';
                
        for ($i=0; $i<count($words)-1; $i++) {
            $words[$i] = str_replace('ة', 'ت', $words[$i]);
        }

        foreach ($words as $word) {
            $temp = $word;

            if ($standard == 'UNGEGN+') {

                $temp = str_replace($this->_diariticalSearch, $this->_diariticalReplace, $temp);

            } else if ($standard == 'RJGC') {

                $temp = str_replace($this->_diariticalSearch, $this->_diariticalReplace, $temp);
                $temp = str_replace($this->_rjgcSearch, $this->_rjgcReplace, $temp);

            } else if ($standard == 'SES') {

                $temp = str_replace($this->_diariticalSearch, $this->_diariticalReplace, $temp);
                $temp = str_replace($this->_sesSearch, $this->_sesReplace, $temp);

            } else if ($standard == 'ISO233') {

                $temp = str_replace($this->_iso233Search, $this->_iso233Replace, $temp);
            }
            
            $temp = preg_replace($this->_ar2enPregSearch, $this->_ar2enPregReplace, $temp);
            $temp = str_replace($this->_ar2enStrSearch, $this->_ar2enStrReplace, $temp);
            $temp = preg_replace($this->_arFinePatterns, $this->_arFineReplacements, $temp);
            
            if (preg_match('/[a-z]/', mb_substr($temp, 0, 1))) {
                $temp = ucwords($temp);
            }
            
            $pos  = strpos($temp, '-');

            if ($pos > 0) {
                if (preg_match('/[a-z]/', mb_substr($temp, $pos+1, 1))) {
                    $temp2  = substr($temp, 0, $pos);
                    $temp2 .= '-'.strtoupper($temp[$pos+1]);
                    $temp2 .= substr($temp, $pos+2);
                } else {
                    $temp2 = $temp;
                }
            } else {
                $temp2 = $temp;
            }

            $string .= ' ' . $temp2;
        }
        
        return $string;
    }
    
    /**
     * Render numbers in given string using HTML entities that will show them as 
     * Arabic digits (i.e. 1, 2, 3, etc.) whatever browser language settings are 
     * (if browser supports UTF-8 character set).
     *         
     * @param string $string String includes some digits here or there
     *                    
     * @return String Original string after replace digits by HTML entities that 
     *                will show given number using Indian digits
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function enNum($string)
    {
        $html = '';

        $digits = str_split("$string");

        foreach ($digits as $digit) {
            $html .= preg_match('/\d/', $digit) ? "&#x3$digit;" : $digit;
        }
        
        return $html;
    }
    
    /**
     * Render numbers in given string using HTML entities that will show them as 
     * Indian digits (i.e. ١, ٢, ٣, etc.) whatever browser language settings are 
     * (if browser supports UTF-8 character set).
     *         
     * @param string $string String includes some digits here or there
     *                    
     * @return String Original string after replace digits by HTML entities that 
     *                will show given number using Arabic digits
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function arNum($string)
    {
        $html = '';

        $digits = str_split("$string");

        foreach ($digits as $digit) {
            $html .= preg_match('/\d/', $digit) ? "&#x066$digit;" : $digit;
        }
        
        return $html;
    }
}
