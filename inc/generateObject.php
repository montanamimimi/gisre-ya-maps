<?php 

    function generateObject($newdata) {

        $object = array(
            'name' => $newdata['name'],
            'type' => $newdata['type'],
            'lat' => $newdata['lat'],
            'lon' => $newdata['lon'],
            'location' => $newdata['location'],
            'power' => $newdata['power'],
            'powerpr' => $newdata['powerpr'],
            'year' => $newdata['year'],
            'status' => $newdata['status'],
            'function' => $newdata['function'],
            'holder' => $newdata['holder'],
            'source' => $newdata['source'],
            'link' => $newdata['link'],
            'linkshort' => $newdata['linkshort'],
            'picture' => $newdata['picture'],
            'date' => $newdata['date'],
            'pp' => $newdata['pp'],
            'gen' => $newdata['gen'],
            'truthplace' => $newdata['truthplace'],
            'published' => 1
        );

        return $object;
    }


?>