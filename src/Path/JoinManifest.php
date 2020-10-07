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
        // WordPress now checks for PHP errors/warnings and adjusts the admin
        // screen to allow space for them to show (which is nice). Our use of
        // error suppression on `file_get_contents` does not prevent this from
        // happening, but it does hide the warning, so user is left with a
        // confusing empty space. So let's just add a check if the file exists
        // first.
        if (!is_file($this->manifestPath)) {
            return [];
        }

        return (array) json_decode((string) @file_get_contents($this->manifestPath), true);
    }
}
