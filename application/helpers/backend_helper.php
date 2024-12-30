<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('time_elapsed_string')){
		function time_elapsed_string($datetime, $full = false) {
		    $now = new DateTime;
		    $ago = new DateTime($datetime);
		    $diff = $now->diff($ago);

		    $diff->w = floor($diff->d / 7);
		    $diff->d -= $diff->w * 7;

		    $string = array(
		        'y' => 'year',
		        'm' => 'month',
		        'w' => 'week',
		        'd' => 'day',
		        'h' => 'hour',
		        'i' => 'minute',
		        's' => 'second',
		    );
		    foreach ($string as $k => &$v) {
		        if ($diff->$k) {
		            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		        } else {
		            unset($string[$k]);
		        }
		    }

		    if (!$full) $string = array_slice($string, 0, 1);
		    return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
	}

	if ( ! function_exists('check_permission')){
		function check_permission($permission_id,$user_permissions) {
			if ($user_permissions[$permission_id] != 'Yes') {
				redirect('ct-admin/no-permission', 'refresh');
				exit();
			}
		}
	}

	if ( ! function_exists('geolocate_address')){
		function geolocate_address($city = null, $state = null, $zipcode = null, $address = null, $unit = null){
			$class =& get_instance();
			$bing_token = $class->config->item('bing_token');
			$search_string = 'http://dev.virtualearth.net/REST/v1/Locations/'.rawurlencode($address).rawurlencode($unit).rawurlencode($city).rawurlencode($state).rawurlencode($zipcode).'?o=json&maxResults=1&key='.$bing_token;
			$json_result = file_get_contents($search_string);

			$array_result = json_decode($json_result,true);
			if ($array_result['resourceSets'][0]['estimatedTotal'] == 1) {
				$return['latitude'] = $array_result['resourceSets'][0]['resources'][0]['point']['coordinates'][0];
				$return['longitude'] = $array_result['resourceSets'][0]['resources'][0]['point']['coordinates'][1];
	    	return $return;
			}else{
				return false;
			}
		}
	}

	if ( ! function_exists('generate_contract_status_badge')){
		function generate_contract_status_badge($status){
			switch ($status) {
				case 'Open':
					$badge = '<span class="badge badge-secondary">'.($status).'</span>';
				break;
				case 'Canceled':
					$badge = '<span class="badge badge-danger">'.($status).'</span>';
				break;
				case 'Expired':
					$badge = '<span class="badge badge-danger">'.($status).'</span>';
				break;
				case 'Completed':
					$badge = '<span class="badge badge-success">'.($status).'</span>';
				break;
				default:
				break;
			}
			return $badge;
		}
	}

	if ( ! function_exists('generate_contract_owner_badge')){
		function generate_contract_owner_badge($status, $prefix){
			switch ($status) {
				case 'Waiting':
					$badge = '<span class="badge badge-secondary">'.$prefix.strtolower($status).'</span>';
				break;
				case 'Declined':
					$badge = '<span class="badge badge-danger">'.$prefix.strtolower($status).'</span>';
				break;
				case 'Accepted':
					$badge = '<span class="badge badge-success">'.$prefix.strtolower($status).'</span>';
				break;
				default:
				break;
			}
			return $badge;
		}
	}

	if ( ! function_exists('generate_license_status_pill')){
		function generate_license_status_pill($status){
			switch ($status) {
				case 'Active':
					$pill = '<span class="badge badge-success">'.strtoupper($status).'</span>';
				break;
				case 'Declined':
					$pill = '<span class="badge badge-secondary">'.strtoupper($status).'</span>';
				break;
				case 'Pending':
					$pill = '<span class="badge badge-info">'.strtoupper($status).'</span>';
				break;
				case 'Expired':
				case 'Removed':
					$pill = '<span class="badge badge-danger">'.strtoupper($status).'</span>';
				break;
				default:
					$pill = '<span class="badge badge-secondary">'.strtoupper($status).'</span>';
				break;
			}
			return $pill;
		}
	}

	if ( ! function_exists('generate_property_badge')){
		function generate_property_badge($status, $extras = null){
			switch ($status) {
	  		case 'Pending':
	  			$badge = '<span class="badge badge-info '.$extras.'">Pending</span>';
	  			break;
	  		case 'Declined':
	  			$badge = '<span class="badge badge-danger '.$extras.'">Declined</span>';
	  			break;
	  		case 'Active':
	  			$badge = '<span class="badge badge-success '.$extras.'">Active</span>';
	  			break;
	  		case 'Contracted':
	  			$badge = '<span class="badge bg-purple '.$extras.'">Contracted</span>';
	  			break;
	  		case 'Inactivated':
	  			$badge = '<span class="badge badge-warning '.$extras.'">Inactivated</span>';
	  			break;
	  		case 'Deleted':
	  		default:
	  			$badge = '<span class="badge badge-danger '.$extras.'">Deleted</span>';
	  			break;
			}
			return $badge;
		}
	}

	if ( ! function_exists('generate_offer_badge')){
		function generate_offer_badge($status){
			switch ($status) {
				case 'Unread':
					$badge = '<span class="badge badge-secondary">'.$status.'</span>';
				break;
				case 'Declined':
					$badge = '<span class="badge badge-danger">'.$status.'</span>';
				break;
				case 'Read':
					$badge = '<span class="badge badge-primary">'.$status.'</span>';
				break;
				case 'Countered':
					$badge = '<span class="badge badge-warning">'.$status.'</span>';
				break;
				case 'Withdrawn':
					$badge = '<span class="badge badge-secondary">'.$status.'</span>';
				break;
				case 'Accepted':
					$badge = '<span class="badge badge-success">'.$status.'</span>';
				break;
				default:
				break;
			}
			return $badge;
		}
	}
