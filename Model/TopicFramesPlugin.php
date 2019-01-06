<?php
/**
 * TopicFramesPlugin Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');

/**
 * TopicFramesPlugin Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicFramesPlugin extends TopicsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array_merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'plugin_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * TopicFramesPluginのチェック
 *
 * @param array $data リクエストデータ
 * @return bool
 */
	public function validateRequestData($data) {
		$pluginKeys = [];
		if (isset($data['Plugin'])) {
			foreach ($data['Plugin'] as $plugin) {
				$pluginKeys[] = $plugin['key'];
			}
		}

		$check = isset($data['TopicFrameSetting']['plugin_key'])
			? $data['TopicFrameSetting']['plugin_key']
			: [];
		foreach ($check as $pluginKey) {
			if (! in_array($pluginKey, $pluginKeys, true)) {
				return false;
			}
		}

		return true;
	}

/**
 * 新着取得するための条件を取得する
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array 条件配列
 */
	public function getConditions($topicFrameSetting, $conditions = []) {
		if (isset($conditions['Topic']['plugin_key'])) {
			$conditions['Topic.plugin_key'] = $conditions['Topic']['plugin_key'];
		} elseif ($topicFrameSetting['TopicFrameSetting']['select_plugin']) {
			$pluginKeys = $this->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'plugin_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$pluginKeys = array_unique(array_values($pluginKeys));

			$conditions['Topic.plugin_key'] = array_merge(array('0'), $pluginKeys);
		}

		return $conditions;
	}

/**
 * プラグインデータ取得
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array
 */
	public function getPlugins($topicFrameSetting, $conditions = []) {
		if ($topicFrameSetting['TopicFrameSetting']['select_plugin']) {
			$this->bindModel(array(
				'belongsTo' => array(
					'Plugin' => array(
						'className' => 'PluginManager.Plugin',
						'fields' => array('id', 'name'),
						'foreignKey' => false,
						'type' => 'INNER',
						'conditions' => array(
							'Plugin.key' . ' = ' . $this->alias . '.plugin_key',
							'Plugin.language_id' => Current::read('Language.id', '0'),
						),
					)
				)
			), true);

			$plugin = $this->find('list', array(
				'recursive' => 0,
				'fields' => array('Plugin.key', 'Plugin.name'),
				'conditions' => array(
					$this->alias . '.frame_key' => Current::read('Frame.key'),
				),
				'order' => 'weight'
			));
		} else {
			$this->loadModels([
				'Plugin' => 'PluginManager.Plugin',
			]);

			$conditions = Hash::merge(
				array('display_topics' => true, 'language_id' => Current::read('Language.id', '0')),
				$conditions
			);
			$plugin = $this->Plugin->cacheFindQuery('list', array(
				'recursive' => -1,
				'fields' => array('key', 'name'),
				'conditions' => $conditions,
				'order' => 'weight'
			));
		}

		return $plugin;
	}

/**
 * TopicFramesPluginの登録
 *
 * TopicFrameSetting::saveTopicFrameSetting()から実行されるため、ここではトランザクションを開始しない
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveTopicFramesPlugin($data) {
		$pluginKeys = [];
		if (isset($data[$this->alias]['plugin_key'])) {
			foreach ($data[$this->alias]['plugin_key'] as $pluginKey) {
				$pluginKeys[] = $pluginKey;
			}
		}

		$saved = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('id', 'plugin_key'),
			'conditions' => ['frame_key' => Current::read('Frame.key')],
		));
		$saved = array_unique(array_values($saved));

		$delete = array_diff($saved, $pluginKeys);
		if (count($delete) > 0) {
			$conditions = array(
				'TopicFramesPlugin' . '.frame_key' => Current::read('Frame.key'),
				'TopicFramesPlugin' . '.plugin_key' => $delete,
			);
			if (! $this->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		$new = array_diff($pluginKeys, $saved);
		if (count($new) > 0) {
			$saveDate = array();
			foreach ($new as $i => $pluginKey) {
				$saveDate[$i] = array(
					'id' => null,
					'plugin_key' => $pluginKey,
					'frame_key' => Current::read('Frame.key')
				);
			}
			if (! $this->saveMany($saveDate)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

}
