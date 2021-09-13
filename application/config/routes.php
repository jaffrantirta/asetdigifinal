<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'customer';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['send-email'] = 'email controller';
$route['email'] = 'Auth';

$route['register'] = 'Customer/register';

//APIs
$route['api/total_bonus'] = 'Api/total_bonus';
$route['api/pairing_bonus'] = 'Api/pairing_bonus';
$route['api/withdraw'] = 'Api/withdraw';
$route['api/withdraw_detail'] = 'Api/withdraw_detail';
$route['api/update_status_withdraw'] = 'Api/update_status_withdraw';
$route['api/forgot_password'] = 'Api/forgot_password';
$route['api/reset_password'] = 'Api/reset_password';
$route['api/change_secure_pin'] = 'Api/change_secure_pin';
$route['api/user_detail'] = 'Api/user_detail';