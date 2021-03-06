<?php
if (!function_exists('projects_work_type')) {

    function projects_work_type($source = array(), &$result, $c = 0, $old = '')
    {
        foreach($source as $i) {

            if($c == 0) $result .= '<tr class="worktype1"><td><div class="'.$old.'">';

            if($c > 0) $result .= '<div class="'.$old.'" style="display:none;">';

            $workinp = '';

            if($i['type'] == 'date') $workinp = '<input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2 datepicker" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . '" value="">';

            $result .= '<div class="input-prepend input-append" style="margin-left: '.($c*32).'px;">
                                        <span class="add-on" style="line-height: 17px;">
                                            <input type="checkbox" onclick="$(\'.'.$i['name'].'\').toggle();" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" value="1" style="margin: 0;"/>
                                        </span>
                                        '.$workinp.'
                                        <span class="add-on">' . $i['rname'] . '</span>
                                    </div>';



            if(isset($i['names'])) {

                projects_work_type($i['names'], $result, $c+1, $i['name']);
            }

            if($c == 0) $result .= '</div></td></tr>';

            if($c > 0) $result .= '</div>';
        }

        return $result;
    }
}

if (!function_exists('projects_work_type_pr')) {

    function projects_work_type_pr($source = array(), &$result)
    {
        foreach($source as $i) {

            if(!empty($_POST[$i['name'].'ch']) || !empty($_POST[$i['name'].'note']) || !empty($_POST[$i['name'].'ord']) || !empty($_POST[$i['name'].'cdate'])) {

                $value = isset($_POST[$i['name']]) ? $_POST[$i['name']] : '0';

                $ord = isset($_POST[$i['name'].'ord']) ? $_POST[$i['name'].'ord'] : '';

                $note = isset($_POST[$i['name'].'note']) ? $_POST[$i['name'].'note'] : '';

                //$cdate = isset($_POST[$i['name'].'caldate']) ? $_POST[$i['name'].'caldate'] : '';

                if(isset($_POST[$i['name'].'cdate'])) {

                    $excdate = explode('.', $_POST[$i['name'].'cdate']);

                    if(!empty($excdate[1]) && !empty($excdate[0]) && !empty($excdate[2])) {

                        $cdate = mktime(0, 0, 0, $excdate[1], $excdate[0], $excdate[2]);

                    } else $cdate = '';

                } else $cdate = '';

                $result[$i['name']] = array('value' => $value, 'ord' => $ord, 'note' => $note, 'cdate' => $cdate);

                if(isset($i['names'])) {

                    projects_work_type_pr($i['names'], $result);
                }
            }

        }

        return $result;
    }
}

if (!function_exists('projects_work_type_show')) {

    function projects_work_type_show($source = array(), $data, &$result, $flt = '', $c = 0, $old = '')
    {
        $source = work_type_sort($source, $data);

        foreach($source as $i) {

            $dp = 'display:none;';

            if(isset($data[$i['name']]) || $i['type'] != 'bool') $dp = '';

            $i['value'] = isset($data[$i['name']]['value']) ? $data[$i['name']]['value'] : '';

            $i['ord'] = isset($data[$i['name']]['ord']) ? $data[$i['name']]['ord'] : '';

            $i['note'] = isset($data[$i['name']]['note']) ? $data[$i['name']]['note'] : '';

            $i['cdate'] = !empty($data[$i['name']]['cdate']) ? date('d.m.Y', $data[$i['name']]['cdate']) : '';

            $ch = '';

            if($i['value'] != '') {

                $ch = 'checked';

                $dp = '';
            }

            //Если нет задач, выводится верхний уровень всех задач
            if($c == 0 && empty($data)) $dp = '';

            if($flt != '' && $flt != $i['name']) $dp = 'display:none;';

            if($c == 0) $result .= '<tr class="worktype1"><td><div class="'.$old.' shch" style="'.$dp.'">';

            if($c > 0) $result .= '<div class="'.$old.' shch" style="'.$dp.'">';

            $workinp = '';

            $caldate = '';

            if($i['type'] == 'date') {

                $workinp = '<input id="' . $i['name'] . '" name="' . $i['name'] . '" style="width:70px;" class="span2 datepicker1" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . '" value="'.$i['value'].'">';

                $caldate = '<input id="' . $i['name'] . 'cdate" name="' . $i['name'] . 'cdate" style="width:70px;" class="span2 datepicker1" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . '" value="'.$i['cdate'].'">';
            }

            //if(!empty($i['cdate'])) $caldate = '<span class="add-on">'.date('d.m.Y', $i['cdate']).'</span>';

            $result .= '<div class="input-prepend input-append bordbt" style="width: 100%;">
                                <input type="text" class="span1" style="width: 20px;" id="' . $i['name'] . 'ord" name="' . $i['name'] . 'ord" value="'.$i['ord'].'" placeholder="№" />
                                <span class="add-on" style="line-height: 17px; margin-left: '.($c*32).'px;">
                                    <input type="checkbox" onclick="tglcheck(\''.$i['name'].'\');" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" '.$ch.' value="1" style="margin: 0;"/>
                                </span>
                                '.$workinp.'
                                <span class="add-on">' . $i['rname'] . '</span>
                                ' . $caldate . '
                                <input type="text" class="span1 1inline-input" style="width: 150px; float: right;" id="' . $i['name'] . 'note" name="' . $i['name'] . 'note" placeholder="Примечание" value="'.$i['note'].'" />
                            </div>';

            if(isset($i['names'])) {

                $flt1 = '';

                projects_work_type_show($i['names'], $data, $result, $flt1, $c+1, $i['name']);
            }

            if($c == 0) $result .= '</div></td></tr>';

            if($c > 0) $result .= '</div>';

        }

        return $result;
    }
}

