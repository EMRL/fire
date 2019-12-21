<?php

declare(strict_types=1);

namespace Fire\Path;

class JoinManifest extends JoinSearch
{
    /** @var string $manifestPath */
    protected $manifestPath;

    /** @var array<string,string> $manifest */
    protected $manifest;

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
     *
     * @return mixed
     */
    protected function readManifest()
    {
        return json_decode((string) @file_get_contents($this->manifestPath), true);
    }
}
