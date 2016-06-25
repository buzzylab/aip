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

class Query extends Model
{
    private $_fields = [];
    private $_lexPatterns = [];
    private $_lexReplacements = [];
    private $_mode = 0;

    /**
     * Loads initialize values.
     */
    public function __construct()
    {
        $xml = simplexml_load_file(dirname(__FILE__).'/../../resources/data/ArQuery.xml');

        foreach ($xml->xpath("//preg_replace[@function='__construct']/pair")
                 as $pair) {
            array_push($this->_lexPatterns, (string) $pair->search);
            array_push($this->_lexReplacements, (string) $pair->replace);
        }
    }

    /**
     * Setting value for $_fields array.
     *
     * @param array $arrConfig Name of the fields that SQL statement will search
     *                         them (in array format where items are those
     *                         fields names)
     *
     * @return object $this to build a fluent interface
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setArrFields($arrConfig)
    {
        if (is_array($arrConfig)) {
            // Get _fields array
            $this->_fields = $arrConfig;
        }

        return $this;
    }

    /**
     * Setting value for $_fields array.
     *
     * @param string $strConfig Name of the fields that SQL statement will search
     *                          them (in string format using comma as delimated)
     *
     * @return object $this to build a fluent interface
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setStrFields($strConfig)
    {
        if (is_string($strConfig)) {
            // Get _fields array
            $this->_fields = explode(',', $strConfig);
        }

        return $this;
    }

    /**
     * Setting $mode propority value that refer to search mode
     * [0 for OR logic | 1 for AND logic].
     *
     * @param int $mode Setting value to be saved in the $mode propority
     *
     * @return object $this to build a fluent interface
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function setQueryMode($mode)
    {
        if (in_array($mode, ['0', '1'])) {
            // Set search mode [0 for OR logic | 1 for AND logic]
            $this->_mode = $mode;
        }

        return $this;
    }

    /**
     * Getting $mode propority value that refer to search mode
     * [0 for OR logic | 1 for AND logic].
     *
     * @return int Value of $mode properity
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getQueryMode()
    {
        // Get search mode value [0 for OR logic | 1 for AND logic]
        return $this->_mode;
    }

    /**
     * Getting values of $_fields Array in array format.
     *
     * @return array Value of $_fields array in Array format
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getArrFields()
    {
        $fields = $this->_fields;

        return $fields;
    }

    /**
     * Getting values of $_fields array in String format (comma delimated).
     *
     * @return string Values of $_fields array in String format (comma delimated)
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getStrFields()
    {
        $fields = implode(',', $this->_fields);

        return $fields;
    }

    /**
     * Build WHERE section of the SQL statement using defind lex's rules, search
     * mode [AND | OR], and handle also phrases (inclosed by "") using normal
     * LIKE condition to match it as it is.
     *
     * @param string $arg String that user search for in the database table
     *
     * @return string The WHERE section in SQL statement
     *                (MySQL database engine format)
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function getWhereCondition($arg)
    {
        $sql = '';

        //$arg = mysql_real_escape_string($arg);
        $search = ['\\',  "\x00", "\n",  "\r",  "'",  '"', "\x1a"];
        $replace = ['\\\\', '\\0', '\\n', '\\r', "\'", '\"', '\\Z'];
        $arg = str_replace($search, $replace, $arg);

        // Check if there are phrases in $arg should handle as it is
        $phrase = explode('"', $arg);

        if (count($phrase) > 2) {
            // Re-init $arg variable
            // (It will contain the rest of $arg except phrases).
            $arg = '';

            for ($i = 0; $i < count($phrase); $i++) {
                $subPhrase = $phrase[$i];
                if ($i % 2 == 0 && $subPhrase != '') {
                    // Re-build $arg variable after restricting phrases
                    $arg .= $subPhrase;
                } elseif ($i % 2 == 1 && $subPhrase != '') {
                    // Handle phrases using reqular LIKE matching in MySQL
                    $this->wordCondition[] = $this->getWordLike($subPhrase);
                }
            }
        }

        // Handle normal $arg using lex's and regular expresion
        $words = preg_split('/\s+/', trim($arg));

        foreach ($words as $word) {
            //if (is_numeric($word) || strlen($word) > 2) {
                // Take off all the punctuation
                //$word = preg_replace("/\p{P}/", '', $word);
                $exclude = ['(', ')', '[', ']', '{', '}', ',', ';', ':',
                                 '?', '!', '،', '؛', '؟', ];
            $word = str_replace($exclude, '', $word);

            $this->wordCondition[] = $this->getWordRegExp($word);
            //}
        }

        if (!empty($this->wordCondition)) {
            if ($this->_mode == 0) {
                $sql = '('.implode(') OR (', $this->wordCondition).')';
            } elseif ($this->_mode == 1) {
                $sql = '('.implode(') AND (', $this->wordCondition).')';
            }
        }

        return $sql;
    }

    /**
     * Search condition in SQL format for one word in all defind fields using
     * REGEXP clause and lex's rules.
     *
     * @param string $arg String (one word) that you want to build a condition for
     *
     * @return string sub SQL condition (for internal use)
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function getWordRegExp($arg)
    {
        $arg = $this->lex($arg);
        //$sql = implode(" REGEXP '$arg' OR ", $this->_fields) . " REGEXP '$arg'";
        $sql = ' REPLACE('.
               implode(", 'ـ', '') REGEXP '$arg' OR REPLACE(", $this->_fields).
               ", 'ـ', '') REGEXP '$arg'";


        return $sql;
    }

    /**
     * Search condition in SQL format for one word in all defind fields using
     * normal LIKE clause.
     *
     * @param string $arg String (one word) that you want to build a condition for
     *
     * @return string sub SQL condition (for internal use)
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function getWordLike($arg)
    {
        $sql = implode(" LIKE '$arg' OR ", $this->_fields)." LIKE '$arg'";

        return $sql;
    }

    /**
     * Get more relevant order by section related to the user search keywords.
     *
     * @param string $arg String that user search for in the database table
     *
     * @return string sub SQL ORDER BY section
     *
     * @author Saleh AlMatrafe <saleh@saleh.cc>
     */
    public function getOrderBy($arg)
    {
        // Check if there are phrases in $arg should handle as it is
        $phrase = explode('"', $arg);
        if (count($phrase) > 2) {
            // Re-init $arg variable
            // (It will contain the rest of $arg except phrases).
            $arg = '';
            for ($i = 0; $i < count($phrase); $i++) {
                if ($i % 2 == 0 && $phrase[$i] != '') {
                    // Re-build $arg variable after restricting phrases
                    $arg .= $phrase[$i];
                } elseif ($i % 2 == 1 && $phrase[$i] != '') {
                    // Handle phrases using reqular LIKE matching in MySQL
                    $wordOrder[] = $this->getWordLike($phrase[$i]);
                }
            }
        }

        // Handle normal $arg using lex's and regular expresion
        $words = explode(' ', $arg);
        foreach ($words as $word) {
            if ($word != '') {
                $wordOrder[] = 'CASE WHEN '.
                               $this->getWordRegExp($word).
                               ' THEN 1 ELSE 0 END';
            }
        }

        $order = '(('.implode(') + (', $wordOrder).')) DESC';

        return $order;
    }

