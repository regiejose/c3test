<?php

namespace Drupal\senior_portal\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SeniorPortalSettingsForm extends ConfigFormBase {
  /**
   * Config name.
   */
  protected function getEditableConfigNames() {
    return ['senior_portal.settings'];
  }

  /**
   * Form ID.
   */
  public function getFormId() {
    return 'senior_portal_settings_form';
  }

  /**
   * Build form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('senior_portal.settings');

    $form['api_url'] = [
      '#type' => 'url',
      '#title' => $this->t('API URL'),
      '#default_value' => $config->get('api_url'),
      '#required' => TRUE,
    ];
    
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable API'),
      '#default_value' => $config->get('enabled'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('senior_portal.settings')
      ->set('api_url', $form_state->getValue('api_url'))
      ->set('enabled', $form_state->getValue('enabled'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}