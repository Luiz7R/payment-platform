<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(int $code = 422)
    {
        $this->message = 'Insufficient amount to transfer';
        $this->code = $code;

        parent::__construct( $this->message,$code);
    }

    // Opcional: Personalizar a resposta HTTP
    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
