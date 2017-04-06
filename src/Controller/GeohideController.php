<?php
/**
 * @file
 * Contains Drupal\geohide\Controller\GeohideController.
 */
namespace Drupal\geohide\Controller;
use Drupal\node\Entity\Node;
class GeohideController {
	function getIP() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	    {
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
	/**
 * Implements hook_node_view().
 *
 * Changes the way the node information is displayed on screen.
 *
 * In this case, it was added a geographic filter to avoid using ip2location or geoplugin webservice to filter the showing of field phonenumber
 */
 
function geohide_entity_view($node, $view_mode) {
	$ip = getIP();
	
	// Uncomment these lines if you want to use ip2location xml webservice
	// $xml = simplexml_load_file("http://api.ip2location.com/?ip={$ip}&key=demo&package=WS3&format=xml");
	// $cityvisitor = $xml->city_name;
	
	// Uncomment these lines if you want to use geoplugin xml webservice
	//$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip={$ip}");
	//$cityvisitor = $xml->geoplugin_city;
	
	// Uncomment these lines if you want to use ip2location json webservice
	$json = file_get_contents("http://api.ip2location.com/?ip={$ip}&key=demo&package=WS3&format=json");
	$array = json_decode($json, true);
	$cityvisitor = $array['city_name'];
	
	
    if ($node->title=="nodetitle" && $cityvisitor=='cityvisitor'){
        if ($view_mode == 'full'){
            $node->content['field_correo']['#access'] = FALSE;     
           }
         return $node;
    }    
}

}

