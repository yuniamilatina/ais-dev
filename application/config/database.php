<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '192.168.0.222';
$db['default']['username'] = 'app_db_ais';
$db['default']['password'] = 'VL2SvE4d6Syq5U5S';
$db['default']['database'] = 'DB_AIS';
$db['default']['dbdriver'] = 'mssql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['db_report']['hostname'] = '192.168.0.222';
$db['db_report']['username'] = 'sa';
$db['db_report']['password'] = 'Server03';
$db['db_report']['database'] = 'DB_REPORT';
$db['db_report']['dbdriver'] = 'mssql';
$db['db_report']['dbprefix'] = '';
$db['db_report']['pconnect'] = TRUE;
$db['db_report']['db_debug'] = TRUE;
$db['db_report']['cache_on'] = FALSE;
$db['db_report']['cachedir'] = '';
$db['db_report']['char_set'] = 'utf8';
$db['db_report']['dbcollat'] = 'utf8_general_ci';
$db['db_report']['swap_pre'] = '';
$db['db_report']['autoinit'] = TRUE;
$db['db_report']['stricton'] = FALSE;

$db['db_iot']['hostname'] = '192.168.0.222';
$db['db_iot']['username'] = 'sa';
$db['db_iot']['password'] = 'Server03';
$db['db_iot']['database'] = 'DB_IOT';
$db['db_iot']['dbdriver'] = 'mssql';
$db['db_iot']['dbprefix'] = '';
$db['db_iot']['pconnect'] = TRUE;
$db['db_iot']['db_debug'] = TRUE;
$db['db_iot']['cache_on'] = FALSE;
$db['db_iot']['cachedir'] = '';
$db['db_iot']['char_set'] = 'utf8';
$db['db_iot']['dbcollat'] = 'utf8_general_ci';
$db['db_iot']['swap_pre'] = '';
$db['db_iot']['autoinit'] = TRUE;
$db['db_iot']['stricton'] = FALSE;

//DB MY SQL DISPLAY
// $db['db_production']['hostname'] = '192.168.0.232';
// $db['db_production']['username'] = 'root';
// $db['db_production']['password'] = 'Server03';
// $db['db_production']['database'] = 'db_production';
// $db['db_production']['dbdriver'] = 'mysql';
// $db['db_production']['dbprefix'] = '';
// $db['db_production']['pconnect'] = TRUE;
// $db['db_production']['db_debug'] = TRUE;
// $db['db_production']['cache_on'] = FALSE;
// $db['db_production']['cachedir'] = '';
// $db['db_production']['char_set'] = 'utf8';
// $db['db_production']['dbcollat'] = 'utf8_general_ci';
// $db['db_production']['swap_pre'] = '';
// $db['db_production']['autoinit'] = TRUE;
// $db['db_production']['stricton'] = FALSE;

//DB MY SQL DISPLAY
$db['db_covid']['hostname'] = '192.168.0.222';
$db['db_covid']['username'] = 'sa';
$db['db_covid']['password'] = 'Server03';
$db['db_covid']['database'] = 'DB_COVID';
$db['db_covid']['dbdriver'] = 'mssql';
$db['db_covid']['dbprefix'] = '';
$db['db_covid']['pconnect'] = TRUE;
$db['db_covid']['db_debug'] = TRUE;
$db['db_covid']['cache_on'] = FALSE;
$db['db_covid']['cachedir'] = '';
$db['db_covid']['char_set'] = 'utf8';
$db['db_covid']['dbcollat'] = 'utf8_general_ci';
$db['db_covid']['swap_pre'] = '';
$db['db_covid']['autoinit'] = TRUE;
$db['db_covid']['stricton'] = FALSE;

// $db['timbangan_default']['hostname'] = '192.168.0.249';
// $db['timbangan_default']['username'] = 'app_kanban';
// $db['timbangan_default']['password'] = 'nybemVdhLfQrH6C2';
// $db['timbangan_default']['database'] = 'kanban';
// $db['timbangan_default']['dbdriver'] = 'mysql';
// $db['timbangan_default']['dbprefix'] = '';
// $db['timbangan_default']['pconnect'] = TRUE;
// $db['timbangan_default']['db_debug'] = TRUE;
// $db['timbangan_default']['cache_on'] = FALSE;
// $db['timbangan_default']['cachedir'] = '';
// $db['timbangan_default']['char_set'] = 'utf8';
// $db['timbangan_default']['dbcollat'] = 'utf8_general_ci';
// $db['timbangan_default']['swap_pre'] = '';
// $db['timbangan_default']['autoinit'] = TRUE;
// $db['timbangan_default']['stricton'] = FALSE;

