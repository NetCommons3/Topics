<?php
$channel = [
	'title' => Configure::read('App.siteName'),
	'link' => Configure::read('App.fullBaseUrl'),
	'guid' => Configure::read('App.fullBaseUrl'),
	'description' => Configure::read('App.siteDescription'),
];
$this->set('channel', $channel);
echo $this->Rss->items($topics, 'transformRSS');

function transformRSS($topics) {
	return array(
		'title' => h($topics['Topic']['title']), //投稿のタイトル
		'link' => array('action' => 'view', $topics['Topic']['path']), //投稿の個別ページへのリンク先
		'guid' => array('action' => 'view', $topics['Topic']['path']), //投稿の個別ページへのリンク先
		'description' => h(strip_tags($topics['Topic']['contents'])), //投稿の本文
		'pubDate' => $topics['Topic']['created'] //投稿日時
	);
}
