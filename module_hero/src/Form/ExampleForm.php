<?php

namespace Drupal\module_hero\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ExampleForm extends FormBase {

   /**
   * (@inheritdoc)
   **/

   public function getFormId() {
     return "module_hero_exampleform";
   }

   /**
   * (@inheritdoc)
   **/
   public function buildForm(array $form, FormStateInterface $form_state) {

     return $form;
   }


}
