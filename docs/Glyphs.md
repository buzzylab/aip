# Arabic Glyphs is class to render Arabic text

PHP class to render Arabic text by performs Arabic glyph joining on it, then output a UTF-8 hexadecimals stream gives readable results on PHP libraries supports UTF-8.

## Example:


```php

   include_once "aip/vendor/autoload.php";

   use Buzzylab\Aip\Arabic;

   $arabic = new Arabic();

   $text = $arabic->utf8Glyphs($text);

   imagettftext($im, 20, 0, 200, 100, $black, $font, $text);

```