<?php
/*
Plugin Name: SubPage List
Plugin URI: https://github.com/bobboteck/Plugin_SubPage_List
Description: This plugin use the shortcut to show subpage in the parent page
Version: 0.1.2
Author: Roberto D'Amico
Author URI: http://www.officinerobotiche.it/
*/
echo '<link rel="stylesheet" href="'.plugins_url('css/style.css', __FILE__).'" > ';

function Bobboteck_PageList()
{
	$PagesHtml = '<div class="subpage-list">';
	
	$SubPages_Args = array(
		'sort_order' => 'asc',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => get_the_ID(),
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '', 
		'offset' => 0, 
		'post_type' => 'page',
		'post_status' => 'publish',
	);
	
	$PageCounter = 0;
	$Pages = get_pages($SubPages_Args);
	
	if ($Pages !== false && count($Pages) > 0) 
	{
		foreach($Pages as $SubPage)
		{
			$SubPageLink = get_permalink($SubPage->ID);
			// Contenitore riga
			if(($PageCounter % 3) == 0)
			{
				$PagesHtml .= '<div class="subpage-row">';
			}
			// Contenitore Articolo
			$PagesHtml .= '<article id="page-'.$SubPage->ID.'" class="subpage"><div class="subpage-inner">';
			// Sezione thumbnail
			$ImgTag = get_the_post_thumbnail($SubPage->ID);
			if(strlen($ImgTag)>0)
			{
				$PagesHtml .= '<div class="subpage-thumbnail">';
				$PagesHtml .= '<a href="'.$SubPageLink.'">'.$ImgTag.'</a>';
				$PagesHtml .= '</div>';
			}
			else
			{
				$PagesHtml .= '<div class="subpage-thumbnail">';
				$PagesHtml .= '<a href="'.$SubPageLink.'"><img src="'.plugins_url('img/nothumb.png', __FILE__).'"></a>';
				$PagesHtml .= '</div>';
			}
			// Sezione info
			$PagesHtml .= '<div class="subpage-info"><p class="subpage-category">'.$SubPage->post_author.'</p><p class="subpage-date">'.$SubPage->post_date.'</p></div>';
			// Titolo
			$PagesHtml .= '<div class="subpage-title"><a href="'.$SubPageLink.'">'.esc_attr($SubPage->post_title).'</a></div>';
			// Testo
			$PageContent = $SubPage->post_content;
			$PagesHtml .= '<div class="tutorial-text"><p>'.substr($PageContent,0,200).'</p></div>';
			
			////$PagesHtml .= '<a href="'.$SubPageLink.'" title="'.esc_attr($SubPage->post_title).'" alt="'.$SubPage->ID.'">'.$SubPage->post_title.'</a><br>';
			// Fine contenitore Articolo
			$PagesHtml .= '</div></article>';
			// Fine contenitore riga
			if(($PageCounter % 3) == 2)
			{
				$PagesHtml .= '</div>';
			}
			
			$PageCounter++;
		}
		// Se non ha chiuso il DIV di riga
		if(substr($PagesHtml, -6) !== '</div>')
		{
			$PagesHtml .= '</div>';
		}
	}
	else
	{
		$PagesHtml = 'No sub page to show!';
	}
	
	$PagesHtml .= '</div>';
	
	return $PagesHtml;
}
add_shortcode('or-subpage-list', 'Bobboteck_PageList');
?>
