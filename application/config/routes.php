<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login_c";
$route['404_override'] = 'fail_c';

$route['inesstp/(:any)'] = 'pes/ines_manufacture_trial_c/line/$1';
$route['inesset/(:any)'] = 'pes/ines_ogawa_c/index/$1';
$route['inesprd/(:any)'] = 'pes/ines_ogawa_c/line/$1';
$route['inesasm/(:any)'] = 'pes/ines_assy_c/line/$1';
$route['inescoil/(:any)'] = 'pes/ines_manufacture_c/line/$1';
$route['inespps/(:any)'] = 'pes/ines_spps_c/line/$1';
$route['inesinj/(:any)'] = 'pes/ines_injection_c/line/$1';
$route['dandori_board/(:any)'] = 'prd/dandori_board_c/index/$1';

$route['getGuest'] = 'welcome_board/board_c/getGuest';

/* End of file routes.php */
/* Location: ./application/config/routes.php */