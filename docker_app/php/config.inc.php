<?php // -*-mode: PHP; coding:utf-8;-*-
namespace MRBS;

$timezone = "Europe/Zurich";
$dbsys = "mysql";
$db_host = "db";
$db_database = "mrbs";
$db_login = "mrbs";
$db_password = "mrbs";
$db_tbl_prefix = "mrbs_";
$db_persist = FALSE;


// Default settings

$mrbs_company = "QWV";   // This line must always be uncommented ($mrbs_company is used in various places)
//$custom_css_url = 'css/custom.css';
$weekstarts = 1;
$style_weekends = true;
$kiosk_mode_enabled = true;
$theme = "modern";
$default_view = "week";
$view_week_number = true;

$mail_settings['admin_lang'] = 'en';   // Default is 'en'.

// Settings from MRBS-modern theme

$disable_menu_items_for_non_admins = ["kiosk", "user_list", "rooms"];
$enable_pwa = True;
