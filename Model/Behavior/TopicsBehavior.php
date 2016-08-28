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
class TopicsBehavior extends TopicsBaseBehavior {

/**
 * ビヘイビアの設定
 *
 * @var array
 * @see ModelBehavior::$settings
 */
	protected $_settings = array(
		'fields' => array(
			'title' => '', //必須項目
			'summary' => '', //必須項目
			'content_key' => 'key',
			'content_id' => 'id',
			'path' => '/:plugin_key/:plugin_key/view/:block_id/:content_key',
			'title_icon' => null,
			'category_id' => null,
			'public_type' => null,
			'publish_start' => null,
			'publish_end' => null,
			'is_no_member_allow' => null,
			'is_answer' => false,
			'answer_period_start' => null,
			'answer_period_end' => null,
			'is_active' => null,
			'is_latest' => null,
			'status' => null,
		),
		'search_contents' => array(
			//ここにフィールドを追加、デフォルトでfields.titleとfields.summaryの内容が含まれる
		),
		'users' => array('0'),
		'is_workflow' => true,
		'data' => array(),
		'titleHtml' => false,
		'summaryWysiwyg' => false,
	);

/**
 * 削除するデータ保持用配列
 *
 * @var array
 */
	protected $_deletedRow = array();

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);
		$this->settings[$model->alias] = Hash::merge($this->_settings, $config);

		//コンテンツは配列とする
		if (is_string(Hash::get($this->settings[$model->alias], 'fields.summary'))) {
			$this->settings[$model->alias]['fields']['summary'] = array(
				Hash::get($this->settings[$model->alias], 'fields.summary')
			);
		}

		//モデル名を付与する
		$this->_setupFields($model);

		//検索項目にfields.summaryの内容を含む
		$this->_setupSearchContents($model);

		$fields = $this->settings[$model->alias]['fields'];

		$isAnswer = $fields['answer_period_start'] || $fields['answer_period_end'];
		$this->settings[$model->alias]['fields']['is_answer'] = $isAnswer;
	}

/**
 * saveTopics
 *
 * @param Model $model 呼び出し元のモデル
 * @return bool
 */
	public function saveTopics(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		//新着データの登録
		$this->_saveTopic($model);

		//既読データのクリア
		$this->_deleteTopicUserStatus($model);

		//新着に表示させる会員のリスト登録
		$topicIds = Hash::extract($model->data, $model->Topic->alias . '.{n}.id');
		foreach ($topicIds as $topicId) {
			$this->_saveTopicReadable($model, $topicId);
		}

		return true;
	}

/**
 * beforeDeleteTopics
 *
 * @param Model $model 呼び出し元のモデル
 * @return bool
 */
	public function beforeDeleteTopics(Model $model) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
			'Topic' => 'Topics.Topic',
		]);

		//idからkey取得
		if (! $model->blockId && ! $model->blockKey && ! $model->contentKey && $model->hasField('key')) {
			$content = $model->find('first', array(
				'recursive' => -1,
				'fields' => array('id', 'key'),
				'conditions' => array('id' => $model->id)
			));
			$model->contentKey = Hash::get($content, $model->alias . '.key');

		} elseif ($model->blockId && ! $model->blockKey) {
			$block = $model->Block->find('first', array(
				'recursive' => -1,
				'fields' => array('id', 'key'),
				'conditions' => array('id' => $model->blockId)
			));
			$model->blockKey = Hash::get($block, $model->Block->alias . '.key');
		}

		//削除するトピックID取得
		$this->_deleteRow = array();
		if ($model->blockKey) {
			$blockIds = $model->Block->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'id'),
				'conditions' => array('key' => $model->blockKey)
			));

			$result = $model->Topic->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'id'),
				'conditions' => array('block_id' => $blockIds)
			));
			$this->_deleteRow = array_values($result);

		} elseif ($model->contentKey) {
			$result = $model->Topic->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'id'),
				'conditions' => array('content_key' => $model->contentKey)
			));
			$this->_deleteRow = array_values($result);
		}

		return true;
	}