// $db['takaibiki']['hostname'] = '192.168.0.249';
// $db['takaibiki']['username'] = 'app_db_picking';
// $db['takaibiki']['password'] = 'C3HaEYUwNAHhTC7M';
// $db['takaibiki']['database'] = 'db_picking';
// $db['takaibiki']['dbdriver'] = 'mysql';
// $db['takaibiki']['dbprefix'] = '';
// $db['takaibiki']['pconnect'] = TRUE;
// $db['takaibiki']['db_debug'] = FALSE;
// $db['takaibiki']['cache_on'] = FALSE;
// $db['takaibiki']['cachedir'] = '';
// $db['takaibiki']['char_set'] = 'utf8';
// $db['takaibiki']['dbcollat'] = 'utf8_general_ci';
// $db['takaibiki']['swap_pre'] = '';
// $db['takaibiki']['autoinit'] = TRUE;
// $db['takaibiki']['stricton'] = FALSE;

$db['zsap']['hostname'] = '192.168.0.222';
$db['zsap']['username'] = 'sa';
$db['zsap']['password'] = 'Server03';
$db['zsap']['database'] = 'DB_AIS';
$db['zsap']['dbdriver'] = 'mssql';
$db['zsap']['dbprefix'] = '';
$db['zsap']['pconnect'] = TRUE;
$db['zsap']['db_debug'] = FALSE;
$db['zsap']['cache_on'] = FALSE;
$db['zsap']['cachedir'] = '';
$db['zsap']['char_set'] = 'utf8';
$db['zsap']['dbcollat'] = 'utf8_general_ci';
$db['zsap']['swap_pre'] = '';
$db['zsap']['autoinit'] = TRUE;
$db['zsap']['stricton'] = FALSE;

$db['db_infinity']['hostname'] = '192.168.0.222';
$db['db_infinity']['username'] = 'sa';
$db['db_infinity']['password'] = 'Server03';
$db['db_infinity']['database'] = 'DB_INFINITY';
$db['db_infinity']['dbdriver'] = 'mssql';
$db['db_infinity']['dbprefix'] = '';
$db['db_infinity']['pconnect'] = FALSE;
$db['db_infinity']['db_debug'] = TRUE;
$db['db_infinity']['cache_on'] = FALSE;
$db['db_infinity']['cachedir'] = '';
$db['db_infinity']['char_set'] = 'utf8';
$db['db_infinity']['dbcollat'] = 'utf8_general_ci';
$db['db_infinity']['swap_pre'] = '';
$db['db_infinity']['autoinit'] = TRUE;
$db['db_infinity']['stricton'] = FALSE;

// $db['zqa']['hostname'] = '192.168.0.249';
// $db['zqa']['username'] = '';
// $db['zqa']['password'] = '';
// //$db['zsap']['port'] = 1433;
// $db['zqa']['database'] = 'DB_AIS_QA';
// $db['zqa']['dbdriver'] = 'mssql';
// $db['zqa']['dbprefix'] = '';
// $db['zqa']['pconnect'] = TRUE;
// $db['zqa']['db_debug'] = FALSE;
// $db['zqa']['cache_on'] = FALSE;
// $db['zqa']['cachedir'] = '';
// $db['zqa']['char_set'] = 'utf8';
// $db['zqa']['dbcollat'] = 'utf8_general_ci';
// $db['zqa']['swap_pre'] = '';
// $db['zqa']['autoinit'] = TRUE;
// $db['zqa']['stricton'] = FALSE;

//AORTA
$db['aorta']['hostname'] = '192.168.0.222';
$db['aorta']['username'] = 'sa';
$db['aorta']['password'] = 'Server03';
$db['aorta']['database'] = 'DB_AORTA';
$db['aorta']['dbdriver'] = 'mssql';
$db['aorta']['dbprefix'] = '';
$db['aorta']['pconnect'] = FALSE;
$db['aorta']['db_debug'] = TRUE;
$db['aorta']['cache_on'] = FALSE;
$db['aorta']['cachedir'] = '';
$db['aorta']['char_set'] = 'utf8';
$db['aorta']['dbcollat'] = 'utf8_general_ci';
$db['aorta']['swap_pre'] = '';
$db['aorta']['autoinit'] = TRUE;
$db['aorta']['stricton'] = FALSE;

