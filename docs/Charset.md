# Detect Arabic String Character Set

- The last step of the Information Retrieval process is to display the found documents to the user. However, some difficulties might occur at that point. English texts are usually written in the ASCII standard. Unlike the English language, many languages have different character sets, and do not have one standard. This plurality of standards causes problems, especially in a web environment.

- This PHP class will return Arabic character set that used for a given Arabic string passing into this class, those available character sets that can be detected by this class includes the most popular three: Windows-1256, ISO 8859-6, and UTF-8.

## Example:

```php

    include_once "aip/vendor/autoload.php";

    use Buzzylab\Aip\Arabic;

    $arabic = new Arabic();

    $charset = $arabic->getCharset($text);

```
