<?php

namespace Buzzylab\Aip\Models;

use Buzzylab\Aip\Model;

class Charset extends Model
{
    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct(){}

    /**
     * Count number of hits for the most frequented letters in Arabic language 
     * (Alef, Lam and Yaa), then calculate association ratio with each of 
     * possible character set (UTF-8, Windows-1256 and ISO-8859-6)
     *                           
     * @param string $string Arabic string in unknown format
     *      
     * @return array Character set as key and string association ratio as value
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function guess($string)
    {
        $charset = [];

        // The most frequent Arabic letters are Alef, Lam, and Yeh
        $charset['windows-1256']  = substr_count($string, chr(199));
        $charset['windows-1256'] += substr_count($string, chr(225));
        $charset['windows-1256'] += substr_count($string, chr(237));

        $charset['iso-8859-6']  = substr_count($string, chr(199));
        $charset['iso-8859-6'] += substr_count($string, chr(228));
        $charset['iso-8859-6'] += substr_count($string, chr(234));
        
        $charset['utf-8']  = substr_count($string, chr(216).chr(167));
        $charset['utf-8'] += substr_count($string, chr(217).chr(132));
        $charset['utf-8'] += substr_count($string, chr(217).chr(138));
        
        $total = $charset['windows-1256'] + 
                 $charset['iso-8859-6'] + 
                 $charset['utf-8'] + 1;
        
        $charset['windows-1256'] = round($charset['windows-1256'] * 100 / $total);
        $charset['iso-8859-6']   = round($charset['iso-8859-6'] * 100 / $total);
        $charset['utf-8']        = round($charset['utf-8'] * 100 / $total);
        
        return $charset;
    }
    
    /**
     * Find the most possible character set for given Arabic string in unknown 
     * format
     *         
     * @param String $string Arabic string in unknown format
     *      
     * @return String The most possible character set for given Arabic string in
     *                unknown format[utf-8|windows-1256|iso-8859-6]
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getCharset($string)
    {
        if (preg_match('/<meta .* charset=([^\"]+)".*>/sim', $string, $matches)) {
            $value = $matches[1];
        } else {
            $charset = $this->guess($string);
            arsort($charset);
            $value = key($charset);
        }

        return $value;
    }
}
