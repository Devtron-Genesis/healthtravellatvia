<?php
function manifest_admin_form($form, &$form_state)
{
    $t = get_t();

    $form['manifest_name'] = [
      '#type' => 'textfield',
      '#title' => $t('name'),
      '#description' => $t('description'),
      '#default_value' => variable_get('manifest_name', manifest_NAME),
      '#required' => true,
    ];

    $form['manifest_shortname'] = [
      '#type' => 'textfield',
      '#title' => $t('short Name'),
      '#description' => $t('Usually appears as the name on the splash screen during launch.'),
      '#default_value' => variable_get('manifest_shortname', manifest_SHORTNAME),
      '#required' => true,
    ];

    $form['manifest_description'] = [
      '#type' => 'textfield',
      '#title' => $t('Description'),
      '#description' => $t('A short description of the Progressive Web App. Answer the question "Why do I need this app?"'),
      '#default_value' => variable_get('manifest_description', manifest_DESCRIPTION),
    ];

    $form['manifest_backcolor'] = [
      '#type' => 'textfield',
      '#title' => $t('Background color'),
      '#description' => $t('Color of the browser UI when launching from home screen.'),
      '#default_value' => variable_get('manifest_backcolor', manifest_BACKCOLOR),
    ];

    $form['manifest_themecolor'] = [
      '#type' => 'textfield',
      '#title' => $t('Theme color'),
      '#description' => $t('Color of the background splash page when launching from home screen.'),
      '#size' => 8,
      '#default_value' => variable_get('manifest_themecolor', manifest_THEMECOLOR),
    ];

    $form['manifest_starturl'] = [
      '#type' => 'textfield',
      '#title' => $t('Start URL'),
      '#description' => $t('Home page when launched from home screen. You can append a query string for analytics. For example <code>/home?startfrom=manifest</code>.'),
      '#default_value' => variable_get('manifest_starturl', manifest_STARTURL),
    ];

    $form['manifest_orientation'] = [
      '#type' => 'select',
      '#title' => $t('Orientation'),
      '#options' => [
        'portrait' => $t('Portrait'),
        'landscape' => $t('Landscape'),
      ],
      '#default_value' => variable_get('manifest_orientation', manifest_ORIENTATION),
    ];

    $form['manifest_display'] = [
      '#type' => 'select',
      '#title' => $t('Display'),
      '#options' => [
        'fullscreen' => $t('Full screen'),
        'standalone' => $t('Standalone (as an app)'),
        'minimal-ui' => $t('Minimal UI'),
        'browser'    => $t('Browser'),
      ],
      '#default_value' => variable_get('manifest_display', manifest_DISPLAY),
    ];

    $form['manifest_icon'] = [
      '#type' => 'textfield',
      '#title' => $t('Icon'),
      '#description' => $t('Define a set of icons for the browser to use. Support file *.svg'),
      '#default_value' => variable_get('manifest_icon', manifest_ICON),
    ];

    $form = system_settings_form($form);
    $form['#submit'][] = 'manifest_admin_configuration_submit';

    return $form;
}

function manifest_admin_configuration_submit($form, &$form_state)
{
    manifest_create();
}
