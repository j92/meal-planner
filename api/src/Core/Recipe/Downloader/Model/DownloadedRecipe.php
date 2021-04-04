<?php
declare(strict_types=1);

namespace App\Core\Recipe\Downloader\Model;

final class DownloadedRecipe
{
    private string $fullContent;

    private string $path;

    public function __construct(string $fullContent, string $path)
    {
        $this->fullContent = $fullContent;
        $this->path = $path;
    }

    public function getFullContent(): string
    {
        return $this->fullContent;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
