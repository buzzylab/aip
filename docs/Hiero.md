# Translate English word into Hieroglyphics

Royality is made affordable, and within your reach. Now you can have The Royal Cartouche custome made in Egypt in 18 Kt. Gold with your name translated and inscribed in Hieroglyphic.

Originally, the Cartouche was worn only by the Pharaohs or Kings of Egypt. The Pharaoh was considered a living God and his Cartouche was his insignia. The "Magical Oval" in which the Pharaoh's first name was written was intended to protect him from evil spirits both while he lived and in the afterworld when entombed.

Over the past 5000 years the Cartouche has become a universal symbol of long life, good luck and protection from any evil.

Now you can acquire this ancient pendent handmade in Egypt from pure 18 Karat Egyptian gold with your name spelled out in the same way as King Tut, Ramses, Queen Nefertiti did.

## Example:

```php

     include_once "aip/vendor/autoload.php";

     use Buzzylab\Aip\Arabic;

     $arabic = new Arabic();

     $word = $_GET['w'];
     $im   = $arabic->str2graph($word);

     header ("Content-type: image/jpeg");
     imagejpeg($im, '', 80);
     ImageDestroy($im);

 ```

## Example 2:

```php

     include_once "aip/vendor/autoload.php";

     use Buzzylab\Aip\Arabic;

     $arabic = new Arabic();

     $arabic->setLanguage('Phoenician');
     $im = $arabic->str2graph($word, 'rtl', 'ar');

     $w = imagesx($im);
     $h = imagesy($im);

     $bg  = imagecreatefromjpeg('images/bg.jpg');
     $bgw = imagesx($bg);
     $bgh = imagesy($bg);

     // Set the content-type
     header("Content-type: image/png");

     imagecopyresized($bg, $im, ($bgw-$w)/2, ($bgh-$h)/2, 0, 0, $w, $h, $w, $h);

     imagepng($bg);
     imagedestroy($im);
     imagedestroy($bg);

 ```