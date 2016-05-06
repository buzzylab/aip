<?php

namespace Buzzylab\Aip;

class Model {


    /**
     * Get json data from json file
     * 
     * @param $file
     * @return mixed
     */
    protected function getJsonData($file){
        return json_decode(file_get_contents($file));
    }

}