# English-Arabic Transliteration

PHP class transliterate English words into Arabic by render them in the orthography of the Arabic language and vise versa.

Out of vocabulary (OOV) words are a common source of errors in cross language information retrieval. Bilingual dictionaries are often limited in their coverage of named- entities, numbers, technical terms and acronyms. There is a need to generate translations for these "on-the-fly" or at query time.

A significant proportion of OOV words are named entities and technical terms. Typical analyses find around 50% of OOV words to be named entities. Yet these can be the most important words in the queries. Cross language retrieval performance (average precision) reduced more than 50% when named entities in the queries were not translated.

When the query language and the document language share the same alphabet it may be sufficient to use the OOV word as its own translation. However, when the two languages have different alphabets, the query term must somehow be rendered in the orthography of the other language. The process of converting a word from one orthography into another is called transliteration.

Foreign words often occur in Arabic text as transliteration. This is the case for many categories of foreign words, not just proper names but also technical terms such as caviar, telephone and internet.




## Example :

```php

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$en_terms = array('George Bush, Paul Wolfowitz', 'Silvio Berlusconi?',
        'Guantanamo', 'Arizona', 'Maryland', 'Oracle', 'Yahoo', 'Google',
        'Formula1', 'Boeing', 'Caviar', 'Telephone', 'Internet', "Côte d'Ivoire");

    echo <<< END
<center>
  <table border="0" cellspacing="2" cellpadding="5" width="500">
    <tr>
      <td bgcolor="#27509D" align="center" width="150">
        <b>
          <font color="#ffffff">
            English<br />(sample input)
          </font>
        </b>
      </td>
      <td bgcolor="#27509D" align="center" width="150">
        <b>
          <font color="#ffffff" face="Tahoma">
            Arabic<br />(auto generated)
          </font>
        </b>
      </td>
    </tr>
END;

    foreach ($en_terms as $term) {
        echo '<tr><td bgcolor="#f5f5f5" align="left">'.$term.'</td>';
        echo '<td bgcolor="#f5f5f5" align="right"><font face="Tahoma">';
        echo $arabic->en2ar($term);
        echo '</font></td></tr>';
    }

    echo '<tr><td bgcolor="#d0d0f5" align="left">0123,456.789</td>';
    echo '<td bgcolor="#d0d0f5" align="right"><font face="Tahoma">';
    echo $arabic->arNum('0123,456.789');
    echo '</font></td></tr>';

    echo '</table></center>';


```

## Example 2:

```php

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$ar_terms = array('خالِد الشَمعَة', 'جُبران خَليل جُبران', 'كاظِم الساهِر',
        'ماجِدَة الرُومِي، نِزار قَبَّانِي', 'سُوق الحَمِيدِيَّة؟', 'مَغارَة
        جَعِيتَا', 'غُوطَة دِمَشق', 'حَلَب الشَهبَاء', 'جَزيرَة أَرواد', 'بِلاد
        الرافِدَين', 'أهرامات الجِيزَة', 'دِرْع', 'عِيد', 'عُود', 'رِدْء', 
        'إِيدَاء', 'هِبَة الله');
    echo <<< END
<center>
  <table border="0" cellspacing="2" cellpadding="5" width="500">
    <tr>
      <td bgcolor="#27509D" align="center" width="150">
        <b>
          <font color="#ffffff" face="Tahoma">
            English<br />(auto generated)
          </font>
        </b>
      </td>
      <td bgcolor="#27509D" align="center" width="150">
        <b>
          <font color="#ffffff">
            Arabic<br />(sample input)
          </font>
        </b>
      </td>
    </tr>
END;

    foreach ($ar_terms as $term) {
        echo '<tr><td bgcolor="#f5f5f5" align="left"><font face="Tahoma">';
        echo $arabic->ar2en($term);
        echo '</font></td>';
        echo '<td bgcolor="#f5f5f5" align="right">'.$term.'</td></tr>';
    }

    echo '<tr><td bgcolor="#d0d0f5" align="left"><font face="Tahoma">';
    echo $arabic->enNum('0123,456.789');
    echo '</font></td>';
    echo '<td bgcolor="#d0d0f5" align="right">0123,456.789</td></tr>';

    echo '</table></center>';

```