//EFILA
// $db['efila']['hostname'] = '192.168.0.249';
// $db['efila']['username'] = 'app_db_efila';
// $db['efila']['password'] = '0ec53c34ceb021b4';
// $db['efila']['database'] = 'DB_EFILA';
// $db['efila']['dbdriver'] = 'mssql';
// $db['efila']['dbprefix'] = '';
// $db['efila']['pconnect'] = FALSE;
// $db['efila']['db_debug'] = TRUE;
// $db['efila']['cache_on'] = FALSE;
// $db['efila']['cachedir'] = '';
// $db['efila']['char_set'] = 'utf8';
// $db['efila']['dbcollat'] = 'utf8_general_ci';
// $db['efila']['swap_pre'] = '';
// $db['efila']['autoinit'] = TRUE;
// $db['efila']['stricton'] = FALSE;

//DB MY SQL STOCK OPNAME ENTRY
// $db['stock_opname']['hostname'] = '192.168.0.249';
// $db['stock_opname']['username'] = 'app_stock_opname';
// $db['stock_opname']['password'] = '3uFGzACHaPWPmDRD';
// $db['stock_opname']['database'] = 'stock_opname';
// $db['stock_opname']['dbdriver'] = 'mysql';
// $db['stock_opname']['dbprefix'] = '';
// $db['stock_opname']['pconnect'] = TRUE;
// $db['stock_opname']['db_debug'] = TRUE;
// $db['stock_opname']['cache_on'] = FALSE;
// $db['stock_opname']['cachedir'] = '';
// $db['stock_opname']['char_set'] = 'utf8';
// $db['stock_opname']['dbcollat'] = 'utf8_general_ci';
// $db['stock_opname']['swap_pre'] = '';
// $db['stock_opname']['autoinit'] = TRUE;
// $db['stock_opname']['stricton'] = FALSE;

// //DB MY SQL STOCK OPNAME ENTRY
// $db['db_android']['hostname'] = '192.168.0.249';
// $db['db_android']['username'] = 'root';
// $db['db_android']['password'] = 'Server03';
// // $db['db_android']['username'] = 'app_db_android';
// // $db['db_android']['password'] = 'YaPMLGhSFwVS2dza';
// $db['db_android']['database'] = 'db_android';
// $db['db_android']['dbdriver'] = 'mysql';
// $db['db_android']['dbprefix'] = '';
// $db['db_android']['pconnect'] = TRUE;
// $db['db_android']['db_debug'] = TRUE;
// $db['db_android']['cache_on'] = FALSE;
// $db['db_android']['cachedir'] = '';
// $db['db_android']['char_set'] = 'utf8';
// $db['db_android']['dbcollat'] = 'utf8_general_ci';
// $db['db_android']['swap_pre'] = '';
// $db['db_android']['autoinit'] = TRUE;
// $db['db_android']['stricton'] = FALSE;

// $db['bgt_aii']['hostname'] = '192.168.0.249';
// $db['bgt_aii']['username'] = 'app_db_budget_aii';
// $db['bgt_aii']['password'] = 'wzRW2XJwrpQK3nQa';
// $db['bgt_aii']['database'] = 'DB_BUDGET_AII';
// $db['bgt_aii']['dbdriver'] = 'mssql';
// $db['bgt_aii']['dbprefix'] = '';
// $db['bgt_aii']['pconnect'] = FALSE;
// $db['bgt_aii']['db_debug'] = TRUE;
// $db['bgt_aii']['cache_on'] = FALSE;
// $db['bgt_aii']['cachedir'] = '';
// $db['bgt_aii']['char_set'] = 'utf8';
// $db['bgt_aii']['dbcollat'] = 'utf8_general_ci';
// $db['bgt_aii']['swap_pre'] = '';
// $db['bgt_aii']['autoinit'] = TRUE;
// $db['bgt_aii']['stricton'] = FALSE;


