<?php

namespace Drupal\survey_manager\Form;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;

class SurveyForm extends EntityForm {

  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $entity = $this->entity;

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#required' => TRUE,
      '#default_value' => $entity->label(),
    ];

    $form['code'] = [
      '#type' => 'textarea',
      '#title' => t('HTML code'),
      '#required' => TRUE,
      '#default_value' => $entity->getCode(),
    ];

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    print '<pre>';
    print_r($entity);
    exit;
/*
    $is_new = !$entity->getOriginalId();

    if ($is_new) {
      $machine_name = \Drupal::transliteration()->transliterate($entity->label(), LanguageInterface::LANGCODE_DEFAULT, '_');
      $entity->set('id', Unicode::strtolower($machine_name));

      drupal_set_message(t('The %label survey has been created.', [
        '%label' => $entity->label()
      ]));
    }
    else {
      drupal_set_message(t('Updated the %label survey.', [
        '%label' => $entity->label()
      ]));
    }

    $entity->save();
*/

    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
  }

}