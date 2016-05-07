# Muslim Prayer Times

Using this PHP Class you can calculate the time of Muslim prayer according to the geographic location.

The five Islamic prayers are named Fajr, Zuhr, Asr, Maghrib and Isha. The timing of these five prayers varies from place to place and from day to day. It is obligatory for Muslims to perform these prayers at the correct time.

The prayer times for any given location on earth may be determined mathematically if the latitude and longitude of the location are known. However, the theoretical determination of prayer times is a lengthy process. Much of this tedium may be alleviated by using computer programs.

## Definition of prayer times

- FAJR starts with the dawn or morning twilight. Fajr ends just before sunrise.
- ZUHR begins after midday when the trailing limb of the sun has passed the meridian. For convenience, many published prayer timetables add five minutes to mid-day (zawal) to obtain the start of Zuhr. Zuhr ends at the start of Asr time.
- The timing of ASR depends on the length of the shadow cast by an object. According to the Shafi school of jurisprudence, Asr begins when the length of the shadow of an object exceeds the length of the object. According to the Hanafi school of jurisprudence, Asr begins when the length of the shadow exceeds TWICE the length of the object. In both cases, the minimum length of shadow (which occurs when the sun passes the meridian) is subtracted from the length of the shadow before comparing it with the length of the object.
- MAGHRIB begins at sunset and ends at the start of isha.
- ISHA starts after dusk when the evening twilight disappears.


## Qibla Determination Methods - Basic Spherical Trigonometric Formula

The problem of qibla determination has a simple formulation in spherical trigonometry. A is a given location, K is the Ka'ba, and N is the North Pole. The great circle arcs AN and KN are along the meridians through A and K, respectively, and both point to the north. The qibla is along the great circle arc AK. The spherical angle q = NAK is the angle at A from the north direction AN to the direction AK towards the Ka'ba, and so q is the qibla bearing to be computed. Let F and L be the latitude and longitude of A, and FK and LK be the latitude and longitude of K (the Ka'ba). If all angles and arc lengths are measured in degrees, then it is seen that the arcs AN and KN are of measure 90 - F and 90 - FK, respectively. Also, the angle ANK between the meridians of K and A equals the difference between the longitudes of A and K, that is, LK - L, no matter what the prime meridian is. Here we are given two sides and the included angle of a spherical triangle, and it is required to determine one other angle. One of the simplest solutions is given by the formula:

                       -1              sin(LK - L)
                q = tan   ------------------------------------------
                              cos F tan FK - sin F cos(LK - L)

In this Equation, the sign of the input quantities are assumed as follows: latitudes are positive if north, negative if south; longitudes are positive if east, negative if west. The quadrant of q is assumed to be so selected that sin q and cos q have the same sign as the numerator and denominator of this Equation. With these conventions, q will be positive for bearings east of north, negative for bearings west of north.
Reference: The Correct Qibla, S. Kamal Abdali <k.abdali@acm.org> PDF version in http://www.patriot.net/users/abdali/ftp/qibla.pdf



## Example : 

```php

    include_once "aip/vendor/autoload.php";
    
    use Buzzylab\Aip\Arabic;
    
    $arabic = new Arabic();

    // Latitude, Longitude, Zone, and Elevation
    $arabic->setLocation(33.52, 36.31, 3, 691);
    
    // Month, Day, and Year
    $arabic->setDate(date('n'), date('j'), date('Y'));

    echo "<b>Damascus, Syria</b> ".date('l F j, Y')."<br /><br />";

    // Salat calculation configuration: Egyptian General Authority of Survey
    $arabic->setConf('Shafi', -0.833333,  -17.5, -19.5, 'Sunni');
    $times = $arabic->getPrayTime();
    
    echo "<b>Imsak:</b> {$times[8]}<br />";
    echo "<b>Fajr:</b> {$times[0]}<br />";
    echo "<b>Sunrise:</b> {$times[1]}<br />";
    echo "<b>Dhuhr:</b> {$times[2]}<br />";
    echo "<b>Asr:</b> {$times[3]}<br />";
    echo "<b>Sunset:</b> {$times[6]}<br />";
    echo "<b>Maghrib:</b> {$times[4]}<br />";
    echo "<b>Isha:</b> {$times[5]}<br />";
    echo "<b>Midnight:</b> {$times[7]}<br /><br />";

    echo '<b>Imsak:</b> '   .date('l j F Y g:i a', $times[9][8]).'<br />';
    echo '<b>Fajr:</b> '    .date('l j F Y g:i a', $times[9][0]).'<br />';
    echo '<b>Sunrise:</b> ' .date('l j F Y g:i a', $times[9][1]).'<br />';
    echo '<b>Dhuhr:</b> '   .date('l j F Y g:i a', $times[9][2]).'<br />';
    echo '<b>Asr:</b> '     .date('l j F Y g:i a', $times[9][3]).'<br />';
    echo '<b>Sunset:</b> '  .date('l j F Y g:i a', $times[9][6]).'<br />';
    echo '<b>Maghrib:</b> ' .date('l j F Y g:i a', $times[9][4]).'<br />';
    echo '<b>Isha:</b> '    .date('l j F Y g:i a', $times[9][5]).'<br />';
    echo '<b>Midnight:</b> '.date('l j F Y g:i a', $times[9][7]).'<br /><br />';
    
    $direction = $arabic->getQibla();
    echo "<b>Qibla Direction (from the north direction):</b> $direction<br />";
    echo "(<a href=\"./Qibla.php?d=$direction\" target=_blank>click here</a>)<br /><br/>";


```