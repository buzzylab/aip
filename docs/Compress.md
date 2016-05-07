# Arabic Compress String Class

## Compress string using Huffman-like coding

This class compresses text strings into roughly 70% of their original size by benefit from using compact coding for most frequented letters in a given language. This algorithm associated with text language, so you will find 6 different classes for the following languages: Arabic, English, French, German, Italian and Spanish language.

## Benefits of this compress algorithm include:

- It is written in pure PHP code, so there is no need to any PHP extensions to use it.
- You can search in compressed string directly without any need uncompress text before search in.
- You can get original string length directly without need to uncompress compressed text.

> Note: Unfortunately text compressed using this algorithm lose the structure that normal zip algorithm used, so benefits from using ZLib functions on this text will be reduced.

>There is another drawback, this algorithm working only on text from a given language, it does not working fine on binary files like images or PDF.

## Example:

```php

 include_once "aip/vendor/autoload.php";

 use Buzzylab\Aip\Arabic;

 $arabic = new Arabic();

 $arabic->setInputCharset('windows-1256');
 $arabic->setOutputCharset('windows-1256');

 $file = 'Compress/ar_example.txt';
 $fh   = fopen($file, 'r');
 $str  = fread($fh, filesize($file));
 fclose($fh);

 $zip = $arabic->compress($str);

 $before = strlen($str);
 $after  = strlen($zip);
 $rate   = round($after * 100 / $before);

 echo "String size before was: $before Byte<br>";
 echo "Compressed string size after is: $after Byte<br>";
 echo "Rate $rate %<hr>";

 $str = $arabic->decompress($zip);

 if ($arabic->search($zip, $word)) {
     echo "Search for $word in zipped string and find it<hr>";
 } else {
     echo "Search for $word in zipped string and do not find it<hr>";
 }

 $len = $arabic->length($zip);
 echo "Original length of zipped string is $len Byte<hr>";

 echo '<div dir="rtl" align="justify">'.nl2br($str).'</div>';

```