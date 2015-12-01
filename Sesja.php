<?php
namespace marcinmisiak\dbsession;

use Yii;
use yii\db\Connection;
use yii\db\Query;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\base\ErrorHandler;

class Sesja extends \yii\web\DbSession {
	
	public function writeSession($id, $data)
	{
		// exception must be caught in session write handler
		// http://us.php.net/manual/en/function.session-set-save-handler.php
		try {
			$query = new Query;
			$exists = $query->select(['id'])
			->from($this->sessionTable)
			->where(['id' => $id])
			->createCommand($this->db)
			->queryScalar();
			$fields = $this->composeFields($id, $data);
			
			// add our fields
		
			if(!Yii::$app->user->getIsGuest()) {
				$fields['user_id'] = Yii::$app->user->getId();
			}
			
			//var_dump($fields);exit;
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
			// its too late to use Yii logging here
			error_log($exception);
			echo $exception;
	
			return false;
		}
	
		return true;
	}
}