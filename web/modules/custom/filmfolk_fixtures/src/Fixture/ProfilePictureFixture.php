<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\Core\File\FileSystemInterface;
use Drupal\file\FileInterface;
use Drupal\media\Entity\Media;

/**
 * Creates profile picture media entities for fixtures.
 */
final class ProfilePictureFixture extends AbstractFixture {

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    /** @var \Drupal\Core\File\FileSystemInterface $file_system */
    $file_system = \Drupal::service('file_system');
    /** @var \Drupal\Core\File\FileRepositoryInterface $file_repository */
    $file_repository = \Drupal::service('file.repository');
    /** @var \Drupal\Core\Extension\ModuleExtensionList $module_extension_list */
    $module_extension_list = \Drupal::service('extension.list.module');

    // --- Create Default Profile Picture File ---
    // Get path to the filmfolk_fixtures module directory.
    $module_path = $module_extension_list->getPath('filmfolk_fixtures');

    // Construct the full path to your image file.
    $source_image_path = $module_path . '/src/Images/default_profile_picture.jpg';

    // Verify the constructed path points to an existing file.
    if (!file_exists($source_image_path)) {
      $error_message = 'Fixture image not found. Checked path: ' . $source_image_path;
      \Drupal::logger('filmfolk_fixtures')->error($error_message);
      throw new \RuntimeException($error_message);
    }

    \Drupal::logger('filmfolk_fixtures')->notice('Image file found at: @path', ['@path' => $source_image_path]);

    // Define where the file should be copied within Drupal's public file system.
    $destination_directory = 'public://fixtures/profile_pictures/';
    // Ensure the destination directory exists.
    $file_system->prepareDirectory($destination_directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);

    // Construct the destination URI using the original filename.
    $destination_uri = $destination_directory . basename($source_image_path);

    // Read the source image content.
    $file_contents = file_get_contents($source_image_path);
    if ($file_contents === FALSE) {
      throw new \RuntimeException('Could not read file contents from: ' . $source_image_path);
    }

    // Create the managed file entity.
    $file = $file_repository->writeData(
      $file_contents,
      $destination_uri,
      FileSystemInterface::EXISTS_REPLACE
    );

    // Check if file entity was created successfully.
    if (!$file instanceof FileInterface) {
      throw new \RuntimeException('Failed to create Drupal file entity for image: ' . $source_image_path);
    }

    // Mark the file as permanent.
    $file->setPermanent();
    $file->save();

    \Drupal::logger('filmfolk_fixtures')->notice('Created file entity with ID: @id', ['@id' => $file->id()]);

    // --- Create Media Entity for the File ---
    // Create a Media entity that uses the file.
    $media = Media::create([
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

    \Drupal::logger('filmfolk_fixtures')->notice('Created media entity with ID: @id', ['@id' => $media->id()]);

    // Set a reference to the media entity for other fixtures to use.
    $this->setReference('media:profile_picture:default', $media);
    \Drupal::logger('filmfolk_fixtures')->notice('Reference set for media:profile_picture:default');
  }

}
