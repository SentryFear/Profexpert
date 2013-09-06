<?php
header('Access-Control-Allow-Origin: *');
$result = array(
                array('name' => 'test', 'version' => '0.1'),
                array('name' => 'catalog', 'version' => '2b')
                );
echo json_encode($result);
?>