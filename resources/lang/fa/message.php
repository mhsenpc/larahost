<?php
return [

//main-sidebar

'main-sidebar-userpanel-onlinelink' => 'آنلاین',
'main-sidebar-form-inputsitename-placeholder' => 'جستجو',
'main-sidebar-sidebarmenu-header' => 'منو',
'main-sidebar-menu-dashboard-title' => 'میزکار',
'main-sidebar-menu-dashboard-mysite-link' => 'سایت های من',
'main-sidebar-menu-dashboard-newsite-link' => 'سایت جدید',
'main-sidebar-menu-dashboard-allsite-link' => 'همه سایت ها',
'main-sidebar-menu-dashboard-userslist-link' => 'لیست کاربران',
'main-sidebar-menu-dashboard-domainslist-link' => 'لیست دامنه ها',
'main-sidebar-menu-dashboard-siteslist-link' => 'لیست سایت ها',

//site-sidebar

'site-sidebar-off' => 'خاموش',
'site-sidebar-on' => 'روشن',
'site-sidebar-menu-title' => 'منو',
'site-sidebar-return-to-my-sites' => 'بازگشت به سایت های من',
'site-sidebar-site-desktop' => 'میزکار سایت',
'site-sidebar-environment' => 'Environment',
'site-sidebar-deployments' => 'Deployments',
'site-sidebar-syntax' => 'دستورات',
'site-sidebar-reports' => 'گزارش ها',
'site-sidebar-domains' => 'دامنه ها',
'site-sidebar-queue' => 'Queue',

//action_button

'action-button-site-control' => 'کنترل سایت',
'action-button-edit-env-file' => 'ویرایش فایل ENV',
'action-button-edit-apache-setting' => 'ویرایش تنظیمات Apache',
'action-button-restart' => 'راه اندازی مجدد',
'action-button-restart-apache' => 'Restart Apache',
'action-button-restart-mysql' => 'Restart Mysql',
'action-button-restart-redis' => 'Restart Redis',
'action-button-restart-supervisor' => 'Restart Supervisor',
'action-button-factory-reset-notif' => 'با بازنشانی سرور، تمامی تغییراتی که روی سرور انجام داده بودید به حالت اولیه برمیگردند. آیا اطمینان دارید؟',
'action-button-factory-reset' => 'بازنشانی به تنظیمات اولیه',
'action-button-delete-site' => 'حذف سایت',
'action-button-delete-site-notif-first' => 'آیا از حذف سایت',
'action-button-delete-site-notif-second' => 'اطمینان دارید؟ این عملیات غیرقابل بازگشت است!',

//app

'app-control-panel' => 'کنترل پنل',
'app-logo-mini' => 'پنل',
'app-logo-lg' => 'لاراهاست',
'app-new-notification' => 'اعلان جدید',
'app-free-service-notification' => 'سرویس ها تا اطلاع ثانوی رایگان هستند',
'app-welcome-notification' => 'به لاراهاست خوش آمدید',
'app-all-notif' => 'نمایش همه',
'app-user-status-title' => 'کاربر سایت',
'app-profile' => 'پروفایل',
'app-exit' => 'خروج',
'app-reserved-right-text' => 'تمامی حقوق مادی و معنوی این سرویس متعلق به لاراهاست می باشد',

//partial/js

'js-pre-alert-text' => 'سایت',
'js-after-alert-text' => ' با موفقیت ایجاد شد',

//dashboard

'dashboard-title' => 'داشبورد',
'dashboard-welcome-text' => 'به لاراهاست خوش آمدید',
'dashboard-sitescount-title' => 'سایت ها',
'dashboard-userscount-title' => 'کاربران ثبت شده',
'dashboard-domainscount-title' => 'دامنه ها',
'dashboard-moreinfo' => 'اطلاعات بیشتر',
'dashboard-desktop' => 'میزکار',

//site/commands

'commands-title' => 'اجرای دستورات',
'commands-exec-command' => 'اجرا',
'commands-exec-command-alert1' => 'تمامی command هایی که اجرا می کنید در پوشه root سایت شما به آدرس',
'commands-exec-command-alert2' => ' توسط کاربر',
'commands-exec-command-alert3' => 'اجرا می شوند.',
'commands-exec-syntax' => 'دستور',
'commands-exec-button' => 'اجرا',
'commands-history-command-box-title' => 'تاریخچه اجرای دستورات',
'commands-history-command-box-table-thead-user' => 'کاربر',
'commands-history-command-box-table-thead-syntax' => 'دستور',
'commands-history-command-box-table-thead-date' => 'تاریخ',
'commands-history-command-box-table-thead-status' => 'وضعیت',
'commands-history-command-box-table-tbody-status-success' => 'موفق',
'commands-history-command-box-table-tbody-status-faile' => 'ناموفق',
'commands-history-command-box-table-tbody-panelbutton-history-output' => 'نمایش خروجی',
'commands-history-command-box-table-tbody-panelbutton-run-again' => 'اجرای مجدد',
'commands-history-command-box-table-tbody-panelbutton-null' => 'تاکنون هیچ دستوری روی این سایت اجرا نکرده اید.',
'commands-history-command-resultbox-title' => 'خروجی دستور',
'commands-history-command-resultbox-footerbutton' => 'بستن',
'commands-breadcrumb-homeaddress' => 'خانه',

//site/create

'create-newsite-title' => 'ایجاد سایت جدید',
'create-allownewsite-alert' => 'ضمن تشکر از علاقه مندی شما به سرویس لاراهاست، لازم به ذکر هست که در حال حاضر هر کاربر مجاز به ساخت فقط یک سایت می باشد. یقینا پس از اتمام دوره آزمایشی و اعمال هزینه بر روی سرویس، میزبان سایت های شما به تعداد نامحدود خواهیم بود',
'create-formbox-header-title' => 'راه اندازی سایت',
'create-formbox-name-label' => 'نام سایت',
'create-formbox-repository-label' => 'آدرس Repository',
'create-formbox-checkbox-value1-title' => 'این Repository اختصاصی است و نیاز به احراز هویت دارد',
'create-formbox-navtabs-sshkey-links-title' => 'احراز هویت با کلید',
'create-formbox-navtabs-basicauth-links-title' => 'احراز هویت سنتی',
'create-formbox-tabcontent-sshkey-calloutinfo-header' => 'توجه',
'create-formbox-tabcontent-sshkey-calloutinfo-content' => 'این کلید را در Git Server مربوطه در بخش کلید ها اضافه نمایید ',
'create-formbox-tabcontent-basicauth-calloutwarning-header' => 'توجه',
'create-formbox-tabcontent-basicauth-calloutwarning-content' => 'لطفا جهت بالابردن ضریب امنیت خودتان، تا حد امکان از این نوع احراز هویت استفاده نفرمایید بلکه از احراز هویت با کلید استفاده کنید.',
'create-formbox-tabcontent-basicauth-username-label-title' => 'نام کاربری Git',
'create-formbox-tabcontent-basicauth-password-label-title' => 'رمز عبور Git',
'create-formbox-boxfooter-submitvalue-input' => 'راه اندازی سایت',
'create-breadcrumb-dashboard-homeaddress-title' => 'خانه',
'create-breadcrumb-mysitesaddress-title' => 'سایت های من',
'create-breadcrumb-createnewsiteaddress-title' => 'ایجاد سایت جدید',

//site/deployments

'deployments-title' => 'تاریخچه Deploy',
'deployments-historynone-alert' => 'تاکنون هیچ deployment ای برای این سایت انجام نشده است',
'deployments-historycontent-table-historyth' => 'تاریخ',
'deployments-historycontent-table-statusth' => 'وضعیت',
'deployments-historycontent-table-successfullstatus' => 'موفق',
'deployments-historycontent-table-failedstatus' => 'ناموفق',
'deployments-historycontent-table-report' => 'نمایش گزارش deploy',
'deployments-breadcrumb-dashboardhome' => 'خانه',

//site/domains

'domains-title' => 'دامنه های متصل به سایت',
'domains-formbox-header-title' => 'اتصال دامنه جدید',
'domains-formbox-body-title1' => 'در این بخش می توانید یک یا چند دامنه را به سایت',
'domains-formbox-body-title2' => 'متصل کنید',
'domains-formbox-namedomain-label' => 'نام دامنه',
'domains-formbox-footer-submitbutton' => 'اتصال',
'domains-domainlist-title1' => 'لیست دامنه های سایت',
'domains-domainlist-title2' => '',
'domains-domainlist-table-nameth' => 'نام دامنه',
'domains-domainlist-table-connectiondateth' => 'تاریخ اتصال',
'domains-domainlist-table-statusth' => 'وضعیت',
'domains-domainlist-table-statustd' => 'متصل',
'domains-domainlist-table-removebutton-alert1' => 'آیا از حذف دامنه',
'domains-domainlist-table-removebutton-alert2' => 'اطمینان دارید؟',
'domains-domainlist-table-removebutton-linktitle' => 'حذف',
'domains-domainlist-none1' => 'تاکنون هیچ دامنه ای برای سایت',
'domains-domainlist-none2' => 'تعریف نشده است',
'domains-parkdomain-formbox-header' => 'زیردامنه پیش فرض',
'domains-parkdomain-formbox-status-info1' => 'بصورت پیش فرض زیردامنه',
'domains-parkdomain-formbox-status-info2' => 'به سایت شما متصل گردیده است.',
'domains-parkdomain-formbox-status-warning' => 'در حال حاضر زیردامنه',
'domains-parkdomain-formbox-status-warning2' => 'توسط شما غیرفعال شده است. شما می توانید آن را مجددا فعال نمایید',
'domains-parkdomain-formbox-footer-disablebutton' => 'قطع اتصال',
'domains-parkdomain-formbox-footer-enablebutton' => 'فعال سازی مجدد',
'domains-breadcrumb-dashboard-homeaddress' => 'خانه',

//site/env-editor

'env-editor-title' => 'ویرایش فایل env',
'env-editor-contentbox-none' => 'متاسفانه فایل env پروژه شما پیدا نشد',
'env-editor-formbox-submitbutton' => 'ذخیره',
'env-editor-breadcrumb-dashboard-homeaddress' => 'خانه',

//site/index

'index-title' => 'سایت های من',
'index-description' => 'لیست سایت هایی که تاکنون ساخته اید',
'index-tablebox-sitenameth' => 'نام سایت',
'index-tablebox-subdomain-nameth' => 'زیر دامنه (رایگان)',
'index-tablebox-progressiveofservice-title' => 'در حال نصب و راه اندازی',
'index-breadcrumb-dashboard-homeaddress' => 'خانه',
'index-breadcrumb-mysites' => 'سایت های من',

//site/laravel-logs

'laravel-logs-title' => 'گزارش های سایت |',
'laravel-logs-content-none' => 'تا کنون فایل log ای توسط این سایت تولید نشده است',
'laravel-logs-tablebox-filenameth' => 'نام فایل',
'laravel-logs-tablebox-showlogsbutton' => 'نمایش محتویات Log',
'laravel-logs-breadcrumb-dashboard-homeaddress' => 'خانه',

//site/show_deployment_log

'show-deployment-log-title' => 'گزارش Deployment',
'show-deployment-log-breadcrumb-dashboard-homeaddress' => 'خانه',


//site/show_laravel_log

'show-laravel-log-title' => 'محتویات گزارش',
'show-laravel-log-breadcrumb-dashboard-homeaddress' => 'خانه',

//site/show

'show-title' => 'میزکار سایت ',
'show-contentbox-info' => 'اگر انتظار دارید که به محض push کردن در نرم افزار کنترل نسخه، عملیات deploy شروع شود، لازم است که تریگر مربوطه که در بخش Deployment Trigger URL وجود دارد را تنظیم نمایید',
'show-contentbox-footer-lastdeploymentreport-button' => 'دیدن گزارش آخرین Deployment',
'show-formbox-description' => 'در این بخش می توانید دستوراتی که بعد از هر deploy لازم است در سرور اجرا شوند را تعیین نمایید',
'show-formbox-footer-submitbutton' => 'ذخیره',
'show-deploytriggerurlbox-description' => 'در صورتی که بخواهید به محض push کردن کدها در نرم افزار سورس کنترل و یا پس از اتمام عملیات تست اتوماتیک توسط نرم افزارهایی همانند Jenkins یا CircleCI، لاراهاست کدهای شما را از سیستم کنترل نسخه دریافت کرده و بطور اتوماتیک روی سایت شما بارگذاری کند کافیست یک درخواست Get و یا Post به آدرس زیر داده شود که این امر باعث شروع عملیات Deploy خودکار می شود',
'show-deploytriggerurlbox-footer-button' => 'تغییر Token',
'show-maintenace-status-formbox-maintenaceup-title' => 'حالت تعمیر',
'show-maintenace-status-formbox-warningcontent' => 'در حال حاضر سایت شما در حالت تعمیر قرار دارد',
'show-maintenace-status-formbox-footer-cancelsubmitbutton' => 'خروج از حالت تعمیر',
'show-maintenace-status-formbox-maintenacedown-title' => 'حالت تعمیر',
'show-maintenace-status-formbox-infocontent' => 'فعال سازی حالت تعمیر باعث خارج شدن سایت از دسترس عموم می شود',
'show-maintenace-status-formbox-secretinput-text1' => 'نکته: فقط لاراول 8 توانایی استفاده از',
'show-maintenace-status-formbox-secretinput-link' => 'عبارت مخفی',
'show-maintenace-status-formbox-secretinput-text2' => 'را دارد.',
'show-maintenace-status-formbox-footer-activesubmitbutton' => 'فعال سازی حالت تعمیر',
'show-maintenace-status-formbox-gitremote-title' => 'تغییر Git Remote',
'show-maintenace-status-formbox-gitremote-info' => 'در این بخش می توانید Git remote Url متصل به سایت خود را تغییر دهید.توجه کنید که آدرس Repository جدیدی که وارد می کنید دقیقا باید شامل همان repository و همان تاریخچه commit باشد در غیر این صورت سیستم deploy عمل نخواهد کرد!',
'show-maintenace-status-formbox-footer-gitremotesubmitbutton' => 'تغییر Git Remote',
'show-maintenace-status-deploymentlog-closemodal' => 'بستن',
'show-breadcrumb-dashboard-homeaddress' => 'خانه',

//site/workers...

'workers-title' => 'صف (Queue)',
'workers-createworker-formbox-title' => 'ایجاد worker جدید',
'workers-createworker-formbox-info' => 'در این قسمت به هر تعداد که نیاز دارید می توانید queue worker بسازید. worker ها بصورت خودکار توسط برنامه supervisor مانیتور خواهند شد و در صورت بروز مشکل، مجددا اجرا خواهند شد. تمامی worker در صورت restart کردن سرور، بطور اتوماتیک اجرا می شوند.',
'workers-createworker-formbox-footer-addsubmitbutton' => 'افزودن',
'workers-listworkercontent-title' => 'لیست Worker ها',
'workers-listworkercontent-table-queueth' => 'صف',
'workers-listworkercontent-table-processcountth' => 'تعداد پردازش',
'workers-listworkercontent-table-effortsth' => 'تلاش ها',
'workers-listworkercontent-table-none' => 'تاکنون هیچ worker ای برای این سایت تعریف نکرده اید',
'workers-modalworker-closebutton' => 'بستن',
'workers-breadcrumb-dashboard-homeaddress' => 'خانه',

//auth/login

'login-title' => 'ورود | کنترل پنل',
'login-content-loginbox-titlelink' => 'ورود به سایت',
'login-content-loginbox-message' => 'فرم زیر را تکمیل کنید و ورود بزنید',
'login-content-loginbox-form-emailinput-placeholder' => 'ایمیل',
'login-content-loginbox-form-passwordinput-placeholder' => 'رمز عبور',
'login-content-loginbox-form-remember input-placeholder' => 'مرا به خاطر بسپار',
'login-content-loginbox-form-submitbutton' => 'ورود',
'login-content-passwordrequest-link' => 'رمز عبورم را فراموش کرده ام.',
'login-content-register-requestlink' => 'ثبت نام',
'login-content-demoaccount-button' => 'ورود به حساب کاربری آزمایشی ( دمو اکانت )',

//auth/register

'register-title' => 'ثبت نام | کنترل پنل',
'register-content-registerbox-titlelink' => 'ثبت نام در سایت',
'register-content-registerbox-message' => 'ثبت نام کاربر جدید',
'register-content-registerbox-form-nameinput-placeholder' => 'نام و نام خانوادگی',
'register-content-registerbox-form-emailinput-placeholder' => 'ایمیل',
'register-content-registerbox-form-passwordinput-placeholder' => 'رمز عبور',
'register-content-registerbox-form-confirmpasswordinput-placeholder' => 'تکرار رمز عبور',
'register-content-registerbox-form-terms&conditioncheckbox-agree' => 'من',
'register-content-registerbox-form-terms&conditioncheckbox-link' => 'قوانین و شرایط',
'register-content-registerbox-form-terms&conditioncheckbox-accept' => 'را قبول میکنم.',
'register-content-registerbox-form-submitbutton' => 'ثبت نام',
'register-content-registerbox-loginlink' => 'من قبلا ثبت نام کرده ام',

//auth/passwords/email

'email-title' => 'فراموشی رمز عبور | کنترل پنل',
'email-content-loginbox-titlelink' => 'فراموشی رمز عبور',
'email-content-loginbox-message' => 'ایمیلی که با آن ثبت نام کرده اید را وارد نمایید',
'email-content-loginbox-form-emailinput-placeholder' => 'ایمیل',
'email-content-loginbox-form-submitbutton' => 'ارسال لینک بازنشانی',
'email-content-loginbox-registerlink' => 'ثبت نام',

//auth/passwords/reset

'reset-title' => 'بازنشانی رمز عبور | کنترل پنل',
'reset-content-registerbox-titlelink' => 'بازنشانی رمز عبور',
'reset-content-registerbox-message' => 'بازنشانی رمز عبور',
'reset-content-registerbox-form-emailinput-placeholder' => 'ایمیل',
'reset-content-registerbox-form-passwordinput-placeholder' => 'رمز عبور',
'reset-content-registerbox-form-confirmpasswordinput-placeholder' => 'تکرار رمز عبور',
'reset-content-registerbox-form-submitbutton' => 'بازنشانی رمز',
'reset-content-registerbox-loginlink' => 'من قبلا ثبت نام کرده ام',
'reset-content-registerbox-registerlink' => 'ثبت نام کاربر جدید',

//admin/domains

'admin-domains-title' => 'دامنه ها',
'admin-domains-description' => 'لیست دامنه ها',
'admin-domains-boxcontent-table-domainth' => 'دامنه',
'admin-domains-boxcontent-table-sitenameth' => 'نام سایت',
'admin-domains-boxcontent-table-vendorth' => 'مالک',
'admin-domains-breadcrumb-dashboard-homeaddress' => 'خانه',
'admin-domains-breadcrumb-management' => 'مدیریت',
'admin-domains-breadcrumb-domainslist' => 'لیست دامنه ها',

//admin/site

'admin-site-title' => 'سایت ها',
'admin-site-description' => 'لیست تمامی سایت ها',
'admin-site-boxcontent-table-sitenameth' => 'نام سایت',
'admin-site-boxcontent-table-domainscountth' => 'تعداد دامنه ها',
'admin-site-boxcontent-table-vendorth' => 'مالک',
'admin-site-breadcrumb-dashboard-homeaddress' => 'خانه',
'admin-site-breadcrumb-management' => 'مدیریت',
'admin-site-breadcrumb-siteslist' => 'لیست سایت ها',

//admin/users

'admin-users-title' => 'کاربران سایت',
'admin-users-description' => 'لیست تمامی کاربرانی که ثبت نام کرده اند',
'admin-users-contentbox-table-nameth' => 'نام',
'admin-users-contentbox-table-emailth' => 'ایمیل',
'admin-users-contentbox-table-sitesth' => 'سایت ها',
'admin-users-contentbox-table-loginastd' => 'ورود',
'admin-users-breadcrumb-dashboard-homeaddress' => 'خانه',
'admin-users-breadcrumb-management' => 'مدیریت',
'admin-users-breadcrumb-userslist' => 'لیست کاربران',

];
