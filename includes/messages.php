<?
///////////////
// [RUSSIAN] //
///////////////
// наименования
$MSG["RU"]["NMainPage"] = "Главная";
$MSG["RU"]["VarInterfaceLang"] = "Язык интерфейса CMS";
$MSG["RU"]["VarCMSVersion"] = "Версия системы управления";
$MSG["RU"]["VarCMSNewsCount"] = "Количество анонсов новостей";
$MSG["RU"]["VarCMSRSSCount"] = "Количество анонсов rss-новостей";
$MSG["RU"]["VarCMSWebsiteName"] = "Общее название ресурса";
$MSG["RU"]["VarCMSMailToSend"] = "EMail для обратной связи";
$MSG["RU"]["VarCMSMailToSendCat"] = "EMail для отправки заявок";
$MSG["RU"]["VarCMSMailToSendErr"] = "EMail для отправки ошибок";
$MSG["RU"]["VarCMSSiteOff"] = "Сайт временно отключен";
$MSG["RU"]["VarCMSShowPrice"] = "Отображать кнопку \"Заказать\"";
$MSG["RU"]["VarCMSMailingServer"] = "Почтовый сервер рассылки";
$MSG["RU"]["VarCMSMailingUser"] = "Имя пользователя адреса рассылки";
$MSG["RU"]["VarCMSMailingPass"] = "Пароль пользователя адреса рассылки";
$MSG["RU"]["VarCMSMailingEMail"] = "Обратный e-mail рассылки";
$MSG["RU"]["VarCMSOfferVariants"] = "Предлагать варианты, если не найдено";
$MSG["RU"]["VarCMSIPagesCount"] = "Количество инфостраниц на главной странице";
$MSG["RU"]["VarCMSShowGroupCount"] = "Отображать кол-во организаций в группах";
$MSG["RU"]["VarCMSIPagesLimit"] = "Количество инфостраниц в перечне";
$MSG["RU"]["VarCMSNewsLimit"] = "Ограничение размера краткой новости";
$MSG["RU"]["VarCMSPhoneLimit"] = "Ограничение количество телефонов у организации";
$MSG["RU"]["VarCMSAutoShow"] = "Показывать тематику в разделе автомобили";
$MSG["RU"]["VarCMSVacsCount"] = "Количество кадров на главной";
$MSG["RU"]["VarCMSPanelNumber"] = "Номер панельки для отображения (1 - 4)";
$MSG["RU"]["VarCMSSubscrFrom"] = "Email, от которого идёт рассылка";
$MSG["RU"]["VarCMSShowMySQLErrors"] = "Показывать ошибки MySQL";
$MSG["RU"]["VarCMSPhone"] = "Контактный телефон";
$MSG["RU"]["VarCMSEMail"] = "Контактный EMail";
$MSG["RU"]["VarCMSEMailOnMain"] = "EMail на главной странице";
$MSG["RU"]["VarCMSPhoneOnMain"] = "Телефон на главной странице";
$MSG["RU"]["VarCMSMailToSendBack"] = "EMail для отправки сообщений";
$MSG["RU"]["VarCMSAdminEMail"] = "EMail администратора сайта";
$MSG["RU"]["VarCMSMainPhone"] = "Контактный телефон";
$MSG["RU"]["VarCMSMainText"] = "Основной текст";
$MSG["RU"]["VarCMSMainAddress"] = "Основной адрес";
$MSG["RU"]["VarCMSMainEMail"] = "Основной email";
// сообщения
$MSG["RU"]["MsgCheckDBParams"] = "Программа установки обнаружила, что соединение с базой данных отсутствует. Проверьте параметры доступа к ней:";
$MSG["RU"]["MsgDescrDBParams"] = "Для работы системы управления сайтом RoachCMS требуется наличие и правильно настроенное соединение с базой данных MySQL (далее БД).<br />Параметры доступа к ней включают в себя адрес сервера (в случае, если БД установлена на том же сервере, что и PHP, используется адрес localhost),<br />наименование БД, а также имя и пароль пользователя БД, которые Вы можете получить у организации, предоставляющей хостинг.<br />В случае, если не удастся изменить параметры доступа автоматически, Вам будет предложено сохранить файл db.php.<br />Этот файл необходимо отправить на сервер вручную в директорию admin (например, с помощью программы доступа по протоколу FTP)";
$MSG["RU"]["MsgSaveFail"] = "Автоматическая запись файла /admin/db.php не удалась, сохраните файл и замените его вручную для доступа к БД";
$MSG["RU"]["MsgAccessBlocked"] = "После третьей неправильной попытки доступ заблокирован, обратитесь к администратору";
$MSG["RU"]["MsgNoAccess"] = "Введен неверный логин или пароль";
$MSG["RU"]["MsgDeptsOrderChanged"] = "Порядок следования разделов изменён";
$MSG["RU"]["MsgAttrsOrderChanged"] = "Порядок следования атрибутов изменён";
$MSG["RU"]["MsgGoodsOrderChanged"] = "Порядок следования товаров изменён";
$MSG["RU"]["MsgDeptStatus"] = "Статус раздела изменён";
$MSG["RU"]["MsgGoodStatus"] = "Статус товара изменён";
$MSG["RU"]["MsgDeptMoved"] = "Раздел перенесён";
$MSG["RU"]["MsgDeptExists"] = "Раздел с таким названием уже существует";
$MSG["RU"]["MsgPollStatus"] = "Статус вопроса изменён";
$MSG["RU"]["MsgEmptyDept"] = "Пустое наименование раздела";
$MSG["RU"]["MsgDeptChanged"] = "Параметры раздела изменены";
$MSG["RU"]["MsgKeywordsChanged"] = "Ключевые слова изменены";
$MSG["RU"]["MsgVarsChanged"] = "Настройки изменены";
$MSG["RU"]["MsgDeptOnce"] = "Такой раздел уже существует и должен быть единственным";
$MSG["RU"]["MsgWorkflowStatus"] = "Статус пользователя изменён";
$MSG["RU"]["MsgWorkflowUpdated"] = "Доступ для пользователя изменён";
$MSG["RU"]["MsgLoginExists"] = "Такой логин уже существует";
$MSG["RU"]["MsgSessionFailed"] = "Сессия устарела или ошибочна, попробуйте войти ещё раз";
$MSG["RU"]["MsgNoDeptRights"] = "У Вас нет прав доступа к этому разделу";
$MSG["RU"]["MsgNoMDeptRights"] = "У Вас нет прав доступа к главному разделу";
$MSG["RU"]["MsgEnteredAs"] = "Вы вошли как";
$MSG["RU"]["MsgEmptyGood"] = "Не указана цена или название товара";
$MSG["RU"]["MsgGoodChanged"] = "Параметры товара изменены";
$MSG["RU"]["MsgGoodMoved"] = "Товар перемещен";
$MSG["RU"]["MsgGoodState"] = "Статус товара изменён";
$MSG["RU"]["MsgNoGoodMove"] = "Товар не может быть перемещен (в разделе есть подразделы или уже есть данный товар или указаны не все параметры)";
$MSG["RU"]["MsgAttrExists"] = "Такой атрибут уже есть, выберите из списка существующих для добавления атрибута в данный раздел";
$MSG["RU"]["MsgAttrExists1"] = "Такой атрибут уже есть в данном разделе";
$MSG["RU"]["MsgAttrEmpty"] = "Не указано название атрибута ";
$MSG["RU"]["MsgWordsChanged"] = "Слова изменены";
$MSG["RU"]["MsgContactChanged"] = "Параметры контакта изменены";
$MSG["RU"]["MsgMapCenterUpdated"] = "Центр и зум изменены";
$MSG["RU"]["MsgNoRusLangDelete"] = "Нельзя удалять единственный язык";
// ошибки
$MSG["RU"]["ErrDeptsTableExists"] = "Ошибка обращения к таблице разделов";
$MSG["RU"]["ErrDeptTypesTableExists"] = "Ошибка обращения к таблице типов разделов";
$MSG["RU"]["ErrDeptVarsTableExists"] = "Ошибка обращения к таблице переменных";
$MSG["RU"]["ErrNoConFile"] = "Ошибка загрузки конфигурационного файла";
$MSG["RU"]["ErrInstanceReg"] = "Ошибка регистрации версии системы";
$MSG["RU"]["ErrMetaSelect"] = "Ошибка обращения к мета-данным";
$MSG["RU"]["ErrNewsSelect"] = "Ошибка обращения к БД новостей";
$MSG["RU"]["ErrOpenDir"] = "Ошибка обращения к папке сервера";
$MSG["RU"]["NoParams"] = "Не хватает параметров или они не переданы";
// подтверждения
$MSG["RU"]["ConfDel"] = "Вы уверены?";
$MSG["RU"]["ConfDelLang"] = "Вы уверены? Вся информация на этом языке будет удалена!!!";
// предупреждения
$MSG["RU"]["WarnNoDeptName"] = "Введите название для нового подраздела!";
// кнопки
$MSG["RU"]["ButRenew"] = "Обновить";
$MSG["RU"]["ButTryAgain"] = "Попробовать ещё раз";
$MSG["RU"]["ButFileWritten"] = "Файл заменён, создать сайт";
$MSG["RU"]["ButDBParamsSave"] = "Изменить параметры доступа к БД";
$MSG["RU"]["ButDBSaveToFile"] = "Сохранить в файл";
// надписи и заголовки
$MSG["RU"]["TTLInstallation"] = "Установка системы управления RoachCMS";
$MSG["RU"]["TTLDBPrefix"] = "Префикс названий таблиц";
$MSG["RU"]["TTLDBServer"] = "Сервер базы данных (БД)";
$MSG["RU"]["TTLDBName"] = "Имя базы данных";
$MSG["RU"]["TTLDBUser"] = "Логин пользователя БД";
$MSG["RU"]["TTLDBPassword"] = "Пароль пользователя БД";
$MSG["RU"]["TTLUp"] = "переместить вверх";
$MSG["RU"]["TTLDown"] = "переместить вниз";
$MSG["RU"]["TTLNo"] = "---";
$MSG["RU"]["TTLEditData"] = "Редактировать данные";
$MSG["RU"]["TTLNewsEdit"] = "Редактирование новостей";
$MSG["RU"]["TTLLinksEdit"] = "Редактирование полезных ресурсов";
$MSG["RU"]["TTLGalleryEdit"] = "Редактирование фотогалереи";
$MSG["RU"]["TTLNewsInsEdit"] = "Добавление и редактирование ленты новостей";
$MSG["RU"]["TTLReadmoreLinks"] = "Ссылки \"Читайте также\"";
$MSG["RU"]["TTLRMLinkText"] = "Текст cсылки";
$MSG["RU"]["TTLRMLink"] = "Ccылка";
$MSG["RU"]["TTLMeta"] = "Редактирование мета-тегов страницы (используется в продвижении)";
$MSG["RU"]["TTLMetaTitle"] = "Заголовок";
$MSG["RU"]["TTLMetaVIPTitle"] = "VIP-заголовок";
$MSG["RU"]["TTLMetaDescr"] = "Описание";
$MSG["RU"]["TTLMetaKeywords"] = "Ключевые слова";
$MSG["RU"]["TTLAdd"] = "добавить";
$MSG["RU"]["TTLNotAllowed"] = "недоступно";
$MSG["RU"]["TTLNoModule"] = "Нет доступных модулей";
$MSG["RU"]["TTLTypeName"] = "Наименование";
$MSG["RU"]["TTLTypeFile"] = "Файл";
$MSG["RU"]["TTLTypeEntry"] = "Запись";
$MSG["RU"]["TTLManagement"] = "Управление";
$MSG["RU"]["TTLEnterName"] = "впишите название нового подраздела и нажмите +";
$MSG["RU"]["TTLDeleteDept"] = "Удалить подраздел";
$MSG["RU"]["TTLDeptName"] = "Название подраздела";
$MSG["RU"]["TTLDeptType"] = "Модуль";
$MSG["RU"]["TTLDeptList"] = "Быстрый переход к разделу";
$MSG["RU"]["TTLDeptChoose"] = "Выберите раздел из списка";
$MSG["RU"]["TTLDeptSubDepts"] = "Подразделы раздела";
$MSG["RU"]["TTLDeptEdit"] = "Редактирование разделов";
$MSG["RU"]["TTLDeptRegion"] = "Регионы";
$MSG["RU"]["TTLDeptsOrder"] = "Порядок<br>в меню";
$MSG["RU"]["TTLCurrentDept"] = "Текущий раздел";
$MSG["RU"]["TTLDBDataEdit"] = "подключение базы данных";
$MSG["RU"]["TTLEditText"] = "Редактировать текст в текущем разделе";
$MSG["RU"]["TTLAddDept"] = "Добавить подраздел";
$MSG["RU"]["TTLConfigPage"] = "Общие настройки и модули";
$MSG["RU"]["TTLConfig"] = "Общие настройки";
$MSG["RU"]["TTLModules"] = "Обнаруженные модули";
$MSG["RU"]["TTLMailingEdit"] = "Редактирование информационных писем";
$MSG["RU"]["TTLCurrentLang"] = "Выбранный язык";
$MSG["RU"]["TTLDeleteLang"] = "Удалить язык";
$MSG["RU"]["TTLEditLang"] = "Редактировать язык";
$MSG["RU"]["TTLMoveDept"] = "Перенести этот раздел в раздел";
$MSG["RU"]["TTLMove"] = "Перенести";
$MSG["RU"]["TTLNoSorting"] = "Сортировка невозможна";
$MSG["RU"]["TTLMenuInclude1"] = "Отображать раздел в верхнем меню";
$MSG["RU"]["TTLMenuInclude2"] = "Отображать раздел в нижнем меню";
$MSG["RU"]["TTLMenuIncludeH"] = "Отображать раздел";
$MSG["RU"]["TTLWorkflow"] = "Раздельный доступ к разделам";
$MSG["RU"]["TTLCatalogue"] = "Работа с каталогом товаров";
$MSG["RU"]["TTLParser"] = "Работа с парсером";
$MSG["RU"]["TTLRSS"] = "Работа с RSS - каналами";
$MSG["RU"]["TTLAnalyze"] = "Анализ сайта";
$MSG["RU"]["TTLAdmin"] = "администратор";
$MSG["RU"]["TTLBanners"] = "Баннеры";
$MSG["RU"]["TTLClients"] = "Рабочее место модератора";
$MSG["RU"]["TTLOrgEdit"] = "Редактирование координат организации";
$MSG["RU"]["TTLPreShowI"] = "Предварительный просмотр инфостраницы";
$MSG["RU"]["TTLPreShowN"] = "Предварительный просмотр новости";
$MSG["RU"]["TTLShowI"] = "Просмотр инфостраницы";
$MSG["RU"]["TTLShowN"] = "Просмотр новости";
$MSG["RU"]["TTLBannerStat"] = "Статистика баннеров";
$MSG["RU"]["TTLOrgGet"] = "Просмотр организации";
$MSG["RU"]["TTLFAQEdit"] = "Редактирование вопросов и ответов";
$MSG["RU"]["TTLPollEdit"] = "Редактирование опросов";
$MSG["RU"]["TTLIPad"] = "Именительный падеж";
$MSG["RU"]["TTLRPad"] = "Родительный падеж";
$MSG["RU"]["TTLLang"] = "Язык";
$MSG["RU"]["TTLPath"] = "Путь к изображению";
$MSG["RU"]["TTLLangsEdit"] = "Управление языками интерфейса";
$MSG["RU"]["TTLAddLang"] = "Новый";
$MSG["RU"]["TTLWordsEdit"] = "Редактирование слов и фраз";
$MSG["RU"]["TTLContacts"] = "Редактирование контактов на карте";
$MSG["RU"]["TTLRegionStat"] = "Статистика организаций по регионам";
$MSG["RU"]["TTLMapChoose"] = "Выбор оторажаемой карты для регионов";
$MSG["RU"]["TTLMyAllinform"] = "Работа с MyAllinform";
$MSG["RU"]["TTLMUserReg"] = "Регистрация пользователей MyAllinform";
$MSG["RU"]["TTLImport"] = "Импортированные данные";
$MSG["RU"]["TTLPayment"] = "Платежи";
$MSG["RU"]["TTLOnline"] = "Продажи он-лайн";
$MSG["RU"]["TTLOferta"] = "Договор-оферта";
$MSG["RU"]["TTLorder"] = "Online-заказ";
$MSG["RU"]["TTLkeywords"] = "Ключевые слова";
$MSG["RU"]["TTLNewOrgs"] = "Новые организации";
$MSG["RU"]["TTLNewOrgsStat"] = "Статистика по новым организациям";
$MSG["RU"]["TTLNewOrders"] = "Новые заявки";
$MSG["RU"]["TTLDiscounts"] = "Купоны";
$MSG["RU"]["TTLSubscr"] = "Рассылка";
$MSG["RU"]["TTLSEO"] = "Настройки поискового продвижения";
$MSG["RU"]["TTLStat"] = "Статистика";
// меню
$MSG["RU"]["MenuDepts"] = "разделы";
$MSG["RU"]["MenuConfig"] = "настройка";
$MSG["RU"]["MenuWords"] = "настройка языка";
$MSG["RU"]["MenuAnalyze"] = "анализ";
$MSG["RU"]["MenuQueries"] = "запросы";
$MSG["RU"]["MenuBanners"] = "баннеры";
$MSG["RU"]["MenuParser"] = "парсер";
$MSG["RU"]["MenuAds"] = "реклама";
$MSG["RU"]["MenuSpec"] = "спец.реклама";
$MSG["RU"]["MenuOrg"] = "организация";
$MSG["RU"]["MenuRubr"] = "каталог";
$MSG["RU"]["MenuLK"] = "личный кабинет";
$MSG["RU"]["MenuForm"] = "добавленные";
$MSG["RU"]["MenuSubscr"] = "рассылка";
$MSG["RU"]["MenuOrgMap"] = "организация на карте";
$MSG["RU"]["MenuBD"] = "Выгрузка БД";
$MSG["RU"]["MenuHelp"] = "помощь";
$MSG["RU"]["MenuExit"] = "выход";
$MSG["RU"]["BannerStat"] = "баннерная стат.";
// описания модулей
$MSG["RU"]["MODnews"] = "Новости";
$MSG["RU"]["MODmailing"] = "Рассылка";
$MSG["RU"]["MODhidden"] = "Управление скрытыми разделами";
$MSG["RU"]["MODworkflow"] = "Раздельный доступ к разделам";
$MSG["RU"]["MODcatalogue"] = "Каталог товаров";
$MSG["RU"]["MODshopcart"] = "Работа с корзиной";
$MSG["RU"]["MODsearch"] = "Поиск";
$MSG["RU"]["MODform"] = "Форма обратной связи";
$MSG["RU"]["MODform1"] = "Форма отправки сообщения в компанию";
$MSG["RU"]["MODgallery"] = "Фотогалерея";
$MSG["RU"]["MODcatsearch"] = "Поиск по каталогу";
$MSG["RU"]["MODgoroscope"] = "Гороскоп";
$MSG["RU"]["MODregion"] = "Выбор региона";
$MSG["RU"]["MODindexes"] = "Почтовые индексы";
$MSG["RU"]["MODcodes"] = "Коды городов";
$MSG["RU"]["MODrss"] = "RSS - каналы";
$MSG["RU"]["MODgroup"] = "Группы";
$MSG["RU"]["MODrubr_orig"] = "Работа с рубриками - оригинал";
$MSG["RU"]["MODsearch_orig"] = "Поиск - оригинал";
$MSG["RU"]["MODgroup_orig"] = "Группы - оригинал";
$MSG["RU"]["MODorg_orig"] = "Организации - оригинал";
$MSG["RU"]["MODrubr"] = "Работа с рубриками";
$MSG["RU"]["MODorg"] = "Организации";
$MSG["RU"]["MODorgmap"] = "Организации на карте";
$MSG["RU"]["MODmap"] = "Карта веб-сайта";
$MSG["RU"]["MODforgot"] = "Напоминание пароля";
$MSG["RU"]["MODreg_user"] = "Регистрация пользователя";
$MSG["RU"]["MODclients"] = "Клиенты";
$MSG["RU"]["MODpreshowinfopage"] = "Предварительный просмотр инфостраницы";
$MSG["RU"]["MODpreshownews"] = "Предварительный просмотр новости";
$MSG["RU"]["MODshowinfopage"] = "Просмотр инфостраницы";
$MSG["RU"]["MODshownews"] = "Просмотр новости";
$MSG["RU"]["MODpreshowinfopage_demo"] = "Предварительный просмотр инфостраницы (демо)";
$MSG["RU"]["MODpreshownews_demo"] = "Предварительный просмотр новости (демо)";
$MSG["RU"]["MODshowinfopage_demo"] = "Просмотр инфостраницы (демо)";
$MSG["RU"]["MODshownews_demo"] = "Просмотр новости (демо)";
$MSG["RU"]["MODclients_stat"] = "Статистика в личном кабинете";
$MSG["RU"]["MODclients_demo"] = "Личный кабинет. Демо - версия";
$MSG["RU"]["MODhistory"] = "История поиска";
$MSG["RU"]["MODpoll"] = "Опросы";
$MSG["RU"]["MODfaq"] = "Вопросы и ответы";
$MSG["RU"]["MODnotepad"] = "Блокнот";
$MSG["RU"]["MODhelp"] = "Помощь по разделам";
$MSG["RU"]["MODsearch_advance"] = "Расширенный поиск";
$MSG["RU"]["MODlangs"] = "Управление языками интерфейса";
$MSG["RU"]["MODwords"] = "Определение терминов";
$MSG["RU"]["MODcontacts"] = "Контакты на карте";
$MSG["RU"]["MODinfopages"] = "Все инфостраницы";
$MSG["RU"]["MODabbrs"] = "Список сокращений";
$MSG["RU"]["MODmap_choose"] = "Выбор карты для региона";
$MSG["RU"]["MODmyallinform"] = "Мой ALLINFORM";
$MSG["RU"]["MODmuser_reg"] = "Регистрация пользователей MyAllinform";
$MSG["RU"]["MODimport"] = "Импорт данных";
$MSG["RU"]["MODmapserv"] = "Карта как сервис";
$MSG["RU"]["MODstat"] = "Статистика запросов к рубрикам";
$MSG["RU"]["MODbox"] = "Для партнеров";
$MSG["RU"]["MODpayment"] = "Платежи";
$MSG["RU"]["MODpay_accept"] = "Подтверждение платежа";
$MSG["RU"]["MODpay_refuse"] = "Отказ в платеже";
$MSG["RU"]["MODonline"] = "Он-лайн продажи";
$MSG["RU"]["MODoferta"] = "Договор-оферта";
$MSG["RU"]["MODorder"] = "Online-заказ";
$MSG["RU"]["MODclients_orders"] = "Online-заказы клиента";
$MSG["RU"]["MODclients_orgs"] = "Организации клиента";
$MSG["RU"]["MODonline_reg"] = "Регистрация клиента";
$MSG["RU"]["MODactions"] = "Акции к праздникам";
$MSG["RU"]["MODinfopage"] = "Новые инфостраницы";
$MSG["RU"]["MODprogramms"] = "Виртуальная БД, программа";
$MSG["RU"]["MODglobal"] = "Виртуальная БД, отображение";
$MSG["RU"]["MODkeywords"] = "Работа с ключевыми словами";
$MSG["RU"]["MODdiscounts"] = "Работа с купонами и скидками";
$MSG["RU"]["MODneworgs"] = "Просмотр добавленных организаций";
$MSG["RU"]["MODdiscounts"] = "Редактирование купонов";
$MSG["RU"]["MODtags"] = "Тэги для каталога";
$MSG["RU"]["MODdict"] = "Словарь терминов";
$MSG["RU"]["MODexhib"] = "Выставки";
$MSG["RU"]["MODorgs_news"] = "Новости организаций";
$MSG["RU"]["MODbanners"] = "Баннеры";
$MSG["RU"]["MODknow"] = "Новости портала";
$MSG["RU"]["MODvacs"] = "Вакансии организаций";
$MSG["RU"]["MODlk"] = "Личный кабинет";
$MSG["RU"]["MODsubs"] = "Подписка на издания";
$MSG["RU"]["MODpasschange"] = "Смена пароля";
$MSG["RU"]["MODform_stat"] = "Статистика заявок на добавление орг-ций";
$MSG["RU"]["MODonews"] = "Новости отрасли";
$MSG["RU"]["MODsubscr"] = "Рассылка";
$MSG["RU"]["MODallsites"] = "Все сайты компаний";
$MSG["RU"]["MODarticles"] = "Статьи";
$MSG["RU"]["MODown"] = "Калькулятор баз данных";
$MSG["RU"]["MODready"] = "Готовые базы данных";
$MSG["RU"]["MODabout"] = "Общие сведения о компании";
$MSG["RU"]["MODresp"] = "Вопрос-ответ";
$MSG["RU"]["MODbasket"] = "Корзина";
$MSG["RU"]["MODbase"] = "Отдельная база";
$MSG["RU"]["MODadvices"] = "Советы";
$MSG["RU"]["MODforum"] = "Управление форумом";
$MSG["RU"]["MODgov"] = "Власти - детям";
$MSG["RU"]["MODvpdet"] = "ВП Детский";
$MSG["RU"]["MODclient"] = "Личный кабинет";
$MSG["RU"]["MODrubr_meta"] = "Мета-теги к рубрикам";
$MSG["RU"]["MODphotos"] = "Загрузка фотографий для организаций";
$MSG["RU"]["MODforums"] = "Форум";
$MSG["RU"]["MODslider"] = "Управление слайдером";
$MSG["RU"]["MODquotes"] = "Управление цитатами";
$MSG["RU"]["MODmaterials"] = "Управление историческими материалами";
$MSG["RU"]["MODportfolio"] = "Управление портфолио";
$MSG["RU"]["MODpersons"] = "Управление командой";
?>
