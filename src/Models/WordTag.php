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

class WordTag extends  Model
{
    /**
     * @var array
     */
    private $_particlePreNouns = ['عن', 'في', 'مذ', 'منذ',
                                              'من', 'الى', 'على', 'حتى',
                                              'الا', 'غير', 'سوى', 'خلا',
                                              'عدا', 'حاشا', 'ليس'];

    /**
     * @var array
     */
    private $_normalizeAlef       = ['أ','إ','آ'];

    /**
     * @var array
     */
    private $_normalizeDiacritics = ['َ','ً','ُ','ٌ',
                                    'ِ','ٍ','ْ','ّ'];

    /**
     * @var array
     */
    private $_commonWords = [];

    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct()
    {
        $words = $this->getJsonData(dirname(__FILE__).'/../../resources/data/summarize/ArStopWords.json');
        $words = array_map('trim', $words);
        
        $this->_commonWords = $words;
    }
    
    /**
     * Check if given rabic word is noun or not
     *      
     * @param string $word       Word you want to check if it is 
     *                           noun (utf-8)
     * @param string $word_befor The word before word you want to check
     *                    
     * @return boolean TRUE if given word is Arabic noun
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function isNoun($word, $word_befor)
    {
        $word       = trim($word);
        $word_befor = trim($word_befor);

        $word       = str_replace($this->_normalizeAlef, 'ا', $word);
        $word_befor = str_replace($this->_normalizeAlef, 'ا', $word_befor);
        $wordLen    = strlen($word);
        
        // إذا سبق بحرف جر فهو اسم مجرور
        if (in_array($word_befor, $this->_particlePreNouns)) {
            return true;
        }
        
        // إذا سبق بعدد فهو معدود
        if (is_numeric($word) || is_numeric($word_befor)) {
            return true;
        }
        
        // إذا كان منون
        if (mb_substr($word, -1, 1) == 'ً' || mb_substr($word, -1, 1) == 'ٌ' || mb_substr($word, -1, 1) == 'ٍ') {
            return true;
        }
        
        $word    = str_replace($this->_normalizeDiacritics, '', $word);
        $wordLen = mb_strlen($word);
        
        // إن كان معرف بأل التعريف
        if (mb_substr($word, 0, 1) == 'ا' && mb_substr($word, 1, 1) == 'ل'
            && $wordLen >= 5
        ) {
            return true;
        }
        
        // إذا كان في الكلمة  ثلاث ألفات
        // إن لم تكن الألف الثالثة متطرفة
        if (mb_substr_count($word, 'ا') >= 3) {
            return true;
        }

        //إن كان مؤنث تأنيث لفظي، منتهي بتاء مربوطة
        // أو همزة أو ألف مقصورة
        if ((mb_substr($word, -1, 1) == 'ة' || mb_substr($word, -1, 1) == 'ء'
            || mb_substr($word, -1, 1) == 'ى') && $wordLen >= 4
        ) {
            return true;
        }

        // مؤنث تأنيث لفظي،
        // منتهي بألف وتاء مفتوحة - جمع مؤنث سالم
        if (mb_substr($word, -1, 1) == 'ت' && mb_substr($word, -2, 1) == 'ا'
            && $wordLen >= 5
        ) {
            return true;
        }

        // started by Noon, before REH or LAM, or Noon, is a verb and not a noun
        if (mb_substr($word, 0, 1) == 'ن' && (mb_substr($word, 1, 1) == 'ر'
            || mb_substr($word, 1, 1) == 'ل' || mb_substr($word, 1, 1) == 'ن')
            && $wordLen > 3
        ) {
            return false;
        }
        
        // started by YEH, before some letters is a verb and not a noun
        // YEH,THAL,JEEM,HAH,KHAH,ZAIN,SHEEN,SAD,DAD,TAH,ZAH,GHAIN,KAF
        $haystack = 'يذجهخزشصضطظغك';
        if (mb_substr($word, 0, 1) == 'ي' 
            && (mb_strpos($haystack, mb_substr($word, 1, 1)) !== false) 
            && $wordLen > 3
        ) {
            return false;
        }
        
        // started by beh or meem, before BEH,FEH,MEEM is a noun and not a verb
        if ((mb_substr($word, 0, 1) == 'ب' || mb_substr($word, 0, 1) == 'م') 
            && (mb_substr($word, 1, 1) == 'ب' || mb_substr($word, 1, 1) == 'ف' 
            || mb_substr($word, 1, 1) == 'م') && $wordLen > 3
        ) {
            return true;
        }
        
        // الكلمات التي  تنتهي بياء ونون
        // أو ألف ونون أو ياء ونون
        // تكون أسماء ما لم تبدأ بأحد حروف المضارعة 
        if (preg_match('/^[^ايتن]\S{2}[اوي]ن$/u', $word)) {
            return true;
        }

        // إن كان على وزن اسم الآلة
        // أو اسم المكان أو اسم الزمان
        if (preg_match('/^م\S{3}$/u', $word) 
            || preg_match('/^م\S{2}ا\S$/u', $word)  
            || preg_match('/^م\S{3}ة$/u', $word)  
            || preg_match('/^\S{2}ا\S$/u', $word)  
            || preg_match('/^\Sا\Sو\S$/u', $word)  
            || preg_match('/^\S{2}و\S$/u', $word)  
            || preg_match('/^\S{2}ي\S$/u', $word)  
            || preg_match('/^م\S{2}و\S$/u', $word)  
            || preg_match('/^م\S{2}ي\S$/u', $word)  
            || preg_match('/^\S{3}ة$/u', $word) 
            || preg_match('/^\S{2}ا\Sة$/u', $word)  
            || preg_match('/^\Sا\S{2}ة$/u', $word)  
            || preg_match('/^\Sا\Sو\Sة$/u', $word)  
            || preg_match('/^ا\S{2}و\Sة$/u', $word)  
            || preg_match('/^ا\S{2}ي\S$/u', $word) 
            || preg_match('/^ا\S{3}$/u', $word)  
            || preg_match('/^\S{3}ى$/u', $word)  
            || preg_match('/^\S{3}اء$/u', $word)  
            || preg_match('/^\S{3}ان$/u', $word)  
            || preg_match('/^م\Sا\S{2}$/u', $word)  
            || preg_match('/^من\S{3}$/u', $word)  
            || preg_match('/^مت\S{3}$/u', $word)  
            || preg_match('/^مست\S{3}$/u', $word)  
            || preg_match('/^م\Sت\S{2}$/u', $word)  
            || preg_match('/^مت\Sا\S{2}$/u', $word) 
            || preg_match('/^\Sا\S{2}$/u', $word)
        ) {
            return true;
        }

        return false;
    }
    
    /**
     * Tag all words in a given Arabic string if they are nouns or not
     *      
     * @param string $str Arabic string you want to tag all its words
     *                    
     * @return array Two dimension array where item[i][0] represent the word i
     *               in the given string, and item[i][1] is 1 if that word is
     *               noun and 0 if it is not
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function tagText($str)
    {
        $text     = [];
        $words    = explode(' ', $str);
        $prevWord = '';
        
        foreach ($words as $word) {
            if ($word == '') {
                continue;
            }

            if (self::isNoun($word, $prevWord)) {
                $text[] = [$word, 1];
            } else {
                $text[] = [$word, 0];
            }
            
            $prevWord = $word;
        }

        return $text;
    }
    
    /**
     * Highlighted all nouns in a given Arabic string
     *      
     * @param string $str   Arabic string you want to highlighted 
     *                      all its nouns
     * @param string $style Name of the CSS class you would like to apply
     *                    
     * @return string Arabic string in HTML format where all nouns highlighted
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function highlightText($str, $style = null)
    {
        $html     = '';
        $prevTag  = 0;
        $prevWord = '';
        
        $taggedText = self::tagText($str);
        
        foreach ($taggedText as $wordTag) {
            list($word, $tag) = $wordTag;
            
            if ($prevTag == 1) {
                if (in_array($word, $this->_particlePreNouns)) {
                    $prevWord = $word;
                    continue;
                }
                
                if ($tag == 0) {
                    $html .= "</span> \r\n";
                }
            } else {
                // if ($tag == 1 && !in_array($word, $this->_commonWords)) {
                if ($tag == 1) {
                    $html .= " \r\n<span class=\"" . $style ."\">";
                }
            }
            
            $html .= ' ' . $prevWord . ' ' . $word;
            
            if ($prevWord != '') {
                $prevWord = '';
            }
            $prevTag = $tag;
        }
        
        if ($prevTag == 1) {
            $html .= "</span> \r\n";
        }
        
        return $html;
    }
}
