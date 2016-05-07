Arabic Gender Guesser

This PHP class attempts to guess the gender of Arabic names.

Arabic nouns are either masculine or feminine. Usually when referring to a male, a masculine noun is usually used and when referring to a female, a feminine noun is used. In most cases the feminine noun is formed by adding a special characters to the end of the masculine noun. Its not just nouns referring to people that have gender. Inanimate objects (doors, houses, cars, etc.) is either masculine or feminine. Whether an inanimate noun is masculine or feminine is mostly arbitrary.

Example:

```php

    include_once "aip/vendor/autoload.php";

    use Buzzylab\Aip\Arabic;

    $arabic = new Arabic();

    $names = ['أحمد بشتو','أحمد منصور','الحبيب الغريبي','المعز بو لحية',
                          'توفيق طه','جلنار موسى','جمال  ريان','جمانة نمور',
                                               'جميل عازر','حسن جمول','حيدر عبد الحق','خالد صالح',
                          'خديجة بن قنة','ربى خليل','رشا عارف','روزي عبده',
                          'سمير سمرين','صهيب الملكاوي','عبد الصمد ناصر','علي الظفيري',
                          'فرح البرقاوي','فيروز زياني','فيصل القاسم','لونه الشبل',
                          'ليلى الشايب','لينا زهر الدين','محمد البنعلي',
                          'محمد الكواري','محمد خير البوريني','محمد كريشان',
                          'منقذ العلي','منى سلمان','ناجي سليمان','نديم الملاح',
                          'وهيبة بوحلايس'];


echo <<< END
<center>
  <table border="0" cellspacing="2" cellpadding="5" width="60%">
    <tr>
      <td colspan="2">
        <b>Al Jazeera Reporters (Class Example):</b>
      </td>
    </tr>
    <tr>
      <td bgcolor="#27509D" align="center" width="50%">
        <b><font color="#ffffff">Name (sample input)</font></b>
      </td>
      <td bgcolor="#27509D" align="center" width="50%">
        <b><font color="#ffffff">Gender (auto generated)</font></b>
      </td>
    </tr>
END;

    foreach ($names as $name) {
        if ($arabic->isFemale($name) == true) {
           $gender  = 'Female';
           $bgcolor = '#FFF0FF';
        } else {
           $gender = 'Male';
           $bgcolor = '#E0F0FF';
        }
        echo '<tr><td bgcolor="'.$bgcolor.'" align="center">';
        echo '<font face="Tahoma">'.$name.'</font></td>';
        echo '<td bgcolor="'.$bgcolor.'" align="center">'.$gender.'</td></tr>';
    }

    echo '</table></center>';

```