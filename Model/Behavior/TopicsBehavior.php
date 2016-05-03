<?php
/**
 * Topics Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Topics Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model\Behavior
 */
class TopicsBehavior extends ModelBehavior {

/**
 * タイトルの最大文字数
 *
 * @var int
 */
	const MAX_TITLE_LENGTH = 255;

/**
 * タイトル表示時の文字数
 *
 * @var int
 */
	const DISPLAY_TITLE_LENGTH = 64;

/**
 * Delimiter
 *
 * @var string
 */
	public $delimiter = ' ';

/**
 * ビヘイビアの設定
 *
 * @var array
 * @see ModelBehavior::$settings
 */
	public $settings = array(
		'fields' => array(
			'title' => '', //必須項目
			'contents' => '', //必須項目
			'content_key' => 'key',
			'content_id' => 'id',
			'path' => '/:plugin_key/:plugin_key/view/:block_id/:content_key',
			'title_icon' => null,
			'category_id' => null,
			'public_type' => null,
			'publish_start' => null,
			'publish_end' => null,
			'is_active' => null,
			'is_latest' => null,
			'status' => null,
		),
		'search_contents' => array(
			//ここにフィールドを追加、デフォルトでfields.contentsの内容が含まれる
		),
		'users' => array('0')
	);

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		//fields.title及びfields.contentsの必須チェック
		if (! Hash::get($config, 'fields.title')) {
			trigger_error('The "title" field in $this->settings has not been set.', E_USER_WARNING);
		}
		if (! Hash::get($config, 'fields.contents')) {
			trigger_error('The "contents" field in $this->settings has not been set.', E_USER_WARNING);
		}

		$this->settings = Hash::merge($this->settings, $config);

		//コンテンツは配列とする
		if (is_string(Hash::get($this->settings, 'fields.contents'))) {
			$this->settings['fields']['contents'] = array(Hash::get($this->settings, 'fields.contents'));
		}

		//モデル名を付与する
		$this->__setupFields($model);

		//検索項目にfields.contentsの内容を含む
		$this->settings['search_contents'] = array_merge(
			$this->settings['search_contents'], $this->settings['fields']['contents']
		);
	}

/**
 * $this->settings['fields']のセットアップ
 *
 * @param Model $model 呼び出し元のモデル
 * @return void
 */
	private function __setupFields(Model $model) {
		//モデル名を付与する
		$fields = $this->settings['fields'];
		$fields = Hash::remove($fields, 'path');
		$fields = Hash::remove($fields, 'contents');

		$fieldKeys = array_keys($fields);
		foreach ($fieldKeys as $field) {
			$value = Hash::get($this->settings['fields'], $field);
			if (Hash::get($this->settings['fields'], $field) === false) {
				continue;
			}
			if (! $value && $model->hasField($field)) {
				$this->settings['fields'][$field] = $model->alias . '.' . $field;
			}
			$value = Hash::get($this->settings['fields'], $field);
			if (strpos($value, '.') === false) {
				$this->settings['fields'][$field] = $model->alias . '.' . $value;
			}
		}
		foreach ($this->settings['fields']['contents'] as $i => $field) {
			if (strpos($value, '.') === false) {
				$this->settings['fields']['contents'][$i] = $model->alias . '.' . $field;
			}
		}
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model 呼び出し元のモデル
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @see Model::save()
 */
	public function afterSave(Model $model, $created, $options = array()) {
		if (! Hash::check($model->data, $this->settings['fields']['title'])) {
			return true;
		}
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		//新着データの登録
		$this->__saveTopic($model);

		//既読データのクリア
		$this->__deleteTopicUserStatus($model);

		//新着に表示させる会員のリスト登録
		CakeLog::debug(var_export($model->data, true));

		$topicIds = Hash::extract($model->data, $model->Topic->alias . '.{n}.id');
		foreach ($topicIds as $topicId) {
			$this->__saveTopicReadable($model, $topicId);
		}

		return parent::afterSave($model, $created, $options);
	}

/**
 * 保存する新着データの取得
 *
 * self::afterSave()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return array
 * @throws InternalErrorException
 */
	private function __saveTopic(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
		]);

		$topic = $this->__getTopicForSave($model);

		if (Current::read('Frame.block_id') !== Current::read('Block.id')) {
			$topic = Hash::remove($topic, '{n}.{s}.frame_id');
		}

		$setting = $this->settings['fields'];

		//登録するデータセット
		$merge = array(
			'content_key' => Hash::get($model->data, $setting['content_key']),
			'content_id' => Hash::get($model->data, $setting['content_id']),
			'title' => $this->__parseTitle($model),
			'contents' => $this->__parseContents($model),
			'search_contents' => $this->__parseSearchContents($model),
		);

		$fields1 = array(
			'category_id', 'public_type', 'publish_start', 'publish_end', 'status'
		);
		foreach ($fields1 as $field) {
			if (! Hash::get($model->data, $setting[$field])) {
				continue;
			}
			$merge[$field] = Hash::get($model->data, $setting[$field]);
		}

		$fields2 = array(
			'created_user', 'created', 'modified_user', 'modified'
		);
		foreach ($fields2 as $field) {
			if (! Hash::get($model->data, $model->alias . '.' . $field)) {
				continue;
			}
			$merge[$field] = Hash::get($model->data, $model->alias . '.' . $field);
		}

		//登録処理
		foreach ($topic as $data) {
			$saveData = Hash::merge($data[$model->Topic->alias], $merge);
			$saveData['path'] = $this->__parsePath($model, $saveData);

			$model->Topic->create(false);
			$result = $model->Topic->save($saveData);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$topicId = $result[$model->Topic->alias]['id'];
			$model->data[$model->Topic->alias][$topicId] = $result[$model->Topic->alias];
		}

		return true;
	}

