<?php
declare(strict_types=1);

namespace App\Core\Recipe\Downloader\Saver;

use App\Core\Recipe\Downloader\Model\DownloadedRecipe;
use League\Flysystem\Filesystem;

final class FileSystemSaver
{
    private Filesystem $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function save(DownloadedRecipe $recipe): void
    {
        $this->fileSystem->write(sprintf('/recipes/%s.html', $recipe->getPath()), $recipe->getFullContent());
    }
}
