<?php

namespace App\Exceptions;

use Exception;

class NotificationException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(string $message,int $code = 422)
    {
        $this->code = $code;

        parent::__construct($message, $code);
    }

    // Opcional: Personalizar a resposta HTTP
    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
