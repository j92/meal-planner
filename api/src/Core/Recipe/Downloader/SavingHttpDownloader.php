<?php
declare(strict_types=1);

namespace App\Core\Recipe\Downloader;

use App\Core\Recipe\Downloader\Exception\DownloadingFailed;
use App\Core\Recipe\Downloader\Model\DownloadedRecipe;
use App\Core\Recipe\Downloader\Saver\FileSystemSaver;
use App\Core\Recipe\RecipeDownloaderInterface;
use App\Entity\Recipe;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SavingHttpDownloader implements RecipeDownloaderInterface
{
    private HttpClientInterface $client;
    private FileSystemSaver $recipeSaver;

    public function __construct(HttpClientInterface $client, FileSystemSaver $recipeSaver)
    {
        $this->client = $client;
        $this->recipeSaver = $recipeSaver;
    }

    public function download(Recipe $recipe): void
    {
        $response = $this->client->request('GET', $recipe->getSourceUrl());

        if ($response->getStatusCode() !== 200) {
            throw new DownloadingFailed();
        }

        $downloadedRecipe = new DownloadedRecipe($response->getContent(), sprintf('%s', $recipe->getId()));

        $this->recipeSaver->save($downloadedRecipe);
    }
}