/**
 * 新着のタイトルにパースする
 *
 * self::__saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	private function __parseTitle(Model $model) {
		$setting = $this->settings['fields'];

		$title = Hash::get($model->data, $setting['title']);
		$result = mb_strimwidth(strip_tags($title), 0, self::MAX_TITLE_LENGTH);
		if (preg_replace('/(\s|　)/', '', $result) === '') {
			$result = mb_strimwidth($title, 0, self::MAX_TITLE_LENGTH);
		}
		$result = trim($result);

		return $result;
	}

/**
 * 新着のコンテンツにパースする
 *
 * self::__saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	private function __parseContents(Model $model) {
		$setting = $this->settings['fields'];
		$result = '';

		foreach ($setting['contents'] as $field) {
			$value = Hash::extract($model->data, $field);
			$result .= implode($this->delimiter, $value);
			$result .= chr(10);
		}

		return strip_tags($result);
	}

/**
 * リンク先のPathにパースする
 *
 * self::__saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $saveData 登録するデータ
 * @return string
 */
	private function __parsePath(Model $model, $saveData) {
		$setting = $this->settings['fields'];
		$result = $setting['path'];

		foreach ($saveData as $key => $value) {
			$result = preg_replace('/' . preg_quote(':' . $key, '/') . '/', $value, $result);
		}

		return $result;
	}

/**
 * 検索対象データにパースする
 *
 * self::__saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	private function __parseSearchContents(Model $model) {
		$result = array();

		foreach ($this->settings['search_contents'] as $field) {
			$value = Hash::extract($model->data, $field);
			$result[] = $value;
		}

		return serialize($result);
	}

/**
 * 保存する新着データの取得
 *
 * self::__saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return array
 */
	private function __getTopicForSave(Model $model) {
		$topic = array();

		$setting = $this->settings['fields'];
		if ($model->hasField('is_latest') && Hash::get($model->data, $setting['is_latest'])) {
			$topic[] = $this->__getTopic($model,
				['is_latest' => Hash::get($model->data, $setting['is_latest'])]
			);
		}
		if ($model->hasField('is_active') && Hash::get($model->data, $setting['is_active'])) {
			$topic[] = $this->__getTopic($model,
				['is_active' => Hash::get($model->data, $setting['is_active'])]
			);
		}
		if (! $topic) {
			$topic[] = $this->__getTopic($model);
		}

		return $topic;
	}

/**
 * 保存する新着データの取得
 *
 * self::__getTopicForSave()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $addConditions 追加条件
 * @return array
 */
	private function __getTopic(Model $model, $addConditions = array()) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
		]);

		$setting = $this->settings['fields'];
		if (Hash::get($model->data, $model->alias . '.key')) {
			$defaultConditions = array(
				'plugin_key' => Current::read('Plugin.key'),
				'language_id' => Current::read('Language.id'),
				'content_key' => Hash::get($model->data, $setting['content_key']),
			);
		} else {
			$defaultConditions = false;
		}

		if ($defaultConditions) {
			$conditions = Hash::merge($defaultConditions, $addConditions);
			$result = $model->Topic->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			));
		} else {
			$result = false;
		}
		if (! $result) {
			$result = $model->Topic->create($conditions);
		}

		$result = Hash::insert($result, '{s}.frame_id', Current::read('Frame.id'));
		return $result;
	}

/**
 * 既読データのクリア
 *
 * @param Model $model 呼び出し元のモデル
 * @return array
 * @throws InternalErrorException
 */
	private function __deleteTopicUserStatus(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
		]);

		$topicId = Hash::extract($model->data, $model->Topic->alias . '.{n}.id');

		$conditions = array($model->TopicUserStatus->alias . '.id' => $topicId);
		if (! $model->TopicUserStatus->deleteAll($conditions, false, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * 新着に表示させる会員のリスト登録
 *
 * @param Model $model 呼び出し元のモデル
 * @param int $topicId トピックID
 * @return array
 * @throws InternalErrorException
 */
	private function __saveTopicReadable(Model $model, $topicId) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		foreach ($this->settings['users'] as $userId) {
			$conditions = array('topic_id' => $topicId, 'user_id' => $userId);
			$count = $model->TopicReadable->find('count', array(
				'recursive' => -1,
				'conditions' => $conditions,
			));
			if ($count === 0) {
				$model->TopicReadable->create(false);
				$result = $model->TopicReadable->save($conditions);
				if (! $result) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}
		}

		return true;
	}

}
