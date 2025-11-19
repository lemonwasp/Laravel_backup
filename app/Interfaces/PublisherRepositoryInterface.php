namespace App\Interfaces;

use App\Models\Publisher;

interface PublisherRepositoryInterface
{
  public function getAllPublishers();
  public function getPublisherById(int $publisherId): ?Publisher;
  public function deletePublisher(int $publisherId): void;
  public function createPublisher(array $publisherDetails): Publisher;
  public function updatePublisher(int $publisherId, array $newDetails): Publisher;
}