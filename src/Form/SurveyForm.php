<?php

namespace Drupal\survey_manager\Form;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\user\Entity\Role;
use Drupal\survey_manager\Entity\Survey;

class SurveyForm extends EntityForm {

  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $entity = $this->entity;

    $form['label'] = [
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

    $types = [];
    $content_types = \Drupal::service('entity.manager')->getStorage('node_type')->loadMultiple();

    foreach ($content_types as $key => $content_type) {
      $types['content_types'][$key] = $content_type->get('name');
    }

    $user_roles = [];
    $roles = Role::loadMultiple();

    foreach ($roles as $key => $role) {
      $user_roles['user_roles'][$key] = $role->label();
    }

    $visibility = $entity->getVisibility();

    $form['visibility'] = [
      '#type' => 'fieldset',
      '#title' => t('Visibility'),
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#title' => $this->t('ID'),
      '#maxlength' => 255,
      '#default_value' => $entity->id(),
      '#required' => TRUE,
      '#disabled' => !$entity->isNew(),
      '#machine_name' => [
        'source' => ['label'],
        'exists' => 'Survey::load',
      ],
    ];

    $form['visibility']['content_types'] = [
      '#type' => 'checkboxes',
      '#title' => t('Content types'),
      '#options' => $types['content_types'],
      '#default_value' => array_keys(array_filter($visibility['content_types'])),
    ];

    $form['visibility']['user_roles'] = [
      '#type' => 'checkboxes',
      '#title' => t('Roles'),
      '#options' => $user_roles['user_roles'],
      '#default_value' => array_keys(array_filter($visibility['user_roles'])),
    ];

    $form['visibility']['pages'] = [
      '#type' => 'textarea',
      '#title' => t('Pages'),
      '#default_value' => $visibility['pages'],
    ];

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    if (!$entity->getOriginalId()) {
      $entity->set('id', $form_state->getValue('id'));
      $entity->set('type', $entity->getType());

      drupal_set_message(t('%label survey has been created.', [
        '%label' => $entity->label(),
      ]));
    }
    else {
      drupal_set_message(t('%label survey has been updated.', [
        '%label' => $entity->label(),
      ]));
    }

    $entity->set('visibility', [
      'content_types' => $form_state->getValue('content_types'),
      'user_roles' => $form_state->getValue('user_roles'),
      'pages' => $form_state->getValue('pages'),
    ]);

    $entity->save();

    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
  }

}