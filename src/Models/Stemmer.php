<?php

namespace Buzzylab\Aip\Models;
use Buzzylab\Aip\Model;

class Stemmer extends Model
{
    /**
     * @var string
     */
    private $_verbPre  = 'وأسفلي';

    /**
     * @var string
     */
    private $_verbPost = 'ومكانيه';

    /**
     * @var string
     */
    private $_verbMay;

    /**
     * @var string
     */
    private $_verbMaxPre  = 4;

    /**
     * @var string
     */
    private $_verbMaxPost = 6;

    /**
     * @var string
     */
    private $_verbMinStem = 2;

    /**
     * @var string
     */
    private $_nounPre  = 'ابفكلوأ';

    /**
     * @var string
     */
    private $_nounPost = 'اتةكمنهوي';

    /**
     * @var string
     */
    private $_nounMay;

    /**
     * @var string
     */
    private $_nounMaxPre  = 4;

    /**
     * @var string
     */
    private $_nounMaxPost = 6;

    /**
     * @var string
     */
    private $_nounMinStem = 2;
    
    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct()
    {
        $this->_verbMay = $this->_verbPre . $this->_verbPost;
        $this->_nounMay = $this->_nounPre . $this->_nounPost;
    }
    
    /**
     * Get rough stem of the given Arabic word 
     *      
     * @param string $word Arabic word you would like to get its stem
     *                    
     * @return string Arabic stem of the word
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function stem($word)
    {
        $nounStem = $this->roughStem(
            $word, $this->_nounMay, $this->_nounPre, $this->_nounPost, 
            $this->_nounMaxPre, $this->_nounMaxPost, $this->_nounMinStem
        );
        $verbStem = $this->roughStem(
            $word, $this->_verbMay, $this->_verbPre, $this->_verbPost, 
            $this->_verbMaxPre, $this->_verbMaxPost, $this->_verbMinStem
        );
        
        if (mb_strlen($nounStem, 'UTF-8') < mb_strlen($verbStem, 'UTF-8')) {
            $stem = $nounStem;
        } else {
            $stem = $verbStem;
        }
        
        return $stem;
    }
    
    /**
     * Get rough stem of the given Arabic word (under specific rules)
     *      
     * @param string  $word      Arabic word you would like to get its stem
     * @param string  $notChars  Arabic chars those can't be in postfix or prefix
     * @param string  $preChars  Arabic chars those may exists in the prefix
     * @param string  $postChars Arabic chars those may exists in the postfix
     * @param integer $maxPre    Max prefix length
     * @param integer $maxPost   Max postfix length
     * @param integer $minStem   Min stem length
     *
     * @return string Arabic stem of the word under giving rules
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function roughStem (
        $word, $notChars, $preChars, $postChars, $maxPre, $maxPost, $minStem
    ) {
        $right = -1;
        $left  = -1;
        $max   = mb_strlen($word, 'UTF-8');
        
        for ($i=0; $i < $max; $i++) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($notChars, $needle, 0, 'UTF-8') === false) {
                if ($right == -1) {
                    $right = $i;
                }
                $left = $i;
            }
        }
        
        if ($right > $maxPre) {
            $right = $maxPre;
        }
        
        if ($max - $left - 1 > $maxPost) {
            $left = $max - $maxPost -1;
        }
        
        for ($i=0; $i < $right; $i++) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($preChars, $needle, 0, 'UTF-8') === false) {
                $right = $i;
                break;
            }
        }
        
        for ($i=$max-1; $i>$left; $i--) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($postChars, $needle, 0, 'UTF-8') === false) {
                $left = $i;
                break;
            }
        }

        if ($left - $right >= $minStem) {
            $stem = mb_substr($word, $right, $left-$right+1, 'UTF-8');
        } else {
            $stem = null;
        }

        return $stem;
    }
}
