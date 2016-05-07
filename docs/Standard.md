#Arabic Text Standardize Class

PHP class to standardize Arabic text just like rules followed in magazines and newspapers like spaces before and after punctuations, brackets and units etc ...


# Example :

```php


include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();


$content = <<<END
هذا نص عربي ، و فيه علامات ترقيم بحاجة إلى ضبط و معايرة !و كذلك نصوص( بين
أقواس )أو حتى مؤطرة"بإشارات إقتباس "أو- علامات إعتراض -الخ......
<br>
لذا ستكون هذه المكتبة أداة و وسيلة لمعالجة مثل هكذا حالات، بما فيها الواحدات 1
Kg أو مثلا MB 16 وسواها حتى النسب المؤية مثل 20% أو %50 وهكذا ...
END;

    $str = $arabic->standard($content);

    echo '<b>Origenal:</b>';
    echo '<p dir="rtl" align="justify">';
    echo $content . '</p>';

    echo '<b>Standard:</b>';
    echo '<p dir="rtl" align="justify">';
    echo $str . '</p>';

```