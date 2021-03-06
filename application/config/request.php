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
                            array('name' => 'За 30 дней', 'uri' => 'mz3dn', 'allow' => '3', 'logic' => 'mid:usr?date>2419200'),
                            array('name' => 'Необработанные заявки с сайта', 'uri' => 'mSite', 'allow' => '3', 'logic' => 'mid:0'),
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
                            array('name' => 'Все', 'uri' => 'pAll', 'allow' => '4', 'logic' => 'uid:0?kp:1,uid:usr?kp!2'),
                            array('name' => 'Актуальные заявки', 'uri' => 'pAkt', 'allow' => '4', 'logic' => 'uid:0?kp:1,uid:usr?date>2419200?kp!2', 'default' => '1'),
                            array('name' => 'Новые', 'uri' => 'pNew', 'allow' => '4', 'logic' => 'uid:0?kp:1'),
                            array('name' => 'В работе', 'uri' => 'pInWork', 'allow' => '4', 'logic' => 'uid:usr?kp:1'),
                            array('name' => 'Завершённые', 'uri' => 'pCompleted', 'allow' => '4', 'logic' => 'uid:usr?kp:3,uid:usr?kp:4,uid:usr?kp:5,uid:usr?kp:6,uid:usr?kp:7'),
                        // Отдел согласования - id = 5
                            array('name' => 'Все', 'uri' => 'sAll', 'allow' => '5', 'logic' => 'id:0', 'default' => '1'),
                        // Руководство - id = 6
                            array('name' => 'Все', 'uri' => 'rAll', 'allow' => '2,6', 'logic' => 'all'),
                            array('name' => 'Актуальные заявки', 'uri' => 'rAkt', 'allow' => '2,6', 'logic' => 'date>2419200?kp!13', 'default' => '1'),
                            array('name' => 'За 30 дней', 'uri' => 'rz3dn', 'allow' => '2,6', 'logic' => 'date>2419200'),
                            array('name' => 'Необработанные заявки с сайта', 'uri' => 'rSite', 'allow' => '2,6', 'logic' => 'mid:0'),
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
                                array('name' => 'Отказался', 'fullname' => 'Нажмите если заказчик отказался', 'class' => 'important', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/otkaz/'),
                                array('name' => 'Согласился', 'fullname' => 'Нажмите если заказчик согласился', 'class' => 'success', 'allow' => '3', 'logic' => 'ikp:6', 'uri' => '/request/send/inwork/'),
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
                        array('name' => 'paz', 'rname' => 'Паспорт фасада здания', 'pname' => 'Паспорт фасада здания', 'sname' => 'Паспорт фасада здания', 'price' => '0'),
                        array('name' => 'pifvz', 'rname' => 'Проект изменения фасадного вида здания', 'pname' => 'Проект изменения фасадного вида здания', 'sname' => 'Проект изменения фасадного вида здания', 'price' => '0'),
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
                                array('rname' => 'ТУ по водоотведению и канализации', 'name' => 'typviv', 'price' => '2000'),
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
                                array('rname' => 'Справка КГИОП о статусе здания', 'name' => 'sokgiop', 'price' => '2000'),
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
                            array('rname' => 'Комитет по управлению городским имуществом Санкт-Петербурга', 'ins' => '1', 'names' => array('zvkygi', 'soglkygi')),
                                array('rname' => 'Заявление в КУГИ', 'name' => 'zvkygi', 'price' => '2000'),
                                array('rname' => 'Согласование КУГИ', 'name' => 'soglkygi', 'price' => '10000'),
                            array('rname' => 'Федеральное агенство по управлению государственным имуществом', 'ins' => '1', 'names' => array('sfaugi')),
                                array('rname' => 'Согласование ФАУГИ', 'name' => 'sfaugi', 'price' => '10000'),
                            array('rname' => 'Районная Межведомственная комиссия', 'ins' => '1', 'names' => array('spvmvk', 'vove', 'suvpvmk')),
                                array('rname' => 'Решение МВК', 'name' => 'spvmvk', 'price' => '10000'),
                                array('rname' => 'АКТ МВК', 'name' => 'vove', 'price' => '10000'),
                                array('rname' => 'Согласование установки времнной перегородки в межквартирном коридоре', 'name' => 'suvpvmk', 'price' => '5000'),
                            array('rname' => 'Администрация района', 'ins' => '1', 'names' => array('perevodvnezilfond')),
                                array('rname' => 'Перевод в нежилой фонд', 'name' => 'perevodvnezilfond', 'price' => '5000'),
                            array('rname' => 'Управление Федеральной службы государственной регистрации, кадастра и картографии по Санкт-Петербургу', 'ins' => '1', 'names' => array('psogrps', 'vnesenieizmeneniyvegrp')),
                                array('rname' => 'Получение свидетельства о государственной регистрации права собственности', 'name' => 'psogrps', 'price' => '2500'),
                                array('rname' => 'Внесение изменений в ЕГРП', 'name' => 'vnesenieizmeneniyvegrp', 'price' => '0'),
                            array('rname' => 'Государственная Административно-Техническая Инспекция', 'ins' => '1', 'names' => array('ponpsr', 'zaor')),
                                array('rname' => 'Получение ордера на производство строительных работ', 'name' => 'ponpsr', 'price' => '100000'),
                                array('rname' => 'Закрытие ордера', 'name' => 'zaor', 'price' => '10000'),
                            array('rname' => 'Федеральная кадастровая палата по Санкт-Петербургу', 'ins' => '1', 'names' => array('pkadpas')),
                                array('rname' => 'Получение старого кадастрового паспорта (росреестр)', 'name' => 'pstarkadpas', 'price' => '2000'),
                                array('rname' => 'Получение кадастрового паспорта', 'name' => 'pkadpas', 'price' => '2000'),
                        );
