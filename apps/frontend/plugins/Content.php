<?php
namespace Chen\Frontend\Plugins;

use Chen\Plugins\ChenHookPlugin;

class Content
{
	public function __construct()
	{
		ChenHookPlugin::add_action('the_content', __NAMESPACE__ .'\\'.'Content::content');
	}
	public static function content($content)
	{
		return '<p>asdgasg</p>';
	}
}

//ChenHookPlugin::add_action('the_content', __NAMESPACE__ .'\\'.'Content::content');

//ChenHookPlugin::do_action('the_content', array($content));