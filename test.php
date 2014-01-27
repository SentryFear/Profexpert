<?php
/*$to      = 'sentryfear@gmail.com';
$subject = 'проверка хостинга';
$message = 'проверка хостинга';
$headers =  'From: spb@profexpert.com' . "\r\n" .
            'Reply-To: spb@profexpert.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers, '-fspb@profexpert.com');*/



/*header('Access-Control-Allow-Origin: *');
$result = array(
                array('name' => 'test', 'version' => '0.1'),
                array('name' => 'catalog', 'version' => '2b')
                );
echo json_encode($result);
ignore_user_abort();
set_time_limit(0);
function decodeMd5($pass) {
    $strlen = 10;
    $hash = "5e5a62d13338d9052805615c4fba37df";


// Массив символов
    $char[] = 'a'; $char[] = 'b'; $char[] = 'c'; $char[] = 'd'; $char[] = 'e';
    $char[] = 'f'; $char[] = 'g'; $char[] = 'h'; $char[] = 'i'; $char[] = 'j';
    $char[] = 'k'; $char[] = 'l'; $char[] = 'm'; $char[] = 'n'; $char[] = 'o';
    $char[] = 'p'; $char[] = 'q'; $char[] = 'r'; $char[] = 's'; $char[] = 't';
    $char[] = 'u'; $char[] = 'v'; $char[] = 'w'; $char[] = 'x'; $char[] = 'y';
    $char[] = 'z';

    $char[] = '1'; $char[] = '2'; $char[] = '3'; $char[] = '4';
    $char[] = '5'; $char[] = '6'; $char[] = '7'; $char[] = '8'; $char[] = '9'; $char[] = '0';
    $char[] = 'A'; $char[] = 'B'; $char[] = 'C'; $char[] = 'D'; $char[] = 'E';
    $char[] = 'F'; $char[] = 'G'; $char[] = 'H'; $char[] = 'I'; $char[] = 'J';
    $char[] = 'K'; $char[] = 'L'; $char[] = 'M'; $char[] = 'N'; $char[] = 'O';
    $char[] = 'P'; $char[] = 'Q'; $char[] = 'R'; $char[] = 'S'; $char[] = 'T';
    $char[] = 'U'; $char[] = 'V'; $char[] = 'W'; $char[] = 'X'; $char[] = 'Y';
    $char[] = 'Z';

    $maxlen = $strlen - 1;

    if(strlen($pass) > $maxlen) return 'end.';

    for($j = 0; $j < count($char); $j++) {
        $temp = $pass.$char[$j];
        $insert_hash = md5($temp);
        $insert_pass = addslashes($temp);

        if($insert_hash == $hash){

            define("fileName", "md5_decode.log");
            $str = "Хеш: ".$insert_hash." Пароль: ".$insert_pass . "\r\n";
            $f = fopen(fileName, "a");
            fputs($f, $str);
            fclose($f);
            break;
        }


        $result = decodeMd5($temp);

    }
    sleep(1);

}

decodeMd5("");
*/
?>