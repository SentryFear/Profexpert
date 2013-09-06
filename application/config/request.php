<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Район
|--------------------------------------------------------------------------
*/
$config['region'] = array(
                        'Не выбрано',
                        'Адмиралтейский район',
                        'Василеостровский район',
                        'Выборгский район',
                        'Калининский район',
                        'Кировский район',
                        'Колпинский район',
                        'Красногвардейский район',
                        'Красносельский район',
                        'Кронштадтcкий район',
                        'Курортный район',
                        'Московский район',
                        'Невский район',
                        'Петроградский район',
                        'Приморский район',
                        'Пушкинский район',
                        'Фрунзенский район',
                        'Центральный район'
                     );

/*
|--------------------------------------------------------------------------
| Сортировка заявок по группам
|--------------------------------------------------------------------------
|
| name = string
|   - Название для отображения
|
| uri = string
|   - ссылка для обработки
|
| allow = string
|   - отделы которым отображать сортировку
|
| logic =
|   - логика отображения
|     пример:
|       - (kp:1?mid:usr,kp:2?mid:usr) - через двоеточие логическое "=", через вопросительный знак логическое "и", через запятую логическое "или"
|
| default = bool
|   - значение по умолчанию
|
| Дополнительные значения:
|  usr = айди юзера (например если надо чтобы какое-то значение было равно айди пользователя)
|
*/
$config['sort'] = array(
                        // Отдел продаж - id = 3
                            array('name' => 'Все', 'uri' => 'mAll', 'allow' => '3', 'logic' => 'mid:usr', 'default' => '1'),
                            array('name' => 'Новые', 'uri' => 'mNew', 'allow' => '3', 'logic' => 'kp:0?mid:usr'),
                            array('name' => 'Расчёт времени', 'uri' => 'mInDev', 'allow' => '3', 'logic' => 'kp:1?mid:usr,kp:2?mid:usr'),
                            array('name' => 'В работе', 'uri' => 'mInWork', 'allow' => '3', 'logic' => 'kp:3?mid:usr'),
                            array('name' => 'Предложение сделано', 'uri' => 'mSend', 'allow' => '3', 'logic' => 'kp:6?mid:usr'),
                            array('name' => 'Без ответа', 'uri' => 'mNoAns', 'allow' => '3', 'logic' => 'kp:6?date:259200?mid:usr'),
                            array('name' => 'Отказ', 'uri' => 'nFail', 'allow' => '3', 'logic' => 'kp:7?mid:usr'),
                        // Проектный отдел - id = 4
                            array('name' => 'Все', 'uri' => 'pAll', 'allow' => '4', 'logic' => 'uid:0?kp:1,uid:usr?kp:1,uid:usr?kp:3,uid:usr?kp:4,uid:usr?kp:5,uid:usr?kp:6,uid:usr?kp:7,uid:usr?kp:8,uid:usr?kp:9,uid:usr?kp:10', 'default' => '1'),
                            array('name' => 'Новые', 'uri' => 'pNew', 'allow' => '4', 'logic' => 'uid:0?kp:1'),
                            array('name' => 'В работе', 'uri' => 'pInWork', 'allow' => '4', 'logic' => 'uid:usr?kp:1'),
                            array('name' => 'Завершённые', 'uri' => 'pCompleted', 'allow' => '4', 'logic' => 'uid:usr?kp:3,uid:usr?kp:4,uid:usr?kp:5,uid:usr?kp:6,uid:usr?kp:7'),
                        // Отдел согласования - id = 5
                            array('name' => 'Все', 'uri' => 'sAll', 'allow' => '5', 'logic' => 'id:0', 'default' => '1'),
                        // Руководство - id = 6
                            array('name' => 'Все', 'uri' => 'rAll', 'allow' => '2,6', 'logic' => 'all', 'default' => '1'),
                            array('name' => 'В работе у менеджера', 'uri' => 'rmInDev', 'allow' => '2,6', 'logic' => 'kp:0,kp:3'),
                            array('name' => 'В работе у проектировщиков', 'uri' => 'rpInDev', 'allow' => '2,6', 'logic' => 'kp:1,kp:2'),
                            array('name' => 'Согласование стоимости', 'uri' => 'rPrice', 'allow' => '2,6', 'logic' => 'kp:4'),
                            array('name' => 'Предложение сделано', 'uri' => 'rSend', 'allow' => '2,6', 'logic' => 'kp:6'),
                            array('name' => 'Без ответа', 'uri' => 'rNoAns', 'allow' => '2,6', 'logic' => 'kp:6?date:259200'),
                            array('name' => 'Отказ', 'uri' => 'rFail', 'allow' => '2,6', 'logic' => 'kp:7'),
                    );

