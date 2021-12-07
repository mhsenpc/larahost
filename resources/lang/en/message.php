<?php
return [

//main-sidebar

'main-sidebar-userpanel-onlinelink' => 'online',
'main-sidebar-form-inputsitename-placeholder' => 'Search',
'main-sidebar-sidebarmenu-header' => 'Menu',
'main-sidebar-menu-dashbord-title' => 'Dashbord',
'main-sidebar-menu-dashbord-mysite-link' => 'My Sites',
'main-sidebar-menu-dashbord-newsite-link' => 'New Site',
'main-sidebar-menu-dashbord-allsite-link' => 'All sites',
'main-sidebar-menu-dashbord-userslist-link' => 'User list',
'main-sidebar-menu-dashbord-domainslist-link' => 'Domains list',
'main-sidebar-menu-dashbord-siteslist-link' => 'Sites list',

//site-sidebar

'site-sidebar-off' => 'OFF',
'site-sidebar-on' => 'ON',
'site-sidebar-menu-title' => 'Menu',
'site-sidebar-return-to-my-sites' => 'Return to My Sites',
'site-sidebar-site-desktop' => 'Site Desktop',
'site-sidebar-environment' => 'Environment',
'site-sidebar-deployments' => 'Deployments',
'site-sidebar-syntax' => 'Syntax',
'site-sidebar-reports' => 'Reports',
'site-sidebar-domains' => 'Domains',
'site-sidebar-queue' => 'Queue',

//action_button

'action-button-site-control' => 'Site Control',
'action-button-edit-env-file' => 'Editing ENV File',
'action-button-edit-apache-setting' => 'Edit Apache Settings',
'action-button-restart' => 'Restart',
'action-button-restart-apache' => 'Restart Apache',
'action-button-restart-mysql' => 'Restart Mysql',
'action-button-restart-redis' => 'Restart Redis',
'action-button-restart-supervisor' => 'Restart Supervisor',
'action-button-factory-reset-notif' => 'By resetting the server, all the changes you made to the server will be reset. Are you sure?',
'action-button-factory-reset' => 'Factory Reset',
'action-button-delete-site' => 'Delete Site',
'action-button-delete-site-notif-first' => 'Are you sure you want to delete',
'action-button-delete-site-notif-second' => 'site? This operation is irreversible!',

//app

'app-control-panel' => 'Control panel',
'app-logo-mini' => 'Panel',
'app-logo-lg' => 'Larahost',
'app-new-notification' => 'new notification',
'app-free-service-notification' => 'services are available as free until further notice',
'app-welcome-notification' => 'welcome to your larahost',
'app-all-notif' => 'show all notification',
'app-user-status-title' => 'user',
'app-profile' => 'profile',
'app-exit' => 'exit',
'app-reserved-right-text' => 'All rights reserved by larahost ©2021',

//partial/js

'js-pre-alert-text' => 'Required site',
'js-after-alert-text' => ' created successfully',

//dashbord

'dashbord-title' => 'Dashbord',
'dashbord-welcome-text' => 'Welcome to Your Larahost',
'dashbord-sitescount-title' => 'Sites',
'dashbord-userscount-title' => 'Registered Users',
'dashbord-domainscount-title' => 'Domains',
'dashbord-moreinfo' => 'More information',
'dashbord-desktop' => 'Desktop',

//site/commands

'commands-title' => 'Execute commands',
'commands-exec-command' => 'Execute',
'commands-exec-command-alert1' => 'All the Commands that you Executing are in root Address of your Site in',
'commands-exec-command-alert2' => ' Folder. that Executing by',
'commands-exec-command-alert3' => 'User Permission.',
'commands-exec-syntax' => 'Syntax of Command',
'commands-exec-button' => 'Execution',
'commands-history-command-box-title' => 'Execution history of Commands',
'commands-history-command-box-table-thead-user' => 'User',
'commands-history-command-box-table-thead-syntax' => 'Syntax',
'commands-history-command-box-table-thead-date' => 'Date',
'commands-history-command-box-table-thead-status' => 'Status',
'commands-history-command-box-table-tbody-status-success' => 'successfully',
'commands-history-command-box-table-tbody-status-faile' => 'failed',
'commands-history-command-box-table-tbody-panelbutton-history-output' => 'Show history output ',
'commands-history-command-box-table-tbody-panelbutton-run-again' => 'Run again',
'commands-history-command-box-table-tbody-panelbutton-null' => 'You have not executed any commands.',
'commands-history-command-resultbox-title' => 'Command output',
'commands-history-command-resultbox-footerbutton' => 'Close',
'commands-breadcrumb-homeaddress' => 'Home',

//site/create

'create-newsite-title' => 'Create new Site',
'create-allownewsite-alert' => 'Thank you for your interest in the Larahost Services, We should be noted that each user is allowed to build only one site. be sure, after complete the trialing term task and apply fees (price) service, we have been unlimited Hosting for your sites.',
'create-formbox-header-title' => 'Site setting up',
'create-formbox-name-label' => 'Site name',
'create-formbox-repository-label' => 'Repository address',
'create-formbox-checkbox-value1-title' => 'This Repository is dedicated and needs authentication',
'create-formbox-navtabs-sshkey-links-title' => 'Authentication by the Key',
'create-formbox-navtabs-basicauth-links-title' => 'Traditional authentication (Basically auth)',
'create-formbox-tabcontent-sshkey-calloutinfo-header' => 'Attention',
'create-formbox-tabcontent-sshkey-calloutinfo-content' => 'Add this key in the relevant Git Server in the keys section',
'create-formbox-tabcontent-basicauth-calloutwarning-header' => 'Attention',
'create-formbox-tabcontent-basicauth-calloutwarning-content' => 'For Increasing your security solutions, please Do not use this type of authentication as much as possible. Instead of Traditional authentication, Please using by the Key Authentication.',
'create-formbox-tabcontent-basicauth-username-label-title' => 'Git Username',
'create-formbox-tabcontent-basicauth-password-label-title' => 'Git Password',
'create-formbox-boxfooter-submitvalue-input' => 'Launching web site',
'create-breadcrumb-dashbord-homeaddress-title' => 'Home',
'create-breadcrumb-mysitesaddress-title' => 'My Sites',
'create-breadcrumb-createnewsiteaddress-title' => 'Create New Site',

//site/deployments

'deployments-title' => 'Deploy History',
'deployments-historynone-alert' => 'So far no deployment has been done for this site',
'deployments-historycontent-table-historyth' => 'History',
'deployments-historycontent-table-statusth' => 'Status',
'deployments-historycontent-table-successfullstatus' => 'Successfull',
'deployments-historycontent-table-failedstatus' => 'Failed',
'deployments-historycontent-table-report' => 'View deploy report',
'deployments-breadcrumb-dashbordhome' => 'Home',

//site/domains

'domains-title' => 'Domains connected to the site',
'domains-formbox-header-title' => 'Connect a new domain',
'domains-formbox-body-title1' => 'In this section, you can connect one or more domains to Site',
'domains-formbox-body-title2' => '',
'domains-formbox-namedomain-label' => 'Domain name',
'domains-formbox-footer-submitbutton' => 'Connect',
'domains-domainlist-title1' => 'List of',
'domains-domainlist-title2' => 'site domains',
'domains-domainlist-table-nameth' => 'Domain name',
'domains-domainlist-table-connectiondateth' => 'Connection date',
'domains-domainlist-table-statusth' => 'Status',
'domains-domainlist-table-statustd' => 'Connected',
'domains-domainlist-table-removebutton-alert1' => 'Do you want to Remove',
'domains-domainlist-table-removebutton-alert2' => 'domain, Are you sure?',
'domains-domainlist-table-removebutton-linktitle' => 'Remove',
'domains-domainlist-none1' => 'No domain has been defined for site',
'domains-domainlist-none2' => 'so far',
'domains-parkdomain-formbox-header' => 'Default subdomain',
'domains-parkdomain-formbox-status-info1' => 'By default, the',
'domains-parkdomain-formbox-status-info2' => 'Subdomain is connected to your site',
'domains-parkdomain-formbox-status-warning' => 'You have now disabled the subdomain site',
'domains-parkdomain-formbox-status-warning2' => 'You can do it Reactivate again',
'domains-parkdomain-formbox-footer-disablebutton' => 'Disconnect',
'domains-parkdomain-formbox-footer-enablebutton' => 'Connect again',
'domains-breadcrumb-dashbord-homeaddress' => 'Home',

//site/env-editor

'env-editor-title' => 'Editing env File',
'env-editor-contentbox-none' => 'Sorry, your project env file could not be found',
'env-editor-formbox-submitbutton' => 'Save',
'env-editor-breadcrumb-dashbord-homeaddress' => 'Home',

//site/index

'index-title' => 'My sites',
'index-description' => 'List of sites you have created so far',
'index-tablebox-sitenameth' => 'Site name',
'index-tablebox-subdomain-nameth' => 'Subdomain (free)',
'index-tablebox-progressiveofservice-title' => 'Durring Installation progressive...',
'index-breadcrumb-dashbord-homeaddress' => 'Home',
'index-breadcrumb-mysites' => 'My sites',

//site/laravel-logs

'laravel-logs-title' => 'Site reports |',
'laravel-logs-content-none' => 'No log file has been generated by this site so far',
'laravel-logs-tablebox-filenameth' => 'File name',
'laravel-logs-tablebox-showlogsbutton' => 'View Log contents',
'laravel-logs-breadcrumb-dashbord-homeaddress' => 'Home',

//site/show_deployment_log

'show-deployment-log-title' => 'Deployment Report',
'show-deployment-log-breadcrumb-dashbord-homeaddress' => 'Home',

//site/show_laravel_log

'show-laravel-log-title' => 'Contents of the report',
'show-laravel-log-breadcrumb-dashbord-homeaddress' => 'Home',

//site/show

'show-title' => 'Site Desktop ',
'show-contentbox-info' => 'if you expect to Begining deploy operation as soon as after push in the control version software, it is necessary to Set the relevant trigger in the Deployment Trigger URl section.',
'show-contentbox-footer-lastdeploymentreport-button' => 'See the latest Deployment report',
'show-formbox-description' => 'in this section you can Determine the necessary execute commands after each deploy',
'show-formbox-footer-submitbutton' => 'Save',
'show-deploytriggerurlbox-description' => 'if you want, Larahast receives your code from the system control version and Automatically load on your site as soon as after push the codes in the source control software or after the automatic testing operation by Software such as Jenkins or CircleCI, just send a Get or Post request to the following address, which will cause start automated Deploy operation',
'show-deploytriggerurlbox-footer-button' => 'Change the Token',
'show-maintenace-status-formbox-maintenaceup-title' => 'Repair mode',
'show-maintenace-status-formbox-warningcontent' => 'Your site is currently under Repair mode',
'show-maintenace-status-formbox-footer-cancelsubmitbutton' => 'Cancel Repair mode',
'show-maintenace-status-formbox-maintenacedown-title' => 'Repair mode',
'show-maintenace-status-formbox-infocontent' => 'Activating the repair mode will cause the site unavailable.',
'show-maintenace-status-formbox-secretinput-text1' => 'Note: only Laravel 8 can have usability of',
'show-maintenace-status-formbox-secretinput-link' => 'secret phrases.',
'show-maintenace-status-formbox-secretinput-text2' => '',
'show-maintenace-status-formbox-footer-activesubmitbutton' => 'Active Repair mode',
'show-maintenace-status-formbox-gitremote-title' => 'Changing Git Remote',
'show-maintenace-status-formbox-gitremote-info' => 'in this Section you can Change the Connected Git Remote URI to your site. Be Notice that The New Repository Address as you want to enter as Be Exactly the same repository and the same commit history, in otherwise the System Deploy will not work!',
'show-maintenace-status-formbox-footer-gitremotesubmitbutton' => 'Changing git remote',
'show-maintenace-status-deploymentlog-closemodal' => 'Close',
'show-breadcrumb-dashbord-homeaddress' => 'Home',

//site/workers...

'workers-title' => 'Queue',
'workers-createworker-formbox-title' => 'Create new worker',
'workers-createworker-formbox-info' => 'In this section, you can create many Queue worker as you need as you want. the Workers have been Monitoring automatically by supervisor program. and will have been Restarted if a problem occurs and All workers Run automatically when restarting server',
'workers-createworker-formbox-footer-addsubmitbutton' => 'Add',
'workers-listworkercontent-title' => 'Workers List',
'workers-listworkercontent-table-queueth' => 'Queue',
'workers-listworkercontent-table-processcountth' => 'Process Count',
'workers-listworkercontent-table-effortsth' => 'Efforts',
'workers-listworkercontent-table-none' => 'You have not defined any workers for this site so far',
'workers-modalworker-closebutton' => 'Close',
'workers-breadcrumb-dashbord-homeaddress' => 'Home',

//auth/login

'login-title' => 'Login | Control panel',
'login-content-loginbox-titlelink' => 'Login to site',
'login-content-loginbox-message' => 'Filling the below Form and Login to site',
'login-content-loginbox-form-emailinput-placeholder' => 'Email',
'login-content-loginbox-form-passwordinput-placeholder' => 'Password',
'login-content-loginbox-form-remember input-placeholder' => 'Remember Me',
'login-content-loginbox-form-submitbutton' => 'Login',
'login-content-passwordrequest-link' => 'Forget my password',
'login-content-register-requestlink' => 'Register',

//auth/register

'register-title' => 'Register | Control panel',
'register-content-registerbox-titlelink' => 'Site Registering',
'register-content-registerbox-message' => 'Registering new User',
'register-content-registerbox-form-nameinput-placeholder' => 'first name and last name',
'register-content-registerbox-form-emailinput-placeholder' => 'email',
'register-content-registerbox-form-passwordinput-placeholder' => 'password',
'register-content-registerbox-form-confirmpasswordinput-placeholder' => 'confirm password',
'register-content-registerbox-form-terms&conditioncheckbox-agree' => 'I agree',
'register-content-registerbox-form-terms&conditioncheckbox-link' => 'the Terms & Conditions',
'register-content-registerbox-form-terms&conditioncheckbox-accept' => 'and accept it',
'register-content-registerbox-form-submitbutton' => 'Register',
'register-content-registerbox-loginlink' => 'I have already registered',

//auth/passwords/email

'email-title' => 'Forget password | Control panel',
'email-content-loginbox-titlelink' => 'Forget the Password',
'email-content-loginbox-message' => 'Enter the correct registered email address',
'email-content-loginbox-form-emailinput-placeholder' => 'Email',
'email-content-loginbox-form-submitbutton' => 'Send reset link',
'email-content-loginbox-registerlink' => 'Register',

//auth/passwords/reset

'reset-title' => 'Reset the Password | Control panel',
'reset-content-registerbox-titlelink' => 'Reset the Password',
'reset-content-registerbox-message' => 'Reset the Password',
'reset-content-registerbox-form-emailinput-placeholder' => 'email',
'reset-content-registerbox-form-passwordinput-placeholder' => 'password',
'reset-content-registerbox-form-confirmpasswordinput-placeholder' => 'confirmation password',
'reset-content-registerbox-form-submitbutton' => 'Reset Password',
'reset-content-registerbox-loginlink' => 'I am already registered',
'reset-content-registerbox-registerlink' => 'Register new User',

//admin/domains

'admin-domains-title' => 'Domains',
'admin-domains-description' => 'Domains list',
'admin-domains-boxcontent-table-domainth' => 'Domain',
'admin-domains-boxcontent-table-sitenameth' => 'Site name',
'admin-domains-boxcontent-table-vendorth' => 'vendor',
'admin-domains-breadcrumb-dashbord-homeaddress' => 'Home',
'admin-domains-breadcrumb-management' => 'Management',
'admin-domains-breadcrumb-domainslist' => 'Domains list',

//admin/site

'admin-site-title' => 'Sites',
'admin-site-description' => 'list of all Sites',
'admin-site-boxcontent-table-sitenameth' => 'Site name',
'admin-site-boxcontent-table-domainscountth' => 'Domains count',
'admin-site-boxcontent-table-vendorth' => 'Vendor',
'admin-site-breadcrumb-dashbord-homeaddress' => 'Home',
'admin-site-breadcrumb-management' => 'Management',
'admin-site-breadcrumb-siteslist' => 'Sites List',

//admin/users

'admin-users-title' => 'Site Users',
'admin-users-description' => 'List of all registered users',
'admin-users-contentbox-table-nameth' => 'Name',
'admin-users-contentbox-table-emailth' => 'Email',
'admin-users-contentbox-table-sitesth' => 'Sites',
'admin-users-contentbox-table-loginastd' => 'Login',
'admin-users-breadcrumb-dashbord-homeaddress' => 'Home',
'admin-users-breadcrumb-management' => 'Management',
'admin-users-breadcrumb-userslist' => 'Users list',

];
