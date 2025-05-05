<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileSystemInterface;
// Changed to file module namespace.
use Drupal\file\FileRepositoryInterface;
use Drupal\file\FileInterface;

/**
 * Creates profile picture media entities for fixtures.
 */
final class ProfilePictureFixture extends AbstractFixture {

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  private FileSystemInterface $fileSystem;

  /**
   * The file repository service.
   *
   * @var \Drupal\file\FileRepositoryInterface
   */
  private FileRepositoryInterface $fileRepository;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs a new ProfilePictureFixture.
   *
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   *   The file system service.
   * @param \Drupal\file\FileRepositoryInterface $fileRepository
   *   The file repository service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(
    FileSystemInterface $fileSystem,
    FileRepositoryInterface $fileRepository,
    EntityTypeManagerInterface $entityTypeManager,
  ) {
    $this->fileSystem = $fileSystem;
    $this->fileRepository = $fileRepository;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    // Get path to the image file using __DIR__.
    $sourceImagePath = __DIR__ . '/../Images/default_profile_picture.jpg';

    // Verify the constructed path points to an existing file.
    if (!file_exists($sourceImagePath)) {
      throw new \RuntimeException('Fixture image not found. Checked path: ' . $sourceImagePath);
    }

    // Define where the file should be copied within Drupal's public file
    // system.
    $destinationDirectory = 'public://fixtures/profile_pictures/';

    // Ensure the destination directory exists.
    $this->fileSystem->prepareDirectory(
      $destinationDirectory,
      FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS
    );

    // Construct the destination URI using the original filename.
    $destinationUri = $destinationDirectory . basename($sourceImagePath);

    // Read the source image content.
    $fileContents = file_get_contents($sourceImagePath);
    if ($fileContents === FALSE) {
      throw new \RuntimeException('Could not read file contents from: ' . $sourceImagePath);
    }

    // Create the managed file entity.
    $file = $this->fileRepository->writeData(
      $fileContents,
      $destinationUri,
      FileSystemInterface::EXISTS_REPLACE
    );

    // Check if file entity was created successfully.
    if (!$file instanceof FileInterface) {
      throw new \RuntimeException('Failed to create Drupal file entity for image: ' . $sourceImagePath);
    }

    // Mark the file as permanent.
    $file->setPermanent();
    $file->save();

    // Create a Media entity that uses the file.
    $mediaStorage = $this->entityTypeManager->getStorage('media');
    $media = $mediaStorage->create([
    // Must match your media type machine name.
      'bundle' => 'image',
      'name' => 'Default Profile Picture',
      // The field name may vary - check your media type configuration.
      'field_media_image' => [
        'target_id' => $file->id(),
        'alt' => 'Default profile picture',
      ],
      'status' => 1,
    ]);

    $media->save();

    // Set a reference to the media entity for other fixtures to use.
    $this->setReference('media:profile_picture:default', $media);
  }

}
