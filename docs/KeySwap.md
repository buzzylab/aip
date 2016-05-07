# Arabic Keyboard Swapping Language

PHP class to convert keyboard language between English and Arabic programmatically. This function can be helpful in dual language forms when users miss change keyboard language while they are entering data.

If you wrote an Arabic sentence while your keyboard stays in English mode by mistake, you will get a non-sense English text on your PC screen. In that case you can use this class to make a kind of magic conversion to swap that odd text by original Arabic sentence you meant when you type on your keyboard.

Please note that magic conversion in the opposite direction (if you type English sentences while your keyboard stays in Arabic mode) is also available in this class, but it is not reliable as much as previous case because in Arabic keyboard we have some keys provide a short-cut to type two chars in one click (those keys include: b, B, G and T).

Well, we try in this class to come over this issue by suppose that user used optimum way by using short-cut keys when available instead of assemble chars using stand alone keys, but if (s)he does not then you may have some typo chars in converted text.


## Example:

```php

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$str = "Hpf lk hgkhs hglj'vtdkK Hpf hg`dk dldg,k f;gdjil Ygn
,p]hkdm hgHl,v tb drt,k ljv]]dk fdk krdqdk>";
echo "<u><i>Before - English Keyboard:</i></u><br />$str<br /><br />";

$text = $arabic->swapEa($str);
echo "<u><i>After:</i></u><br />$text<br /><br />";


$str = "ِىغ هىفثممهلثىف بخخم ؤشى ةشنث فاهىلس لاهللثق ةخقث ؤخةحمثء شىي ةخقث رهخمثىفز ÷ف فشنثس ش فخعؤا خب لثىهعس شىي ش مخف خب ؤخعقشلث فخ ةخرث هى فاث خححخسهفث يهقثؤفهخىز";
echo "<u><i>Before:</i></u><br />$str<br /><br />";

$text = $arabic->swapAe($str);
echo "<u><i>After:</i></u><br />$text<br /><br /><b>Albert Einstein</b>";


$examples = array("ff'z g;k fefhj", "FF'Z G;K FEFHJ", 'ٍمخصمغ لاعف سعقثمغ', 'sLOWLY BUT SURELY');

foreach ($examples as $example) {
    $fix = $arabic->fixKeyboardLang($example);

    echo '<font color="red">' . $example . '</font> => ';
    echo '<font color="blue">' . $fix . '</font><br />';
}


```