/**
 * afterDeleteTopics
 *
 * @param Model $model 呼び出し元のモデル
 * @return void
 * @throws InternalErrorException
 */
	public function afterDeleteTopics(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicReadable' => 'Topics.TopicReadable',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
		]);

		if ($this->_deleteRow) {
			//読めるかどうかデータ削除
			$conditions = array($model->TopicReadable->alias . '.topic_id' => $this->_deleteRow);
			$result = $model->TopicReadable->deleteAll($conditions, false, false);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//既読データ削除
			$conditions = array($model->TopicUserStatus->alias . '.topic_id' => $this->_deleteRow);
			$result = $model->TopicUserStatus->deleteAll($conditions, false, false);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//新着データの削除
			$conditions = array($model->Topic->alias . '.id' => $this->_deleteRow);
			$result = $model->Topic->deleteAll($conditions, false, false);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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
		//$options['fieldList']がセットされているときは、saveFieldから実行されたとして判断し、処理しない
		if ($options['fieldList']) {
			return true;
		}

		$this->saveTopics($model);

		return parent::afterSave($model, $created, $options);
	}

/**
 * Before delete is called before any delete occurs on the attached model, but after the model's
 * beforeDelete is called. Returning false from a beforeDelete will abort the delete.
 *
 * @param Model $model Model using this behavior
 * @param bool $cascade If true records that depend on this record will also be deleted
 * @return mixed False if the operation should abort. Any other result will continue.
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeDelete(Model $model, $cascade = true) {
		return $this->beforeDeleteTopics($model);
	}

/**
 * After delete is called after any delete occurs on the attached model.
 *
 * @param Model $model Model using this behavior
 * @return void
 */
	public function afterDelete(Model $model) {
		$this->afterDeleteTopics($model);
	}

/**
 * 既読データの登録
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $content コンテンツ
 * @param bool $answered 回答したかどうか
 * @return array
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function saveTopicUserStatus(Model $model, $content, $answered = false) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
		]);

		$topicAlias = $model->Topic->alias;
		$conditions = array(
			$topicAlias . '.plugin_key' => Current::read('Plugin.key'),
			$topicAlias . '.language_id' => Current::read('Language.id'),
			$topicAlias . '.block_id' => Current::read('Block.id', '0'),
			$topicAlias . '.content_id' => Hash::get(
				$content, $this->settings[$model->alias]['fields']['content_id'], '0'
			),
		);
		if ($model->Behaviors->loaded('Workflow.Workflow')) {
			if ($model->canEditWorkflowContent($content) && $this->settings[$model->alias]['is_workflow']) {
				$conditions[$topicAlias . '.is_latest'] = true;
			} else {
				$conditions[$topicAlias . '.is_active'] = true;
			}
		}

		//既読データ登録
		$update = array(
			'read' => true,
			'answered' => $answered
		);
		$model->TopicUserStatus->saveTopicUserStatus($content, $conditions, $update);

		return true;
	}

/**
 * 読めるユーザIDをセットする
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $users ユーザIDのリスト
 * @param bool $append 追加かどうか
 * @return void
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function setTopicUsers(Model $model, $users, $append = false) {
		if ($append) {
			$this->settings[$model->alias]['users'] = array_merge(
				$this->settings[$model->alias]['users'], $users
			);
		} else {
			$this->settings[$model->alias]['users'] = $users;
		}
	}

/**
 * 新着のデータをセットする
 *
 * @param Model $model 呼び出し元のモデル
 * @param string $key キー
 * @param mixed $value 値
 * @return void
 * @throws InternalErrorException
 */
	public function setTopicValue(Model $model, $key, $value) {
		$this->settings[$model->alias]['data'][$key] = $value;
	}

}

/**
 * Topics Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model\Behavior
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class TopicsBaseBehavior extends ModelBehavior {

/**
 * タイトルの最大文字数
 *
 * @var int
 */
	const MAX_TITLE_LENGTH = 255;

/**
 * Delimiter
 *
 * @var string
 */
	public $delimiter = ' ';

