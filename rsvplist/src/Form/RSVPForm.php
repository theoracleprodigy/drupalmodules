<?php
/**
  * @file
  * Contains \Drupal\rsvplist\Form\RSVPForm
  */
namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;


/**
 * Provides an RSVP Email form.
 */

 class RSVPForm extends FormBase {
   /**
    * (@inheritdoc)
    */

    public function getFormId() {
      return 'rsvplist_email_form';
    }

    /**
      * (@inheritdoc)
      */
      public function buildForm(array $form, FormStateInterface $form_state) {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['email'] = array(
          '#title' => t('Email Address'),
          '#type' => 'textfield',
          '#size' => 25,
          '#description' => t("We'll send updates to the email address you provide."),
          '#required' => TRUE,
        );
        $form['submit'] = array(
          '#type' => 'submit',
          '#value' => t('RSVP'),
        );
        $form['nid'] = array(
          '#type' => 'hidden',
          '#value' => $nid,
        );
        return $form;
      }

      public function validateForm(array &$form, FormStateInterface $form_state){
        $value = $form_state->getValue('email');
        if ($value == !\Drupal::service('email.validator')->isValid($value)){
          $form_state->setErrorByName('email', t('The email address %mail is not valid.',array('%mail' =>$value)) );
          return;
        }
        $node = \Drupal::routeMatch()->getParameter('node');
        // Check if email already is set for this node
        $select = Database::getConnection()->select('rsvplist', 'r');
        $select->fields('r', array('nid'));
        $select->condition('nid', $node->id());
        $select->condition('mail', $value);
        $results = $select->execute();
        if(!empty($results->fetchCol())) {
          // We found a row with this nid and email.
          $form_state->setErrorByName('email', t('The address %mail is already subscibed to this list.', array('%mail' => $value)));
        }
      }
      /**
       * (@inheritdoc)
       */

      public function submitForm(array &$form, FormStateInterface $form_state){
      // $messages = \Drupal::messenger()->addMessage('The form is working.');
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
        $connection = \Drupal::service('database');

        $query = $connection->insert('rsvplist')
        ->fields(['mail','nid','uid','created'])
        ->values([
          'mail' => $form_state->getValue('email'),
          'nid' => $form_state->getValue('nid'),
          'uid' => $user->id(),
          'created' => time(),
        ])

        ->execute();
        $messages = \Drupal::messenger()->addMessage('Thank you for your rsvp, you are on the list for the event');
      }
 }