    /**
     * This method will implement various regular expressin rules based on
     * pre-defined Arabic lexical rules.
     *
     * @param string $arg String of one word user want to search for
     *
     * @return string Regular Expression format to be used in MySQL query statement
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function lex($arg)
    {
        $arg = preg_replace($this->_lexPatterns, $this->_lexReplacements, $arg);

        return $arg;
    }

    /**
     * Get most possible Arabic lexical forms for a given word.
     *
     * @param string $word String that user search for
     *
     * @return string list of most possible Arabic lexical forms for a given word
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected function allWordForms($word)
    {
        $wordForms = [$word];

        $postfix1 = ['كم', 'كن', 'نا', 'ها', 'هم', 'هن'];
        $postfix2 = ['ين', 'ون', 'ان', 'ات', 'وا'];

        $len = mb_strlen($word);

        if (mb_substr($word, 0, 2) == 'ال') {
            $word = mb_substr($word, 2);
        }

        $wordForms[] = $word;

        $str1 = mb_substr($word, 0, -1);
        $str2 = mb_substr($word, 0, -2);
        $str3 = mb_substr($word, 0, -3);

        $last1 = mb_substr($word, -1);
        $last2 = mb_substr($word, -2);
        $last3 = mb_substr($word, -3);

        if ($len >= 6 && $last3 == 'تين') {
            $wordForms[] = $str3;
            $wordForms[] = $str3.'ة';
            $wordForms[] = $word.'ة';
        }

        if ($len >= 6 && ($last3 == 'كما' || $last3 == 'هما')) {
            $wordForms[] = $str3;
            $wordForms[] = $str3.'كما';
            $wordForms[] = $str3.'هما';
        }

        if ($len >= 5 && in_array($last2, $postfix2)) {
            $wordForms[] = $str2;
            $wordForms[] = $str2.'ة';
            $wordForms[] = $str2.'تين';

            foreach ($postfix2 as $postfix) {
                $wordForms[] = $str2.$postfix;
            }
        }

        if ($len >= 5 && in_array($last2, $postfix1)) {
            $wordForms[] = $str2;
            $wordForms[] = $str2.'ي';
            $wordForms[] = $str2.'ك';
            $wordForms[] = $str2.'كما';
            $wordForms[] = $str2.'هما';

            foreach ($postfix1 as $postfix) {
                $wordForms[] = $str2.$postfix;
            }
        }

        if ($len >= 5 && $last2 == 'ية') {
            $wordForms[] = $str1;
            $wordForms[] = $str2;
        }

        if (($len >= 4 && ($last1 == 'ة' || $last1 == 'ه' || $last1 == 'ت'))
            || ($len >= 5 && $last2 == 'ات')
        ) {
            $wordForms[] = $str1;
            $wordForms[] = $str1.'ة';
            $wordForms[] = $str1.'ه';
            $wordForms[] = $str1.'ت';
            $wordForms[] = $str1.'ات';
        }

        if ($len >= 4 && $last1 == 'ى') {
            $wordForms[] = $str1.'ا';
        }

        $trans = ['أ' => 'ا', 'إ' => 'ا', 'آ' => 'ا'];
        foreach ($wordForms as $word) {
            $normWord = strtr($word, $trans);
            if ($normWord != $word) {
                $wordForms[] = $normWord;
            }
        }

        $wordForms = array_unique($wordForms);

        return $wordForms;
    }

    /**
     * Get most possible Arabic lexical forms of user search keywords.
     *
     * @param string $arg String that user search for
     *
     * @return string list of most possible Arabic lexical forms for given keywords
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function allForms($arg)
    {
        $wordForms = [];
        $words = explode(' ', $arg);

        foreach ($words as $word) {
            $wordForms = array_merge($wordForms, $this->allWordForms($word));
        }

        $str = implode(' ', $wordForms);

        return $str;
    }
}