if (!function_exists('work_type_sort')) {

    function work_type_sort($config, $data, $key = 'ord') {

        $new_array = array();

        $sortable_array = array();

        foreach($config as $k => $i) {

            $i['ord'] = isset($i['ord']) ? $i['ord']+10 : '';

            if(!empty($data[$i['name']]['ord'])) $i['ord'] = $data[$i['name']]['ord'];

            $sortable_array[$k] = $i[$key];

        }

        asort($sortable_array);

        foreach ($sortable_array as $k => $v) {

            $new_array[$k] = $config[$k];
        }

        return $new_array;
    }
}

if (!function_exists('projects_last_edit')) {

    function projects_last_edit($source = array(), $data, &$result, &$last = array(), $c = 1)
    {
        foreach($source as $i) {

            if($i['type'] == 'bool') {

                $last = $i;
            }

            if(isset($data[$i['name']])) {

                $i['value'] = !empty($data[$i['name']]['value']) ? $data[$i['name']]['value']." - " : '';

                $i['ord'] = !empty($data[$i['name']]['ord']) ? $data[$i['name']]['ord']." - " : '';

                $i['note'] = !empty($data[$i['name']]['note']) ? $data[$i['name']]['note'] : '';

                $result .= "<small style='margin-left: ".(32*$c)."px;'>".$i['ord']."".$i['rname']." - ".$i['value'].$i['note']."</small><br>";

            }

            if(isset($i['names'])) {

                projects_last_edit($i['names'], $data, $result, $last, $c+1);
            }
        }

        return $result;
    }
}

if (!function_exists('projects_work_type_total')) {

    function projects_work_type_total($source = array(), &$result = array(), &$last = '', &$last1 = array(), &$vl = 0, &$count = 0)
    {
        //if(empty($result)) $result = array('count' => 0, 'current' => array('top' => '', 'bottom' => ''), 'next' => array('top' => '', 'bottom' => ''));
        if(empty($result)) $result = array('count' => 0, 'rs' => array());
        //$source = projects_work_type_sort_ord($source, 'ord');

        foreach($source as $k => $i) {

            if($i['type'] == 'bool' && $vl == 0) {

                $last = $i;
            }

            if($i['type'] == 'bool') {

                $last1 = $i;
            }

            $i['value'] = isset($i['value']) ? $i['value'] : '';

            if(empty($i['value']) && $i['type'] != 'bool') {

                $result['count']++;

                $i['last'] = $last;

                $i['last1'] = $last1;

                //if(empty($result['current']['top'])) $result['current']['top'] = $last;

                //if(empty($result['current']['bottom'])) $result['current']['bottom'] = $last1;

                //if(!empty($result['current']['top']) && empty($result['next']['top']) && $result['current']['top'] != $last) $result['next']['top'] = $last;

                //if(!empty($result['next']['top']) && !empty($result['current']['bottom']) && empty($result['next']['bottom']) && $result['current']['bottom'] != $last1) $result['next']['bottom'] = $last1;
                //echo $result['rs'][0];
                //if(!empty($result['rs']) && $result['rs'][$result['count']-1]['last1']['name'] != $i['last1']['name'])

                if(isset($result['rs'][$count-1]) && $result['rs'][$count-1]['last1']['name'] == $i['last1']['name']) {



                } else {

                    $result['rs'][$count] = $i;

                    $count++;
                }
            }

            if(isset($i['names'])) {

                $bl = $vl + 1;

                projects_work_type_total($i['names'], $result, $last, $last1, $bl, $count);
            }
        }

        return $result;
    }
}

