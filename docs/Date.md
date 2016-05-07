# Arabic Date

PHP class for Arabic and Islamic customization of PHP date function. It can convert UNIX timestamp into string in Arabic as well as convert it into Hijri calendar

##The Islamic Calendar:

The Islamic calendar is purely lunar and consists of twelve alternating months of 30 and 29 days, with the final 29 day month extended to 30 days during leap years. Leap years follow a 30 year cycle and occur in years 1, 5, 7, 10, 13, 16, 18, 21, 24, 26, and 29. The calendar begins on Friday, July 16th, 622 C.E. in the Julian calendar, Julian day 1948439.5, the day of Muhammad's separate from Mecca to Medina, the first day of the first month of year 1 A.H.--"Anno Hegira".

Each cycle of 30 years thus contains 19 normal years of 354 days and 11 leap years of 355, so the average length of a year is therefore ((19 x 354) + (11 x 355)) / 30 = 354.365... days, with a mean length of month of 1/12 this figure, or 29.53055... days, which closely approximates the mean synodic month (time from new Moon to next new Moon) of 29.530588 days, with the calendar only slipping one day with respect to the Moon every 2525 years. Since the calendar is fixed to the Moon, not the solar year, the months shift with respect to the seasons, with each month beginning about 11 days earlier in each successive solar year.

The convert presented here is the most commonly used civil calendar in the Islamic world; for religious purposes months are defined to start with the first observation of the crescent of the new Moon.

## The Julian Calendar:

The Julian calendar was proclaimed by Julius Casar in 46 B.C. and underwent several modifications before reaching its final form in 8 C.E. The Julian calendar differs from the Gregorian only in the determination of leap years, lacking the correction for years divisible by 100 and 400 in the Gregorian calendar. In the Julian calendar, any positive year is a leap year if divisible by 4. (Negative years are leap years if when divided by 4 a remainder of 3 results.) Days are considered to begin at midnight.

In the Julian calendar the average year has a length of 365.25 days. compared to the actual solar tropical year of 365.24219878 days. The calendar thus accumulates one day of error with respect to the solar year every 128 years. Being a purely solar calendar, no attempt is made to synchronise the start of months to the phases of the Moon.

## The Gregorian Calendar:

The Gregorian calendar was proclaimed by Pope Gregory XIII and took effect in most Catholic states in 1582, in which October 4, 1582 of the Julian calendar was followed by October 15 in the new calendar, correcting for the accumulated discrepancy between the Julian calendar and the equinox as of that date. When comparing historical dates, it's important to note that the Gregorian calendar, used universally today in Western countries and in international commerce, was adopted at different times by different countries. Britain and her colonies (including what is now the United States), did not switch to the Gregorian calendar until 1752, when Wednesday 2nd September in the Julian calendar dawned as Thursday the 14th in the Gregorian.

The Gregorian calendar is a minor correction to the Julian. In the Julian calendar every fourth year is a leap year in which February has 29, not 28 days, but in the Gregorian, years divisible by 100 are not leap years unless they are also divisible by 400. How prescient was Pope Gregory! Whatever the problems of Y2K, they won't include sloppy programming which assumes every year divisible by 4 is a leap year since 2000, unlike the previous and subsequent years divisible by 100, is a leap year. As in the Julian calendar, days are considered to begin at midnight.


> The average length of a year in the Gregorian calendar is 365.2425 days compared to the actual solar tropical year (time from equinox to equinox) of 365.24219878 days, so the calendar accumulates one day of error with respect to the solar year about every 3300 years. As a purely solar calendar, no attempt is made to synchronise the start of months to the phases of the Moon.

> date -- Format a local time/date string date ( string format, int timestamp);

> Returns a string formatted according to the given format string using the given integer timestamp or the current local time if no timestamp is given. In otherwords, timestamp is optional and defaults to the value of time().

## Example:


```php

    date_default_timezone_set('GMT');
    $time = time();

    echo date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    include_once "aip/vendor/autoload.php";

    use Buzzylab\Aip\Arabic;

    $arabic = new Arabic();

    $correction = $arabic->dateCorrection ($time);
    echo $arabic->date('l dS F Y h:i:s A', $time, $correction);

    $day = $arabic->date('j', $time, $correction);
    echo ' [<a href="Moon.php?day='.$day.'" target=_blank>القمر الليلة</a>]';
    echo '<br /><br />';

    $arabic->setMode(8);
    echo $arabic->date('l dS F Y h:i:s A', $time, $correction);
    echo '<br /><br />';

    $arabic->setMode(2);
    echo $arabic->date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    $arabic->setMode(3);
    echo $arabic->date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    $arabic->setMode(4);
    echo $arabic->date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    $arabic->setMode(5);
    echo $arabic->date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    $arabic->setMode(6);
    echo $arabic->date('l dS F Y h:i:s A', $time);
    echo '<br /><br />';

    $arabic->setMode(7);
    echo $arabic->date('l dS F Y h:i:s A', $time);

```

## Example 2:

```php

    date_default_timezone_set('UTC');

    include_once "aip/vendor/autoload.php";

    use Buzzylab\Aip\Arabic;

    $arabic = new Arabic();

    $correction = $arabic->mktimeCorrection(9, 1429);
    $time = $arabic->mktime(0, 0, 0, 9, 1, 1429, $correction);
    echo "Calculated first day of Ramadan 1429 unix timestamp is: $time<br>";

    $Gregorian = date('l F j, Y', $time);
    echo "Which is $Gregorian in Gregorian calendar";

    $days = $arabic->hijriMonthDays(9, 1429);
    echo "That Ramadan has $days days in total";

```
