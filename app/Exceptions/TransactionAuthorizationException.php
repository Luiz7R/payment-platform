<?php

namespace App\Exceptions;

use Exception;

class TransactionAuthorizationException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(int $code = 422)
    {
        $this->code = $code;

        parent::__construct('Transaction Authorization Error, Service Unavailable', $code);
    }

    // Opcional: Personalizar a resposta HTTP
    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
