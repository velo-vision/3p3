<?php
/**
 * Compatibility with exifography plugin
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'loop_start', 'eram_add_exif_filter' );
function eram_add_exif_filter() {
	if ( is_attachment() )
		add_filter('exifography_display_exif', 'eram_exifography_filter');
}

/**
* filter the exifography output
*/
if ( ! function_exists('eram_exifography_filter') )
{
	function eram_exifography_filter($exif) {
		if ( ! is_array($exif) )
			return $exif;

		if ( count($exif) < 1 )
			return $exif;

		$exif_class = new exifography();
		$options = get_option($exif_class->exif_options);
		$sep = $options['sep'];

		// remove labels
		foreach ($exif as $key=>$li) {
			$temp = eram_delete_all_between('">',$sep,$li);
			$exif[$key] = eram_add_title_to_exif($temp[0],$temp[1],$sep);
		}

		// move camera to the top
		if ( array_key_exists('camera', $exif) )
		{
			$camera = $exif['camera'];
			unset( $exif['camera'] );
			$exif =  array('camera'=>$camera) + $exif;
		}else{
			$camera = '<li class="camera"></li>';
			$exif =  array('camera'=>$camera) + $exif;
		}

		// move location to end
		if ( array_key_exists('location', $exif) )
		{
			$location = $exif['location'];
			unset($exif['location']);
			$exif =  $exif + array('location'=>$location);
		}

		return $exif;
	}
}


function eram_delete_all_between($beginning, $end, $string) {
	$beginningPos = strpos($string, $beginning) + strlen($beginning);
	$endPos = strpos($string, $end);
	if ($beginningPos === false || $endPos === false) {
		return array(
			$string,
			''
		);
	}

	$textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

	return array(
		str_replace($textToDelete, '', $string),
		$textToDelete
	);
}

function eram_add_title_to_exif($html, $title, $separator)
{
	// remove sep from title
	if (strpos($title, $separator, strlen($title) - strlen($separator)) !== false) {
        $title = substr($title, 0, -strlen($separator));
    }

    // add title
    $html = substr_replace($html, 'title="'.$title.'" ', strpos($html, 'class'), 0);
	
	return $html;
}