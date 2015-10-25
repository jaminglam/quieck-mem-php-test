<?php 
/**
 * This is a json encoder by jam version
 */
function isAssoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function valConvert($val) {
    if (is_string($val)) {
        return "\"" . $val . "\"";
    }
    return $val; 
}

function encode($arr, $json) {
    $json .= "{";
    $size = count($arr);
    $cnt = 1;
    foreach ($arr as $key => $val) {
        if ($cnt < $size) {
            if (is_array($val) && isAssoc($val)) {
                $json = $json . "\"" . $key . "\"" . ":";
                $json = encode($val, $json) . ",";
            } else if (is_array($val)) {
                $json = $json . "\"" . $key ."\"" . ":[";
                for ($i = 0; $i < count($val); $i++) {
                    if ($i == 0) {
                        $json = $json . valConvert($val[$i]);
                    } else {
                        $json = $json . "," . valConvert($val[$i]);
                    }
                }
                $json .= "],";
            } else {
                $json = $json . "\"" . $key . "\"" . ":" . valConvert($val) . ",";
            }
            $cnt++;
        } else if ($cnt == $size) {
            if (is_array($val) && isAssoc($val)) {
                $json = $json . "\"" . $key . "\"" . ":";
                $json = encode($val, $json);
            } else if (is_array($val)) {
                $json = $json . "\"" . $key ."\"" . ":[";
                for ($i = 0; $i < count($val); $i++) {
                    if ($i == 0) {
                        $json = $json . valConvert($val[$i]);
                    } else {
                        $json = $json . "," . valConvert($val[$i]);
                    }
                }
                $json .= "]";
            } else {
                $json = $json . "\"" . $key . "\"" . ":" . valConvert($val);
            }
            $cnt++;
            return $json . "}";
        }
    }
}

 $test_arr = array(
     "test_key1" => "test_val1",
     "test_key2" => 1,
     "test_key3" => array(1,2,3,4,5),
     "test_key4" => array(
         "sub_test_key1" => 2,
         "sub_test_key2" => array(6,7,8),
         "sub_test_key3" => array(
             "sub_sub_test_key1" => 3
         )
     )
 );
 
echo json_encode($test_arr) . "\n";
echo encode($test_arr, "") . "\n";
