<?php

declare(strict_types=1);

namespace App\Infra;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

final class SymfonyJsonParser
{
    private readonly array $payload;

    public function __construct(Request $request)
    {
        $this->payload = $this->getJsonFromRequest($request);
    }

    public function get(string $key): mixed
    {
        if (!isset($this->payload[$key])) {
            return null;
        }

        return $this->payload[$key];
    }

    public function getAll(): array
    {
        return $this->payload;
    }

    private function getJsonFromRequest(Request $request): array
    {
        if ($request->getContentTypeFormat() != 'json' || !$request->getContent()) {
            throw new InvalidArgumentException('content type must to be a json format');
        }

        $payload = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('invalid json body: ' . json_last_error_msg());
        }

        return $payload;
    }
}
