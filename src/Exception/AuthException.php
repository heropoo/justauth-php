<?php
/**
 * @author pfinal南丞
 * @date 2021年06月02日 上午11:31
 */

namespace JustAuth\Exception;


use JustAuth\Config\AuthSource;
use JustAuth\Enums\AuthResponseStatus;


class AuthException extends \RuntimeException
{
    public $parameter;

    public function __construct()
    {
        $fun_args = func_get_args();
        if($fun_args[0] instanceof AuthResponseStatus){
            $this->code = $fun_args[0]->getvalue();
            $this->message = AuthResponseStatus::getMessage($fun_args[0]);
            if(isset($fun_args[1]) && $fun_args[1] instanceof AuthSource){
                $this->parameter = $fun_args[1];
            }
        }elseif ($fun_args[0] instanceof \Throwable){
            $this->code = 0;
            $this->message = "";
            $this->parameter = $fun_args[0];
        }elseif (is_int($fun_args[0])){
            $this->code = $fun_args[0];
            $this->message = $fun_args[1] ?? "";
            $this->parameter = $fun_args[2] ?? ($fun_args[2] instanceof \Throwable ? $fun_args[2] : null);
        }else{
            $this->code = $fun_args[0];
            $this->message = AuthResponseStatus::getMessage(AuthResponseStatus::FAILURE());
            $this->parameter = null;
            if(isset($fun_args[1]) && ($fun_args[1] instanceof AuthSource || $fun_args[1] instanceof Throwable)){
                $this->parameter = $fun_args[1];
            }
        }
    }
}