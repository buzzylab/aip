# Arabic Soundex

PHP class for Arabic soundex algorithm takes Arabic word as an input and produces a character string which identifies a set words of those are (roughly) phonetically alike.

Terms that are often misspelled can be a problem for database designers. Names, for example, are variable length, can have strange spellings, and they are not unique. Words can be misspelled or have multiple spellings, especially across different cultures or national sources.

To solve this problem, we need phonetic algorithms which can find similar sounding terms and names. Just such a family of algorithms exists and is called SoundExes, after the first patented version.

A Soundex search algorithm takes a word, such as a person's name, as input and produces a character string which identifies a set of words that are (roughly) phonetically alike. It is very handy for searching large databases when the user has incomplete data.

The original Soundex algorithm was patented by Margaret O'Dell and Robert C. Russell in 1918. The method is based on the six phonetic classifications of human speech sounds (bilabial, labiodental, dental, alveolar, velar, and glottal), which in turn are based on where you put your lips and tongue to make the sounds.

Soundex function that is available in PHP, but it has been limited to English and other Latin-based languages. This function described in PHP manual as the following: Soundex keys have the property that words pronounced similarly produce the same soundex key, and can thus be used to simplify searches in databases where you know the pronunciation but not the spelling. This soundex function returns string of 4 characters long, starting with a letter.

We develop this class as an Arabic counterpart to English Soundex, it handle an Arabic input string formatted in UTF-8 character set to return Soundex key equivalent to normal soundex function in PHP even for English and other Latin-based languages because the original algorithm focus on phonetically characters alike not the meaning of the word itself.


## Example :

```php


include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();


$Clinton = array('كلينتون', 'كلينتن', 'كلينطون', 'كلنتن', 'كلنتون', 'كلاينتون');

    echo <<<END
<table border="0" cellpadding="5" cellspacing="2" align="center">
<tr>
    <td colspan="3">Listed below are 6 different spelling for the name
    <i><a href="http://en.wikipedia.org/wiki/Bill_Clinton" target=_blank>Clinton</a></i>
      found in collection of news articles in addition to original English spelling.</td>
</tr>
<tr>
    <td bgcolor=#000000 width=33%><b><font color=#ffffff>Function</font></b></td>
    <td bgcolor=#000000 width=33%><b><font color=#ffffff>Input</font></b></td>
    <td bgcolor=#000000 width=33%><b><font color=#ffffff>Output</font></b></td>
</tr>
END;
echo '<tr>
        <td bgcolor=#f5f5f5>PHP soundex function</td>
        <td bgcolor=#f5f5f5>Clinton</td>
        <td bgcolor=#f5f5f5>' . soundex('Clinton') . '</td>
      </tr>';

foreach ($Clinton as $name) {
    echo '<tr>
            <td bgcolor=#f5f5f5>ArSoundex Method</td>
            <td bgcolor=#f5f5f5>' . $name . '</td>
            <td bgcolor=#f5f5f5>' . $arabic->soundex($name) . '</td>
          </tr>';
}

echo '<tr>
        <td bgcolor=#f5f5c5>ArSoundex Method</td>
        <td bgcolor=#f5f5c5>كلينزمان</td>
        <td bgcolor=#f5f5c5>' . $arabic->soundex('كلينزمان') . '</td>
      </tr>';

echo <<<END
<tr>
    <td colspan=3>&nbsp;</td>
</tr>
<tr>
    <td colspan=3>Listed below are 6 different spelling for the name
    <i><a href="http://en.wikipedia.org/wiki/Milosevic" target=_blank>Milosevic</a></i>
     found in collection of news articles in addition to original English spelling.</td>
</tr>
<tr>
    <td bgcolor=#000000><b><font color=#ffffff>Function</font></b></td>
    <td bgcolor=#000000><b><font color=#ffffff>Input</font></b></td>
    <td bgcolor=#000000><b><font color=#ffffff>Output</font></b></td>
</tr>
<tr>
END;
    
    $Milosevic = array('ميلوسيفيتش', 'ميلوسفيتش', 'ميلوزفيتش', 'ميلوزيفيتش', 'ميلسيفيتش', 'ميلوسيفتش');

    echo '<tr>
            <td bgcolor=#f5f5f5>PHP soundex function</td>
            <td bgcolor=#f5f5f5>Milosevic</td>
            <td bgcolor=#f5f5f5>' . soundex('Milosevic') . '</td>
          </tr>';
                       
    foreach ($Milosevic as $name) {
        echo '<tr>
                <td bgcolor=#f5f5f5>ArSoundex Method</td>
                <td bgcolor=#f5f5f5>' . $name . '</td>
                <td bgcolor=#f5f5f5>' . $arabic->soundex($name) . '</td>
              </tr>';
    }

    echo '<tr>
            <td bgcolor=#f5f5c5>ArSoundex Method</td>
            <td bgcolor=#f5f5c5>ميلينيوم</td>
            <td bgcolor=#f5f5c5>' . $arabic->soundex('ميلينيوم') . '</td>
          </tr></table>';

```