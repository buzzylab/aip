This class provides various functions to manipulate arabic text and normalise it by applying filters, for example, to strip tatweel and tashkeel, to normalise hamza and lamalephs, and to unshape a joined Arabic text back into its normalised form.

There is also a function to reverse a utf8 string.

The functions are helpful for searching, indexing and similar functions.

Note that this class can only deal with UTF8 strings. You can use functions from the other classes to convert between encodings if necessary.

## Example :

```php

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

echo <<<END
<p>قال الشاعر حافظ إبراهيم على لسان اللغة العربية</p>
<table border="0" cellpadding="5" cellspacing="2" dir="rtl">
END;

$lines[] = 'وَسِعْتُ كِتابَ اللَّهِ لفظـــاً وَحِكمَــــةً **** وَما ضِقْتُ عن آيٍ به وَعِظــــاتِ';
$lines[] = 'فَكيفَ أَضيقُ اليومَ عن وَصْفِ آلــةٍ **** وَتَنسيـــقُ أسمــاءٍ لِمُخْتَرَعــــاتِ';

foreach ($lines as $line) {
    echo '<tr><th style="background-color: #E5E5E5">Function</th>
          <th style="background-color: #E5E5E5">Text</th></tr>';

    echo "<tr bgcolor=#F0F8FF><th>Original</th><td>$line</td></tr>";

    $n1 = $arabic->unshape($line);
    echo "<tr bgcolor=#F0F8FF><th>Unshape</th><td>$n1</td></tr>";

    $n2 = $arabic->utf8Strrev($n1);
    echo "<tr bgcolor=#F0F8FF><th>UTF8 Reverse</th><td>$n2</td></tr>";

    $n3 = $arabic->stripTashkeel($n1);
    echo "<tr bgcolor=#F0F8FF><th>Strip Tashkeel</th><td>$n3</td></tr>";

    $n4 = $arabic->stripTatweel($n3);
    echo "<tr bgcolor=#F0F8FF><th>Strip Tatweel</th><td>$n4</td></tr>";

    $n5 = $arabic->normaliseHamza($n4);
    echo "<tr bgcolor=#F0F8FF><th>Normalise Hamza</th><td>$n5</td></tr>";

    $n6 = $arabic->normaliseLamaleph($n5);
    echo "<tr bgcolor=#F0F8FF><th>Normalise Lam Alef</th><td>$n6</td></tr>";
}

echo '</table>';

```