/**
 * $this->settings[$model->alias]['fields']のセットアップ
 *
 * @param Model $model 呼び出し元のモデル
 * @return void
 */
	protected function _setupFields(Model $model) {
		//モデル名を付与する
		$fields = $this->settings[$model->alias]['fields'];
		$fields = Hash::remove($fields, 'path');
		$fields = Hash::remove($fields, 'summary');
		$fields = Hash::remove($fields, 'search_contents');

		$fieldKeys = array_keys($fields);
		foreach ($fieldKeys as $field) {
			$value = Hash::get($this->settings[$model->alias]['fields'], $field);
			if (Hash::get($this->settings[$model->alias]['fields'], $field) === false) {
				continue;
			}
			if (! $value && $model->hasField($field)) {
				$this->settings[$model->alias]['fields'][$field] = $model->alias . '.' . $field;
			}
			$value = Hash::get($this->settings[$model->alias]['fields'], $field);
			if ($value && strpos($value, '.') === false) {
				$this->settings[$model->alias]['fields'][$field] = $model->alias . '.' . $value;
			}
		}
		foreach ($this->settings[$model->alias]['fields']['summary'] as $i => $field) {
			if (strpos($field, '.') === false) {
				$this->settings[$model->alias]['fields']['summary'][$i] = $model->alias . '.' . $field;
			}
		}
	}

