<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Maximum number of segments that Ar-acl should check
$config['segment_max']	= 3;

// variable session role id
$config['sess_role_var'] = "IGS.user_type";

// default role: this role will applied if there is no role found
$config['default_role'] = "User";

// Page that need to be controlled
$config['page_control'] = array(
    'agent/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(1, 2),                    // the allowed user role_id array (e.g. Accounting role is 2, Admin role is 1)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view employer's salary!",
    ),
	'salary/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(1, 2),                    // the allowed user role_id array (e.g. Accounting role is 2, Admin role is 1)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view employer's salary!",
    ),
);

// Page that need The Very Private Page (VPP) access control
$config['vpp_control'] = array(
    'test/salary/personal/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(0, 1),                    // the allowed user role_id array (e.g. user role is 0, Admin role is 1)
        'vpp_sess_name'        => 'user_id',          // variable session key for Very Private Page (VPP)
        'vpp_key'        => 4,          // number of segment in the uri that contain the information about vpp_sess_name (e.g. user_id)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view other's salary!",
    ),
    'test/profile/edit/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(0, 1),                    // the allowed user role_id array (e.g. user role is 0, Admin role is 1)
        'vpp_sess_name'        => 'user_id',          // variable session key for Very Private Page (VPP)
        'vpp_key'        => 4,          // number of segment in the uri that contain the information about vpp_sess_name (e.g. user_id)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view other's profile!",
    ),
    'salary/personal/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(0, 1),                    // the allowed user role_id array (e.g. user role is 0, Admin role is 1)
        'vpp_sess_name'        => 'user_id',          // variable session key for Very Private Page (VPP)
        'vpp_key'        => 3,          // number of segment in the uri that contain the information about vpp_sess_name (e.g. user_id)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view other's salary!",
    ),
    'profile/edit/' => array(                       // the "module/controller/method/" to protect
        'allowed'    => array(0, 1),                    // the allowed user role_id array (e.g. user role is 0, Admin role is 1)
        'vpp_sess_name'        => 'user_id',          // variable session key for Very Private Page (VPP)
        'vpp_key'        => 3,          // number of segment in the uri that contain the information about vpp_sess_name (e.g. user_id)
        'error_uri'  => '/staticpage/error_auth',  // the url to redirect to on failure
        'error_msg'  => "You do not have permission to view other's profile!",
    ),
);


/* End of file ar_acl.php */
/* Location: ./system/application/config/ar_acl.php */