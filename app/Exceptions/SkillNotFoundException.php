<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Http\JsonResponse;

class SkillNotFoundException extends DomainException
{
    public function __construct(string $message = 'Skill not found.')
    {
        parent::__construct($message);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 422);
    }
}