/*
|--------------------------------------------------------------------------
| Статусы заявки
|--------------------------------------------------------------------------
|
| name = string
|   - Название для отображения
|
| fullname = string
|   - пояснение выводящееся при наведении курсора
|
| uri = string
|   - ссылка для обработки если есть
|
| allow = string
|   - отделы которым отображать статус
|
| logic =
|   - логика отображения
|     пример:
|       - (kp:1?mid:usr,kp:2?mid:usr) - через двоеточие логическое "=", через вопросительный знак логическое "и", через запятую логическое "или"
|
*/
$config['status'] = array(
                            // Отдел продаж - id = 3
                                array('name' => 'Отправить', 'fullname' => 'Нажмите чтобы отправить заявку проектировщикам', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:0', 'uri' => '/request/send/optop/'),
                                array('name' => 'Отправлено', 'fullname' => 'Заявка отправлена проектировщикам', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:1'),
                                array('name' => 'Отправить руководству', 'fullname' => 'Отправить заявку руководству для согласование стоимости', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:2,ikp:3', 'uri' => '/request/send/optor/'),
                                array('name' => 'Согласовывается', 'fullname' => 'Заявка у руководства', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:4'),
                                array('name' => 'Отправить заказчику', 'fullname' => 'Нажмите чтобы отправить заявку заказчику', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:5', 'uri' => '/request/send/optoz/'),
                                array('name' => 'Отказ', 'fullname' => 'Нажмите если заказчик отказался', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/otkaz/'),
                                array('name' => 'В работу', 'fullname' => 'Нажмите если заказчик согласился с кп', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/inwork/'),
                                array('name' => 'Отказано', 'fullname' => 'Заказчик отказался', 'class' => 'important', 'allow' => '3', 'logic' => 'ikp:7'),
                                array('name' => 'В работе', 'fullname' => 'Заказчик согласился', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:8'),
                                array('name' => 'Отправить повторно', 'fullname' => 'Отправить повторно на согласование', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:9', 'uri' => '/request/send/optordor/'),
                                array('name' => 'Согласовывается', 'fullname' => 'Заявка у руководства согласовывается после доработки', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:10'),
                            // Проектный отдел - id = 4
                                array('name' => 'Забрать заявку', 'fullname' => 'Нажмите чтобы забрать заявку', 'class' => 'warning', 'allow' => '4', 'logic' => 'uid:0', 'uri' => '/request/send/pstop/'),
                                array('name' => 'Завершить работу', 'fullname' => 'Завершить работу над заявкой', 'class' => 'info', 'allow' => '4', 'logic' => 'ikp:1?uid:usr', 'uri' => '/request/send/ptoop/'),
                                array('name' => 'Завершено', 'fullname' => 'Работа над заявкой завершена', 'class' => 'success', 'allow' => '4', 'logic' => 'ikp:2,ikp:3,ikp:4,ikp:5,ikp:6,ikp:7,ikp:8,ikp:9,ikp:10'),
                            // Руководство - id = 6
                                //array('name' => 'Не выбран', 'fullname' => 'Менеджер не выбран', 'class' => 'important', 'allow' => '2,6', 'logic' => 'mid:0'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:0'),
                                array('name' => 'Проектный отдел', 'fullname' => 'Заявка в данный момент у проектировщиков', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:1'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера составление стоимости', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:2,ikp:3'),
                                array('name' => 'Согласовать', 'fullname' => 'Нажмите если стоимость согласована', 'class' => 'warning', 'allow' => '2,6', 'logic' => 'ikp:4', 'uri' => '/request/send/rtoop/'),
                                array('name' => 'Доработка', 'fullname' => 'Нажмите чтобы отправить на доработку', 'class' => 'important', 'allow' => '2,6', 'logic' => 'ikp:4', 'uri' => '/request/send/rtodor/'),
                                array('name' => 'Менеджер', 'fullname' => 'Дорабатывается менеджером', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:9'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера отправка КП заказчику', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:5'),
                                array('name' => 'Заказчик', 'fullname' => 'Заявка отправлена заказчику', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:6'),
                                array('name' => 'Отказ', 'fullname' => 'Заказчик отказался', 'class' => 'important', 'allow' => '2,6', 'logic' => 'ikp:7'),
                                array('name' => 'В работе', 'fullname' => 'Заказчик согласился', 'class' => 'success', 'allow' => '2,6', 'logic' => 'ikp:8'),
                                array('name' => 'Согласовать', 'fullname' => 'Нажмите если стоимость согласована после доработки', 'class' => 'warning', 'allow' => '2,6', 'logic' => 'ikp:10', 'uri' => '/request/send/rtoop/'),
                                array('name' => 'Доработка', 'fullname' => 'Нажмите чтобы отправить на доработку ещё раз', 'class' => 'important', 'allow' => '2,6', 'logic' => 'ikp:10', 'uri' => '/request/send/rtodor/'),
                          );

/*
|--------------------------------------------------------------------------
| Статусы коммерческого предложения
|--------------------------------------------------------------------------
|
| name = Название коммерческого предложения на русском
| dbname = записывание даты в базу history
|
*/
$config['kpstatus'] = array(
                        array('name' => 'Ожидание документов', 'dbname' => 'dt0'),
                        array('name' => 'Расчет данных', 'dbname' => 'dt1'),
                        array('name' => 'Согласование сроков', 'dbname' => 'dt2'),
                        array('name' => 'Оформление предложения', 'dbname' => 'dt3'),
                        array('name' => 'Согласование стоимости', 'dbname' => 'dt4'),
                        array('name' => 'Готово к отправке', 'dbname' => 'dt5'),
                        array('name' => 'Отправлено', 'dbname' => 'dt6'),
                        array('name' => 'Отказ', 'dbname' => 'dt7'),
                        array('name' => 'В работе', 'dbname' => 'dt8'),
                        array('name' => 'Руководство отправило на доработку', 'dbname' => 'dt9'),
                        array('name' => 'Менеджер прислал с доработки', 'dbname' => 'dt10'),
                     );
/*
|--------------------------------------------------------------------------
| Таблица истории
|--------------------------------------------------------------------------
*/
$config['history'] = array(
                        array('name' => 'Передача заявки проектировщикам', 'dbname' => 'dt20'),
                        array('name' => 'Проектировщик принял заявку', 'dbname' => 'dt21'),
                        array('name' => 'Проектировщик завершил работу над заявкой', 'dbname' => 'dt22'),
                        array('name' => 'Руководство отправило на доработку', 'dbname' => 'dt23'),
                     );
/*
|--------------------------------------------------------------------------
| Типы зданий\помещений
|--------------------------------------------------------------------------
*/
$config['ntype'] = array('Не выбрано', 'жилое', 'нежилое');

/*
|--------------------------------------------------------------------------
| Разделы проектной документации
|--------------------------------------------------------------------------
*/
$config['razd'] = array(
                        array('name' => 'ar', 'rname' => 'Архитектурный Раздел', 'price' => '150'),
                        array('name' => 'vk', 'rname' => 'Водоснабжение и Канализация', 'price' => '70'),
                        array('name' => 'km', 'rname' => 'Конструкции Металлические', 'price' => '100'),
                        array('name' => 'ov', 'rname' => 'Отопление Вентиляция', 'price' => '50'),
                        array('name' => 'eo', 'rname' => 'Электрическое Оборудование', 'price' => '70'),
                        array('name' => 'to', 'rname' => 'ТехОбследование', 'price' => '60'),
                        array('name' => 'th', 'rname' => 'ТеХнология', 'price' => '120'),
                        array('name' => 'tz', 'rname' => 'Техническое Заключение', 'price' => '50'),
                        array('name' => 'apz', 'rname' => 'Архитектурно-Планировочное Задание', 'price' => '150'),
                        array('name' => 'aro', 'rname' => 'Архитектурный Раздел Отдельный Вход', 'price' => '150'),
                        array('name' => 'arop', 'rname' => 'Архитектурный Раздел Отдельного Входа с Приямком', 'price' => '150'),
                        array('name' => 'visit', 'rname' => 'Выезд на объект', 'price' => '0'),
                        );

/*
|--------------------------------------------------------------------------
| Согласование
|--------------------------------------------------------------------------
*/
$config['instance'] = array(
                            array('rname' => 'Жилищно-эксплуатационные органы', 'ins' => '1', 'names' => array('paov', 'type', 'sooz', 'sbd')),
                                array('rname' => 'Получение акта обследования вентканалов', 'name' => 'paov', 'price' => '2000'),
                                array('rname' => 'ТУ по электрике', 'name' => 'type', 'price' => '2000'),
                                array('rname' => 'Справка об отсутствии задолженности', 'name' => 'sooz', 'price' => '2000'),
                                array('rname' => 'Согласование балансодержателя дома (ТСЖ, ГУЖА, УК)', 'name' => 'sbd', 'price' => '5000'),
                            array('rname' => 'Государственное унитарное предприятие «Водоканал Санкт-Петербурга»', 'ins' => '1', 'names' => array('typviv')),
                                array('rname' => 'ТУ по водоснабжению и водоотведению', 'name' => 'typviv', 'price' => '2000'),
                            array('rname' => 'Органы санитарно-эпидемиологической службы', 'ins' => '1', 'names' => array('zfgyz')),
                                array('rname' => 'Заключение ФГУЗ', 'name' => 'zfgyz', 'price' => '10000'),
                            array('rname' => 'Государственный пожарный надзор Санкт-Петербурга', 'ins' => '1', 'names' => array('zogpn')),
                                array('rname' => 'Заключение ОГПН', 'name' => 'zogpn', 'price' => '10000'),
                            array('rname' => 'Проектно-инвентаризационное бюро', 'ins' => '1', 'names' => array('pid', 'ptp', 'sp', 'ptppib', 'ppib')),
                                array('rname' => 'Получение исходной документации', 'name' => 'pid', 'price' => '2000'),
                                array('rname' => 'Ситуационный план', 'name' => 'sp', 'price' => '3000'),
                                array('rname' => 'Получение технического паспорта', 'name' => 'ptp', 'price' => '2000'),
                                array('rname' => 'Получение технического плана ПИБ', 'name' => 'ptppib', 'price' => '2000'),
                                array('rname' => 'Переобмер ПИБ', 'name' => 'ppib', 'price' => '2000'),
                            array('rname' => 'Комитет по государственному контролю, использованию и охране памятников истории и культуры Санкт-Петербурга', 'ins' => '1', 'names' => array('sokgiop', 'zkgiop', 'skgiop')),
                                array('rname' => 'Справка КГИОП', 'name' => 'sokgiop', 'price' => '10000'),
                                array('rname' => 'Задание КГИОП', 'name' => 'zkgiop', 'price' => '10000'),
                                array('rname' => 'Согласование КГИОП', 'name' => 'skgiop', 'price' => '10000'),
                            array('rname' => 'Комитет по градостроительству и архитектуре', 'ins' => '1', 'names' => array('pkga', 'zkga', 'apzkga', 'sops')),
                                array('rname' => 'Письмо КГА', 'name' => 'pkga', 'price' => '10000'),
                                array('rname' => 'Заключение КГА', 'name' => 'zkga', 'price' => '10000'),
                                array('rname' => 'АПЗ КГА', 'name' => 'apzkga', 'price' => '10000'),
                                array('rname' => 'Согласование ОПС', 'name' => 'sops', 'price' => '5000'),
                            array('rname' => 'Проектные, экспертно-технические и строительные организации', 'ins' => '1', 'names' => array('dsrodnp', 'ep')),
                                array('rname' => 'Договор на проведение строительно-монтажных работ + допуск СРО, договор на технадзор + СРО, договор на вывоз строительного мусора, акты скрытых работ', 'name' => 'dsrodnp', 'price' => '10000'),
                                array('rname' => 'Экспертиза проекта', 'name' => 'ep', 'price' => '10000'),
                            array('rname' => 'Комитет по управлению городским имуществом Санкт-Петербурга', 'ins' => '1', 'names' => array('zvkygi')),
                                array('rname' => 'Заявление в КУГИ', 'name' => 'zvkygi', 'price' => '2000'),
                            array('rname' => 'Районная Межведомственная комиссия', 'ins' => '1', 'names' => array('sp', 'vove')),
                                array('rname' => 'Согласование проекта', 'name' => 'sp', 'price' => '10000'),
                                array('rname' => 'Ввод объекта в эксплуатацию', 'name' => 'vove', 'price' => '10000'),
                            array('rname' => 'Главное Управление Федеральной регистрационной службы по Санкт-Петербургу и Ленинградской области', 'ins' => '1', 'names' => array('pkp', 'psogrps')),
                                array('rname' => 'Получение кадастрового паспорта', 'name' => 'pkp', 'price' => '2000'),
                                array('rname' => 'Получение свидетельства о государственной регистрации права собственности', 'name' => 'psogrps', 'price' => '5000'),
                        );

/*
|--------------------------------------------------------------------------
| Генерация таблицы
|--------------------------------------------------------------------------
|
| Работает везде
|   name = string
|     - Название на русском
|
|   value = string
|     - Значение в базе или обрабатываемое любое название
|
|   allow = string
|     - Каким отделам разрешено видеть это поле
|
|
| Работает только в таблице
|   self = string
|     - Дополнения для тегов
|
|   view = bool
|     - Показывать в таблице или нет / по умолчанию отображать
|
|
| Работает только в форме
|   form = bool
|     - Отображать в форме или нет / по умолчанию отображать
|
|   type = string
|     - тип поля в форме / по умолчанию input
|
|   add = bool
|     - отображать при добавлении или нет / по умолчанию отображать
|
*/
$config['access'] = array(
    array('name' => 'Номер',                          'value' => 'loop.index',    'allow' => '2,3,4,6', 'self' => 'class="span2"', 'form' => 0),
    array('name' => 'Дата',                           'value' => 'date',          'allow' => '2,3,4,6', 'date-format' => 'd.m.Y в H:i', 'self' => 'class="span3"', 'form' => 0),
    array('name' => 'ФИО',                            'value' => 'fname',         'allow' => '2,3,4,6', 'self' => 'class="span3"'),
    array('name' => 'Телефон',                        'value' => 'phone',         'allow' => '2,3,4,6', 'self' => 'class="span3"'),
    array('name' => 'Email адрес',                    'value' => 'email',         'allow' => '2,3,4,6', 'self' => 'class="span3"'),
    array('name' => 'Район',                          'value' => 'region',        'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Адрес',                          'value' => 'address',       'allow' => '2,3,4,6', 'view' => 0),
    array('name' => 'Откуда узнали',                  'value' => 'hear',          'allow' => '2,3,6', 'view' => 0),
    array('name' => 'Дополнительная информация',      'value' => 'more',          'allow' => '2,3,4,6', 'view' => 0, 'type' => 'textarea'),
    array('name' => 'Назначение здания',              'value' => 'ztype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Назначение помещения',           'value' => 'ptype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Название проекта',               'value' => 'name',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Тип работ',                      'value' => 'rtype',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Площадь объекта',                'value' => 'footage',       'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Документы',                      'value' => 'vdocs',         'allow' => '2,3,4,6', 'self' => 'class="span3"', 'form' => 0),
    array('name' => 'Работники',                      'value' => 'workers',       'allow' => '2,6', 'self' => 'class="span3"', 'form' => 0),
    array('name' => 'Состав проектной документации',  'value' => 'razd',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    array('name' => 'Согласования',                   'value' => 'instance',      'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    array('name' => 'Примечание',                     'value' => 'pmore',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'textarea'),
    array('name' => 'Общий объём работ',              'value' => 'total',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'КП',                             'value' => 'kp',            'allow' => '2,3,6', 'form' => 0, 'self' => 'class="span3"'),
    array('name' => 'Действия',                       'value' => 'actions',       'allow' => '2,3,4,6', 'self' => 'width="5%"', 'form' => 0, 'self' => 'class="span3"')
);
?>