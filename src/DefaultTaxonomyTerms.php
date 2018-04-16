<?php

namespace Drupal\elemental_core;

use Drupal\taxonomy\Entity\Term;

/**
 * Class DefaultTaxonomyTerms.
 *
 * @package Drupal\elemental_core
 */
class DefaultTaxonomyTerms {

  /**
   * Static method create.
   *
   * @param array $terms
   *   List of names to create.
   * @param string $vocabulary
   *   The vid of the vocabulary for terms.
   * @param string $module
   *   Name of the module that call the method.
   */
  public static function create(array $terms, $vocabulary = NULL, $module = 'elemental_core') {

    if ($terms || $vocabulary != NULL) {
      foreach ($terms as $term) {
        if (!taxonomy_term_load_multiple_by_name($term, $vocabulary)) {
          $term_created = Term::create([
            'name' => $term,
            'vid' => $vocabulary,
          ])->save();

          if ($term_created == SAVED_NEW) {
            \Drupal::logger($module)->notice('@term: created.',
              [
                '@term' => $term,
              ]);
          }
        }
      }
    }
    else {
      \Drupal::logger($module)->error('Terms or vocabulary are not correctly defined.');
    }

  }

}
