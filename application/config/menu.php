<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['topmenu'] = array(
                            array('name' => 'Заявки', 'cpu' => '/request/', 'icon' => '<i class="icon-tasks"></i>'),
                            array('name' => 'Проекты', 'cpu' => '/projects/', 'icon' => '<i class="icon-briefcase"></i>'),
                            array('name' => 'Задачи', 'cpu' => '/tasks/', 'icon' => '<i class="icon-gift"></i>'),
                            array('name' => 'Пользователи', 'cpu' => '/users/', 'icon' => '<i class="icon-user"></i>'),
                            array('name' => 'Отделы', 'cpu' => '/users/roles/', 'icon' => '<i class="icon-group"></i>'),
                            //array('name' => 'Добавить', 'cpu' => '#add', 'self' => 'data-target=#add data-toggle=modal class=suc-nav', 'icon' => '<i class="icon-plus"></i>')
                    );

?>