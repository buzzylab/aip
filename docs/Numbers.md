# Spell numbers in the Arabic idiom

PHP class to spell numbers in the Arabic idiom. This function is very useful for financial applications in Arabic for example.

If you ever have to create an Arabic PHP application built around invoicing or accounting, you might find this class useful. Its sole reason for existence is to help you translate integers into their spoken-word equivalents in Arabic language.

How is this useful? Well, consider the typical invoice: In addition to a description of the work done, the date, and the hourly or project cost, it always includes a total cost at the end, the amount that the customer is expected to pay.

To avoid any misinterpretation of the total amount, many organizations (mine included) put the amount in both words and figures; for example, $1,200 becomes "one thousand and two hundred dollars." You probably do the same thing every time you write a check.

Now take this scenario to a Web-based invoicing system. The actual data used to generate the invoice will be stored in a database as integers, both to save space and to simplify calculations. So when a printable invoice is generated, your Web application will need to convert those integers into words, this is more clarity and more personality.

This class will accept almost any numeric value and convert it into an equivalent string of words in written Arabic language (using Windows-1256 character set). The value can be any positive number up to 999,999,999 (users should not use commas). It will take care of feminine and Arabic grammar rules.


## Example:

```php


include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();


// المعدود مذكر مرفوع
$arabic->setFeminine(1);
$arabic->setFormat(1);

$integer = 141592653589;

$text = $arabic->int2str($integer);

echo "<center>$integer<br />$text</center>";


// المعدود مؤنث منصوب أو مجرور
$arabic->setFeminine(2);
$arabic->setFormat(2);

$integer = 141592653589;

$text = $arabic->int2str($integer);

echo "<center>$integer<br />$text</center>";


//المعدود مؤنث منصوب أو مجرور وهو سالب بفاصلة عشرية
$arabic->setFeminine(2);
$arabic->setFormat(2);

$integer = '-2749.317';

$text = $arabic->int2str($integer);

echo "<p dir=ltr align=center>$integer<br />$text</p>";


//العملات العربية
$number = 24.7;
$text   = $arabic->money2str($number, 'KWD', 'ar');

echo "<p dir=ltr align=center>$number<br />$text</p>";


//الأرقام الهندية
$text1 = '1975/8/2 9:43 صباحا';
$text2 = $arabic->int2indic($text1);

echo "<p dir=ltr align=center>$text1<br />$text2</p>";


//ترتيب لمعدود مؤنث منصوب أو مجرور
$arabic->setFeminine(2);
$arabic->setFormat(2);
$arabic->setOrder(2);

$integer = '17';

$text = $arabic->int2str($integer);

echo "<p dir=ltr align=center>$integer<br />$text</p>";



//تحويل الرقم المكتوب إلى عدد صحيح من جديد
$string  = 'مليار و مئتين و خمسة و ستين مليون و ثلاثمئة و ثمانية و خمسين ألف و تسعمئة و تسعة و سبعين';

$integer = $arabic->str2int($string);
    
echo "<p dir=ltr align=center>$string<br />$integer</p>";


```