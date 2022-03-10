<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;

class CustomException extends Exception
{
    use ApiResponser;

    public function render($request){
        return $this->error([
            'error' => true,
            'message' => $this->getMessage(),
        ],500);
    }
}