/**
 * $this->settings[$model->alias]['fields']のセットアップ
 *
 * @param Model $model 呼び出し元のモデル
 * @return void
 */
	protected function _setupSearchContents(Model $model) {
		//モデル名を付与する
		$this->settings[$model->alias]['search_contents'] = array_merge(
			array($this->settings[$model->alias]['fields']['title']),
			$this->settings[$model->alias]['fields']['summary'],
			$this->settings[$model->alias]['search_contents']
		);

		foreach ($this->settings[$model->alias]['search_contents'] as $i => $field) {
			if (strpos($field, '.') === false) {
				$this->settings[$model->alias]['search_contents'][$i] = $model->alias . '.' . $field;
			}
		}
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
	protected function _saveTopic(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
		]);

		$topic = $this->_getTopicForSave($model);

		if (Current::read('Frame.block_id') !== Current::read('Block.id')) {
			$topic = Hash::remove($topic, '{n}.{s}.frame_id');
		}

		$setting = $this->settings[$model->alias]['fields'];

		//登録するデータセット
		$merge = array(
			'content_key' => Hash::get($model->data, $setting['content_key']),
			'content_id' => Hash::get($model->data, $setting['content_id']),
			'title' => $this->_parseTitle($model),
			'summary' => $this->_parseContents($model),
			'search_contents' => $this->_parseSearchContents($model),
			'is_answer' => $setting['is_answer'],
		);

		$fields = array(
			'category_id', 'title_icon', 'public_type', 'publish_start', 'publish_end', 'status',
			'is_no_member_allow', 'answer_period_start', 'answer_period_end',
			'created_user', 'created', 'modified_user', 'modified'
		);
		foreach ($fields as $field) {
			$value = $this->_getSaveData($model, $field);
			if ($value === false) {
				continue;
			}
			$merge[$field] = $value;
		}

		//公開日時が設定されていない場合は、更新日時をセットする
		if (! isset($merge['publish_start'])) {
			$merge['publish_start'] = Hash::get($model->data, $model->alias . '.modified');
		}

		//登録処理
		foreach ($topic as $data) {
			$saveData = Hash::merge($data[$model->Topic->alias], $merge);
			$saveData['path'] = $this->_parsePath($model, $saveData);

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
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	protected function _parseTitle(Model $model) {
		$title = $this->_getSaveData($model, 'title');

		if (Hash::get($this->settings[$model->alias], 'titleHtml')) {
			$result = mb_strimwidth(strip_tags($title), 0, self::MAX_TITLE_LENGTH);
			if (preg_replace('/(\s|　)/', '', $result) === '') {
				$result = mb_strimwidth($title, 0, self::MAX_TITLE_LENGTH);
			}
			$result = trim($result);
		} else {
			$result = $title;
		}

		return $result;
	}

/**
 * 新着のコンテンツにパースする
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	protected function _parseContents(Model $model) {
		$setting = $this->settings[$model->alias]['fields'];
		$result = '';

		foreach ($setting['summary'] as $field) {
			$value = Hash::extract($model->data, $field);
			$result .= implode($this->delimiter, $value);
			$result .= chr(10);
		}

		if (Hash::get($this->settings[$model->alias], 'summaryWysiwyg')) {
			return strip_tags($result);
		} else {
			return $result;
		}
	}

/**
 * リンク先のPathにパースする
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $saveData 登録するデータ
 * @return string
 */
	protected function _parsePath(Model $model, $saveData) {
		$setting = $this->settings[$model->alias]['fields'];
		$result = $setting['path'];

		foreach ($saveData as $key => $value) {
			$result = preg_replace('/' . preg_quote(':' . $key, '/') . '/', $value, $result);
		}

		return $result;
	}

/**
 * 検索対象データにパースする
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	protected function _parseSearchContents(Model $model) {
		$result = array();

		foreach ($this->settings[$model->alias]['search_contents'] as $field) {
			$value = Hash::extract($model->data, $field);
			$result[] = $value;
		}

		return serialize($result);
	}

/**
 * 新着データを取得する
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param string $field フィールド名
 * @return string
 */
	protected function _getSaveData(Model $model, $field) {
		$setting = $this->settings[$model->alias]['fields'];
		$data = $this->settings[$model->alias]['data'];

		if (in_array($field, ['created_user', 'created', 'modified_user', 'modified'], true)) {
			$pathKey = $model->alias . '.' . $field;
		} else {
			$pathKey = $setting[$field];
		}

		if (array_key_exists($field, $data)) {
			return Hash::get($data, $field);
		} elseif (Hash::get($model->data, $pathKey, false) !== false) {
			return Hash::get($model->data, $pathKey);
		} else {
			return false;
		}
	}

/**
 * 保存する新着データの取得
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return array
 */
	protected function _getTopicForSave(Model $model) {
		$topic = array();

		$setting = $this->settings[$model->alias]['fields'];
		if ($model->hasField('is_latest') && Hash::get($model->data, $setting['is_latest'])) {
			$topic[] = $this->_getTopic($model,
				['is_latest' => Hash::get($model->data, $setting['is_latest'])]
			);
		}
		if ($model->hasField('is_active') && Hash::get($model->data, $setting['is_active'])) {
			$topic[] = $this->_getTopic($model,
				['is_active' => Hash::get($model->data, $setting['is_active'])]
			);
		}
		if (! $topic) {
			$topic[] = $this->_getTopic($model, ['is_active' => true]);
		}

		return $topic;
	}

/**
 * 保存する新着データの取得
 *
 * self::_getTopicForSave()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $addConditions 追加条件
 * @return array
 */
	protected function _getTopic(Model $model, $addConditions = array()) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
		]);

		$setting = $this->settings[$model->alias]['fields'];
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
	protected function _deleteTopicUserStatus(Model $model) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicUserStatus' => 'Topics.TopicUserStatus',
		]);

		$topicId = Hash::extract($model->data, $model->Topic->alias . '.{n}.id');

		$conditions = array($model->TopicUserStatus->alias . '.topic_id' => $topicId);
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
	protected function _saveTopicReadable(Model $model, $topicId) {
		$model->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		//選択されていないユーザIDを削除
		$saved = $model->TopicReadable->find('list', array(
			'recursive' => -1,
			'fields' => array('id', 'user_id'),
			'conditions' => ['topic_id' => $topicId],
		));
		$saved = array_unique(array_values($saved));
		$delete = array_diff($saved, $this->settings[$model->alias]['users']);
		if (count($delete) > 0) {
			$conditions = array(
				$model->TopicReadable->alias . '.topic_id' => $topicId,
				$model->TopicReadable->alias . '.user_id' => $delete,
			);
			if (! $model->TopicReadable->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//登録処理
		foreach ($this->settings[$model->alias]['users'] as $userId) {
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