if (!function_exists('projects_work_type_task')) {

    function projects_work_type_task($source = array())
    {
        $result = array('task' => array(), 'region' => array(), 'nztask' => array(), 'nzreg' => array(), 'prtask' => array(), 'prreg' => array(), 'osttask' => array(), 'today' => array(), 'tomorrow' => array());

        foreach($source['zadach']['rs'] as $i) {

            //if(isset($i['cdate']) && )

            //if(isset($i['last1']['ins'])) {

                $narr = 'osttask';

                $nreg = 'ostregion';

                $note = '';

                $addr = $source['street']."".$source['building'];

                if(!empty($source['buildingAdd'])) $addr .= ", к.".$source['buildingAdd'];

                if(!empty($source['apartment'])) $addr .= ", кв.".$source['apartment'];

                if(empty($i['cdate'])) {

                    $narr = 'nztask';

                    $nreg = 'nzreg';

                } elseif(!empty($i['cdate']) && $i['cdate'] < strtotime("-1 day")) {

                    $narr = 'prtask';

                    $nreg = 'prreg';
                }

                if(!empty($i['last1']['note'])) $note .= $i['last1']['note'];

                if(!empty($i['note'])) $note .= "(".$i['note'].")";

                if(!empty($i['cdate']) && $i['cdate'] > strtotime("-1 day") && $i['cdate'] < time()) {

                    $key = explode(' ', $source['region']);

                    $result['today'][] = array(
                        'id' => $source['id'],
                        'name' => $i['name'],
                        'date' => !empty($i['cdate']) ? date('Y-m-d', $i['cdate']) : date('Y-m-d'),
                        'ins' => isset($i['last1']['ins']) ? $i['last1']['ins'] : '',
                        'region' => $source['region'],
                        'note' => $note,
                        'key' => $key[0],
                        'address' => $addr,
                        'task' => $i['last1']['rname']."/".$i['rname']
                    );

                }

                if(!empty($i['cdate']) && $i['cdate'] > time() && $i['cdate'] < strtotime("+1 day")) {

                    $key = explode(' ', $source['region']);

                    $result['tomorrow'][] = array(
                        'id' => $source['id'],
                        'name' => $i['name'],
                        'date' => !empty($i['cdate']) ? date('Y-m-d', $i['cdate']) : date('Y-m-d'),
                        'ins' => isset($i['last1']['ins']) ? $i['last1']['ins'] : '',
                        'region' => $source['region'],
                        'note' => $note,
                        'key' => $key[0],
                        'address' => $addr,
                        'task' => $i['last1']['rname']."/".$i['rname']
                    );
                }

                if(!empty($i['cdate'])) {

                    $key = explode(' ', $source['region']);

                    $result['task'][] = array(
                        'id' => $source['id'],
                        'name' => $i['name'],
                        'date' => !empty($i['cdate']) ? date('Y-m-d', $i['cdate']) : date('Y-m-d'),
                        'ins' => isset($i['last1']['ins']) ? $i['last1']['ins'] : '',
                        'region' => $source['region'],
                        'note' => $note,
                        'key' => $key[0],
                        'address' => $addr,
                        'task' => $i['last1']['rname']."/".$i['rname']
                    );

                    $result['region'][trim($key[0])] = $source['region'];
                }

                $key = explode(' ', $source['region']);

                $result[$narr][] = array(
                    'id' => $source['id'],
                    'name' => $i['name'],
                    'date' => !empty($i['cdate']) ? date('Y-m-d', $i['cdate']) : date('Y-m-d'),
                    'ins' => isset($i['last1']['ins']) ? $i['last1']['ins'] : '',
                    'region' => $source['region'],
                    'note' => $note,
                    'key' => $key[0],
                    'address' => $addr,
                    'task' => $i['last1']['rname']."/".$i['rname']
                );

                $result[$nreg][trim($key[0])] = $source['region'];

            //}
        }

        return $result;
    }
}

if (!function_exists('projects_work_type_bd')) {

    function projects_work_type_bd($source = array(), $data, &$result = array())
    {
        $source = work_type_sort($source, $data);

        foreach($source as $k => $i) {

            if(isset($data[$i['name']]) || $i['type'] != 'bool') {

                if(isset($data[$i['name']])) $i = array_merge($i, $data[$i['name']]);

                $result[$k] = $i;

                unset($result[$k]['names']);

                if(isset($i['names'])) {

                    projects_work_type_bd($i['names'], $data, $result[$k]['names']);
                }
            }
        }

        return $result;
    }
}

if (!function_exists('projects_work_type_to_search')) {

    function projects_work_type_to_search($source = array(), &$result = '', $nb = 0)
    {
        $nnb = '';

        for($n = 0; $n < $nb; $n++) {

            $nnb .= "&nbsp;&nbsp;&nbsp;&nbsp;";
        }

        foreach($source as $i) {

            if($i['type'] == 'bool') {

                $result .= "<option value='".$i['name']."'>".$nnb.$i['rname']."</option>";

                if(isset($i['names'])) {

                    $bl = $nb + 1;

                    projects_work_type_to_search($i['names'], $result, $bl);
                }
            }
        }

        return $result;
    }
}
?>