<?php
/**
 * Conditional comments
 *
 * 
 *
 * @package 3cb24
 */


$roleList = $args['role'];
$duration = $args['duration'];

// Check if the user has the required role
if (!empty($roleList)) {
    $allowEntry = false;
    foreach ($roleList as $role) {
        if (in_array($role, wp_get_current_user()->roles)) {
            $allowEntry = true;
            break;
        }
    }
    if (!$allowEntry) return;
}

// Check if all comments for this post have timed out
if ($duration!="" && $duration > 0) {
    $post_date = get_the_date('Y-m-d');
    $current_date = date('Y-m-d');
    $datetime1 = new DateTime($post_date);
    $datetime2 = new DateTime($current_date);
    $interval = $datetime1->diff($datetime2);
    $days_since_published = $interval->days;

    if ($days_since_published > $duration) {
        return;
    }
}

comments_template();