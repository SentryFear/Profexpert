<?php
echo 1;
function utf8_convert($str, $type)
{
   static $conv = '';
   if (!is_array($conv))
   {
      $conv = array();
      for ($x=128; $x <= 143; $x++)
      {
         $conv['utf'][] = chr(209) . chr($x);
         $conv['win'][] = chr($x + 112);
      }
      for ($x=144; $x<= 191; $x++)
      {
         $conv['utf'][] = chr(208) . chr($x);
         $conv['win'][] = chr($x + 48);
      }
      $conv['utf'][] = chr(208) . chr(129);
      $conv['win'][] = chr(168);
      $conv['utf'][] = chr(209) . chr(145);
      $conv['win'][] = chr(184);
   }
   if ($type == 'w')
   {
      return str_replace($conv['utf'], $conv['win'], $str);
   }
   elseif ($type == 'u')
   {
      return str_replace($conv['win'], $conv['utf'], $str);
   }
   else
   {
      return $str;
   }
}


if ( isset( $_POST['sendMail'] ) ) {
  $admin  = substr( utf8_convert(@$_POST['admin'],'w'), 0, 64 );
  $name  = substr( utf8_convert(@$_POST['name'],'w'), 0, 64 );
  $email   = substr( utf8_convert(@$_POST['email'],'w'), 0, 64 );
  $subject = substr( utf8_convert(@$_POST['subject'],'w'), 0, 64 );
  $city = substr( utf8_convert(@$_POST['city'],'w'), 0, 64 );
  $message = substr( utf8_convert(@$_POST['message'],'w'), 0, 1000 );

  $error = '';
  if ( empty( $name ) ) $error = $error.'<li>Не заполнено поле "Имя"</li>';
 // if ( empty( $email ) ) $error = $error.'<li>Не заполнено поле "E-mail"</li>';
  if ( empty( $subject ) ) $error = $error.'<li>Не заполнено поле "Тема"</li>';
  if ( empty( $message ) ) $error = $error.'<li>Не заполнено поле "Сообщение"</li>';
  if ( !empty( $email ) and !preg_match( "#^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,6}$#i", $email ) )
    $error = $error.'<li>поле "E-mail" должно соответствовать формату somebody@somewhere.ru</li>';
  if ( !empty( $error ) ) {
    $_SESSION['sendMailForm']['error']   = '<p>При заполнении формы были допущены ошибки:</p><ul>'.$error.'</ul>';
    $_SESSION['sendMailForm']['name']    = $name;
    $_SESSION['sendMailForm']['email']   = $email;
    $_SESSION['sendMailForm']['subject'] = $subject;
    $_SESSION['sendMailForm']['city'] = $city;
    $_SESSION['sendMailForm']['message'] = $message;
    header( "Location: /error/");
    die();
  }

  $filepath = array();
  $filename = array();
  for( $i = 0; $i < count($_FILES['file']); $i++) {
    if ( !empty( $_FILES['file']['tmp_name'][$i] ) and $_FILES['file']['error'][$i] == 0 ) {
      $filepath[] = utf8_convert(@$_FILES['file']['tmp_name'][$i],'w');
      $filename[] = utf8_convert(@$_FILES['file']['name'][$i],'w');
    }
  }

  $body = "Ваше имя:\r\n".$name."\r\n\r\n";
  $body .= "Телефон:\r\n".$email."\r\n\r\n";
  $body .= "e-mail:\r\n".$subject."\r\n\r\n";
  $body .= "Район Города:\r\n".$city."\r\n\r\n";
  $body .= "Текст:\r\n".$message;

  if ( send_mail($admin, utf8_convert(@$body,'w'), $email, $filepath, utf8_convert(@$filename,'w')) )
    $_SESSION['success'] = true;
  else
    $_SESSION['success'] = false;
  /*header( 'Location: '.$_SERVER['PHP_SELF'] );*/
  header("Location: /send/");
  die();
}

// Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($admin, $body, $email, $filepath, $filename)
{
  $subject = utf8_convert('Заполнена форма на сайте','w');
  $boundary = "--".md5(uniqid(time())); // генерируем разделитель
  $headers = utf8_convert("From: ".strtoupper($_SERVER['SERVER_NAME'])." <".$email.">\r\n",'w');
  $headers .= "Return-path: <".$email.">\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
  $multipart = "--".$boundary."\r\n";
  $multipart .= "Content-type: text/plain; charset=\"windows-1251\"\r\n";
  $multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

  $body = utf8_convert(( $body )."\r\n\r\n",'w');

  $multipart .= $body;

  $file = '';
  $count = count( $filepath );
  if ( $count > 0 ) {
    for ( $i = 0; $i < $count; $i++ ) {
      $fp = fopen($filepath[$i], "r");
      if ( $fp ) {
        $content = fread($fp, filesize($filepath[$i]));
        fclose($fp);
        $file .= "--".$boundary."\r\n";
        $file .= "Content-Type: application/octet-stream\r\n";
        $file .= "Content-Transfer-Encoding: base64\r\n";
        $file .= "Content-Disposition: attachment; filename=\"".$filename[$i]."\"\r\n\r\n";
        $file .= chunk_split(base64_encode($content))."\r\n";
      }
    }
  }
  $multipart .= $file."--".$boundary."--\r\n";

  if( mail($admin, $subject, $multipart, $headers) )
    return true;

  else
    return false;
}

function quoted_printable_encode ( $string ) {
   // rule #2, #3 (leaves space and tab characters in tact)
   $string = preg_replace_callback (
   '/[^\x21-\x3C\x3E-\x7E\x09\x20]/',
   'quoted_printable_encode_character',
   $string
   );
   $newline = "=\r\n"; // '=' + CRLF (rule #4)
   // make sure the splitting of lines does not interfere with escaped characters
   // (chunk_split fails here)
   $string = preg_replace ( '/(.{73}[^=]{0,3})/', '$1'.$newline, $string);
   return $string;
}

function quoted_printable_encode_character ( $matches ) {
   $character = $matches[0];
   return sprintf ( '=%02x', ord ( $character ) );
}




?>