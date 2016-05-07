# Identify Arabic Text Segments

Using this PHP Class you can fully automated approach to processing Arabic text by quickly and accurately determining Arabic text segments within multiple languages documents.

Understanding the language and encoding of a given document is an essential step in working with unstructured multilingual text. Without this basic knowledge, applications such as information retrieval and text mining cannot accurately process data and important information may be completely missed or mis-routed.

Any application that works with Arabic in multiple languages documents can benefit from the ArIdentifier class. Using this class, applications can take a fully automated approach to processing Arabic text by quickly and accurately determining Arabic text segments within multiple languages document.

## Example:

```php

$text = <<< END
<p> <big><big><b> Peace &nbsp; <big>سلام</big> &nbsp; שלום &nbsp; Hasîtî &nbsp;
शान्ति&nbsp; Barış &nbsp; 和平&nbsp; Мир </b></big></big> </p><dl>
<dt><b>English:</b>

</dt><dd><big><i>Say <i>Peace</i> in all languages!</i></big>

The people of the world prefer peace to war and they deserve to have it.
Bombs are not needed to solve international problems when they can be solved
just as well with respect and communication.  The Internet Internationalization
(I18N) community, which values diversity and human life everywhere, offers
"Peace" in many languages as a small step in this direction.

<p>

</p></dd><dt><b>Arabic: نص عربي</b>

</dt><dd dir="rtl" align="right" lang="ar"><big>أنطقوا سلام بكل
اللغات!</big>
كل شعوب العالم تفضل السلام علي الحرب وكلها تستحق أن تنعم به.
إن القنابل لا تحل مشاكل العالم ويتم تحقيق ذلك فقط بالاحترام
والتواصل.
مجموعة تدويل الإنترنت <span dir="ltr">(I18N)</span> ، والتي تأخذ بعين
التقدير الاختلافات الثقافية والعادات الحياتية
بين الشعوب، فإنها تقدم "السلام" بلغات كثيرة، كخطوة متواضعة في هذا
الاتجاه.</dd>

<p>

</p><dt><b>Hebrew:</b>

</dt><dd dir="rtl" align="right" lang="he"><big>אמרו "שלום" בכל השפות!</big> אנשי העולם מעדיפים את השלום על-פני המלחמה והם
ראויים לו. אין צורך בפצצות כדי לפתור בעיות בין-לאומיות, רק בכבוד
ובהידברות. קהילת בינאום האינטרנט <span dir="ltr">(I18N)</span>, אשר מוקירה רב-גוניות וחיי אדם
בכל מקום, מושיטה יד ל"שלום" בשפות רבות כצעד קטן בכיוון זה.</dd>
</dl>

<hr>
<p> <b>Some Authors</b><b>:</b> </p>
<dl>
  <ul>
    <li>Frank da&nbsp;Cruz, New York City (USA) </li>
    <li>Marco Cimarosti, Milano (Italy) </li>
    <li>Michael Everson, Dublin (Ireland) </li>
    <li><span dir="rtl">فريد عدلي</span> / Farid Adly,<br>
      Editor in Chief, Italian-Arab News Agency ANBAMED<br>
      (Notizie dal Mediterraneo - <span dir="rtl">أنباء البحر المتوسط</span>),
      Acquedolci (Italy) </li>
  </ul>
  <p></p>
</dl>
END;

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$pos = $arabic->identify($text);

$total = count($pos);

echo substr($text, 0, $pos[0]);

for ($i=0; $i<$total; $i+=2) {
    echo '<span style="BACKGROUND-COLOR: #EEEE80">';
    echo substr($text, $pos[$i], $pos[$i+1]-$pos[$i]);
    echo '</span>';
    echo substr($text, $pos[$i+1], $pos[$i+2]-$pos[$i+1]);
}


```