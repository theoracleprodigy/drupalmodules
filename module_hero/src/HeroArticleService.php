<?php

namespace Drupal\module_hero;

//use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Our hero article service class.
 */

class HeroArticleService {

  //private $entityQuery;
  private $entity_type_manager;


//public function __construct($entityQuery){
// $this->entityQuery = $entityQuery;
  public function __construct($entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }
  /**
   * Method for getting Articles, reguarding heros.
   */
  public function getHeroArticles() {
    $articles = ['Hulk is green!', 'Flash is red!'];

    $entity = \Drupal::entityTypeManager()->getStorage('node');
    $query = $entity->getQuery();


    $ids = $query->condition('status', 1)
   ->condition('type', 'article')#type = bundle id (machine name)
   ->condition('status', 1)
   ->condition('title', $articles, 'IN')
   ->sort('created', 'ASC') #sorted
   //->pager(15) #limit 15 items
   ->execute();

    // Load multiples or single item load($id)
    $articles = $entity->loadMultiple($ids);



     return $articles;
  }
}
