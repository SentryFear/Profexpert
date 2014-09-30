<?php
/*
|--------------------------------------------------------------------------
| Формирование доступных полей
|--------------------------------------------------------------------------
|
| $source = array()
|   - Данные из конфига, для формирования таблицы уже готовые для показа
|
| $type = (string)
|   - Формировать таблицу или форму
|
| $extra = array
|   - Данные из базы
|
*/
if (!function_exists('req_perm_in_view')) {

    function req_perm_in_view($source = array(), $type = 'view', $extra)
    {
        $table = array();

        foreach ($source as $i) {

            $access = array();

            if (!isset($i[$type]) || $i[$type] != 0) {

                $access = explode(",", $i['allow']);

                if (in_array($extra['role_id'], $access)) $table[] = $i;
            }
        }

        return $table;
    }
}

/*
|--------------------------------------------------------------------------
| Генерация таблицы из массива с данными и конфига
|--------------------------------------------------------------------------
|
| $data = array()
|   - Данные из базы
|
| $source = array()
|   - Данные из конфига, для формирования таблицы уже готовые для показа
|
| $extra = array()
|   - Дополнительные данные
|
*/
if (!function_exists('req_arr_to_table')) {

    function req_arr_to_table($data, $source, $extra)
    {
        $result = "<table class='table table-hover' id='fhead'><thead style='background-color: white;'><tr>";

        //$pr = 0;

        //if($this->input->get('print')) $pr = 1;

        $g = 0;

        foreach ($source as $i) {

            $g++;

            $line = '';

            $self = '';

            $self1 = '';

            if (isset($i['self'])) $self = $i['self'];

            if (isset($i['self1'])) $self1 = $i['self1'];

            if ($g > 1) $line = '<span class="line"></span>';

            $result .= "<th $self>" . $line . "<span $self1>" . $i['name'] . "</span></th>";
        }

        $result .= "</tr></thead><tbody>";

        $n = 0;

        $CI =& get_instance();

        $CI->load->model('dx_auth/users_model', 'users_model');

        $users = $CI->db->get('users')->result_array();

        foreach ($data as $i) {

            $n++;

            $result .= "<tr data-scroll-index='" . $i['id'] . "' id='i" . $i['id'] . "'>";

            foreach ($source as $q) {

                $tself = "";

                $val = isset($i[$q['value']]) ? $i[$q['value']] : $val = $q['value'];

                if (isset($q['date-format'])) {



                    $tself = ' data-sort-value="'.$n.'"';

                    $val = '<span data-toggle="tooltip" data-original-title="'.date('d.m.y H:i:s', $val).'">'.date($q['date-format'], $val).'</span>';
                }

                if ($val == 'loop.index') {

                    $val = "<a href='/request/edit/" . $i['id'] . "/'>" . $i['id'] . "</a>";
                }

                if ($q['value'] == 'zname') {

                    $fio = '';

                    $telphone = '';

                    $emaile = '';

                    if(!empty($i['zsurname'])) $fio = $i['zsurname'];

                    if(!empty($i['zname'])) $fio .= ' '.$i['zname'];

                    if(!empty($i['zmname'])) $fio .= ' '.$i['zmname'];

                    if(!empty($i['phone'])) $telphone = '<br> <b><i>Телефон:</b></i> '.$i['phone'];

                    if(!empty($i['email'])) $emaile = '<br><b><i>Email:</b></i> '.$i['email'];

                    $val = '<a href="/card/view/'. $i['cid'] .'/" target="_blank"><span data-toggle="tooltip" data-original-title="' . $fio . ' ' . $telphone . ' ' . $emaile . '">' . $i['zname'] . '</span></a>';

                }

                if ($q['value'] == 'region') {

                    $val = '';

                    if(!empty($extra['region'][$i['region']])) $val = $extra['region'][$i['region']];
                    elseif(!empty($i['region'])) $val = $i['region'];

                }

                if ($q['value'] == 'address') {

                    $regionad = '';

                    if(!empty($extra['region'][$i['region']])) $regionad = 'Район: '.$extra['region'][$i['region']].'<br> ';
                    elseif(!empty($i['region'])) $regionad = 'Район: '.$i['region'];

                    if(!empty($i['city']) || !empty($i['street']) || !empty($i['building']) || !empty($i['buildingAdd']) || !empty($i['apartment'])) {

                        $street = (!empty($i['street'])) ? $i['street'] : '';

                        $building = (!empty($i['building'])) ? ', д.'.$i['building'] : '';

                        $buildingAdd = (!empty($i['buildingAdd'])) ? ', корп/лит.'.$i['buildingAdd'] : '';

                        $apartment = (!empty($i['apartment'])) ? ', кв/пом.'.$i['apartment'] : '';

                        $val = '<span data-toggle="tooltip" data-original-title="Город: '.$i['city'].'<br>'.$regionad.'<br>Улица: '.$i['street'].'<br>Дом: '.$i['building'].'<br>Корпус\Лит: '.$i['buildingAdd'].'<br>Квартира/Помещение: '.$i['apartment'].'">'.$street.''.$building.''.$buildingAdd.''.$apartment.'</span>';

                    } else {

                        $val = '<span data-toggle="tooltip" data-original-title="' . $regionad . 'Адрес: ' . $i['address'] . '">' . $i['address'] . '</span>';
                    }

                    //if(!empty($i['address'])) $val = '<span data-toggle="tooltip" data-original-title="' . $regionad . 'Адрес: ' . $i['address'] . '">' . $i['address'] . '</span>';
                    //else $val = '<span data-toggle="tooltip" data-original-title="Город: '.$i['city'].'<br>Улица: '.$i['street'].'<br>Дом: '.$i['building'].'<br>Корпус\Лит: '.$i['buildingAdd'].'<br>Квартира/Помещение: '.$i['apartment'].'">'.$i['street'].', д.'.$i['building'].', корп.'.$i['buildingAdd'].', кв.'.$i['apartment'].'</span>';
                }

                if ($val == 'vdocs') {

                    $doclabel = 'label-warning';

                    $tself = ' style="white-space: initial;"';

                    if (!empty($i['docs'])) {

                        $doclabel = 'label-success';

                    } else {

                        $i['docs'] = array();
                    }

                    $val = '<a href="/request/add/' . $i['id'] . '" data-target="#upload" data-toggle="modal" class="upl label '.$doclabel.'" data-toggle1="tooltip" data-original-title="Количество загруженых файлов. Нажмите чтобы Добавить или обновить файлы." id="' . $i['id'] . '">[ ' . count($i['docs']) . ' ]</a>';

                }

                if ($val == 'comments') {

                    if(!empty($i['more'])) $i['more'] = unserialize($i['more']);
                    else $i['more'] = array();

                    $worklabel = '';

                    if(count($i['more']) > 0) $worklabel = 'label-important';

                    $val = '<a href="/request/comments/' . $i['id'] . '" data-target="#upload" data-type-form="commentsform" data-toggle="modal" class="upl label '.$worklabel.'" data-toggle1="tooltip" data-original-title="Колличество комментариев" id="' . $i['id'] . '">[ ' . count($i['more']) . ' ]</a>';

                }

                if ($val == 'status') {

                    $extra['id'] = $i['id'];

                    $extra['req'] = $i;

                    $send = req_get_status($extra['status'], $extra);

                    $val = '<span id="ld' . $i['id'] . '">' . $send . '</span>';
                }

                if ($val == 'workers') {

                    $tself = ' style="white-space: nowrap;"';

                    $val = '';

                    foreach ($users as $h) {

                        if ($h['role_id'] == 3) {

                            if ($h['id'] == $i['mid']) $val .= '<span class="label label-success" data-toggle="tooltip" data-original-title="Менеджер: ' . $h['name'] . '">' . $h['username'] . '</span> ';

                        }
                    }

                    foreach ($users as $h) {

                        if ($h['role_id'] == 4) {

                            if ($h['id'] == $i['uid']) $val .= '<span class="label label-success" data-toggle="tooltip" data-original-title="Проектировщик: ' . $h['name'] . '">' . $h['username'] . '</span>';

                        }
                    }
                }

                if ($val == 'actions') {

                    $act = '';

                    $tself = ' style="white-space: nowrap;"';

                    if($extra['role_id'] != 4) $act = '<li><a href="/request/edit/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Изменить"><i class="table-edit"></i></a></li>';

                    if($extra['role_id'] == 2 || $extra['role_id'] == 6 || $extra['role_id'] == 3) {

                        $act .= '<li><a href="/request/review/' . $i['id'] . '/" target="_blank" data-toggle="tooltip" data-original-title="Печать"><i class="table-settings"></i></a></li>';

                        $act .= '<li><a href="/request/review/' . $i['id'] . '/1/" target="_blank" data-toggle="tooltip" data-original-title="Печать только КП"><i class="table-settings"></i></a></li>';
                    }

                    if($extra['role_id'] == 4 ) {

                        $act = '<li><a href="/request/edit/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Изменить"><i class="table-edit"></i></a></li>';

                        $act .= '<li class="last"><a href="/request/review/' . $i['id'] . '/2/" data-toggle="tooltip" data-original-title="Печать"><i class="table-settings"></i></a></li>';
                    }

                    if ($extra['is_admin']) $act .= '<li class="last"><a href="/request/delete/' . $i['id'] . '/" onClick="return confirm(\'Вы уверены что хотите удалить заявку?\')" data-toggle="tooltip" data-original-title="Удалить"><i class="table-delete"></i></a></li>';

                    $val = '<ul class="actions" style="float: left;">' . $act . '</ul>';
                }

                $result .= "<td$tself>$val</td>";
            }

            $result .= "</tr>";
        }

        $result .= "</tbody></table>";

        return $result;
    }
}

