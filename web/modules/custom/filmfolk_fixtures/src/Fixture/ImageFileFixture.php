<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileExists;
use Drupal\Core\File\FileSystemInterface;
use Drupal\file\FileStorageInterface;

/**
 * Image file fixture.
 */
final class ImageFileFixture extends AbstractFixture {

  /**
   * The file storage.
   */
  private FileStorageInterface $fileStorage;

  /**
   * The image filenames.
   *
   * @var string[]
   */
  private static array $sources;

  /**
   * Constructor.
   */
  public function __construct(
    private readonly FileSystemInterface $fileSystem,
    EntityTypeManagerInterface $entityTypeManager,
  ) {
    $this->fileStorage = $entityTypeManager->getStorage('file');
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    if (empty(self::$sources)) {
      self::$sources = glob(__DIR__ . '/../../resources/images/*.*');
    }

    $destinationDirectory = 'public://fixtures/images/';

    // Ensure the destination directory exists.
    $this->fileSystem->prepareDirectory(
      $destinationDirectory,
      FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS
    );

    foreach (self::$sources as $index => $source) {
      $filename = basename($source);
      $uri = $destinationDirectory . $filename;
      $this->fileSystem->copy($source, $uri, FileExists::Replace);

      $file = $this->fileStorage->create([
        'filename' => $filename,
        'uri' => $uri,
      ]);
      $file->setPermanent();
      $file->save();

      $this->setReference(self::getImageReferenceName($index), $file);
    }
  }

  /**
   * Get image reference name.
   */
  public static function getImageReferenceName(int $index): string {
    // Make sure that index is valid, i.e. inside the range of images.
    if (!empty(self::$sources)) {
      $index %= count(self::$sources);
    }

    return sprintf('file:image:%03d', $index);
  }

}
