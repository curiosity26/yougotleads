<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/30/14
 * Time: 2:29 PM
 */

use \YGL\YGLClient;
use \YGL\Response\YGLResponse;

function yougotleads_admin_page() {
  $header = array(
    'ID',
    'Label',
    'Operations'
  );
  $configs = yougotleads_config_load();
  $rows = array();

  foreach ($configs as $cid => $config) {
    $rows[] = array(
      $cid,
      t('@label (@mc)', array('@label' => $config->label,
                              '@mc' => $config->machine_name)),
      t('!edit !delete',
        array('!edit' => l('Edit', 'admin/config/services/ygl/'.$cid.'/edit'),
              '!delete' => l('Delete', 'admin/config/services/ygl'.$cid.'/delete')))
    );
  }

  $output = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $rows,
    '#empty' => t('No configurations have been created. !add.',
      array('!add' => l('Add a New Configuration',
        'admin/config/services/ygl/add')))
  );

  return $output;
}

function yougotleads_machine_name_exists($value) {
  return db_query_range("SELECT 1 FROM {ygl_config} WHERE machine_name = :name",
    0, 1, array(':name' => $value))->fetchField();
}

/**
 * @desc    YouGotLeads config form hook
 * @param         $form_state
 * @param   null  $config
 * @return  array
 */
function yougotleads_config_form($form, &$form_state, $config = array()) {
  $config = (array)$config;
  $values = !empty($form_state['values']) ? $form_state['values'] : $config;

  $form['label'] = array(
    '#type' => 'textfield',
    '#title' => t('Label'),
    '#maxlength' => 50,
    '#required' => TRUE,
    '#default_value' => isset($values['label']) ? $values['label'] : NULL
  );

  $form['machine_name'] = array(
    '#type' => 'machine_name',
    '#maxlength' => 50,
    '#default_value' => $values['machine_name'],
    '#machine_name' => array(
      'source' => array('label'),
      'exists' => 'yougotleads_machine_name_exists'
    )
  );

  $form['accessToken'] = array(
    '#type' => 'textfield',
    '#title' => t('Access Token'),
    '#maxlength' => 255,
    '#default_value' => isset($values['accessToken'])
      ? $values['accessToken']
      : NULL
  );

  $form['or'] = array(
    '#markup' => '<p>If a Username and Password was provided to you in place of '.
      'an Access Token, please enter the credentials below.</p>'
  );

  $form['username'] = array(
    '#type' => 'textfield',
    '#title' => t('Username'),
    '#default_value' => isset($values['username'])
      ? $values['username']
      : NULL
  );

  $form['password'] = array(
    '#type' => 'password_confirm',
    '#size' => 25,
    '#default_value' => isset($values['password'])
      ? (!is_array($values['password'])
        ? array('pass1' => $values['password'], 'pass2' => $values['password'])
        : $values['password'])
      : array()
  );

  if (isset($values['accessToken'])
    || (isset($values['username'])
      && isset($values['password']))) {
    $form['referralSources'] = array(
      '#type' => 'select',
      '#title' => t('Referral Sources'),
      '#options' => yougotleads_referral_sources($values),
      '#multiple' => true,
      '#default_value' => isset($values['referralSources']) ? $values['referralSources'] : NULL
    );

    $form['propertyId'] = array(
      '#type' => 'select',
      '#title' => t('Choose Property'),
      '#options' => yougotleads_properties_form_options($values),
      '#default_value' => isset($values['propertyId']) ? $values['propertyId'] : NULL
    );
  }

  $form['cid'] = array(
    '#type' => 'token',
    '#value' => isset($values['cid']) ? $values['cid'] : NULL
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#suffix' => ' '.l('Cancel', 'admin/config/services/ygl')
  );

  return $form;
}

function yougotleads_config_form_validate(&$form, &$form_state) {

  if (empty($form_state['values']['accessToken'])) {
    if (empty($form_state['values']['username'])
      && empty($form_state['values']['password']['pass1'])) {
      form_error($form['accessToken'], 'A Username is required');
    }
    elseif (empty($form_state['values']['username'])
      || empty($form_state['values']['password'])) {
      if (empty($form_state['values']['username'])) {
        form_error($form['username'], 'A Username is required');
      }
      if (empty($form_state['values']['password']['pass1'])) {
        form_error($form['password'], 'A Password is required');
      }
    }
    else {
      $client = new YGLClient($form_state['values']['username'],
        $form_state['values']['password']);
      $properties = $client->getProperties();
      if ($properties instanceof YGLResponse) {
        form_error($form['username'], 'Invalid credentials');
        form_error($form['password'], 'Invalid credentials');
      }
    }
  }
  else {
    $client = new YGLClient($form_state['values']['accessToken']);
    $properties = $client->getProperties();
    if ($properties instanceof YGLResponse) {
      form_error($form['accessToken'], 'Invalid credentials');
    }
  }
}

function yougotleads_config_form_submit(&$form, &$form_state) {
  $form_state['redirect'] = 'admin/config/services/ygl';
  $values = $form_state['values'];
  if (!isset($values['propertyId']) || (int)$values['propertyId'] < 1 ) {
    $form_state['rebuild'] = TRUE;
    drupal_set_message('Your settings are valid, please choose a Property below.', 'warning');
  }
  else {
    unset($form_state['rebuild'], $form['#rebuild']);
    if (isset($values['cid']) && $values['cid'] > 0) {
      $saved = drupal_write_record('ygl_config', $values, array('cid'));
    }
    else {
      $saved = drupal_write_record('ygl_config', $values);
    }
    if ($saved !== FALSE) {
      drupal_set_message('Your settings have been saved.', 'status');
    }
    else {
      drupal_set_message('Your settings have failed to save.', 'error');
    }
    drupal_redirect_form($form_state);
  }
}

/**
 * @desc  YouGotLeads delete config form hook
 * @param $form_state
 * @param $config
 * @return mixed
 */
function yougotleads_config_delete_form($form, &$form_state, $config) {
  $form['config_id'] = array(
    '#type' => 'token',
    '#value'=> $config['cid']
  );

  return confirm_form($form, t('Are you sure you want to delete this configuration?'),
    'admin/config/services/ygl',
    t('This operation is permanent and can\'t be undone.'),
    t('Delete'),
    t('Cancel'));
}

function yougotleads_config_delete_form_submit(&$form, &$form_state) {
  $id = $form_state['values']['config_id'];
  db_delete('ygl_config', array('cid' => $id));
  drupal_redirect_form($form_state);
}