// $db['db_satel']['hostname'] = '192.168.0.250';
// $db['db_satel']['username'] = 'A3SAT';
// $db['db_satel']['password'] = 'A3SPW';
// $db['db_satel']['database'] = 'DB_INFINITY';
// $db['db_satel']['dbdriver'] = 'mssql';
// $db['db_satel']['dbprefix'] = '';
// $db['db_satel']['pconnect'] = FALSE;
// $db['db_satel']['db_debug'] = TRUE;
// $db['db_satel']['cache_on'] = FALSE;
// $db['db_satel']['cachedir'] = '';
// $db['db_satel']['char_set'] = 'utf8';
// $db['db_satel']['dbcollat'] = 'utf8_general_ci';
// $db['db_satel']['swap_pre'] = '';
// $db['db_satel']['autoinit'] = TRUE;
// $db['db_satel']['stricton'] = FALSE;

$db['financesoft']['hostname'] = '192.168.0.222';
$db['financesoft']['username'] = 'financesoft_admin';
$db['financesoft']['password'] = 'financesoft_admin';
$db['financesoft']['database'] = 'DB_FINANCESOFT';
$db['financesoft']['dbdriver'] = 'mssql';
$db['financesoft']['dbprefix'] = '';
$db['financesoft']['pconnect'] = TRUE;
$db['financesoft']['db_debug'] = FALSE;
$db['financesoft']['cache_on'] = FALSE;
$db['financesoft']['cachedir'] = '';
$db['financesoft']['char_set'] = 'utf8';
$db['financesoft']['dbcollat'] = 'utf8_general_ci';
$db['financesoft']['swap_pre'] = '';
$db['financesoft']['autoinit'] = TRUE;
$db['financesoft']['stricton'] = FALSE;


// DB_SAMANTA - Spare Parts Management System
// $db['samanta']['hostname'] = '192.168.0.223';
// $db['samanta']['username'] = 'app_db_samanta';
// $db['samanta']['password'] = 'pesjnVBh5eDfAxyu';
// $db['samanta']['database'] = 'DB_SAMANTA';
// $db['samanta']['dbdriver'] = 'mssql';
// $db['samanta']['dbprefix'] = '';
// $db['samanta']['pconnect'] = TRUE;
// $db['samanta']['db_debug'] = TRUE;
// $db['samanta']['cache_on'] = FALSE;
// $db['samanta']['cachedir'] = '';
// $db['samanta']['char_set'] = 'utf8';
// $db['samanta']['dbcollat'] = 'utf8_general_ci';
// $db['samanta']['swap_pre'] = '';
// $db['samanta']['autoinit'] = TRUE;
// $db['samanta']['stricton'] = FALSE;

// DB_SAMANTA - Spare Parts Management System
$db['samanta']['hostname'] = '192.168.0.222';
$db['samanta']['username'] = 'sa';
$db['samanta']['password'] = 'Server03';
$db['samanta']['database'] = 'DB_SAMANTA';
$db['samanta']['dbdriver'] = 'mssql';
$db['samanta']['dbprefix'] = '';
$db['samanta']['pconnect'] = TRUE;
$db['samanta']['db_debug'] = TRUE;
$db['samanta']['cache_on'] = FALSE;
$db['samanta']['cachedir'] = '';
$db['samanta']['char_set'] = 'utf8';
$db['samanta']['dbcollat'] = 'utf8_general_ci';
$db['samanta']['swap_pre'] = '';
$db['samanta']['autoinit'] = TRUE;
$db['samanta']['stricton'] = FALSE;

// $db['eids']['hostname'] = '192.168.0.249';
// $db['eids']['username'] = 'eng_application';
// $db['eids']['password'] = 'Engapp2013';
// $db['eids']['database'] = 'engineering';
// $db['eids']['dbdriver'] = 'mysql';
// $db['eids']['dbprefix'] = '';
// $db['eids']['pconnect'] = TRUE;
// $db['eids']['db_debug'] = FALSE;
// $db['eids']['cache_on'] = FALSE;
// $db['eids']['cachedir'] = '';
// $db['eids']['char_set'] = 'utf8';
// $db['eids']['dbcollat'] = 'utf8_general_ci';
// $db['eids']['swap_pre'] = '';
// $db['eids']['autoinit'] = TRUE;
// $db['eids']['stricton'] = FALSE;

