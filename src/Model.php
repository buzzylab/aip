<?php

/**
 * This file is part of the AIP package.
 *
 * (c) Khaled Al-Sham'aa <khaled@ar-php.org> && Maher El Gamil <maherbusnes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace Buzzylab\Aip;

class Model
{
    /**
     * Get json data from json file.
     *
     * @param $file
     *
     * @return mixed
     */
    protected function getJsonData($file)
    {
        return json_decode(file_get_contents($file));
    }
}
