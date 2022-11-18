<?php

namespace Drupal\module_hero\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\module_hero\HeroArticleService;

/**
 * this is our hero controller.
 */

class HeroController extends ControllerBase {

  private $articleHeroService;

  public static function create(ContainerInterface $container){
    return new static(
      $container->get('module_hero.hero_articles')
    );
  }

  public function __construct(HeroArticleService $articleHeroService) {
    $this->articleHeroService = $articleHeroService;
  }

  public function heroList() {

    kint($this->articleHeroService->getHeroArticles()); die();

    $heroes = [
      ['name' => 'Iron Man'],
      ['name' => 'Captain America'],
      ['name' => 'Batman'],
      ['name' => 'Wonder Woman'],
      ['name' => 'Spiderman'],
      ['name' => 'Deadpool']
    ];

    return [
      '#theme' => 'hero_list',  // sets the output to the twig template
      '#items' => $heroes,  // assigns the above array
      '#title' => $this->t('Our wonderful heroes list'),
    ];

  }
}
