# Arabic in PHP (AIP)

[![Latest Stable Version](https://poser.pugx.org/buzzylab/aip/v/stable)](https://packagist.org/packages/buzzylab/aip)
[![Total Downloads](https://poser.pugx.org/buzzylab/aip/downloads)](https://packagist.org/packages/buzzylab/aip)
[![Latest Unstable Version](https://poser.pugx.org/buzzylab/aip/v/unstable)](https://packagist.org/packages/buzzylab/aip)
[![License](https://poser.pugx.org/buzzylab/aip/license)](https://packagist.org/packages/buzzylab/aip)

A simple PHP API extension that's provide arabic tools for PHP . [https://github.com/buzzylab/aip](https://github.com/buzzylab/aip)

> Note: AIP package is a built on the great library [Ar-PHP](http://www.ar-php.org/) (v4.0.0) which is developed by [Khaled Al-Sham'aa](http://www.ar-php.org/about-php-arabic.html).


```php

<?php

include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$rate     = 50;
$title    = 'أضخم تجربة علمية لدراسة بنية المادة المعتمة بمصادم الهدرونات الكبير';
$contents = <<<END
قال علماء في مركز أبحاث الفيزياء التابع للمنظمة الأوروبية للابحاث النووية يوم الجمعة
أنهم حققوا تصادما بين جسيمات بكثافة قياسية في إنجاز مهم في برنامجهم لكشف أسرار الكون.
وجاء التطور في الساعات الأولى بعد تغذية مصادم الهدرونات الكبير بحزمة أشعة بها
جسيمات أكثر بحوالي ستة في المئة لكل وحدة بالمقارنة مع المستوى القياسي السابق
الذي سجله مصادم تيفاترون التابع لمختبر فرميلاب الأمريكي العام الماضي.
وكل تصادم في النفق الدائري لمصادم الهدرونات البالغ طوله 27 كيلومترا تحت الأرض
بسرعة أقل من سرعة الضوء يحدث محاكاة للانفجار العظيم الذي يفسر به علماء نشوء الكون
قبل 13.7 مليار سنة. وكلما زادت "كثافة الحزمة" أو ارتفع عدد الجسيمات فيها زاد
عدد التصادمات التي تحدث وزادت أيضا المادة التي يكون على العلماء تحليلها.
ويجري فعليا انتاج ملايين كثيرة من هذه "الانفجارات العظيمة المصغرة" يوميا.
وقال رولف هوير المدير العام للمنظمة الاوروبية للأبحاث النووية ومقرها على الحدود
الفرنسية السويسرية قرب جنيف أن "كثافة الحزمة هي الأساس لنجاح مصادم الهدرونات الكبير
ولذا فهذه خطوة مهمة جدا"، وأضاف "الكثافة الأعلى تعني مزيدا من البيانات، ومزيد
من البيانات يعني إمكانية أكبر للكشف." وقال سيرجيو برتولوتشي مدير الأبحاث في المنظمة
"يوجد إحساس ملموس بأننا على أعتاب كشف جديد". وفي حين زاد الفيزيائيون والمهندسون
في المنظمة كثافة حزم الأشعة على مدى الأسبوع المنصرم قال جيمس جيليه المتحدث باسم المنظمة
أنهم جمعوا معلومات تزيد على ما جمعوه على مدى تسعة أشهر من عمل مصادم الهدرونات في 2010.
وتخزن تلك المعلومات على آلاف من أقراص الكمبيوتر. ويمثل المصادم البالغة تكلفته
عشرة مليارات دولار أكبر تجربة علمية منفردة في العالم وقد بدأ تشغيله في نهاية
مارس آذار 2010. وبعد الإغلاق الدائم لمصادم تيفاترون في الخريف القادم سيصبح
مصادم الهدرونات المصادم الكبير الوحيد الموجود في العالم. ومن بين أهداف
مصادم الهدرونات الكبير معرفة ما إذا كان الجسيم البسيط المعروف بإسم جسيم هيجز
أو بوزون هيجز موجود فعليا. ويحمل الجسيم إسم العالم البريطاني بيتر هيجز
الذي كان أول من افترض وجوده كعامل أعطي الكتلة للجسيمات بعد الإنفجار العظيم.
ومن خلال متابعة التصادمات على أجهزة الكمبيوتر في المنظمة الأوروبية للأبحاث النووية
وفي معامل في أنحاء العالم مرتبطة بها يأمل العلماء أيضا أن يجدوا دليلا قويا على
وجود المادة المعتمة التي يعتقد أنها تشكل حوالي ربع الكون المعروف وربما الطاقة المعتمة
التي يعتقد أنها تمثل حوالي 70 في المئة من الكون. ويقول علماء الفلك أن تجارب
المنظمة الأوروبية للأبحاث النووية قد تلقي الضوء أيضا على نظريات جديدة بازغة
تشير إلى أن الكون المعروف هو مجرد جزء من نظام لأكوان كثيرة غير مرئية لبعضها البعض
ولا توجد وسائل للتواصل بينها. ويأملون أيضا أن يقدم مصادم الهدرونات الكبير
الذي سيبقى يعمل على مدى عقد بعد توقف فني لمدة عام في 2013 بعض الدعم
لدلائل يتعقبها باحثون آخرون على أن الكون المعروف سبقه كون آخر قبل الانفجار العظيم.
وبعد التوقف عام 2013 يهدف علماء المنظمة الأوروبية للأبحاث النووية إلى زيادة
الطاقة الكلية لكل تصادم بين الجسيمات من الحد الاقصى الحالي البالغ 7 تيرا الكترون فولت
إلى 14 تيرا الكترون فولت. وسيزيد ذلك أيضا من فرصة التوصل لاكتشافات جديدة فيما تصفه
المنظمة بأنه "الفيزياء الجديدة" بما يدفع المعرفة لتجاوز ما يسمى النموذج المعياري
المعتمد على نظريات العالم البرت اينشتاين في اوائل القرن العشرين.
END;

$contents = str_replace("\n", '', $contents);


$highlighted = $arabic->highlightRateSummary($contents, $rate, null, 'summary');
$summary = $arabic->doRateSummarize($contents, $rate, null);

echo "<h3>$title:</h3>";
echo 'الملخص العادى';
echo "<h4>الملخص</h4>$summary";
echo "<h4>النص الكامل</h4>$highlighted";

echo "<br><hr><br>";

$query = "هيجنز";

$highlighted = $arabic->highlightRateSummary($contents, $rate, $query, 'summary');
$summary = $arabic->doRateSummarize($contents, $rate, $query);

echo "<h3>$title:</h3>";
echo 'الملخص لو كنت تبحث عن كلمة هيجنز';
echo "<h4>الملخص</h4>$summary";
echo "<h4>النص الكامل</h4>$highlighted";


```


## Contents
- [Features](#features)
- [Installation](#Installation)
- [Change log](#change-log)
- [Issues](#issues)
- [Contributing](#contributing)
- [Credits & inspirations](#credits--inspirations)
- [License](#license)

## Features
* Arabic text auto summarization
* Advanced Arabic search (stem based)
* Render Arabic text (PDF, GD, SWF)
* Present dates in Arabic or Hijri
* Convert Hijri date into Unix timestamp
* Parse Arabic textual datetime into timestamp
* Transliterate English words in Arabic
* Transliterate Arabic words in English
* Spell numbers in Arabic idiom
* Phonetically alike Arabic words
* Arabic character set converter
* Arabic character set auto detection
* Identify Arabic in multi language documents
* Identify names & places in Arabic text
* Guess gender of Arabic names
* Convert keyboard language programmatically
* Calculate the time of Muslim prayer
* Compress string using Huffman-like coding
* Standardize Arabic text
* Arabic stemmer
* Arabic Cities List
* Informations about Arabic countries
* Arabic text normalisation





## Installation
### With Composer

```
$ composer require buzzylab/aip
```

```json
{
    "require": {
        "buzzylab/aip": "~1.0.*"
    }
}
```

```php
<?php
require 'vendor/autoload.php';

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

```

### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download [Arabic.php](https://github.com/buzzylab/aip/blob/master/src/Arabic.php) from the repo and save the file into your project path somewhere.

```php
<?php
require 'path/to/Arabic.php';

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

```


## Change log
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Issues
For the list of all current and former/closed issues see the [github issue list](https://github.com/buzzylab/aip/issues).
If you find a problem, please follow the same link and create an new issue, I will look at it and get back to you ASAP.

## Contributing
I would be glad to accept your contributions if you want to participate and share. Just follow GitHub's guide on how
to [fork a repository](https://help.github.com/articles/fork-a-repo/). Clone your repository to your machine, make
your change then create a pull request after submitting your change to your repository.

## Credits & inspirations
It goes without saying that none of this could have been done without the great [arphp](http://www.ar-php.org/)
library, a big thank you goes out to [Khaled Al-Sham'aa](http://www.ar-php.org/about-php-arabic.html).



### License
The AIP is open-sourced software licensed under the GNU General Public License Version 3 (GPLv3).
Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/badge/packagist-v0.0.1-orange.svg
[ico-license]: https://img.shields.io/badge/licence-GPLv3-brightgreen.svg

[link-packagist]: https://packagist.org/packages/buzzylab/aip
