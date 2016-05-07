# Arabic Auto Summarize

* This class identifies the key points in an Arabic document for you to share with others or quickly scan. The class determines key points by analyzing an Arabic document and assigning a score to each sentence. Sentences that contain words used frequently in the document are given a higher score. You can then choose a percentage of the highest-scoring sentences to display in the summary. "Summarize" class works best on well-structured documents such as reports, articles, and scientific papers.
* "Summarize" class cuts wordy copy to the bone by counting words and ranking sentences. First, "Summarize" class identifies the most common words in the document and assigns a "score" to each word--the more frequently a word is used, the higher the score.
* Then, it "averages" each sentence by adding the scores of its words and dividing the sum by the number of words in the sentence--the higher the average, the higher the rank of the sentence. "Summarize" class can summarize texts to specific number of sentences or percentage of the original copy.

## We use statistical approach, with some attention apparently paid to:

- Location: leading sentences of paragraph, title, introduction, and conclusion.
- Fixed phrases: in-text summaries.
- Frequencies of words, phrases, proper names
- Contextual material: query, title, headline, initial paragraph

## The motivation for this class is the range of applications for key phrases:

- Mini-summary: Automatic key phrase extraction can provide a quick mini-summary for a long document. For example, it could be a feature in a web sites; just click the summarize button when browsing a long web page.
- Highlights: It can highlight key phrases in a long document, to facilitate skimming the document.
- Author Assistance: Automatic key phrase extraction can help an author or editor who wants to supply a list of key phrases for a document. For example, the administrator of a web site might want to have a key phrase list at the top of each web page. The automatically extracted phrases can be a starting point for further manual refinement by the author or editor.
- Text Compression: On a device with limited display capacity or limited bandwidth, key phrases can be a substitute for the full text. For example, an email message could be reduced to a set of key phrases for display on a pager; a web page could be reduced for display on a portable wireless web browser.


### This list is not intended to be exhaustive, and there may be some overlap in the items.

## Example:

```php

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
