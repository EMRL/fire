<?php

declare(strict_types=1);

namespace Fire\Path;

class JoinManifest extends JoinSearch
{
    protected string $manifestPath;

    /** @var array<string,string> */
    protected array $manifest = [];

    public function __construct(JoinPath $join, string $manifestPath)
    {
        parent::__construct($join);
        $this->manifestPath = $manifestPath;
    }

    protected function search(string $key): string
    {
        if (!$this->manifest) {
            $this->manifest = $this->readManifest();
        }

        return $this->manifest[$key] ?? $key;
    }

    /**
     * Attempts to read and decode manifest file
     */
    protected function readManifest(): array
    {
        return (array) json_decode((string) @file_get_contents($this->manifestPath), true);
    }
}
