<?php

/**
 * Contains \Drupal\entity_browser\Plugin\EntityBrowser\WidgetSelector\DropDown.
 */

namespace Drupal\entity_browser\Plugin\EntityBrowser\WidgetSelector;

use Drupal\entity_browser\WidgetsCollection;
use Drupal\entity_browser\WidgetSelectorBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Displays widgets in a select list.
 *
 * @EntityBrowserWidgetSelector(
 *   id = "drop_down",
 *   label = @Translation("Drop down widget"),
 *   description = @Translation("Displays the widgets in a drop down.")
 * )
 */
class DropDown extends WidgetSelectorBase {

  /**
   * {@inheritdoc}
   */
  public function getForm(array &$form = array(), FormStateInterface &$form_state = NULL) {
    // Set a wrapper container for us to replace the form on ajax call.
    $form['#prefix'] = '<div id="entity-browser-form">';
    $form['#suffix'] = '</div>';

    $element['widget'] = array(
      '#type' => 'select',
      '#options' => $this->widget_options,
      '#default_value' => $this->getCurrentWidget(),
    );

    $element['change'] = array(
      '#type' => 'submit',
      '#name' => 'change',
      '#value' => t('Change'),
      '#limit_validation_errors' => array(array('widget')),
      '#ajax' => array(
        'callback' => array($this, 'changeWidgetCallback'),
        'wrapper' => 'entity-browser-form',
      ),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array &$form, FormStateInterface $form_state) {
    // If we've submitted the form, update the current widget.
    if ($form_state->getValue('widget')) {
      $this->setCurrentWidget($form_state->getValue('widget'));
    }

    $form_state->setRebuild();
  }

  /**
   * AJAX callback to refresh form.
   *
   * @param array $form
   * @param FormStateInterface $form_state
   *
   * @return array
   *   Form element to replace.
   */
  public function changeWidgetCallback(array &$form, FormStateInterface $form_state) {
    return $form;
  }
}
