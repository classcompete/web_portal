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

//$route['default_controller'] = "home";
/* angular default */
$route['default_controller'] = "dashboard";

/* student routs */
$route['student/class/(:num)'] = 'student/index/class/$1';

/*subject */
$route['classroom/available/challenge/(:num)'] = 'classroom/available/challenge/$1';

/* assigned challenges */
$route['assigned_challenge/(:num)'] = 'assigned_challenge/id/$0';
$route['assigned_challenge/single/(:num)/class/(:num)'] = 'assigned_challenge/single/challenge/$1/class/$2';
$route['assigned_challenge/(:any)/(:num)'] = 'assigned_challenge/index/challclass/$0';

/* challenge */
$route['challenge/(:num)'] = 'challenge/index/$0';

/* skill */
$route['skill/(:num)'] = 'skill/index/$0';

/* topic */
$route['topic/skill/(:num)'] = 'topic/index/skill/$0';

/* questions */
$route['question/challenge/(:num)'] = 'question/index/challenge/$1';
$route['question/(:num)'] = 'question/id/$1';
/* student */
$route['student/(:any)/(:num)/(:any)/(:num)'] = 'student/$1/id/$2/class/$4';
$route['student/(:num)'] = 'student/id/$0';

/* marketplace */
$route['marketplace/grade/(:any)'] = 'marketplace/id/grade/$0';

/* content builder */
$route['content_builder/single/(:num)'] = 'content_builder/single/challenge/$1';

/* stats route */
$route['stat/student_class_score/student/(:num)/class/(:num)'] = 'stat/student_class_score/id/student/$1/class/$2';
$route['stat/student_challenge_score_global/student/(:num)/class/(:num)'] = 'stat/student_challenge_score_global/id/student/$1/class/$2';
$route['stat/student_challenge_score_class/class/(:num)'] = 'stat/student_challenge_score_class/id/class/$1';
$route['stat/top_student_class/class/(:num)'] = 'stat/top_student_class/id/class/$1';
$route['stat/bottom_student_class/class/(:num)'] = 'stat/bottom_student_class/id/class/$1';
$route['stat/student_challenge_played_times/class/(:num)'] = 'stat/student_challenge_played_times/id/class/$1';
$route['stat/student_challenge_played_times_details/class/(:num)/student/(:num)'] = 'stat/student_challenge_played_times_details/index/class/$1/student/$2';
$route['stat/student_class_challenge_average/class/(:num)/student/(:num)'] = 'stat/student_class_challenge_average/index/class/$1/student/$2';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */