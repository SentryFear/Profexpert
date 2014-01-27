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
                        'Петродворцовый район',
                        'Приморский район',
                        'Пушкинский район',
                        'Фрунзенский район',
                        'Центральный район',
                        'Ленинградская обл.'
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
                            array('name' => 'Все', 'uri' => 'mAll', 'allow' => '3', 'logic' => 'mid:usr'),
                            array('name' => 'Актуальные заявки', 'uri' => 'mAkt', 'allow' => '3', 'logic' => 'mid:usr?date>2419200?kp!13', 'default' => '1'),
                            array('name' => 'Заявки с сайта', 'uri' => 'mSite', 'allow' => '3', 'logic' => 'mid:0'),
                            array('name' => 'Новые', 'uri' => 'mNew', 'allow' => '3', 'logic' => 'kp:0?mid:usr'),
                            array('name' => 'Расчёт времени', 'uri' => 'mInDev', 'allow' => '3', 'logic' => 'kp:1?mid:usr,kp:2?mid:usr'),
                            array('name' => 'В работе', 'uri' => 'mInWork', 'allow' => '3', 'logic' => 'kp:3?mid:usr'),
                            array('name' => 'Предложение сделано', 'uri' => 'mSend', 'allow' => '3', 'logic' => 'kp:6?mid:usr'),
                            array('name' => 'Без ответа', 'uri' => 'mNoAns', 'allow' => '3', 'logic' => 'kp:6?date<259200?mid:usr'),
                            array('name' => 'Отказ', 'uri' => 'mFail', 'allow' => '3', 'logic' => 'kp:7?mid:usr'),
                            array('name' => 'Согласился', 'uri' => 'mSucc', 'allow' => '3', 'logic' => 'kp:8?mid:usr'),
                            array('name' => 'Архив', 'uri' => 'mArh', 'allow' => '3', 'logic' => 'kp:6?date<2419200?mid:usr'),
                            array('name' => 'Договор подписан', 'uri' => 'mSuccess', 'allow' => '3', 'logic' => 'kp:13?mid:usr'),
                        // Проектный отдел - id = 4
                            array('name' => 'Все', 'uri' => 'pAll', 'allow' => '4', 'logic' => 'uid:0?kp:1,uid:usr?kp:1,uid:usr?kp:3,uid:usr?kp:4,uid:usr?kp:5,uid:usr?kp:6,uid:usr?kp:7,uid:usr?kp:8,uid:usr?kp:9,uid:usr?kp:10,uid:usr?kp:11,uid:usr?kp:12,uid:usr?kp:13', 'default' => '1'),
                            array('name' => 'Новые', 'uri' => 'pNew', 'allow' => '4', 'logic' => 'uid:0?kp:1'),
                            array('name' => 'В работе', 'uri' => 'pInWork', 'allow' => '4', 'logic' => 'uid:usr?kp:1'),
                            array('name' => 'Завершённые', 'uri' => 'pCompleted', 'allow' => '4', 'logic' => 'uid:usr?kp:3,uid:usr?kp:4,uid:usr?kp:5,uid:usr?kp:6,uid:usr?kp:7'),
                        // Отдел согласования - id = 5
                            array('name' => 'Все', 'uri' => 'sAll', 'allow' => '5', 'logic' => 'id:0', 'default' => '1'),
                        // Руководство - id = 6
                            array('name' => 'Все', 'uri' => 'rAll', 'allow' => '2,6', 'logic' => 'all'),
                            array('name' => 'Актуальные заявки', 'uri' => 'rAkt', 'allow' => '2,6', 'logic' => 'date>2419200?kp!13', 'default' => '1'),
                            array('name' => 'Заявки с сайта', 'uri' => 'rSite', 'allow' => '2,6', 'logic' => 'mid:0'),
                            array('name' => 'В работе у менеджера', 'uri' => 'rmInDev', 'allow' => '2,6', 'logic' => 'kp:0,kp:3,kp:5,kp:9,kp:12'),
                            array('name' => 'В работе у проектировщиков', 'uri' => 'rpInDev', 'allow' => '2,6', 'logic' => 'kp:1,kp:2'),
                            array('name' => 'Согласование стоимости', 'uri' => 'rPrice', 'allow' => '2,6', 'logic' => 'kp:4'),
                            array('name' => 'Предложение сделано', 'uri' => 'rSend', 'allow' => '2,6', 'logic' => 'kp:6'),
                            array('name' => 'Без ответа', 'uri' => 'rNoAns', 'allow' => '2,6', 'logic' => 'kp:6?date<259200'),
                            array('name' => 'Архив', 'uri' => 'rArh', 'allow' => '2,6', 'logic' => 'kp:6?date<2419200'),
                            array('name' => 'Отказ', 'uri' => 'rFail', 'allow' => '2,6', 'logic' => 'kp:7'),
                            array('name' => 'Согласился', 'uri' => 'rSucc', 'allow' => '2,6', 'logic' => 'kp:8'),
                            array('name' => 'Договор подписан', 'uri' => 'rSuccess', 'allow' => '2,6', 'logic' => 'kp:13'),
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
                                array('name' => 'Проектный отд.', 'fullname' => 'Нажмите чтобы отправить заявку проектировщикам', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:0', 'uri' => '/request/send/optop/'),
                                array('name' => 'Отправлено', 'fullname' => 'Заявка отправлена проектировщикам', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:1'),
                                array('name' => 'Руководству', 'fullname' => 'Отправить заявку руководству для согласование стоимости', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:0,ikp:2,ikp:3,ikp:12', 'uri' => '/request/send/optor/'),
                                array('name' => 'Согласовывается', 'fullname' => 'Заявка у руководства', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:4'),
                                array('name' => 'Заказчику', 'fullname' => 'Нажмите чтобы отправить заявку заказчику', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:5', 'uri' => '/request/send/optoz/'),
                                array('name' => 'Отказался', 'fullname' => 'Нажмите если заказчик отказался', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/otkaz/'),
                                array('name' => 'Согласился', 'fullname' => 'Нажмите если заказчик согласился', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/inwork/'),
                                array('name' => 'Отказано', 'fullname' => 'Заказчик отказался', 'class' => 'important', 'allow' => '3', 'logic' => 'ikp:7'),
                                array('name' => 'Согласился', 'fullname' => 'Заказчик согласился', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:8'),
                                array('name' => 'Подписать договор', 'fullname' => 'Заказчик подписал договор', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:8', 'uri' => '/request/send/zaytoproj/'),
                                array('name' => 'Руководству [2]', 'fullname' => 'Отправить повторно на согласование', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:9', 'uri' => '/request/send/optordor/'),
                                array('name' => 'Проектный отд. [2]', 'fullname' => 'Отправить на доработку проектировщикам', 'class' => 'warning', 'allow' => '3', 'logic' => 'ikp:9,ikp:2,ikp:3,ikp:12', 'uri' => '/request/send/optopr/'),
                                array('name' => 'Согласовывается', 'fullname' => 'Заявка у руководства согласовывается после доработки', 'class' => 'info', 'allow' => '3', 'logic' => 'ikp:10'),
                                array('name' => 'Дорабатывается', 'fullname' => 'Проектировщики дорабатывают', 'class' => 'info', 'allow' => '3', 'logic' => 'ikp:11'),
                                array('name' => 'Договор подписан', 'fullname' => 'Договор подписан', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:13'),
                            // Проектный отдел - id = 4
                                array('name' => 'Забрать заявку', 'fullname' => 'Нажмите чтобы забрать заявку', 'class' => 'warning', 'allow' => '4', 'logic' => 'uid:0', 'uri' => '/request/send/pstop/'),
                                array('name' => 'Завершить работу', 'fullname' => 'Завершить работу над заявкой', 'class' => 'info', 'allow' => '4', 'logic' => 'ikp:1?uid:usr', 'uri' => '/request/send/ptoop/'),
                                array('name' => 'Завершить доработку', 'fullname' => 'Доработка завершена', 'class' => 'info', 'allow' => '4', 'logic' => 'ikp:11?uid:usr', 'uri' => '/request/send/prtoop/'),
                                array('name' => 'Завершено', 'fullname' => 'Работа над заявкой завершена', 'class' => 'success', 'allow' => '4', 'logic' => 'ikp:2,ikp:3,ikp:4,ikp:5,ikp:6,ikp:7,ikp:8,ikp:9,ikp:10,ikp:12,ikp:13'),
                            // Руководство - id = 6
                                //array('name' => 'Не выбран', 'fullname' => 'Менеджер не выбран', 'class' => 'important', 'allow' => '2,6', 'logic' => 'mid:0'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:0'),
                                array('name' => 'Проектный отд.', 'fullname' => 'Заявка в данный момент у проектировщиков', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:1'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера составление стоимости', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:2,ikp:3'),
                                array('name' => 'Согласовать', 'fullname' => 'Нажмите если стоимость согласована', 'class' => 'warning', 'allow' => '2,6', 'logic' => 'ikp:4', 'uri' => '/request/send/rtoop/'),
                                array('name' => 'Доработка', 'fullname' => 'Нажмите чтобы отправить на доработку', 'class' => 'important upl', 'allow' => '2,6', 'logic' => 'ikp:4', 'uri' => '/request/send/rtodor/'),
                                array('name' => 'Менеджер', 'fullname' => 'Заявка в данный момент у менеджера отправка КП заказчику', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:5'),
                                array('name' => 'Заказчик', 'fullname' => 'Предложение отправлено заказчику', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:6'),
                                array('name' => 'Отказ', 'fullname' => 'Заказчик отказался', 'class' => 'important', 'allow' => '2,6', 'logic' => 'ikp:7'),
                                array('name' => 'Согласился', 'fullname' => 'Заказчик согласился', 'class' => 'success', 'allow' => '2,6', 'logic' => 'ikp:8'),
                                array('name' => 'Менеджер', 'fullname' => 'Дорабатывается менеджером', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:9'),
                                array('name' => 'Согласовать', 'fullname' => 'Нажмите если стоимость согласована после доработки', 'class' => 'warning', 'allow' => '2,6', 'logic' => 'ikp:10', 'uri' => '/request/send/rtoop/'),
                                array('name' => 'Доработка', 'fullname' => 'Нажмите чтобы отправить на доработку ещё раз', 'class' => 'important upl', 'allow' => '2,6', 'logic' => 'ikp:10', 'uri' => '/request/send/rtodor/'),
                                array('name' => 'Проектный отд. [ 2 ]', 'fullname' => 'Дорабатывается проектировщиком', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:11'),
                                array('name' => 'Менеджер', 'fullname' => 'Дорабатывается менеджером', 'class' => 'info', 'allow' => '2,6', 'logic' => 'ikp:12'),
                                array('name' => 'Договор подписан', 'fullname' => 'Договор подписан', 'class' => 'success', 'allow' => '2,6', 'logic' => 'ikp:13'),
                          );

/*
|--------------------------------------------------------------------------
| Статусы коммерческого предложения
|--------------------------------------------------------------------------
|
|  name = string
|    -  Название на русском
|
|  dbname = string
|    - Идентификатор в базе
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
                        array('name' => 'Согласился', 'dbname' => 'dt8'),
                        array('name' => 'Руководство отправило на доработку', 'dbname' => 'dt9'),
                        array('name' => 'Менеджер прислал с доработки', 'dbname' => 'dt10'),
                        array('name' => 'Менеджер отправил на доработку проектировщикам', 'dbname' => 'dt11'),
                        array('name' => 'Проектный отдел вернул с доработки', 'dbname' => 'dt12'),
                        array('name' => 'Договор подписан', 'dbname' => 'dt13'),
                     );
/*
|--------------------------------------------------------------------------
| Таблица истории
|--------------------------------------------------------------------------
|
|  name = string
|    - Название на русском
|
|  dbname = string
|    - Идентификатор в базе
|
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
|
|  name = string
|    - Короткое название раздела как идентификатор
|
|  rname = string
|    - Название на русском
|
|  sname = string
|    - Короткое название на русском
|
|  price = string
|    - Цена по умолчанию, если есть за кв\м
|
*/
$config['razd'] = array(
                        array('name' => 'ar', 'rname' => 'Архитектурные Решения', 'sname' => 'АР', 'price' => '150'),
                        array('name' => 'vk', 'rname' => 'Водоснабжение и Канализация', 'sname' => 'ВК', 'price' => '70'),
                        array('name' => 'km', 'rname' => 'Конструкции Металлические', 'sname' => 'КМ', 'price' => '100', 'time' => '3'),
                        array('name' => 'kr', 'rname' => 'Конструктивные Решения', 'sname' => 'КР', 'price' => '100', 'time' => '3'),
                        array('name' => 'kj', 'rname' => 'Конструкции Железобетонные', 'sname' => 'КЖ', 'price' => '100', 'time' => '3'),
                        array('name' => 'kd', 'rname' => 'Конструкции Деревянные', 'sname' => 'КД', 'price' => '100', 'time' => '3'),
                        array('name' => 'ov', 'rname' => 'Отопление Вентиляция и Кондиционирование', 'sname' => 'ОВ', 'price' => '50'),
                        array('name' => 'eo', 'rname' => 'Электроосвещение', 'sname' => 'ЭО', 'price' => '70'),
                        array('name' => 'to', 'rname' => 'ТехОбследование', 'sname' => 'ТО', 'price' => '60'),
                        array('name' => 'th', 'rname' => 'ТеХнология', 'sname' => 'ТХ', 'price' => '120'),
                        array('name' => 'tz', 'rname' => 'Техническое Заключение', 'sname' => 'ТЗ', 'price' => '50'),
                        array('name' => 'apz', 'rname' => 'Архитектурно-Планировочное Задание', 'sname' => 'АПЗ', 'price' => '150', 'time' => '3'),
                        array('name' => 'aro', 'rname' => 'Архитектурные Решения Отдельный Вход', 'pname' => 'Архитектурные Решения', 'sname' => 'АР', 'price' => '150'),
                        array('name' => 'arop', 'rname' => 'Архитектурное Решение Отдельного Входа с Приямком', 'pname' => 'Архитектурные Решения', 'sname' => 'АР', 'price' => '150'),
                        array('name' => 'visit', 'rname' => 'Выезд на объект', 'price' => '0'),
                        array('name' => 'pecsb', 'rname' => 'Печать и сбор проекта', 'price' => '0'),
                        );

/*
|--------------------------------------------------------------------------
| Согласование
|--------------------------------------------------------------------------
|
|  rname = string
|    - Название на русском
|
|  ins = bool
|    - Инстанция (да\нет)
|
|  names = array
|    - Если (ins = 1) обязательное поле
}    - Список полей которые вхлжят в эту инстанцию
|
|  name = string
|    - Короткое название на английском как индентификатор
|
|  price = string
|    - Цена по умолчанию, если есть
|
*/
$config['instance'] = array(
                            array('rname' => 'Получение исходно-разрешительной документации', 'ins' => '1', 'names' => array('pppib', 'sp', 'votsz', 'paov')),
                                array('rname' => 'Поэтажные планы ПИБ', 'name' => 'pppib', 'price' => '2000'),
                                array('rname' => 'Ситуационный план', 'name' => 'sp', 'price' => '2000'),
                                array('rname' => 'Выписка о техническом состоянии здания', 'name' => 'votsz', 'price' => '2000'),
                                array('rname' => 'Получение акта обследования вентканалов', 'name' => 'paov', 'price' => '2000'),
                            array('rname' => 'Жилищно-эксплуатационные органы', 'ins' => '1', 'names' => array('type', 'sooz', 'sbd')),
                                array('rname' => 'ТУ по электрике', 'name' => 'type', 'price' => '2000'),
                                array('rname' => 'Справка об отсутствии задолженности', 'name' => 'sooz', 'price' => '2000'),
                                array('rname' => 'Согласование балансодержателя дома (ТСЖ, ГУЖА, УК)', 'name' => 'sbd', 'price' => '5000'),
                            array('rname' => 'Государственное унитарное предприятие «Водоканал Санкт-Петербурга»', 'ins' => '1', 'names' => array('typviv')),
                                array('rname' => 'ТУ по водоотведению и канализированию', 'name' => 'typviv', 'price' => '2000'),
                            array('rname' => 'Органы санитарно-эпидемиологической службы', 'ins' => '1', 'names' => array('zfgyz')),
                                array('rname' => 'Заключение ФГУЗ', 'name' => 'zfgyz', 'price' => '10000'),
                            array('rname' => 'Государственный пожарный надзор Санкт-Петербурга', 'ins' => '1', 'names' => array('zogpn', 'sogogpn')),
                                array('rname' => 'Согласование ОГПН', 'name' => 'sogogpn', 'price' => '10000'),
                                array('rname' => 'Заключение ОГПН', 'name' => 'zogpn', 'price' => '10000'),
                            array('rname' => 'Проектно-инвентаризационное бюро', 'ins' => '1', 'names' => array('ptp', 'ptppib', 'ppib')),
                                array('rname' => 'Получение технического паспорта', 'name' => 'ptp', 'price' => '2000'),
                                array('rname' => 'Получение технического плана ПИБ', 'name' => 'ptppib', 'price' => '2000'),
                                array('rname' => 'Переобмер ПИБ', 'name' => 'ppib', 'price' => '2000'),
                            array('rname' => 'Комитет по государственному контролю, использованию и охране памятников истории и культуры Санкт-Петербурга', 'ins' => '1', 'names' => array('sokgiop', 'zkgiop', 'skgiop', 'zakgiop')),
                                array('rname' => 'Справка КГИОП о статусе здания', 'name' => 'sokgiop', 'price' => '0'),
                                array('rname' => 'Задание КГИОП', 'name' => 'zkgiop', 'price' => '10000'),
                                array('rname' => 'Согласование КГИОП', 'name' => 'skgiop', 'price' => '10000'),
                                array('rname' => 'Заключение КГИОП', 'name' => 'zakgiop', 'price' => '10000'),
                            array('rname' => 'Комитет по градостроительству и архитектуре', 'ins' => '1', 'names' => array('pkga', 'zkga', 'skga', 'apzkga', 'sops', 'pokobl', 'ptppt')),
                                array('rname' => 'Письмо КГА', 'name' => 'pkga', 'price' => '30000'),
                                array('rname' => 'Согласование КГА', 'name' => 'skga', 'price' => '30000'),
                                array('rname' => 'Заключение КГА', 'name' => 'zkga', 'price' => '10000'),
                                array('rname' => 'АПЗ КГА', 'name' => 'apzkga', 'price' => '10000'),
                                array('rname' => 'Согласование ОПС', 'name' => 'sops', 'price' => '10000'),
                                array('rname' => 'Получение колерного бланка', 'name' => 'pokobl', 'price' => '5000'),
                                array('rname' => 'Получение топосъёмки (пятисотка)', 'name' => 'ptppt', 'price' => '3000'),
                            array('rname' => 'Проектные, экспертно-технические и строительные организации', 'ins' => '1', 'names' => array('dsrodnp', 'ep')),
                                array('rname' => 'Пакет документов для ввода объекта в эксплуатацию', 'name' => 'dsrodnp', 'price' => '8000'),
                                array('rname' => 'Экспертиза проекта', 'name' => 'ep', 'price' => '10000'),
                            array('rname' => 'Комитет по управлению городским имуществом Санкт-Петербурга', 'ins' => '1', 'names' => array('zvkygi')),
                                array('rname' => 'Заявление в КУГИ', 'name' => 'zvkygi', 'price' => '2000'),
                            array('rname' => 'Федеральное агенство по управлению государственным имуществом', 'ins' => '1', 'names' => array('sfaugi')),
                                array('rname' => 'Согласование ФАУГИ', 'name' => 'sfaugi', 'price' => '10000'),
                            array('rname' => 'Районная Межведомственная комиссия', 'ins' => '1', 'names' => array('spvmvk', 'vove', 'suvpvmk')),
                                array('rname' => 'Решение МВК', 'name' => 'spvmvk', 'price' => '10000'),
                                array('rname' => 'АКТ МВК', 'name' => 'vove', 'price' => '10000'),
                                array('rname' => 'Согласование установки времнной перегородки в межквартирном коридоре', 'name' => 'suvpvmk', 'price' => '5000'),
                            array('rname' => 'Управление Федеральной службы государственной регистрации, кадастра и картографии по Санкт-Петербургу', 'ins' => '1', 'names' => array('psogrps')),
                                array('rname' => 'Получение свидетельства о государственной регистрации права собственности', 'name' => 'psogrps', 'price' => '2500'),
                            array('rname' => 'Государственная Административно-Техническая Инспекция', 'ins' => '1', 'names' => array('ponpsr', 'zaor')),
                                array('rname' => 'Получение ордера на производство строительных работ', 'name' => 'ponpsr', 'price' => '100000'),
                                array('rname' => 'Закрытие ордера', 'name' => 'zaor', 'price' => '10000'),
                            array('rname' => 'Федеральная кадастровая палата по Санкт-Петербургу', 'ins' => '1', 'names' => array('pkadpas')),
                                array('rname' => 'Получение кадастрового паспорта', 'name' => 'pkadpas', 'price' => '2000'),
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
    array('name' => '№',                             'value' => 'loop.index',    'allow' => '2,3,4,6', 'self' => 'width="1%" class="number"', 'form' => 0, 'add' => 0),
    array('name' => 'Дата',                           'value' => 'date',          'allow' => '2,3,4,6', 'date-format' => 'd.m.y', 'self' => 'width="1%" align="center"', 'form' => 0, 'add' => 0),
    array('name' => 'Клиент',                         'value' => 'cid',        'allow' => '2,3,4,6', 'self' => 'id="clnt"', 'type' => 'select', 'form' => 0, 'view' => 0),
    //array('name' => 'ФИО',                            'value' => 'fname',         'allow' => '0,2,3,6', 'self' => 'class="span2"', 'add' => 0),
	array('name' => 'Фамилия',                        'value' => 'zsurname',      'allow' => '0,2,3,6', 'self' => 'class="span2"', 'view' => 0),
	array('name' => 'Имя',                            'value' => 'zname',         'allow' => '0,2,3,6', 'self' => 'class="span2"'),
	array('name' => 'Отчество',                       'value' => 'zmname',        'allow' => '0,2,3,6', 'self' => 'class="span2"', 'view' => 0),
    array('name' => 'Организация',                    'value' => 'organization',  'allow' => '0,2,3,6', 'self' => 'class="span3"', 'view' => 0, 'form' => 0),
    array('name' => 'Телефон',                        'value' => 'phone',         'allow' => '0,2,3,6', 'self' => 'class="span3" id="phone"', 'view' => 0),
    array('name' => 'Email адрес',                    'value' => 'email',         'allow' => '0,2,3,6', 'self' => 'class="span3"', 'view' => 0),
    array('name' => 'Район',                          'value' => 'region',        'allow' => '2,3,6', 'type' => 'select', 'view' => 0),
    array('name' => 'Район',                          'value' => 'region',        'allow' => '4', 'type' => 'select', 'self' => 'class="span3"'),
    array('name' => 'Адрес',                          'value' => 'address',       'allow' => '2,3,4,6', 'self' => 'class="span4"'),
    array('name' => 'Откуда узнали',                  'value' => 'hear',          'allow' => '0,2,3,6', 'view' => 0, 'form' => 0),
    array('name' => 'Дополнительная информация',      'value' => 'more',          'allow' => '0,2,3,4,6', 'view' => 0, 'type' => 'textarea', 'self' => 'class="span3 wysihtml5" rows="5"', 'add' => 1, 'form' => 0),
    array('name' => 'Назначение здания',              'value' => 'ztype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Назначение помещения',           'value' => 'ptype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Название проекта',               'value' => 'name',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span3 wysihtml5" rows="5"'),
    array('name' => 'Стадийность проекта',            'value' => 'rtype',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Площадь объекта',                'value' => 'footage',       'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Файлы',                          'value' => 'vdocs',         'allow' => '2,3,4,6', 'self' => 'class="span1"', 'form' => 0, 'add' => 0),
    array('name' => 'Комент',                         'value' => 'comments',      'allow' => '2,3,4,6', 'self' => 'class="span1"', 'form' => 0, 'add' => 0),
    array('name' => 'Статус',                         'value' => 'status',        'allow' => '2,3,4,6', 'self' => 'class="span1"', 'form' => 0, 'add' => 0),
    array('name' => 'Работники',                      'value' => 'workers',       'allow' => '2,6', 'self' => 'class="span1"', 'form' => 0, 'add' => 0),
    array('name' => 'Состав проектной документации',  'value' => 'razd',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    //array('name' => 'Примечание ПД',                  'value' => 'pmore',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Объём работ ПД',                 'value' => 'total',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'add-on' => 'ч.'),
    array('name' => 'Согласование',                   'value' => 'instance',      'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    //array('name' => 'Примечание согл.',               'value' => 'smore',         'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Общий объём работ',              'value' => 'atotal',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'дн.'),
    array('name' => 'Название проекта для КП',        'value' => 'kpname',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Предварительный расчёт',         'value' => 'traspr',        'allow' => '2,3,6', 'view' => 0, 'add' => 0),
    array('name' => 'Скидка',                         'value' => 'kpsale',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => '%'),
    array('name' => 'Итого с учётом скидки',          'value' => 'kptotsale',     'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'руб.'),
    array('name' => 'Примечание КП',                  'value' => 'kpmore',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    //array('name' => 'КП',                             'value' => 'kp',            'allow' => '2,6', 'form' => 0, 'self' => 'class="span3"'),
    array('name' => 'Действия',                       'value' => 'actions',       'allow' => '2,3,4,6', 'self' => 'width="5%"', 'form' => 0, 'add' => 0)
);
?>