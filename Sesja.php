<?php
namespace marcinmisiak\dbsession;

use Yii;
use yii\db\Query;
use yii\base\ErrorHandler;

class Sesja extends \yii\web\DbSession {
	
	public function writeSession($id, $data)
	{
		try {
			$query = new Query;
			$exists = $query->select(['id'])
			->from($this->sessionTable)
			->where(['id' => $id])
			->createCommand($this->db)
			->queryScalar();
			$fields = $this->composeFields($id, $data);
			
		
			if(!Yii::$app->user->getIsGuest()) {
				$fields['user_id'] = Yii::$app->user->getId();
			}
			
			if ($exists === false) {
				$this->db->createCommand()
				->insert($this->sessionTable, $fields)
				->execute();
			} else {
				unset($fields['id']);
				$this->db->createCommand()
				->update($this->sessionTable, $fields, ['id' => $id])
				->execute();
			}
		} catch (\Exception $e) {
			$exception = ErrorHandler::convertExceptionToString($e);
			error_log($exception);
			echo $exception;
	
			return false;
		}
	
		return true;
	}
	
	protected function composeFields($id = NULL, $data = NULL)
	{
		$fields = [
				'data' => $data,
		];
		if (isset($this->writeCallback)) {
			$fields = array_merge(
					$fields,
					call_user_func($this->writeCallback, $this)
			);
			if (!is_string($fields['data'])) {
				$_SESSION = $fields['data'];
				$fields['data'] = session_encode();
			}
		}
		
		$fields = array_merge($fields, [
				'id' => $id,
				'expire' => time() + $this->getTimeout(),
				'last_activity' => date('Y-m-d H:i:s'),
				'last_ip' => \Yii::$app->request->getUserIP(),
		]);
		return $fields;
	}
}