<?php
/*
 * Enfold Child theme functions file
 */
/*
 * Adds support for LearnDash & Page Builder
 */
add_filter('avf_builder_boxes', 'learndash_add_builder_to_posttype');
function learndash_add_builder_to_posttype($metabox){
	foreach($metabox as &$meta) {
		if($meta['id'] == 'avia_builder' || $meta['id'] == 'layout') {
			$meta['page'][] = 'sfwd-courses';
      			$meta['page'][] = 'sfwd-lessons';
      			$meta['page'][] = 'sfwd-topic';
      			$meta['page'][] = 'sfwd-courses';
      			$meta['page'][] = 'sfwd-quiz';
      			$meta['page'][] = 'sfwd-certificates';
		}
	}
	return $metabox;
}

/*************************************************/
/* Remove (hide) various activities from streams */
/*************************************************/
function my_hidden_activities($a, $activities) {
	/*---------------------------------------------------*/
	/* to view if you're an ADMIN, uncomment lines below */
	/*---------------------------------------------------*/
	// if (is_site_admin())
		// return $activities;
	$nothanks = array(“new_forum_topic”, “new_blog_post”, “created_group”, “joined_group”, “new_member”, “friendship_created”);
	foreach ($activities->activities as $key => $activity) {
		if (in_array($activity->type, $nothanks, true)) {
			unset($activities->activities[$key]);
			$activities->activity_count = $activities->activity_count-1;
			$activities->total_activity_count = $activities->total_activity_count-1;
			$activities->pag_num = $activities->pag_num -1;
		}
	}
	/* Renumber the array keys to account for missing items */
	$activities_new = array_values( $activities->activities );
	$activities->activities = $activities_new;
	return $activities;
}
add_action(‘bp_has_activities’, ‘my_hidden_activities’, 10, 2 );
