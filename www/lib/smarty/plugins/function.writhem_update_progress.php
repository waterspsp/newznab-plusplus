<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.writhem_update_progress.php
 * Type:     function
 * Name:     writhem_update_progress
 * Purpose:  returns the guid based on a comment's id when only a gid is present. 
 * -------------------------------------------------------------
 */
function smarty_function_writhem_update_progress($params, Smarty_Internal_Template $template)
{
$ER = "rawr";

$folder = '/mnt/adamo/nzbfiles/prologs/';
$files = array(
    array('part1.log','Binary Updater'),
    array('part2.log','Release Updater'),
    array('part3.log','MediaInfo Updater'),
    array('part4.log','Backlog Updater')
    );

foreach ($files as $file) {
    $filename = $folder . $file[0];
    if (file_exists($filename)) {
        $update_sec_ago = (time() - filemtime($filename))/60;
        
        if ($update_sec_ago < 360)
        {
            $icon = 'green.png';
        }
        elseif ($update_sec_ago < 1440)
        { 
            $icon = 'orange.png';
        }
        elseif ($update_sec_ago < 10080)
        {
            $icon = 'red.png';
        }
        else
        {
            $icon = 'black.png';
        }
            $title = $file[1] . ' - Last update: ' . sinceTime(filemtime($filename));
        // $data = file($filename);
        // $line = sinceTime(filemtime($filename)) . " ago:" . $data[count($data)-1];
    } else {
        $icon = 'black.png';
            $title = $file[1] . ': Currently Paused.';
    }
    
    echo "<img src='".WWW_TOP."/templates/writhem/images/status/$icon' title='$title'>";
}


}
function sinceTime ($time)
{
    $time = time() - $time; // to get the seconds since that moment
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $unit = 60;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}
?>
