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
App::uses('WysiwygBehavior', 'Wysiwyg.Model/Behavior');

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
			'thumbnail_path' => $this->_parseThumbnailImage($model),
			'summary' => $this->_parseContents($model),
			'search_contents' => $this->_parseSearchContents($model),
			'is_answer' => $setting['is_answer'],
		);

		$fields = array(
			'category_id', 'title_icon', 'public_type', 'publish_start', 'publish_end', 'status',
			'is_no_member_allow', 'answer_period_start', 'answer_period_end', 'is_in_room',
			'created_user', 'created', 'modified_user', 'modified',
			'is_origin', 'is_translation',
		);
		foreach ($fields as $field) {
			if ($this->_hasSaveData($model, $field) === false) {
				continue;
			}
			$value = $this->_getSaveData($model, $field);
			$merge[$field] = $value;
		}

		//登録処理
		foreach ($topic as $data) {
			$saveData = Hash::merge($data[$model->Topic->alias], $merge);
			//公開日時が設定されていない場合
			if (! Hash::get($saveData, 'publish_start')) {
				if (Hash::get($data, $model->alias . '.publish_start')) {
					$saveData['publish_start'] = Hash::get($data, $model->alias . '.publish_start');
				} else {
					$saveData['publish_start'] = Hash::get($model->data, $model->alias . '.modified');
				}
			}
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
				$result = __d('topics', '(no text)');
			}
			$result = trim($result);
		} else {
			$result = mb_strimwidth($title, 0, self::MAX_TITLE_LENGTH);
		}

		return $result;
	}

/**
 * 新着のコンテンツからサムネイルにパースする
 *
 * 自サイトの画像のみ対象とする
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @return string
 */
	protected function _parseThumbnailImage(Model $model) {
		$setting = $this->settings[$model->alias]['fields'];
		$result = '';

		$pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';
		$baseUrl = substr(Router::url('/', true), 0, -1);

		foreach ($setting['summary'] as $field) {
			$value = (string)Hash::get($model->data, $field);
			$matches = [];
			if (! preg_match_all($pattern, $value, $matches)) {
				continue;
			}

			foreach ($matches[1] as $imgUrl) {
				$imgUrl = str_replace(WysiwygBehavior::REPLACE_BASE_URL, '', $imgUrl);
				$imgUrl = str_replace($baseUrl, '', $imgUrl);
				if (substr($imgUrl, 0, 1) !== '/' ||
						strpos($imgUrl, 'img/title_icon') !== false) {
					continue;
				}
				$imgUrl = parse_url($imgUrl, PHP_URL_PATH);
				$imgUrl = preg_replace('/\/(thumb|big|small|biggest|medium)$/i', '', $imgUrl);
				$result = $imgUrl;
				break 2;
			}
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

		return strip_tags($result);
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
 * 新着データのデータを持っているかチェック
 *
 * self::_saveTopic()から実行される
 *
 * @param Model $model 呼び出し元のモデル
 * @param string $field フィールド名
 * @return string
 */
	protected function _hasSaveData(Model $model, $field) {
		$setting = $this->settings[$model->alias]['fields'];
		$data = $this->settings[$model->alias]['data'];

		if (in_array($field, ['created_user', 'created', 'modified_user', 'modified'], true)) {
			$pathKey = $model->alias . '.' . $field;
		} else {
			$pathKey = $setting[$field];
		}

		list($modleByData, $fieldByData) = pluginSplit($pathKey);

		if (array_key_exists($field, $data) ||
				isset($model->data[$modleByData]) &&
					array_key_exists($fieldByData, $model->data[$modleByData]) ||
				Hash::get($model->data, $pathKey) !== null) {
			return true;
		} else {
			return false;
		}
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

		list($modleByData, $fieldByData) = pluginSplit($pathKey);

		if (array_key_exists($field, $data)) {
			return Hash::get($data, $field);
		} elseif (isset($model->data[$modleByData]) &&
					array_key_exists($fieldByData, $model->data[$modleByData])) {
			return $model->data[$modleByData][$fieldByData];
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
