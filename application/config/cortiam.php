<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['zoho_id'] = '1000.POKL5UPMAVIPGZCRL0D4EM9KJL2Q2O';
$config['zoho_secret'] = 'a68bb60349c1e1c8a877a5d07c4628993cd73cf0e0';
$config['zoho_refresh'] = '1000.8f227962a02d307f8204939c59fa4f3d.6f62d2709066a3e63df6e0dbdadd386e';
$ARRAYOFADMINEMAILS = array(
	'twedeveloper@gmail.com',
	'mwebbimg@gmail.com',
);
$config['admin_emails'] = $ARRAYOFADMINEMAILS;
$config['bing_token'] = 'Ari63vii-m7kr6bydGYkv1fp33BXTj1dLROxX4DRCw2OlGdc_6KsrjWSzzgKLiLL';
$config['zipcode_pattern'] = '/^[0-9]{5}(-[0-9]{4})?$/';
$config['phone_pattern'] = '~^\(?(1)?[-. ]?([0-9][0-9]{2})\)?[-. ]?([2-9](?!11)[0-9]{2})[-. ]?([0-9]{4})$~';
$config['email_pattern'] = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

$ARRAYOFRESIDENTALTYPES = array(
	'Apartment',
	'Single Family',
	'Multifamily',
	'Condo',
	'Townhomes',
	'Land/Lots',
	'Other',
);
$config['residental_types'] = $ARRAYOFRESIDENTALTYPES;

$ARRAYOFCOMMERCIALTYPES = array(
	'Office',
	'Industrial',
	'Retail',
	'Restaurant',
	'Shopping Center',
	'Health Care',
	'Hospitality',
	'Entertainment Facility',
	'Other',
);
$config['commercial_types'] = $ARRAYOFCOMMERCIALTYPES;

$ARRAYOFADMINPERMISSIONS = array(
	'seb1' => 'Administrators',
	10 => 'View List of Administrators',
	20 => 'Add New Administrator',
	30 => 'Edit Administrator',
	40 => 'Delete Administrator',
	41 => 'Enable/Disable Administrator',
	50 => 'Edit Administrators Permisson Details',
	51 => 'View Administrators Messages',
	52 => 'View Administrators Logs',
	'seb2' => 'Real Estate Agents',
	60 => 'View List of Agents',
	70 => 'Add New Agent',
	80 => 'Edit Agent',
	90 => 'Edit Agent Limits',
	160 => 'Add Free Package',
	100 => 'Delete Agent',
	101 => 'Enable/Disable Agent',
	120 => 'View Agents Properties',
	130 => 'View Agents Messages',
	140 => 'View Agents Proposals',
	150 => 'View Agents Contracts',
	170 => 'View Agents Purchase History',
	180 => 'Refund Agents Payment',
	'seb3' => 'Property Owners',
	190 => 'View List of Property Owner',
	200 => 'Add New Property Owner',
	210 => 'Edit Property Owner',
	220 => 'Approve Property Owner',
	230 => 'Delete Property Owner',
	231 => 'Enable/Disable Property Owner',
	240 => 'View Property Owners Messages',
	250 => 'View Property Owners Proposals',
	260 => 'View Property Owners Contracts',
	'seb31' => 'Waitlist',
	261 => 'View Waiting Users',
	262 => 'Delete Waiting User',
	'seb4' => 'Properties',
	270 => 'View List of Properties',
	280 => 'Add New Property',
	290 => 'Edit Property',
	300 => 'Set Frontend Photo',
	310 => 'Delete Property',
	320 => 'View Property Proposals',
	'seb5' => 'Approvals',
	330 => 'View Approval List of Property Owners',
	340 => 'Approve&Decline Property Owners',
	350 => 'View Approval List of Agents',
	360 => 'Approve&Decline Agents',
	370 => 'View Approval List of Properties',
	380 => 'Approve&Decline Properties',
	'seb6' => 'Coupons',
	400 => 'View List of Coupons',
	410 => 'Add New Coupon',
	420 => 'Edit Coupon',
	430 => 'Delete Coupon',
	'seb7' => 'Location',
	440 => 'View List States',
	441 => 'Add New State',
	442 => 'Edit State',
	443 => 'Delete State',
	450 => 'View List Cities',
	451 => 'Add New City',
	452 => 'Edit City',
	453 => 'Delete City',
	'seb8' => 'Messages',
	480 => 'View List of Messages',
	'seb10' => 'Proposals',
	500 => 'View List of Proposals',
	'seb11' => 'Contracts',
	510 => 'View List of Contracts',
	'seb12' => 'Reporting',
	520 => 'View User Reporting',
	530 => 'View Properties Reporting',
	540 => 'View Financial Reporting ',
	'seb13' => 'Tutorial Pages',
	550 => 'View&Edit Tutorial Pages',
	'seb14' => 'Settings',
	560 => 'View Settings',
	570 => 'Update Settings',
	575 => 'Edit Free Payment Periods',
	576 => 'Edit Signup Settings',
	'seb15' => 'Support',
	580 => 'View&Reply Property Owners Support Requests',
	600 => 'View&Reply Agent Support Requests',
);
$config['admin_permissions'] = $ARRAYOFADMINPERMISSIONS;

$ARRAYOFADMINNOTIFICATIONS = array(
	10 => 'New Waiting List User Email',
	20 => 'New Administrator Email',
	30 => 'Delete Administrator Email',
	31 => 'Enable/Disable Administrator Email',
	40 => 'New Real Estate Agents Email',
	50 => 'Real Estate Agents Approval Email',
	60 => 'Delete Real Estate Agents Email',
	61 => 'Enable/Disable Real Estate Agents Email',
	70 => 'New Property Owner Email',
	80 => 'Property Owner Approval Email',
	90 => 'Delete Property Owner Email',
	91 => 'Enable/Disable Property Owner Email',
	100 => 'New Property Email',
	110 => 'Property Approval Email',
	120 => 'Delete Property Email',
	130 => 'New Real Estate Agents Support Request Email',
	140 => 'New Property Owner Support Request Email',
	150 => 'Contact Emails',
	160 => 'Join Us Emails',
);
$config['admin_notifications'] = $ARRAYOFADMINNOTIFICATIONS;

$ARRAYOFSELLERNOTIFICATIONS = array(
	20 => 'Email Notifications',
);
$config['seller_notifications'] = $ARRAYOFSELLERNOTIFICATIONS;

