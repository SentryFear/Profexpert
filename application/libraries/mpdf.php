<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Админ
 * Date: 16.10.13
 * Time: 12:17
 * To change this template use File | Settings | File Templates.
 */

class Dompdf_gen {

    public function __construct() {

        require_once APPPATH.'third_party/MPDF57/mpdf.php';

        define('PRICE_DIR', $_SERVER['DOCUMENT_ROOT'].'/uploads/pdf/');

    }

    function generate($file_name, $content)
    {
        //Создаем объект класса mPDF
        $mpdf = new mPDF();
        //Записываем содержимое будущего PDF файла из HTML
        $mpdf->WriteHTML($content);
        //Сохраняем сам файл
        $mpdf->Output(PRICE_DIR.$file_name);
    }

}
require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';