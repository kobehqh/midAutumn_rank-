<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 11:23
 */
$lotArr = array();
$count = array(0, 0, 0, 0, 0, 0);
for($i = 0; $i < 6; ++$i){
    $v = mt_rand(1, 6);
    array_push($lotArr, $v);
    ++$count[$v-1];
    echo '<pre>';
    print_r($count);
}
echo '<pre>';
print_r($count);
print_r($lotArr);
echo $count[3];
echo  $count[0];
?>
