<?php
/**
 * Searchable Model of test_app
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         Frame 0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 **/

/**
 * Class SearchableModel
 */
class SearchableModel extends Model {

/**
 * Save topic
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveTopic($data) {
		$con = $this->getDataSource();
		$con->begin();

		try {
			$this->Topic = ClassRegistry::init('Topics.Topic');
			if (!$this->Topic->validateTopic([
				'block_id' => $data['block_id'],
				'status' => $data['status'],
				'is_active' => $data['is_active'],
				'is_latest' => $data['is_latest'],
				'title' => Search::prepareTitle($data['contents']),
				'contents' => Search::prepareContents([$data['contents']]),
				'plugin_key' => $data['plugin_key'],
				'path' => $data['path'],
				'from' => $data['from'],
				/* 'to' => $data['to'], */
			])) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Topic->validationErrors);
				return false;
			}
			if (! $this->Topic->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$con->commit();
		} catch (Exception $ex) {
			$con->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		/* return $announcement; */
	}
}
