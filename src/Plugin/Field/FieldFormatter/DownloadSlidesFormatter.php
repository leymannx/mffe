<?php

namespace Drupal\mffe\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'mffe_download_slides' formatter.
 *
 * @FieldFormatter(
 *   id = "mffe_download_slides",
 *   label = @Translation("Download Slides"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class DownloadSlidesFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {

      // Get the media item.
      $media_id = $item->getValue()['target_id'];
      $media_item = Media::load($media_id);

      // Get the file.
      $file_id = $media_item->field_media_file->getValue()[0]['target_id'];
      $file = File::load($file_id);

      // Get the URL.
      $uri = $file->getFileUri();
      $url = Url::fromUri(file_create_url($uri))->toString();

      // Output.
      $elements[$delta] = [
        '#type'     => 'inline_template',
        '#template' => '<a href="{{ url }}" target="_blank">Download Slides</a>',
        '#context'  => [
          'url' => $url,
        ],
      ];

      //$elements[$delta] = [
      //  '#theme' => 'mffe_download_slides',
      //  '#url'   => $url,
      //];
    }

    return $elements;
  }

}