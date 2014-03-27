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

            if(isset($_POST[$i['name'].'ch'])) {

                $value = isset($_POST[$i['name']]) ? $_POST[$i['name']] : '0';

                $result[$i['name']] = array('value' => $value);

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
        foreach($source as $i) {

            $dp = 'display:none;';

            if(isset($data[$i['name']]) || $i['type'] != 'bool') $dp = '';

            $i['value'] = isset($data[$i['name']]['value']) ? $data[$i['name']]['value'] : '';

            //$result[$i['name']] = $i;

            $ch = '';

            if($i['value'] != '') {

                $ch = 'checked';

                $dp = '';
            }

            if($flt != '' && $flt != $i['name']) $dp = 'display:none;';

            if($c == 0) $result .= '<tr class="worktype1"><td><div class="'.$old.' shch" style="'.$dp.'">';

            if($c > 0) $result .= '<div class="'.$old.' shch" style="'.$dp.'">';

            $workinp = '';

            if($i['type'] == 'date') $workinp = '<input id="' . $i['name'] . '" name="' . $i['name'] . '" class="span2 datepicker1" data-date-format="dd.mm.yyyy" id="appendedPrependedInput" type="text" placeholder="' . $i['rname'] . '" value="'.$i['value'].'">';

            $result .= '<div class="input-prepend input-append" style="margin-left: '.($c*32).'px;">
                                <span class="add-on" style="line-height: 17px;">
                                    <input type="checkbox" onclick="tglcheck(\''.$i['name'].'\');" id="' . $i['name'] . 'ch" name="' . $i['name'] . 'ch" '.$ch.' value="1" style="margin: 0;"/>
                                </span>
                                '.$workinp.'
                                <span class="add-on">' . $i['rname'] . '</span>
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

if (!function_exists('projects_work_type_total')) {

    function projects_work_type_total($source = array(), $data, &$result, &$last = '', &$last1 = '', &$vl = 0)
    {
        foreach($source as $i) {

            if($i['type'] == 'bool' && $vl == 0) {

                $last = $i;
            }

            if($i['type'] == 'bool' && $vl == 1) {

                $last1 = $i['rname'];
            }

            if(isset($data[$i['name']]) || $i['type'] != 'bool') {

                $i['value'] = isset($data[$i['name']]['value']) ? $data[$i['name']]['value'] : '';

                if($i['value'] == '' && $i['type'] != 'bool') {

                    $i['last'] = $last;

                    $i['last1'] = $last1;

                    $result[] = $i;
                }

                if(isset($i['names'])) {

                    $bl = $vl + 1;

                    projects_work_type_total($i['names'], $data, $result, $last, $last1, $bl);
                }
            }

        }

        return $result;
    }
}
?>