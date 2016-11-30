<?php

namespace rbacUserManager\components;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

trait ConsoleCommandTrait
{

	protected function exitCode($error = FALSE)
	{
		return $error ? Controller::EXIT_CODE_ERROR : Controller::EXIT_CODE_NORMAL;
	}

	protected function checkTransferOptions($options)
	{
		$error = FALSE;

		foreach($options as $item){
			if(empty($this->{$item})){
				$this->notSpecifiedOption($item);
				$error = TRUE;
			}
		}

		return $error;
	}

	protected function notSpecifiedOption($option)
	{
		$this->stdout('Не определена опция ', Console::BOLD);
		$this->stdout('--' . $option . (($key = array_search($option, $this->optionAliases())) ? ' (-' . $key . ')' : '') . PHP_EOL, Console::FG_RED);
	}

	protected function roleNotFound($role)
	{
		$this->stdout('Роль ', Console::BOLD);
		$this->stdout($role, Console::FG_RED);
		$this->stdout(' не существует' . PHP_EOL, Console::BOLD);
	}

	protected function userNotFound($user)
	{
		$this->stdout('Пользователь ', Console::BOLD);
		$this->stdout($user, Console::FG_RED);
		$this->stdout(' не существует' . PHP_EOL, Console::BOLD);
	}

	protected function printErrors($model)
	{
		$this->stdout(PHP_EOL);

		foreach($model->errors as $fieldErrors){
			foreach($fieldErrors as $item){
				$this->stdout($item . PHP_EOL, Console::FG_RED);
			}
		}
	}

}
