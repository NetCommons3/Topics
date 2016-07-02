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

$camelizeData = $this->Topics->camelizeKeyRecursive($topics);

$documentData = array(
	'xmlns:content' => 'http://purl.org/rss/1.0/modules/content/'
);

$siteName = SiteSettingUtil::read('App.site_name');
$channelData = array(
	'title' => h(str_replace('{X-SITE_NAME}', $siteName, $topicFrameSetting['feed_title'])),
	'description' => h(str_replace('{X-SITE_NAME}', $siteName, $topicFrameSetting['feed_summary'])),
	'link' => $this->NetCommonsHtml->url(['action' => 'index']),
);

$content = '';
foreach ($camelizeData as $item) {
	// フィードの本文が正しくなるよう HTML の削除とエスケープ
	$bodyText = $this->Text->truncate($item['topic']['displaySummary'], 400, array(
		'ending' => '...',
		'exact' => true,
		'html' => true,
	));

	$contentData = array(
		'title' => h($item['topic']['displayTitle']),
		'link' => $item['topic']['path'],
		'guid' => array('url' => $item['topic']['path'], 'isPermaLink' => 'true'),
		'description' => $bodyText,
		'pubDate' => $item['topic']['publishStart'],
		'content::encoded' => array('value' => $item['topic']['summary']),
	);
	if ($item['category']['name']) {
		$contentData['category'] = h($item['category']['displayName']);
	}

	$content .= $this->Rss->item(array(), $contentData);
}

$channel = $this->Rss->channel(array(), $channelData, $content);
echo '<?xml version="1.0"?>' . chr(13);
echo preg_replace('/::/', ':', $this->Rss->document($documentData, $channel));
