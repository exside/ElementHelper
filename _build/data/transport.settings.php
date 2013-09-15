<?php

$settings = array();

$settings['elementhelper.root_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.root_path']->fromArray(array(
    'key' => 'elementhelper.root_path',
    'value' => '{base_path}',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.chunk_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.chunk_path']->fromArray(array(
    'key' => 'elementhelper.chunk_path',
    'value' => 'core/elements/chunks/',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.chunk_filetype'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.chunk_filetype']->fromArray(array(
    'key' => 'elementhelper.chunk_filetype',
    'value' => 'tpl',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.template_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.template_path']->fromArray(array(
    'key' => 'elementhelper.template_path',
    'value' => 'core/elements/templates/',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.template_filetype'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.template_filetype']->fromArray(array(
    'key' => 'elementhelper.template_filetype',
    'value' => 'tpl',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.plugin_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.plugin_path']->fromArray(array(
    'key' => 'elementhelper.plugin_path',
    'value' => 'core/elements/plugins/',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.plugin_filetype'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.plugin_filetype']->fromArray(array(
    'key' => 'elementhelper.plugin_filetype',
    'value' => 'php',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.plugin_events'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.plugin_events']->fromArray(array(
    'key' => 'elementhelper.plugin_events',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.plugin_events_check'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.plugin_events_check']->fromArray(array(
    'key' => 'elementhelper.plugin_events_check',
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);


$settings['elementhelper.plugin_events_key'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.plugin_events_key']->fromArray(array(
    'key' => 'elementhelper.plugin_events_key',
    'value' => '@Events',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.snippet_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.snippet_path']->fromArray(array(
    'key' => 'elementhelper.snippet_path',
    'value' => 'core/elements/snippets/',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.snippet_filetype'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.snippet_filetype']->fromArray(array(
    'key' => 'elementhelper.snippet_filetype',
    'value' => 'php',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.tv_json_path'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.tv_json_path']->fromArray(array(
    'key' => 'elementhelper.tv_json_path',
    'value' => 'core/elements/template_variables.json',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'paths'
), '', true, true);

$settings['elementhelper.tv_access_control'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.tv_access_control']->fromArray(array(
    'key' => 'elementhelper.tv_access_control',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.auto_remove_elements'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.auto_remove_elements']->fromArray(array(
    'key' => 'elementhelper.auto_remove_elements',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.auto_create_elements'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.auto_create_elements']->fromArray(array(
    'key' => 'elementhelper.auto_create_elements',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.auto_create_elements_categories'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.auto_create_elements_categories']->fromArray(array(
    'key' => 'elementhelper.auto_create_elements_categories',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.element_history'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.element_history']->fromArray(array(
    'key' => 'elementhelper.element_history',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.source'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.source']->fromArray(array(
    'key' => 'elementhelper.source',
    'value' => 1,
    'xtype' => 'modx-combo-source',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.description_key'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.description_key']->fromArray(array(
    'key' => 'elementhelper.description_key',
    'value' => '@Description',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.description_default'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.description_default']->fromArray(array(
    'key' => 'elementhelper.description_default',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.usergroups'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.usergroups']->fromArray(array(
    'key' => 'elementhelper.usergroups',
    'value' => 'Administrator',
    'xtype' => 'textfield',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

$settings['elementhelper.debug'] = $modx->newObject('modSystemSetting');
$settings['elementhelper.debug']->fromArray(array(
    'key' => 'elementhelper.debug',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'elementhelper',
    'area' => 'default'
), '', true, true);

return $settings;