/*
|--------------------------------------------------------------------------
| Генерация формы из массива с данными и конфига
|--------------------------------------------------------------------------
|
| $source = array()
|   - Данные из конфига, для формирования таблицы уже готовые для показа
|
| $extra = array()
|   - Дополнительные данные
|
| $data = array()
|   - Данные из базы если есть
|
| $allow = string
|   - add или edit
|
*/
if (!function_exists('req_arr_to_form')) {

    function req_arr_to_form($source, $extra, $data = array(), $allow = 'add')
    {
        $result = '<style>ul{margin: 0;}</style>';

        if (empty($data)) $result .= '<div id="aNewReq" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="myModalLabel">Добавить заявку</h3></div>';

        $result .= '<form class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="off">';

        if (empty($data)) $result .= '<div class="modal-body">';
        else $result .= '<div class="form-actions"><div class="btn-group" style="float:left;"><input type="submit" class="btn btn-primary" name="add" value="Сохранить" /><a href="/request/review/' . $data['id'] . '/" target="_blank" class="btn btn-primary">Печать</a></div><div style="float: left; position: relative; height: 30px;">&nbsp;</div></div>';

        $totalrazd = array();

        $totalpr = 0;

        $totalsr = 0;

        $totalarrpr = array();

        $totalipr = 0;

        foreach ($source as $q) {

            $inp = '';

            $val = $q['value'];

            $self = '';

            if(isset($q['self'])) $self = $q['self'];

            $type = 'input';

            //if ($allow == 'add' && isset($q['add']) && $q['add'] == 0) $val = null;

            if (!empty($data) && !empty($val) && !empty($data[$val])) $value = 'value="' . $data[$val] . '"'; else $value = "";

            if (isset($q['type'])) $type = $q['type'];

            if ($type == 'input') {

                $iclass = 'inline-input';

                if(isset($q['add-on'])) {

                    $inp .= '<div class="input-append">';

                    $iclass = 'input-large';

                }

                $inp .= '<input class="' . $iclass . ' autocomp" type="text" data-tbl="request" data-tpol="' . $val . '" id="' . $val . '" name="' . $val . '" placeholder="' . $q['name'] . '" ' . $value . '/>';

                if(isset($q['add-on'])) $inp .= '<span class="add-on">' . $q['add-on'] . '</span></div>';

                if($val == 'traspr') {

                    $inp = '<table width="100%" class="table table-hover addr"><thead><tr><th>№</th><th><span class="line"></span>Наименование</th><th><span class="line"></span>Стоимость работ<br>(руб.)</th><th><span class="line"></span>Сроки<br>исполнения<br>(раб. день)</th></tr></thead><tbody>';

                    if(!empty($data[$val])) $value = unserialize($data[$val]);

                    if(empty($value)) $value = array();

                    foreach($value as $i) {

                        $inp .= '<tr><td>'.$i['id'].'</td>';

                        $inp .= '<td><textarea class="span6 wysihtml5" rows="5" id="' . $val . 'name' .$i['id']. '" name="' . $val . 'name' .$i['id']. '" placeholder="Наименование">' . $i['name'] . '</textarea></td>';

                        $inp .= '<td><input class="inline-input" type="text" id="' . $val . 'pr' .$i['id']. '" name="' . $val . 'pr' .$i['id']. '" placeholder="Стоимость работ" value="' . $i['price'] . '"/></td>';

                        $inp .= '<td><input class="inline-input" type="text" id="' . $val . 'sr' .$i['id']. '" name="' . $val . 'sr' .$i['id']. '" placeholder="Сроки исполнения" value="' . $i['srok'] . '"/></td></tr>';

                    }

                    $inp .= '</tbody></table><div class="addstr" data-count="'.(count($value)+1).'"></div>';

                    $inp .= '<br><br><p><a href="javascript:void();" class="btn btn-success btn-mini" id="addstr1">Добавить строку</a></p>';

                } elseif($val == 'address') {

                    $inp = '';

                    if(!empty($data['address'])) $inp .= $data['address']."<br>";

                    $city = (isset($data['city'])) ? $data['city'] : "";

                    $region = "";

                    if(!empty($data['region'])) {

                        if(is_numeric($data['region'])) $region = $extra['region'][$data['region']];
                        else $region = $data['region'];

                    }

                    $street = (isset($data['street'])) ? $data['street'] : "";
                    $building = (isset($data['building'])) ? $data['building'] : "";
                    $buildingAdd = (isset($data['buildingAdd'])) ? $data['buildingAdd'] : "";
                    $apartment = (isset($data['apartment'])) ? $data['apartment'] : "";

                    $inp .= '<input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="city" id="city" name="city" placeholder="Город" value="' . $city . '"><br>
                            <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="region" id="region" name="region" placeholder="Район" value="' . $region . '"><br>
                            <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="street" id="street" name="street" placeholder="Улица" value="' . $street . '"><br>
                            <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="building" id="building" name="building" placeholder="Дом" value="' . $building . '"><br>
                            <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="buildingAdd" id="buildingAdd" name="buildingAdd" placeholder="корп/лит." value="' . $buildingAdd . '"><br>
                            <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="request5projects" data-tpol="apartment" id="apartment" name="apartment" placeholder="кв/пом." value="' . $apartment . '">';
                }

            } elseif ($type == 'select') {

                if (!empty($value)) $value = $data[$val];

                if (!empty($q['self'])) $self = $q['self'];

                $inp = '<div class="ui-select" style="width: auto;"><select name="' . $val . '" '.$self.'>';

                foreach ($extra[$val] as $k => $i) {

                    if ($k == $value) $selected = "selected"; else $selected = "";

                    if($val == 'cid') {

                        $sn = (!empty($i['zsurname'])) ? $i['zsurname'] : '';

                        $n = (!empty($i['zname'])) ? $i['zname'] : '';

                        $none = (!empty($i['none'])) ? $i['none'] : '';

                        $mn = (!empty($i['zmname'])) ? $i['zmname'] : '';

                        $org = (!empty($i['organization'])) ? $i['organization'] : '';

                        $phone = (!empty($i['phone'])) ? $i['phone'] : '';

                        $email = (!empty($i['email'])) ? $i['email'] : '';

                        $hear = (!empty($i['hear'])) ? $i['hear'] : '';

                        if(empty($sn) && empty($n) && empty($mn)) $sn = $email;

                        if(empty($sn)) $sn = $org;

                        $inp .= '<option value="' . $k . '" data-sn="'.$sn.'" data-n="'.$n.'" data-mn="'.$mn.'" data-org="'.$org.'" data-phone="'.$phone.'" data-email="'.$email.'" data-hear="'.$hear.'"  ' . $selected . '>'.$sn.' '.$n.' '.$mn .''.$none.'</option>';

                    } else $inp .= '<option value="' . $k . '" ' . $selected . '>' . $i . '</option>';

                }

                $inp .= '</select></div>';

            } elseif ($type == 'textarea') {

                if (!empty($value)) $value = $data[$val];

                $inp = '<textarea '.$self.' placeholder="' . $q['name'] . '" name="' . $val . '" id="' . $val . '">' . $value . '</textarea>';

            } elseif ($type == 'checkbox') {

                $inp = '<input type="checkbox" id="' . $val . '" name="' . $val . '" value="1"/>';

                if ($val == 'razd') {

                    if (!empty($value)) {

                        $value = unserialize($data[$val]);
                    }

                    $inp = '<table class="table table-hover razds"><thead><tr><th>Раздел</th></tr></thead><tbody>';

                    $all = 0;

                    $clrz = "var rzd = {};\n";

                    foreach ($extra[$val] as $i) {

                        $sel = "";

                        $val1 = "";

                        if (isset($data['footage'])) {

                            $data['footage'] = str_replace(",",".",$data['footage']);

                            $val2 = $i['price'] * $data['footage'];

                        } else $val2 = $i['price'];

                        $plhold = $i['rname'];

                        if(!empty($i['sname'])) $plhold = $i['sname'];

                        if (isset($value[$i['name']])) {

                            $sel = 'checked';

                            $totalpr = $totalpr + $val2;

                            $val1 = $value[$i['name']]['hours'];

                            $totalsr = $totalsr + $val1;

                            if(!empty($value[$i['name']]['price'])) $val2 = $value[$i['name']]['price'];

                            if(!empty($i['sname'])) $totalrazd[] = array('sname' => $i['sname'], 'rname' => $i['rname'], 'srok' => $val1, 'price' => $val2);

                            $all += $val1;

                            $inp .= '<tr>
                                        <td>
                                            <div class="input-prepend input-append">
                                            <span class="add-on" style="line-height: 17px;">
                                                <input type="checkbox" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                            </span>';

                            if ($extra['user_info']['role_id'] != 4) $inp .= '<input id="' . $i['name'] . '" name="' . $i['name'] . 'pr" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $plhold . ' рублей" value="' . $val2 . '">';

                            $inp .= '<input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $plhold . '" value="' . $val1 . '">
                                            <span class="add-on"> чел./час. ' . $i['rname'] . '</span>
                                            </div>
                                        </td>
                                     </tr>';

                            $clrz .= "rzd.".$i['name']." = '".$val1."';\n";

                        } elseif ($extra['user_info']['role_id'] != 6 && $extra['user_info']['role_id'] != 3 && $extra['user_info']['role_id'] != 2 ) {

                            $inp .= '<tr>
                                        <td>
                                        <div class="input-prepend input-append">
                                            <span class="add-on" style="line-height: 17px;">
                                            <input type="checkbox" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                            </span>';

                            if ($extra['user_info']['role_id'] != 4) $inp .= '<input id="' . $i['name'] . '" name="' . $i['name'] . 'pr" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $plhold . ' рублей" value="' . $val2 . '">';

                            $inp .= '<input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $plhold . '" value="' . $val1 . '">
                                            <span class="add-on"> чел./час. ' . $i['rname'] . '</span>
                                        </div>
                                        </td>
                                    </tr>';

                            $clrz .= "rzd.".$i['name']." = '".$val1."';\n";
                        }
                    }

                    //$inp .= '<tr><td><div class="input-prepend input-append"><span class="add-on">Всего</span><input id="all" name="all" class="span2" id="appendedPrependedInput" type="text" placeholder="Всего чел./час" value="'.$all.'"></div></td></tr>';

                    $inp .= "</tbody></table>";

                    $inp .= "<script>".$clrz."</script>";

                } elseif ($val == 'instance') {

                    if (!empty($value)) {

                        $value = unserialize($data[$val]);
                    }

                    $inp = '<table class="table table-hover insta"><tbody><tr><td><a href="javascript:void(0);" onclick="$(\'.razd\').toggle();">Показать/Скрыть не отмеченные</a></td></tr>';

                    $all = 0;

                    foreach ($extra[$val] as $i) {

                        if (isset($i['ins'])) {

                            $view = 0;

                            $dnon = '';

                            foreach ($i['names'] as $r) {

                                if (isset($value[$r])) {

                                    $view = 1;
                                }
                            }

                            if ($view == 0) $dnon = 'class="razd" style="display:none;"';

                            $inp .= '<tr '.$dnon.'><th>' . $i['rname'] . '</th></tr>';

                            $ins = array('id' => $i['rname'], 'name' => $i['rname']);



                        } else {

                            $sel = "";

                            $val1 = $i['price'];

                            if (isset($value[$i['name']])) {

                                $sel = 'checked';

                                $val1 = $value[$i['name']]['price'];

                                $totalipr = $totalipr + $val1;

                                if(empty($totalarrpr[$ins['id']])) $totalarrpr[$ins['id']] = array('name' => $ins['name'], 'price' => '0', 'inins' => array());

                                $totalarrpr[$ins['id']]['inins'][] = array('name' => $i['rname'], 'price' => $val1);

                                $all += $val1;

                                $inp .= '<tr>
                                            <td>
                                            <div class="input-prepend input-append">
                                                <span class="add-on" style="line-height: 17px;">
                                                <input type="checkbox" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                                </span>
                                                <input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . ' руб." value="' . $val1 . '">
                                                <span class="add-on">руб. ' . $i['rname'] . '</span>
                                            </div>
                                            </td>
                                        </tr>';

                            } else {

                                //$dnone = '';

                                //if($view == 0) $dnone = '';

                                $inp .= '<tr class="razd" style="display:none;">
                                            <td>
                                            <div class="input-prepend input-append">
                                                <span class="add-on" style="line-height: 17px;">
                                                <input type="checkbox" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                                </span>
                                                <input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . ' руб." value="' . $val1 . '">
                                                <span class="add-on">руб. ' . $i['rname'] . '</span>
                                            </div>
                                            </td>
                                        </tr>';
                            }
                        }
                    }

                    //$inp .= '<tr><td><div class="input-prepend input-append"><span class="add-on">Всего</span><input id="all" name="all" class="span2" id="appendedPrependedInput" type="text" placeholder="Всего чел./час" value="'.$all.'"></div></td></tr>';

                    $inp .= "</tbody></table>";

                } elseif ($val == 'worktype') {

                    if (!empty($value)) {

                        $value = unserialize($data[$val]);
                    }

                    $inp = '<table class="table table-hover worktype"><tbody><tr><td><a href="javascript:void(0);" onclick="$(\'.worktype1\').toggle();">Показать/Скрыть не отмеченные</a></td></tr>';

                    $all = 0;

                    $st = '';

                    foreach ($extra[$val] as $i) {

                        $sel = "";

                        $sel1 = "";

                        //$st = 'style="display:none;"';

                        $st = '';

                        if (isset($value[$i['name']])) {

                            $sel1 = 'checked';

                            $st = '';
                        }

                        $inp .= '<tr class="worktype1" '.$st.'><td>';

                        $inp .= '   <div class="input-prepend input-append">
                                        <span class="add-on" style="line-height: 17px;">
                                            <input type="checkbox" onclick="$(\'.'.$i['name'].'\').toggle();" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;" ' . $sel1 . '/>
                                        </span>
                                        <span class="add-on">' . $i['rname'] . '</span>
                                    </div>';

                        $st = 'style="display:none;"';

                        if(isset($i['names'])) {

                            foreach($i['names'] as $w) {

                                $sel2 = "";

                                if (isset($value[$w['name']])) {

                                    $sel2 = 'checked';

                                    $st = '';
                                }

                                if($sel1 == 'checked') $st = '';

                                $inp .= '   <div class="'.$i['name'].'" '.$st.'><div class="input-prepend input-append" style="margin-left: 32px;">
                                                <span class="add-on" style="line-height: 17px;">
                                                    <input type="checkbox" onclick="$(\'.'.$w['name'].'\').toggle();" id="' . $w['name'] . 'ch" name="' . $w['name'] . 'ch" value="1" style="margin: 0;" ' . $sel2 . '/>
                                                </span>
                                                <span class="add-on">' . $w['rname'] . '</span>
                                            </div></div>';

                                $st = 'style="display:none;"';

                                if(isset($w['names'])) {

                                    foreach($w['names'] as $e) {

                                        $sel = "";

                                        $vl = '';

                                        if (isset($value[$e['name']])) {

                                            $vl = $value[$e['name']]['value'];

                                            $sel = 'checked';

                                            $st = '';
                                        }

                                        if($sel2 == 'checked') $st = '';

                                        $workinp = '';

                                        if($e['type'] == 'date') $workinp = '<input id="' . $e['name'] . '" name="' . $e['name'] . '" class="span2 datepicker" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $e['rname'] . '" value="'.$vl.'">';

                                        $inp .= '   <div class="'.$w['name'].'" '.$st.'><div class="input-prepend input-append"  style="margin-left: 64px;">
                                                    <span class="add-on" style="line-height: 17px;">
                                                        <input type="checkbox" onclick="$(\'.'.$e['name'].'\').toggle();" id="' . $e['name'] . 'ch" name="' . $e['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                                    </span>
                                                    '.$workinp.'
                                                    <span class="add-on">' . $e['rname'] . '</span>
                                                </div></div>';

                                        $st = 'style="display:none;"';

                                        if(isset($e['names'])) {

                                            foreach($e['names'] as $r) {

                                                $sel = "";

                                                $vl = '';

                                                if (isset($value[$r['name']])) {

                                                    $vl = $value[$r['name']]['value'];

                                                    $sel = 'checked';

                                                    $st = '';
                                                }

                                                $workinp = '';

                                                if($r['type'] == 'date') $workinp = '<input id="' . $r['name'] . '" name="' . $r['name'] . '" class="span2 datepicker" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $r['rname'] . '" value="'.$vl.'">';

                                                $inp .= '   <div class="'.$e['name'].'" '.$st.'><div class="input-prepend input-append"  style="margin-left: 96px;">
                                                    <span class="add-on" style="line-height: 17px;">
                                                        <input type="checkbox" id="' . $r['name'] . 'ch" name="' . $r['name'] . 'ch" value="1" style="margin: 0;" ' . $sel . '/>
                                                    </span>
                                                    '.$workinp.'
                                                    <span class="add-on">' . $r['rname'] . '</span>
                                                </div></div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $inp .= '</td></tr>';
                    }

                    //$inp .= '<tr><td><div class="input-prepend input-append"><span class="add-on">Всего</span><input id="all" name="all" class="span2" id="appendedPrependedInput" type="text" placeholder="Всего чел./час" value="'.$all.'"></div></td></tr>';

                    $inp .= "</tbody></table>";
                }
            }

            if($val == 'kpname') {

                $arrtext = '';

                $ttarrpr = 0;

                foreach($totalarrpr as $arrpr) {

                    $arrnames = '';

                    foreach($arrpr['inins'] as $arrtpr) {

                        $ttarrpr += $arrtpr['price'];

                        $arrpr['price'] += $arrtpr['price'];

                        $arrnames .= '- '.$arrtpr['name'].'<br>';
                    }

                    $arrtext .= '<tr><td><span data-toggle="tooltip" data-original-title="'.$arrnames.'">'.$arrpr['name'].'</span></td><td>0 д.</td><td>'.number_format($arrpr['price'], '0', ',', ' ').' руб.</td><td>'.number_format($arrpr['price']/0.5, '0', ',', ' ').' руб.</td></tr>';
                }

                $arrtext .= '<tr><td style="text-align: right;"><b>Итого:</b></td><td><b>60</b> д.</td><td><b>'.number_format($ttarrpr, '0', ',', ' ').'</b>  руб.</td><td><b>'.number_format($ttarrpr/0.5, '0', ',', ' ').'</b>  руб.</td></tr>';

                $ttrazdtext = '';

                $ttrazdsr = 0;

                $ttrazdpr = 0;

                foreach($totalrazd as $ttrazd) {

                    $ttrazdsr += $ttrazd['srok'];

                    $ttrazdpr += $ttrazd['price'];

                    $ttrdr = number_format($ttrazd['price'], '0', ',', ' ');

                    $ttrdr2 = number_format($ttrazd['price']/0.8, '0', ',', ' ');

                    $ttrazdtext .= '<tr><td>'.$ttrazd['sname'].' - '.$ttrazd['rname'].'</td><td>'.$ttrazd['srok'].' чел./час.</td><td>'.$ttrdr.' руб.</td><td>'.$ttrdr2.' руб.</td></tr>';
                }

                $ttrazdtext .= '<tr><td style="text-align: right;"><b>Итого:</b></td><td><b>'.$data['atotal'].'</b> д.</td><td><b>'.number_format($ttrazdpr, '0', ',', ' ').'</b>  руб.</td><td><b>'.number_format($ttrazdpr/0.8, '0', ',', ' ').'</b>  руб.</td></tr>';

                $rne = '';

                if(!empty($data['region'])) {

                    if(is_numeric($data['region'])) $rne = $extra['region'][$data['region']];
                    else $rne = $data['region'];

                }

                $result .= '<br><h3>Генерация коммерческого предложения</h3><hr>
                            <div class="row-fluid">
                            <div class="alert alert-info">
                                <div class="row-fluid">
                                    <div class="span3">
                                        <b>Основаная информация:</b><br>
                                         - Адрес: <b>'.$data['city'].', '.$data['region'].', '.$data['street'].', '.$data['building'].', '.$data['buildingAdd'].', '.$data['apartment'].' </b><br>
                                         - Район: <b>'.$rne.'</b><br>
                                         - Название проекта: <b>'.$data['name'].'</b><br>
                                         - Площадь объекта: <b>'.$data['footage'].'</b>м&sup2;<br><br>
                                    </div>
                                    <div class="span9">
                                        <b>Примечание:</b><br>
                                        Стоимость разработки проектной документации может измениться, если здание находится под охраной КГИОП.<br>
                                        Итоговая стоимость работ может измениться после получения подробного технического задания от Заказчика.<br>
                                        Платежи за выдачу технической документации и согласование проектной документации, предусмотренные государственными инстанциями, оплачиваются Заказчиком отдельно по предъявляемым квитанциям.<br>
                                        Стоимость работ по: вводу объекта в эксплуатацию после перепланировки; получению технического паспорта на образованный в результате перепланировки объект; получению дополнительной мощности и оформлению электропотребления, осмечиваются отдельно и составляют 70-80% от данного коммерческого предложения.<br>
                                        Обращаем Ваше внимание, что в соответствии с п. 1 ст. 28 Жилищного Кодекса Российской Федерации завершение переустройства и (или) перепланировки жилого помещения подтверждается актом приемочной комиссии. После выполнения работ в установленные сроки необходимо предоставить к приемке жилое помещение при наличии необходимых документов.<br><br>
                                        Цены по коммерческому предложению действительны в течение месяца.<br><br>
                                        Стоимость работ по вводу объекта в эксплуатацию после перепланировки действительна при полном соответствии выполненных ремонтно-строительных работ согласованному МВК проекту. Урегулирование вопросов несоответствия проекту выполненных ремонтно-строительных работ, оговаривается отдельно.
Платежи за выдачу технической документации и согласование проектной документации, предусмотренные государственными инстанциями, оплачиваются Заказчиком отдельно по предъявляемым квитанциям.<br><br>
                                        В случае необходимости предоставления экспертизы проекта - данная услуга выполняется организацией-партнёром, оплачивается отдельно и составляет от 15 000р. до 20 000 р., либо предоставляется Заказчиком.
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <b><a href="javascript:void(0);" onclick="$(\'.rrp\').toggle(); return false;">Разработка проекта</a></b><br>
                                        <table class="table table-hover hide rrp">
                                            <tr>
                                               <th class="span8">Наименование</th>
                                               <th class="span1">Срок</th>
                                               <th class="span1">Стоимость</th>
                                               <th class="span1">С наценкой</th>
                                            </tr>
                                            '.$ttrazdtext.'
                                        </table>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <b><a href="javascript:void(0);" onclick="$(\'.sgp\').toggle(); return false;">Согласование проекта</a></b><br>
                                        <table class="table table-hover hide sgp">
                                             <tr>
                                                <th class="span8">Наименование</th>
                                                <th class="span1">Срок</th>
                                                <th class="span1">Стоимость</th>
                                                <th class="span1">С наценкой</th>
                                             </tr>
                                             '.$arrtext.'
                                        </table>
                                    </div>
                                </div>

                            </div></div>';
            }

            if($val == 'instance') $result .= '<br><a href="#" onclick="$(\'.insta\').toggle(); return false;"><h3>Согласование <i class="icon-chevron-down"></i></h3></a><hr>';

            if($val == 'razd') $result .= '<br><a href="#" onclick="$(\'.razds\').toggle(); return false;"><h3>Проектный отдел <i class="icon-chevron-down"></i></h3></a><hr>';

            if (!empty($val)) $result .= '<div class="control-group"><label class="control-label" for="' . $val . '">' . $q['name'] . '</label><div class="controls">' . $inp . '</div></div>';
        }

        if (empty($data)) $result .= '</div><div class="modal-footer"><div class="btn-group"><button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button><input type="submit" class="btn btn-primary" name="add" value="Добавить" /></div></div></form>';

        if (!empty($data)) $result .= '<div class="form-actions"><div class="btn-group"><input type="submit" class="btn btn-primary" name="add" value="Сохранить" style="margin-left: 403px;" /><a href="/request/review/' . $data['id'] . '/" target="_blank" class="btn btn-primary">Печать</a></div></div></form>';

        if (empty($data)) $result .= '</div>';

        return $result;
    }

}

/*
|--------------------------------------------------------------------------
| Сбор данных с базы
|--------------------------------------------------------------------------
|
| $query = array()
|   - Данные из базы
|
| $extra = array()
|   - Дополнительные данные
|
*/
if (!function_exists('req_parse_data')) {

    function req_parse_data($query, $extra)
    {
        $result = array();

        foreach ($query['request'] as $i) {

            $i = array_diff_key($i, array(''));

            $i['docs'] = unserialize($i['docs']);

            $i['ikp'] = $i['kp'];

            $i['kp'] = $extra['kpstatus'][$i['kp']]['name'];

            $result[$i['id']] = $i;

            /*$q = $query['card'][$i['cid']];

            if (!empty($q['region'])) $q['region'] = $extra['region'][$q['region']];

            if ($i['cid'] == $q['id']) $result[$i['id']] = array_merge($q, $result[$i['id']]);*/

            foreach ($query['card'] as $q) {

                if ($i['cid'] == $q['id']) {

                    if (!empty($q['region'])) $q['region'] = $extra['region'][$q['region']];

                    $result[$i['id']] = array_merge($q, $result[$i['id']]);

                    break;
                }
            }
        }

        return $result;
    }

}

/*
|--------------------------------------------------------------------------
| Сортировка 
|--------------------------------------------------------------------------
|
| $sort = array()
|   - Конфигуратор сортировки
|
| $extra = array()
|   - Дополнительные данные
|
*/
if (!function_exists('req_parse_sort')) {

    function req_parse_sort($sort, $extra)
    {
        $sort = explode(',', $sort['logic']);

        $data = '';

        $quer1 = '';

        $s = 0;

        foreach ($sort as $i) {

            $s++;

            $ext1 = '';

            if ($s <= count($sort) - 1) $ext1 = ' OR ';

            $data = explode('?', $i);

            $data1 = '';

            $quer = '';

            $n = 0;

            foreach ($data as $q) {

                $n++;

                $del = '=';

                $ext = '';

                if ($n <= count($data) - 1) $ext = ' AND ';

                if(strpos($q, '>') !== false) $del = '>';
                elseif(strpos($q, '<') !== false) $del = '<';
                elseif(strpos($q, ':') !== false) $del = ':';
                elseif(strpos($q, '!') !== false) $del = '!';

                $data1 = explode($del, $q);

                if(strpos($q, ':') !== false) $del = '=';
                elseif(strpos($q, '!') !== false) $del = '!=';

                if ($data1[1] == 'usr') $data1[1] = $extra['user_id'];

                if ($data1[0] == 'date') {

                    $data1[1] = time() -  $data1[1];
                }

                $quer .= $data1[0] . ' '.$del.' ' . $data1[1] . $ext;
            }

            $quer1 .= $quer . $ext1;
        }

        return $quer1;
    }

}

/*
|--------------------------------------------------------------------------
| Статусы 
|--------------------------------------------------------------------------
|
| $status = array()
|   - Конфигуратор сортировки
|
| $extra = array()
|   - Дополнительные данные
|
*/
if (!function_exists('req_get_status')) {

    function req_get_status($status, $extra)
    {
        $html_status = '';

        //Берём по одному элементу из конфига
        foreach ($status as $i) {

            //Распаковываем роли которым доступен этот статус
            $role = explode(',', $i['allow']);

            //Проверяем подходит ли роль пользователя под разрешённые
            if (in_array($extra['role_id'], $role)) {

                //Распаковывем логику
                $logic = explode(',', $i['logic']);

                //
                foreach ($logic as $l) {

                    $data = explode('?', $l);

                    $data1 = array();

                    $accept = 0;

                    $self = '';

                    foreach ($data as $k => $q) {

                        $data1[$k] = explode(':', $q);

                        if ($data1[$k][1] == 'usr') $data1[$k][1] = $extra['user_id'];
                    }

                    foreach ($data1 as $g) {

                        if ($extra['req'][$g[0]] == $g[1]) {

                            $accept++;
                        }
                    }

                    if ($accept == count($data1)) {

                        if (!empty($i['self'])) $self = $i['self'];

                        if (!empty($i['uri'])) $html_status .= '<a href="' . $i['uri'] . '' . $extra['id'] . '/" '.$self.' id="'.$extra['id'].'"  data-ind="' . $extra['id'] . '" data-loading-text="loading..." class="label label-' . $i['class'] . ' fat-btn"  data-toggle="tooltip" data-original-title="' . $i['fullname'] . '">' . $i['name'] . '</a>&nbsp;';

                        if (empty($i['uri'])) $html_status .= '<span class="label label-' . $i['class'] . '" data-toggle="tooltip" data-original-title="' . $i['fullname'] . '">' . $i['name'] . '</span>&nbsp;';

                        //if (!empty($i['uri'])) $html_status .= '</a> ';
                    }
                }
            }
        }
//<div id="ld' . $i['id'] . '"><a href="/request/send/test/' . $i['id'] . '" data-ind="' . $i['id'] . '" data-loading-text="loading..." class="label label-important fat-btn">Loading state</a></div>
        return $html_status;
    }

}

/*
|--------------------------------------------------------------------------
| Получение статистики
|--------------------------------------------------------------------------
|
| $request = array()
|   - Массив заявок
|
*/
if (!function_exists('req_get_stats')) {

    function req_get_stats($request)
    {
        $time = mktime(0, 0, 0, date("n"), 1, date("Y"));

        $result = array(
                        '0' => array('request' => 0, 'contract' => 0, 'month' => ''),
                        '1' => array('request' => 0, 'contract' => 0, 'month' => ''),
                        '2' => array('request' => 0, 'contract' => 0, 'month' => ''),
                        '3' => array('request' => 0, 'contract' => 0, 'month' => ''),
                        '4' => array('request' => 0, 'contract' => 0, 'month' => ''),
                        'month' => array('request' => 0, 'contract' => 0),
                        'total' => array('request' => 0, 'contract' => 0)
        );

        $month = array(
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь'
        );

        foreach($request as $i) {

            $result['total']['request']++;

            if($i['ikp'] == 13) {

                $result['total']['contract']++;
            }

            $lm1 = strtotime("-4 month", $time);

            $reslm1 = mktime(0, 0, 0, date("m", $lm1), 1, date("Y", $lm1));

            $result['1']['month'] = $month[date("m", $lm1)]." ".date("Y", $lm1);

            if($i['date'] < $reslm1) {

                $result['0']['request']++;

                if($i['ikp'] == 13) {

                    $result['0']['contract']++;
                }
            }

            $lm2 = strtotime("-3 month", $time);

            $reslm2 = mktime(0, 0, 0, date("m", $lm2), 1, date("Y", $lm2));

            $result['2']['month'] = $month[date("m", $lm2)]." ".date("Y", $lm2);

            if($i['date'] < $reslm2 && $i['date'] > $reslm1) {

                $result['1']['request']++;

                if($i['ikp'] == 13) {

                    $result['1']['contract']++;
                }
            }

            $lm3 = strtotime("-2 month", $time);

            $reslm3 = mktime(0, 0, 0, date("m", $lm3), 1, date("Y", $lm3));

            $result['3']['month'] = $month[date("m", $lm3)]." ".date("Y", $lm3);

            if($i['date'] < $reslm3 && $i['date'] > $reslm2) {

                $result['2']['request']++;

                if($i['ikp'] == 13) {

                    $result['2']['contract']++;
                }
            }

            $lm4 = strtotime("-1 month", $time);

            $reslm4 = mktime(0, 0, 0, date("m", $lm4), 1, date("Y", $lm4));

            $result['4']['month'] = $month[date("m", $lm4)]." ".date("Y", $lm4);

            if($i['date'] < $reslm4 && $i['date'] > $reslm3) {

                $result['3']['request']++;

                if($i['ikp'] == 13) {

                    $result['3']['contract']++;
                }
            }

            $lm5 = time();

            $reslm5 = mktime(0, 0, 0, date("m", $lm5), 1, date("Y", $lm5));

            if($i['date'] < $reslm5 && $i['date'] > $reslm4) {

                $result['4']['request']++;

                if($i['ikp'] == 13) {

                    $result['4']['contract']++;
                }
            }

            if($i['date'] < time() && $i['date'] > time() - 2592000) {

                $result['month']['request']++;

                if($i['ikp'] == 13) {

                    $result['month']['contract']++;
                }
            }

        }

        return $result;
    }
}
?>