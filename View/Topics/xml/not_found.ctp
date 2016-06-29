<?php
/**
 * 新着表示view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$documentData = array();

$siteName = SiteSettingUtil::read('App.site_name');
$channelData = array(
	'title' => h(str_replace('{X-SITE_NAME}', $siteName, $topicFrameSetting['feed_title'])),
	'description' => h(str_replace('{X-SITE_NAME}', $siteName, $topicFrameSetting['feed_summary'])),
	'link' => $this->NetCommonsHtml->url(['action' => 'index']),
);

$channel = $this->Rss->channel(array(), $channelData, '');
echo $this->Rss->document($documentData, $channel);
