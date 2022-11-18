<?php

namespace Drupal\module_hero\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block called "Example hero block".
 *
 * @Block(
 *  id = "module_hero_hero",
 *  admin_label = @Translation("Example hero block")
 * )
 */

class HeroBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $heroes = [
      ['hero_name' => 'Iron Man', 'real_name' => 'Tony Stark'],
      ['hero_name' => 'Captain America', 'real_name' => 'Steven Rogers'],
      ['hero_name' => 'Batman', 'real_name' => 'Bruce Wayne'],
      ['hero_name' => 'Wonder Woman', 'real_name' => 'Diana'],
      ['hero_name' => 'Spiderman', 'real_name' => 'Parker'],
      ['hero_name' => 'Deadpool', 'real_name' => 'Wade Wilson']
    ];

    $table = [
      '#type' => 'table',
      '#header' => [
        $this->t('Hero name'),
        $this->t('Real name'),
      ]
    ];

    foreach($heroes as $hero) {
      $table[] = [
          'hero_name' => [
            '#type' => 'markup',
            '#markup' => $hero['hero_name'],
          ],
          'real_name' => [
            '#type' => 'markup',
            '#markup' => $hero['real_name'],
        ],
      ];
    }

    return $table;
  }
}
