# Arabic Word Stemmer Class

PHP class to get stem of an Arabic word

A stemmer is an automatic process in which morphological variants of terms are mapped to a single representative string called a stem. Arabic belongs to the Semitic family of languages which also includes Hebrew and Aramaic. Since morphological change in Arabic results from the addition of prefixes and infixes as well as suffixes, simple removal of suffixes is not as effective for Arabic as it is for English.

Arabic has much richer morphology than English. Arabic has two genders, feminine and masculine; three numbers, singular, dual, and plural; and three grammatical cases, nominative, genitive, and accusative. A noun has the nominative case when it is a subject; accusative when it is the object of a verb; and genitive when it is the object of a preposition. The form of an Arabic noun is determined by its gender, number, and grammatical case. The definitive nouns are formed by attaching the Arabic article "AL" to the immediate front of the nouns. Besides prefixes, a noun can also carry a suffix which is often a possessive pronoun. In Arabic, the conjunction word "WA" (and) is often attached to the following word.

Like nouns, an Arabic adjective can also have many variants. When an adjective modifies a noun in a noun phrase, the adjective agrees with the noun in gender, number, case, and definiteness. Arabic verbs have two tenses: perfect and imperfect. Perfect tense denotes actions completed, while imperfect denotes uncompleted actions. The imperfect tense has four mood: indicative, subjective, jussive, and imperative. Arabic verbs in perfect tense consist of a stem and a subject marker. The subject marker indicates the person, gender, and number of the subject. The form of a verb in perfect tense can have subject marker and pronoun suffix. The form of a subject-marker is determined together by the person, gender, and number of the subject.


## Example :

```php
include_once "aip/vendor/autoload.php";

use Buzzylab\Aip\Arabic;

$arabic = new Arabic();

$examples = array();
    $examples[] = 'سيعرفونها من خلال العمل بالحاسوبين المستعملين لديهما';
    $examples[] = 'الخيليات البرية المهددة بالإنقراض';
    $examples[] = 'تزايدت الحواسيب الشخصية بمساعدة التطبيقات الرئيسية';
    $examples[] = 'سيتعذر هذا على عمليات نشر المساعدات للجائعين بالطريقة الجديدة';
    $examples[] = 'ليس هذا بالحل المثالي انظر  كتبي وكتابك';
    foreach ($examples as $str) {
        echo $str . ' <br />(';

        $words = split(' ', $str);
        $stems = array();

        foreach ($words as $word) {
            $stem = $arabic->stem($word);
            if ($stem) {
                $stems[] = $stem;
            }
        }

        echo implode('، ', $stems) . ')<br /><br />';
    }

```