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
        $result = "<table class='table table-hover'><thead><tr>";

        $g = 0;

        foreach ($source as $i) {

            $g++;

            $line = '';

            $self = '';

            if (isset($i['self'])) $self = $i['self'];

            if ($g > 1) $line = '<span class="line"></span>';

            $result .= "<th $self>" . $line . $i['name'] . "</th>";
        }

        $result .= "</tr></thead><tbody>";

        $n = 0;

        foreach ($data as $i) {

            $n++;

            $result .= "<tr>";

            foreach ($source as $q) {

                $tself = "";

                $val = isset($i[$q['value']]) ? $i[$q['value']] : $val = $q['value'];

                if (isset($q['date-format'])) $val = date($q['date-format'], $val);

                if ($val == 'loop.index') {

                    $val = "<a href='/request/edit/" . $i['id'] . "/'>#" . $i['id'] . "</a>";

                    if($extra['role_id'] == 4 && $i['ikp'] != 1) $val = "#" . $i['id'];
                }

                if ($q['value'] == 'fname') $val = '<span data-toggle="tooltip" data-original-title="Телефон:' . $i['phone'] . '  Email:' . $i['email'] . '">' . $i['fname'] . '</span>';

                if ($q['value'] == 'address') $val = '<span data-toggle="tooltip" data-original-title="' . $i['region'] . '">' . $i['address'] . '</span>';

                if ($val == 'vdocs') {

                    $exist = '<span class="label label-important" data-toggle="tooltip" data-original-title="Файлы ещё не загружены">[ 0 ]</span>';

                    $send = '';

                    $rework = '';

                    if (!empty($i['docs'])) {

                        $exist = '<span class="label label-success" data-toggle="tooltip" data-original-title="Колличество загруженых файлов. Нажмите чтобы Добавить или обновить файлы.">[ ' . count($i['docs']) . ' ]</span>';

                    }

                    $extra['id'] = $i['id'];

                    $extra['req'] = $i;

                    $send = req_get_status($extra['status'], $extra);

                    if(!empty($i['rework'])) $i['rework'] = unserialize($i['rework']);
                    else $i['rework'] = array();

                    if($extra['req']['ikp'] == 9) $rework = '<a href="/request/rework/' . $i['id'] . '" data-target="#upload" data-toggle="modal" class="upl" id="' . $i['id'] . '"><span class="label label-important" data-toggle="tooltip" data-original-title="Колличество комментариев.">[ ' . count($i['rework']) . ' ]</span></a>';

                    $val = '<a href="/request/add/' . $i['id'] . '" data-target="#upload" data-toggle="modal" class="upl" id="' . $i['id'] . '">' . $exist . '</a> ' . $send . ' ' . $rework;


                }

                if ($val == 'workers') {

                    $CI =& get_instance();

                    $CI->load->model('dx_auth/users_model', 'users_model');

                    $users = $CI->db->get('users')->result_array();

                    //$users = $CI->users_model->get_all()->result_array();

                    //$val = '<div class="ui-select" style="width: auto;"><select><option>Не выбрано</option>';

                    $val = '';

                    foreach ($users as $h) {

                        if ($h['role_id'] == 3) {

                            if ($h['id'] == $i['mid']) $val .= '<span class="label label-success" data-toggle="tooltip" data-original-title="Менеджер: ' . $h['name'] . '">' . $h['username'] . '</span> ';

                            //if($h['id'] == $i['mid']) $select = "selected"; else $select = '';
                            //
                            //$val .= "<option value='".$h['id']."' $select>".$h['username']."</option>";
                        }
                    }

                    if ($i['mid'] == 0) $val .= '<span class="label label-important" data-toggle="tooltip" data-original-title="Менеджер не выбран">Не выбран</span> ';

                    //$val .= "</select></div>";

                    //$val .= '<div class="ui-select" style="width: auto;"><select><option>Не выбрано</option>';

                    foreach ($users as $h) {

                        if ($h['role_id'] == 4) {

                            if ($h['id'] == $i['uid']) $val .= '<span class="label label-success" data-toggle="tooltip" data-original-title="Проектировщик: ' . $h['name'] . '">' . $h['username'] . '</span>';

                            //if($h['id'] == $i['uid']) $select = "selected"; else $select = '';
                            //
                            //$val .= "<option value='".$h['id']."' $select>".$h['username']."</option>";
                        }
                    }

                    if ($i['uid'] == 0) $val .= '<span class="label label-important" data-toggle="tooltip" data-original-title="Проектировщик не выбран">Не выбран</span> ';

                    //$val .= "</select></div>";

                    //$val = "In Dev";

                }

                if ($val == 'actions') {

                    $act = '';

                    if($extra['role_id'] != 4) $act = '<li><a href="/request/edit/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Изменить"><i class="table-edit"></i></a></li>';

                    if($extra['role_id'] == 2 || $extra['role_id'] == 6 || $extra['role_id'] == 3) $act .= '<li><a href="/request/review/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Печать"><i class="table-settings"></i></a></li>';

                    if($extra['role_id'] == 4 && ($i['ikp'] == 1 || $i['ikp'] == 11)) {

                        $act = '<li><a href="/request/edit/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Изменить"><i class="table-edit"></i></a></li>';

                        $act .= '<li class="last"><a href="/request/prints/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Печать"><i class="table-settings"></i></a></li>';
                    }

                    if($extra['role_id'] == 4 && $i['ikp'] > 1 && $i['ikp'] != 11) $act = '<li><a href="/request/prints/' . $i['id'] . '/" data-toggle="tooltip" data-original-title="Печать"><i class="table-settings"></i></a></li>';

                    if ($extra['is_admin']) $act .= '<li class="last"><a href="/request/delete/' . $i['id'] . '/" onClick="return confirm(\'Вы уверены что хотите удалить заявку?\')" data-toggle="tooltip" data-original-title="Удалить"><i class="table-delete"></i></a></li>';

                    //$val = '<div class="btn-group">'.$act.'</div>';
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
        else $result .= '<div class="form-actions"><div class="btn-group" style="float:left;"><input type="submit" class="btn btn-primary" name="add" value="Сохранить" /></div><div style="float: left; position: relative; height: 30px;">&nbsp;</div></div>';

        $totalrazd = '';

        $totalpr = 0;

        $totalsr = 0;

        $totalipr = 0;

        foreach ($source as $q) {

            $inp = '';

            $val = $q['value'];

            $self = '';

            if(isset($q['self'])) $self = $q['self'];

            $type = 'input';

            if ($allow == 'add' && isset($q['add']) && $q['add'] == 0) $val = null;

            if (!empty($data) && !empty($val) && !empty($data[$val])) $value = 'value="' . $data[$val] . '"'; else $value = "";

            if (isset($q['type'])) $type = $q['type'];

            if ($type == 'input') {

                $iclass = 'inline-input';

                if(isset($q['add-on'])) {

                    $inp .= '<div class="input-append">';

                    $iclass = 'input-large';

                }

                $inp .= '<input class="' . $iclass . '" type="text" id="' . $val . '" name="' . $val . '" placeholder="' . $q['name'] . '" ' . $value . '/>';

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
                }

            } elseif ($type == 'select') {

                if (!empty($value)) $value = $data[$val];

                $inp = '<div class="ui-select" style="width: auto;"><select name="' . $val . '">'; //{% for key,row in region %}<option value="{{ key }}">{{ row }}</option>{% endfor %}</select>';

                foreach ($extra[$val] as $k => $i) {

                    if ($k == $value) $selected = "selected"; else $selected = "";

                    $inp .= '<option value="' . $k . '" ' . $selected . '>' . $i . '</option>';
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

                    $inp = "<table class='table table-hover'><thead><tr><th>Раздел</th></tr></thead><tbody>";

                    $all = 0;

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

                            if(!empty($i['sname'])) $totalrazd .= " - ".$i['sname']." - ".$i['rname']."<br>";

                            $totalpr = $totalpr + $val2;

                            $val1 = $value[$i['name']]['hours'];

                            $totalsr = $totalsr + $val1;

                            if(!empty($value[$i['name']]['price'])) $val2 = $value[$i['name']]['price'];

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
                        }
                    }

                    //$inp .= '<tr><td><div class="input-prepend input-append"><span class="add-on">Всего</span><input id="all" name="all" class="span2" id="appendedPrependedInput" type="text" placeholder="Всего чел./час" value="'.$all.'"></div></td></tr>';

                    $inp .= "</tbody></table>";

                } elseif ($val == 'instance') {

                    if (!empty($value)) {

                        $value = unserialize($data[$val]);
                    }

                    $inp = '<table class="table table-hover"><tbody><tr><td><a href="javascript:void(0);" onclick="$(\'.razd\').toggle();">Показать/Скрыть не отмеченные</a></td></tr>';

                    $all = 0;

                    $view1 = 0;

                    foreach ($extra[$val] as $i) {

                        if (isset($i['ins'])) {

                            $view = 0;

                            foreach ($i['names'] as $r) {

                                if (isset($value[$r])) {

                                    $view = 1;

                                    $view1 = 1;
                                }
                            }

                            if ($view == 1 || $view1 == 0) {

                                $inp .= '<tr><th>' . $i['rname'] . '</th></tr>';

                            } else {

                                $inp .= '<tr class="razd" style="display:none;"><th>' . $i['rname'] . '</th></tr>';
                            }

                        } else {

                            $sel = "";

                            $val1 = $i['price'];

                            if (isset($value[$i['name']])) {

                                $sel = 'checked';

                                $val1 = $value[$i['name']]['price'];

                                //$val2 = $value[$i['name']]['price'];

                                $totalipr = $totalipr + $val1;

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

                            } elseif ($extra['user_info']['role_id'] != 6) {

                                $dnone = '';

                                if($view1 != 0) $dnone = 'style="display:none;"';

                                $inp .= '<tr class="razd" '.$dnone.'>
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
                }
            }

            if($val == 'kpname') $result .= '<br><h3>Генерация коммерческого предложения</h3><hr>
                            <div class="alert alert-info">
                                <b>Основаная информация:</b><br>
                                 - Адрес: <b>'.$data['address'].'</b><br>
                                 - Район: <b>'.$extra['region'][$data['region']].'</b><br>
                                 - Название проекта: <b>'.$data['name'].'</b><br>
                                 - Площадь объекта: <b>'.$data['footage'].'</b>м&sup2;<br><br>
                                <b>Разделы:</b><br>'.$totalrazd.'<br>
                                <b>Стоимость</b><br>
                                 - Получение документации: стоимость - <b>12 000</b> руб., срок - <b>12</b> д.<br>
                                 - Разработка проекта: стоимость - <b>'.number_format(($totalpr*2), '0', ',', ' ').'</b> руб., срок - <b>'.$data['atotal'].'</b> д.<br>
                                 - Согласование проекта: стоимость - <b>'.number_format(($totalipr*2), '0', ',', ' ').'</b> руб., срок - <b>60</b> д.
                            </div>';

            if($val == 'instance') $result .= "<br><h3>Согласование</h3><hr>";

            if($val == 'razd') $result .= "<br><h3>Проектный отдел</h3><hr>";

            if (!empty($val)) $result .= '<div class="control-group"><label class="control-label" for="' . $val . '">' . $q['name'] . '</label><div class="controls">' . $inp . '</div></div>';
        }

        if (empty($data)) $result .= '</div><div class="modal-footer"><div class="btn-group"><button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button><input type="submit" class="btn btn-primary" name="add" value="Добавить" /></div></div></form>';

        if (!empty($data)) $result .= '<div class="form-actions"><div class="btn-group"><input type="submit" class="btn btn-primary" name="add" value="Сохранить" style="margin-left: 403px;" /></div></div></form>';

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

            $i['docs'] = unserialize($i['docs']);

            $i['ikp'] = $i['kp'];

            $i['kp'] = $extra['kpstatus'][$i['kp']]['name'];

            $result[$i['id']] = $i;

            foreach ($query['cCard'] as $q) {

                if (!empty($q['region'])) $q['region'] = $extra['region'][$q['region']];

                if ($i['cid'] == $q['id']) $result[$i['id']] = array_merge($q, $result[$i['id']]);
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

                $data1 = explode(':', $q);

                if ($data1[1] == 'usr') $data1[1] = $extra['user_id'];

                if ($data1[0] == 'date') {

                    $data1[1] = time() -  $data1[1];

                    $del = '<';
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

        foreach ($status as $i) {

            $role = explode(',', $i['allow']);

            if (in_array($extra['role_id'], $role)) {

                $logic = explode(',', $i['logic']);

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

                        if (!empty($i['uri'])) $html_status .= '<a href="' . $i['uri'] . '' . $extra['id'] . '/" '.$self.' id="'.$extra['id'].'">';

                        $html_status .= '<span class="label label-' . $i['class'] . '" data-toggle="tooltip" data-original-title="' . $i['fullname'] . '">' . $i['name'] . '</span> ';

                        if (!empty($i['uri'])) $html_status .= '</a> ';
                    }
                }
            }
        }

        return $html_status;
    }

}


?>