/*
|--------------------------------------------------------------------------
| Инстанции для worktype
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
$config['workins'] = array(
    array('rname' => 'МВК', 'name' => 'mvk'),
    array('rname' => 'ПИБ', 'name' => 'pib'),
);
/*
|--------------------------------------------------------------------------
| Виды работ
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
$config['worktype'] = array(
    array('rname' => 'Правоустанавливающие документы', 'name' => 'pravodoki', 'type' => 'bool', 'ord' => '1', 'names' => array(
        array('rname' => 'Свидетельство ФРС', 'name' => 'svidetalstvofrs', 'type' => 'bool', 'ord' => '1', 'names' => array(
            //array('rname' => 'статус', 'name' => 'svidetalstvofrsstatus', 'type' => 'bool'),
            array('rname' => 'Дата', 'name' => 'svidetalstvofrsdata', 'type' => 'date'),
        )),
        array('rname' => 'Договор основания', 'name' => 'dogovorosnovaniya', 'type' => 'bool', 'ord' => '2', 'names' => array(
            //array('rname' => 'статус', 'name' => 'dogovorosnovaniyastatus', 'type' => 'bool'),
            array('rname' => 'Дата', 'name' => 'dogovorosnovaniyadata', 'type' => 'date'),
        )),
        array('rname' => 'Доверенность / срок окончания', 'name' => 'doverennstsrokokonchaniya', 'type' => 'bool', 'ord' => '3', 'names' => array(
            //array('rname' => 'статус', 'name' => 'doverennstsrokokonchaniyastatus', 'type' => 'bool'),
            array('rname' => 'Дата', 'name' => 'doverennstsrokokonchaniyadata', 'type' => 'date'),
        )),
        array('rname' => 'Кад. паспорт', 'name' => 'kadpassport', 'type' => 'bool', 'ord' => '4', 'names' => array(
            //array('rname' => 'статус', 'name' => 'kadpassportstatus', 'type' => 'bool'),
            array('rname' => 'Дата', 'name' => 'kadpassportdata', 'type' => 'date'),
        )),
        array('rname' => 'Тех. паспорт ПИБ', 'name' => 'tehpassportpib', 'type' => 'bool', 'ord' => '5', 'names' => array(
            //array('rname' => 'статус', 'name' => 'tehpassportpibstatus', 'type' => 'bool'),
            array('rname' => 'Дата', 'name' => 'tehpassportpibdata', 'type' => 'date'),
        )),
        array('rname' => 'Разрешительное письмо КГА', 'name' => 'pravodokirazreshitelnoepismokga', 'type' => 'bool', 'ord' => '6', 'names' => array(
            array('rname' => 'Дата', 'name' => 'pravodokirazreshitelnoepismokgapol', 'type' => 'date', 'ord' => '1'),
        )),
    )),
    array('rname' => 'Получение ИРД', 'name' => 'pird', 'type' => 'bool', 'ord' => '2', 'names' => array(
        array('rname' => 'Акт вентканалов', 'name' => 'aktventkanalov', 'type' => 'bool', 'ord' => '1', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'aktventzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'aktventopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'aktventpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Ф-7, Ф-9', 'name' => 'f7f8', 'type' => 'bool', 'ord' => '2', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'f7f9zak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'f7f9pol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Поэтажные планы выше/ниже', 'name' => 'poetazhplan', 'type' => 'bool', 'ord' => '3', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'poetazhplanzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'poetazhplanopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'poetazhplanpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Топосъемка (планы под/над коммуникаций)', 'name' => 'pirdtoposemka', 'type' => 'bool', 'ord' => '4', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'pirdtoposemkazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'pirdtoposemkaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'pirdtoposemkapol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Выписка тех. состояния', 'name' => 'vipiskatehsostoyaniya', 'type' => 'bool', 'ord' => '5', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'vipiskatehsostoyaniyazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'vipiskatehsostoyaniyaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'vipiskatehsostoyaniyapol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'ТУ по электрике', 'name' => 'typoelektrike', 'type' => 'bool', 'ord' => '6', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'typoelektrikezak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'typoelektrikeopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'typoelektrikepol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'ТУ по водоотведению и канализированию', 'name' => 'typovodootvedeniyikanalizirovaniy', 'type' => 'bool', 'ord' => '7', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'typovodootvedeniyikanalizirovaniyzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'typovodootvedeniyikanalizirovaniyopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'typovodootvedeniyikanalizirovaniypol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Тех. паспорт ПИБ', 'name' => 'tehplannakvartiry', 'type' => 'bool', 'ord' => '8', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'tehplannakvartiryzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'tehplannakvartiryopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'tehplannakvartirypol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Справка о статусе здания КГИОП', 'name' => 'spravkaostatusezdaniya', 'type' => 'bool', 'ord' => '9', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'spravkaostatusezdaniyazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'spravkaostatusezdaniyapol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Задание КГИОП', 'name' => 'zadaniekgiop', 'type' => 'bool', 'ord' => '10', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'zadaniekgiopzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'zadaniekgioppol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Согласие соседей', 'name' => 'soglasiesosedei', 'type' => 'bool', 'ord' => '11', 'names' => array(
            //array('rname' => 'Заказан', 'name' => 'soglasiesosedeizak', 'type' => 'date'),
            array('rname' => 'Получен', 'name' => 'soglasiesosedeipol', 'type' => 'date'),
        )),
        array('rname' => 'Получение письма КГА', 'name' => 'polucheniepismokga', 'type' => 'bool', 'ord' => '12', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'poluchenieppismokgazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'poluchenieppismokgapol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Продление письма КГА', 'name' => 'prodleniepismokga', 'type' => 'bool', 'ord' => '13', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'prodleniepismokgazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'prodleniepismokgapol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'АПЗ КГА', 'name' => 'pirdapzkga', 'type' => 'bool', 'ord' => '14', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'pirdapzkgazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'pirdapzkgaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'pirdapzkgapol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Городостроительный план КГА', 'name' => 'pirdgorodostplankga', 'type' => 'bool', 'ord' => '15', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'pirdgorodostplankgazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'pirdgorodostplankgaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'pirdgorodostplankgapol', 'type' => 'date', 'ord' => '3'),
        )),
    )),
    array('rname' => 'Проектирование', 'name' => 'proekti', 'type' => 'bool', 'ord' => '3', 'names' => array(
        array('rname' => 'Перепланировка жилого помещения', 'name' => 'proektipereplankvart', 'type' => 'bool', 'ord' => '1', 'names' => array(
            array('rname' => 'Техническое задание', 'name' => 'proektipereplankvarttz', 'type' => 'bool', 'ord' => '1', 'names' => array(
                array('rname' => 'Заказан', 'name' => 'proektipereplankvarttzzak', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Получен', 'name' => 'proektipereplankvarttzpol', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ТО/ТЗ', 'name' => 'proektipereplankvarttotz', 'type' => 'bool', 'ord' => '2', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvarttotzplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvarttotzvk', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'АР', 'name' => 'proektipereplankvartar', 'type' => 'bool', 'ord' => '2', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartarplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartarvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ВК', 'name' => 'proektipereplankvartvk', 'type' => 'bool', 'ord' => '3', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartvkplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartvkvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ЭО', 'name' => 'proektipereplankvarteo', 'type' => 'bool', 'ord' => '4', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvarteoplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvarteovp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'КР', 'name' => 'proektipereplankvartkr', 'type' => 'bool', 'ord' => '5', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartkrplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartkrvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ОВ', 'name' => 'proektipereplankvartov', 'type' => 'bool', 'ord' => '6', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartovplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartovvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ОПС', 'name' => 'proektipereplankvartops', 'type' => 'bool', 'ord' => '7', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartopsplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartopsvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ТХ', 'name' => 'proektipereplankvartth', 'type' => 'bool', 'ord' => '8', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplankvartthplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplankvartthvp', 'type' => 'date', 'ord' => '2'),
            )),
        )),
        array('rname' => 'Перепланировка нежилого помещения', 'name' => 'proektipereplannezil', 'type' => 'bool', 'ord' => '2', 'names' => array(
            array('rname' => 'Техническое задание', 'name' => 'proektipereplanneziltz', 'type' => 'bool', 'ord' => '1', 'names' => array(
                array('rname' => 'Заказан', 'name' => 'proektipereplanneziltzzak', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Получен', 'name' => 'proektipereplanneziltzpol', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ТО/ТЗ', 'name' => 'proektipereplanneziltotz', 'type' => 'bool', 'ord' => '2', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplanneziltotzplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplanneziltotzvk', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'АР', 'name' => 'proektipereplannezilar', 'type' => 'bool', 'ord' => '3', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilarplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilarvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ВК', 'name' => 'proektipereplannezilvk', 'type' => 'bool', 'ord' => '4', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilvkplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilvkvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ЭО', 'name' => 'proektipereplannezileo', 'type' => 'bool', 'ord' => '5', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezileoplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezileovp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'КР', 'name' => 'proektipereplannezilkr', 'type' => 'bool', 'ord' => '6', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilkrplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilkrvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ОВ', 'name' => 'proektipereplannezilov', 'type' => 'bool', 'ord' => '7', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilovplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilovvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ОПС', 'name' => 'proektipereplannezilops', 'type' => 'bool', 'ord' => '8', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilopsplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilopsvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'ТХ', 'name' => 'proektipereplannezilth', 'type' => 'bool', 'ord' => '9', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektipereplannezilthplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektipereplannezilthvp', 'type' => 'date', 'ord' => '2'),
            )),
        )),
        array('rname' => 'Концепция кондиционеры', 'name' => 'proektikonchepkondich', 'type' => 'bool', 'ord' => '3', 'names' => array(
            array('rname' => 'Планируемая дата', 'name' => 'proektikonchepkondichplan', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Выполнен', 'name' => 'proektikonchepkondichvp', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Паспорт фасада здания', 'name' => 'proektipassport', 'type' => 'bool', 'ord' => '4', 'names' => array(
            array('rname' => 'Планируемая дата', 'name' => 'proektipassportplan', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Выполнен', 'name' => 'proektipassportvp', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Проект изменения фасадного вида', 'name' => 'proektizmeneniyafasada', 'type' => 'bool', 'ord' => '5', 'names' => array(
            array('rname' => 'Планируемая дата', 'name' => 'proektizmeneniyafasadaplan', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Выполнен', 'name' => 'proektizmeneniyafasadavp', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Проект устройства отдельного входа', 'name' => 'proektizmeneniefasad', 'type' => 'bool', 'ord' => '6', 'names' => array(
            array('rname' => 'КЖ', 'name' => 'proektizmeneniefasadkj', 'type' => 'bool', 'ord' => '1', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektizmeneniefasadkjplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektizmeneniefasadkjvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'КМ', 'name' => 'proektizmeneniefasadkm', 'type' => 'bool', 'ord' => '2', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektizmeneniefasadkmplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektizmeneniefasadkmvp', 'type' => 'date', 'ord' => '2'),
            )),
            array('rname' => 'АР', 'name' => 'proektizmeneniefasadar', 'type' => 'bool', 'ord' => '3', 'names' => array(
                array('rname' => 'Планируемая дата', 'name' => 'proektizmeneniefasadarplan', 'type' => 'date', 'ord' => '1'),
                array('rname' => 'Выполнен', 'name' => 'proektizmeneniefasadarvp', 'type' => 'date', 'ord' => '2'),
            )),
        )),
    )),
    array('rname' => 'Согласование', 'name' => 'soglasovan', 'type' => 'bool', 'ord' => '4', 'names' => array(
        array('rname' => 'КГА Архитектура', 'name' => 'soglasovankgaar', 'type' => 'bool', 'ord' => '1', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovankgaarzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovankgaarvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovankgaarpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'КГА Отдел подземных сооружений', 'name' => 'soglasovankgaops', 'type' => 'bool', 'ord' => '2', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovankgaopszak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovankgaopsvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovankgaopspol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'КГА Эстетики и городской среды', 'name' => 'soglasovankgaestetigorsred', 'type' => 'bool', 'ord' => '3', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovankgaestetigorsredzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovankgaestetigorsredvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovankgaestetigorsredpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Получение колерного бланка', 'name' => 'soglasovanpolucheniecolernogoblanka', 'type' => 'bool', 'ord' => '4', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanpolucheniecolernogoblankazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'soglasovanpolucheniecolernogoblankaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanpolucheniecolernogoblankapol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'КГИОП', 'name' => 'soglasovankgiop', 'type' => 'bool', 'ord' => '5', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovankgiopzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovankgiopdtvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovankgioppol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'ОГПН согласование', 'name' => 'soglasovanogpn', 'type' => 'bool', 'ord' => '6', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanogpnzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovanogpndtvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanogpnpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Администрация района', 'name' => 'soglasovanadministratraion', 'type' => 'bool', 'ord' => '7', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanadministratraionzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovanadministratraionvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanadministratraionpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Балансодержатель дома', 'name' => 'soglasovanbalansoderzatdom', 'type' => 'bool', 'ord' => '8', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanbalansoderzatdomzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovanbalansoderzatdomvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanbalansoderzatdompol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'КУГИ', 'name' => 'soglasovankugi', 'type' => 'bool', 'ord' => '9', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovankugizak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovankugidtvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovankugipol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'ФГУЗ (СЭС)', 'name' => 'soglasovanfguzses', 'type' => 'bool', 'ord' => '10', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanfguzseszak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovanfguzsesdtvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanfguzsespol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Экспертиза проекта', 'name' => 'soglasovanekspertizaproekta', 'type' => 'bool', 'ord' => '11', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanekspertizaproektazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачено', 'name' => 'soglasovanekspertizaproektaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanekspertizaproektapol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'МВК', 'name' => 'soglasovanmvk', 'type' => 'bool', 'ord' => '12', 'ins' => 'mvk', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'soglasovanmvkzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'soglasovanmvkdtvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'soglasovanmvkpol', 'type' => 'date', 'ord' => '3'),
        )),
    )),
    array('rname' => 'Приемка', 'name' => 'priemka', 'type' => 'bool', 'ord' => '5', 'names' => array(
        array('rname' => 'Строительные документы', 'name' => 'priemkaaktyskrityhrabot', 'type' => 'bool', 'ord' => '1', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkaaktyskrityhrabotzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'priemkaaktyskrityhrabotvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkaaktyskrityhrabotpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Переобмер ПИБ', 'name' => 'priemkapereobmerpib', 'type' => 'bool', 'ord' => '2', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkapereobmerpibzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkapereobmerpibopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkapereobmerpibpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'ОГПН Приёмка', 'name' => 'priemkaogpn', 'type' => 'bool', 'ord' => '3', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkaogpnzak', 'type' => 'date', 'ord' => '1'),
            //array('rname' => 'Дата выполнения', 'name' => 'priemkaogpnvip', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkaogpnpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'КГИОП', 'name' => 'priemkakgiop', 'type' => 'bool', 'ord' => '4', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkakgiopzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'priemkakgioppol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Акт МВК', 'name' => 'priemkaaktmvk', 'type' => 'bool', 'ord' => '5', 'ins' => 'mvk', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkaaktmvkzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Получен', 'name' => 'priemkaaktmvkpol', 'type' => 'date', 'ord' => '2'),
        )),
        array('rname' => 'Тех. паспорт ПИБ', 'name' => 'priemkapatehpassportpib', 'type' => 'bool', 'ord' => '6', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkapatehpassportpibzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkapatehpassportpibopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkapatehpassportpibpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Тех. план', 'name' => 'priemkatehplan', 'type' => 'bool', 'ord' => '7', 'ins' => 'pib', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkatehplanzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkatehplanopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkatehplanpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Старый кадастровый паспорт (росреестр)', 'name' => 'priemkastariykadastroviypasport', 'type' => 'bool', 'ord' => '8', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkastariykadastroviypasportzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkastariykadastroviypasportopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkastariykadastroviypasportpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Кадастровый паспорт', 'name' => 'priemkakadastroviypasport', 'type' => 'bool', 'ord' => '9', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkakadastroviypasportzak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkakadastroviypasportopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkakadastroviypasportpol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'УФРС внесение изменений в ЕГРП', 'name' => 'priemkayfms', 'type' => 'bool', 'ord' => '10', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkayfmszak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkayfmsopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkayfmspol', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'УФРС получение нового свидетельства', 'name' => 'priemkayfrspolucheniesvidetelstva', 'type' => 'bool', 'ord' => '11', 'names' => array(
            array('rname' => 'Заказан', 'name' => 'priemkayfrspolucheniesvidetelstvazak', 'type' => 'date', 'ord' => '1'),
            array('rname' => 'Оплачен', 'name' => 'priemkayfrspolucheniesvidetelstvaopl', 'type' => 'date', 'ord' => '2'),
            array('rname' => 'Получен', 'name' => 'priemkayfrspolucheniesvidetelstvapol', 'type' => 'date', 'ord' => '3'),
        )),
    )),
    array('rname' => 'Работа с заказчиком', 'name' => 'rabotaszak', 'type' => 'bool', 'ord' => '6', 'names' => array(
        array('rname' => 'Предоплата', 'name' => 'rabotaszakpredoplata', 'type' => 'bool', 'ord' => '1', 'names' => array(
            array('rname' => 'Нал', 'name' => 'rabotaszakpredoplatanal', 'type' => 'bool', 'ord' => '1'),
            array('rname' => 'Безнал', 'name' => 'rabotaszakpredoplatabeznal', 'type' => 'bool', 'ord' => '2'),
            array('rname' => 'Дата', 'name' => 'rabotaszakpredoplatadata', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Предоплата', 'name' => 'rabotaszakpredoplata1', 'type' => 'bool', 'ord' => '2', 'names' => array(
            array('rname' => 'Нал', 'name' => 'rabotaszakpredoplata1nal', 'type' => 'bool', 'ord' => '1'),
            array('rname' => 'Безнал', 'name' => 'rabotaszakpredoplata1beznal', 'type' => 'bool', 'ord' => '2'),
            array('rname' => 'Дата', 'name' => 'rabotaszakpredoplata1data', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Оплата квитанций', 'name' => 'rabotaszakoplatakvit', 'type' => 'bool', 'ord' => '3', 'names' => array(
            array('rname' => 'Заказчик', 'name' => 'rabotaszakoplatakvitzak', 'type' => 'bool', 'ord' => '1'),
            array('rname' => 'Профэксперт', 'name' => 'rabotaszakoplatakvitprof', 'type' => 'bool', 'ord' => '2'),
            array('rname' => 'Дата', 'name' => 'rabotaszakoplatakvitdata', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Акт приема выполненных работ', 'name' => 'rabotaszakaktpriemavipolnrabot', 'type' => 'bool', 'ord' => '4', 'names' => array(
            array('rname' => 'Дата', 'name' => 'rabotaszakaktpriemavipolnrabotdata', 'type' => 'date'),
        )),
        array('rname' => 'Окончательный расчет', 'name' => 'rabotaszakokonchatelniyraschet', 'type' => 'bool', 'ord' => '5', 'names' => array(
            array('rname' => 'Нал', 'name' => 'rabotaszakokonchatelniyraschetnal', 'type' => 'bool', 'ord' => '1'),
            array('rname' => 'Безнал', 'name' => 'rabotaszakokonchatelniyraschetbeznal', 'type' => 'bool', 'ord' => '2'),
            array('rname' => 'Дата', 'name' => 'rabotaszakokonchatelniyraschetdata', 'type' => 'date', 'ord' => '3'),
        )),
        array('rname' => 'Приостановить договор', 'name' => 'rabotaszakpriostanovitdogovor', 'type' => 'bool', 'ord' => '6', 'names' => array(
            array('rname' => 'Дата', 'name' => 'rabotaszakpriostanovitdogovordata', 'type' => 'date', 'ord' => '1'),
        )),
        array('rname' => 'Закрыть договор', 'name' => 'rabotaszakzakrytdogovor', 'type' => 'bool', 'ord' => '7', 'names' => array(
            array('rname' => 'Дата', 'name' => 'rabotaszakzakrytdogovordata', 'type' => 'date', 'ord' => '1'),
        )),
    )),
    /*array('rname' => '', 'name' => '', 'type' => '', 'names' => array(
        array('rname' => '', 'name' => '', 'type' => '')
    )),*/
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
    array('name' => 'Адрес',                          'value' => 'address',       'allow' => '2,3,4,6', 'self' => 'class="span4"'),
    array('name' => 'Клиент',                         'value' => 'cid',           'allow' => '2,3,4,6', 'self' => 'id="clnt"', 'type' => 'select', 'form' => 0, 'view' => 0),
    //array('name' => 'ФИО',                            'value' => 'fname',         'allow' => '0,2,3,6', 'self' => 'class="span2"', 'add' => 0),
	array('name' => 'Фамилия',                        'value' => 'zsurname',      'allow' => '0,2,3,6', 'self' => 'class="span2"', 'view' => 0),
	array('name' => 'Имя',                            'value' => 'zname',         'allow' => '0,2,3,6', 'self' => 'class="span1"'),
	array('name' => 'Отчество',                       'value' => 'zmname',        'allow' => '0,2,3,6', 'self' => 'class="span2"', 'view' => 0),
    array('name' => 'Организация',                    'value' => 'organization',  'allow' => '0,2,3,6', 'self' => 'class="span3"', 'view' => 0, 'form' => 0),
    array('name' => 'Телефон',                        'value' => 'phone',         'allow' => '0,2,3,6', 'self' => 'class="span3" id="phone"', 'view' => 0),
    array('name' => 'Email адрес',                    'value' => 'email',         'allow' => '0,2,3,6', 'self' => 'class="span3"', 'view' => 0),
    array('name' => 'Вид работ',                      'value' => 'worktype',      'allow' => '2,3,6', 'type' => 'checkbox', 'self' => 'class="span3"', 'view' => 0),
    //array('name' => 'Район',                          'value' => 'region',        'allow' => '2,3,6', 'type' => 'select', 'view' => 0),
    array('name' => 'Район',                          'value' => 'region',        'allow' => '4', 'type' => 'select', 'self' => 'class="span3"', 'form' => 0),
    array('name' => 'Откуда узнали',                  'value' => 'hear',          'allow' => '0,2,3,6', 'view' => 0, 'form' => 0),
    array('name' => 'Дополнительная информация',      'value' => 'more',          'allow' => '0,2,3,4,6', 'view' => 0, 'type' => 'textarea', 'self' => 'class="span3 wysihtml5" rows="5"', 'add' => 1, 'form' => 0),
    array('name' => 'Назначение здания',              'value' => 'ztype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Назначение помещения',           'value' => 'ptype',         'allow' => '2,3,4,6', 'view' => 0, 'type' => 'select'),
    array('name' => 'Название проекта',               'value' => 'name',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span3 wysihtml5" rows="5"'),
    array('name' => 'Стадийность проекта',            'value' => 'rtype',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Площадь объекта',                'value' => 'footage',       'allow' => '2,3,4,6', 'view' => 0, 'add' => 0),
    array('name' => 'Статус',                         'value' => 'status',        'allow' => '2,3,4,6', 'self' => 'class="span1"', 'form' => 0, 'add' => 0),
    array('name' => 'Работники',                      'value' => 'workers',       'allow' => '2,6', 'self' => 'width="1%"', 'form' => 0, 'add' => 0),
    array('name' => '[ Ф ]',                          'value' => 'vdocs',         'allow' => '2,3,4,6', 'self' => 'width="1%"', 'self1' => 'data-toggle="tooltip" data-original-title="Файлы"', 'form' => 0, 'add' => 0),
    array('name' => '[ К ]',                          'value' => 'comments',      'allow' => '2,3,4,6', 'self' => 'width="1%"', 'self1' => 'data-toggle="tooltip" data-original-title="Комментарии"', 'form' => 0, 'add' => 0),
    array('name' => 'Состав проектной документации',  'value' => 'razd',          'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    //array('name' => 'Примечание ПД',                  'value' => 'pmore',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Объём работ ПД',                 'value' => 'total',         'allow' => '2,3,4,6', 'view' => 0, 'add' => 0, 'add-on' => 'ч.'),
    array('name' => 'Согласование',                   'value' => 'instance',      'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'checkbox'),
    //array('name' => 'Примечание согл.',               'value' => 'smore',         'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Общий объём работ',              'value' => 'atotal',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'дн.'),
    array('name' => 'Название проекта для КП',        'value' => 'kpname',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    array('name' => 'Предварительный расчёт',         'value' => 'traspr',        'allow' => '2,3,6', 'view' => 0, 'add' => 0),
    array('name' => 'Текст скидки',                   'value' => 'kpsaletext',    'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'По умолчанию: "Скидка"'),
    array('name' => 'Скидка',                         'value' => 'kpsale',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => '%'),
    array('name' => 'Текст итого с учётом скидки',    'value' => 'kptotsaletext',     'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'По умолчанию: "Итого с учётом скидки"'),
    array('name' => 'Итого с учётом скидки',          'value' => 'kptotsale',     'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'add-on' => 'руб.'),
    array('name' => 'Примечание КП',                  'value' => 'kpmore',        'allow' => '2,3,6', 'view' => 0, 'add' => 0, 'type' => 'textarea', 'self' => 'class="span10 wysihtml5" rows="10"'),
    //array('name' => 'КП',                             'value' => 'kp',            'allow' => '2,6', 'form' => 0, 'self' => 'class="span3"'),
    array('name' => 'Действия',                       'value' => 'actions',       'allow' => '2,3,4,6', 'self' => 'width="5%"', 'form' => 0, 'add' => 0)
);
?>