$db['mssql']['hostname'] = '192.168.0.222';
$db['mssql']['username'] = 'sa';
$db['mssql']['password'] = 'Server03';
$db['mssql']['database'] = 'DB_MRP_DEV';
$db['mssql']['dbdriver'] = 'mssql';
$db['mssql']['dbprefix'] = '';
$db['mssql']['pconnect'] = TRUE;
$db['mssql']['db_debug'] = FALSE;
$db['mssql']['cache_on'] = FALSE;
$db['mssql']['cachedir'] = '';
$db['mssql']['char_set'] = 'utf8';
$db['mssql']['dbcollat'] = 'utf8_general_ci';
$db['mssql']['swap_pre'] = '';
$db['mssql']['autoinit'] = TRUE;
$db['mssql']['stricton'] = FALSE;

// $db['mrp_d']['hostname'] = '192.168.0.223';
// $db['mrp_d']['username'] = 'sa';
// $db['mrp_d']['password'] = 'Server03';
// $db['mrp_d']['database'] = 'DB_MRP';
// $db['mrp_d']['dbdriver'] = 'mssql';
// $db['mrp_d']['dbprefix'] = '';
// $db['mrp_d']['pconnect'] = TRUE;
// $db['mrp_d']['db_debug'] = FALSE;
// $db['mrp_d']['cache_on'] = FALSE;
// $db['mrp_d']['cachedir'] = '';
// $db['mrp_d']['char_set'] = 'utf8';
// $db['mrp_d']['dbcollat'] = 'utf8_general_ci';
// $db['mrp_d']['swap_pre'] = '';
// $db['mrp_d']['autoinit'] = TRUE;
// $db['mrp_d']['stricton'] = FALSE;

$db['dbqua']['hostname'] = '192.168.0.222';
$db['dbqua']['username'] = 'sa';
$db['dbqua']['password'] = 'Server03';
$db['dbqua']['database'] = 'DB_QUINSA';
$db['dbqua']['dbdriver'] = 'mssql';
$db['dbqua']['dbprefix'] = '';
$db['dbqua']['pconnect'] = TRUE;
$db['dbqua']['db_debug'] = FALSE;
$db['dbqua']['cache_on'] = FALSE;
$db['dbqua']['cachedir'] = '';
$db['dbqua']['char_set'] = 'utf8';
$db['dbqua']['dbcollat'] = 'utf8_general_ci';
$db['dbqua']['swap_pre'] = '';
$db['dbqua']['autoinit'] = TRUE;
$db['dbqua']['stricton'] = FALSE;

$db['qua_dev']['hostname'] = '192.168.0.222\DEV';
$db['qua_dev']['username'] = 'user_9042';
$db['qua_dev']['password'] = 'P@ssw0rd';
$db['qua_dev']['database'] = 'DB_QUINSA_DEV';
$db['qua_dev']['dbdriver'] = 'mssql';
$db['qua_dev']['dbprefix'] = '';
$db['qua_dev']['pconnect'] = TRUE;
$db['qua_dev']['db_debug'] = FALSE;
$db['qua_dev']['cache_on'] = FALSE;
$db['qua_dev']['cachedir'] = '';
$db['qua_dev']['char_set'] = 'utf8';
$db['qua_dev']['dbcollat'] = 'utf8_general_ci';
$db['qua_dev']['swap_pre'] = '';
$db['qua_dev']['autoinit'] = TRUE;
$db['qua_dev']['stricton'] = FALSE;

$db['ais_dev']['hostname'] = '192.168.0.222\DEV';
$db['ais_dev']['username'] = 'user_9042';
$db['ais_dev']['password'] = 'P@ssw0rd';
$db['ais_dev']['database'] = 'DB_AIS_DEV';
$db['ais_dev']['dbdriver'] = 'mssql';
$db['ais_dev']['dbprefix'] = '';
$db['ais_dev']['pconnect'] = TRUE;
$db['ais_dev']['db_debug'] = FALSE;
$db['ais_dev']['cache_on'] = FALSE;
$db['ais_dev']['cachedir'] = '';
$db['ais_dev']['char_set'] = 'utf8';
$db['ais_dev']['dbcollat'] = 'utf8_general_ci';
$db['ais_dev']['swap_pre'] = '';
$db['ais_dev']['autoinit'] = TRUE;
$db['ais_dev']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */