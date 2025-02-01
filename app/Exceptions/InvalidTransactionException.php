<?php

namespace App\Exceptions;

use Exception;

class InvalidTransactionException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(string $message = "Transação inválida", int $code = 422)
    {
        $this->message = $message;
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
