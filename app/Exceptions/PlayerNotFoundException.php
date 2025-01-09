<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Http\JsonResponse;

class PlayerNotFoundException extends DomainException
{
    public function __construct(string $message = 'Player not found.')
    {
        parent::__construct($message);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 404);
    }
}
