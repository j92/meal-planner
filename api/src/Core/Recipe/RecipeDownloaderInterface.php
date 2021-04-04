<?php
declare(strict_types=1);

namespace App\Core\Recipe;

use App\Core\Recipe\Downloader\Exception\DownloadingFailed;
use App\Entity\Recipe;

interface RecipeDownloaderInterface
{
    /**
     * @throws DownloadingFailed
     */
    public function download(Recipe $recipe): void;
}
