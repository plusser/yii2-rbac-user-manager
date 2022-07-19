<?php

namespace rbacUserManager\components;

use yii\helpers\Console;
use yii\console\ExitCode;

trait ConsoleCommandTrait
{

    protected function exitCode($error = false)
    {
        return $error ? ExitCode::UNSPECIFIED_ERROR : ExitCode::OK;
    }

    protected function checkTransferOptions($options)
    {
        $error = false;

        foreach($options as $item){
            if(empty($this->{$item})){
                $this->notSpecifiedOption($item);
                $error = true;
            }
        }

        return $error;
    }

    protected function notSpecifiedOption($option)
    {
        $this->stdout('Не определена опция ', Console::BOLD);
        $this->stdout('--' . $option . (($key = array_search($option, $this->optionAliases())) ? ' (-' . $key . ')' : '') . PHP_EOL, Console::FG_RED);
    }

    abstract public function optionAliases();

}
