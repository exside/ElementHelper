<?php

$_lang['setting_elementhelper.root_path'] = 'Root Path';
$_lang['setting_elementhelper.root_path_desc'] = 'This is the path all the other relative element paths get appended to. Defaults to {base_path}. If you have your MODx core outsite of the webroot (which you should, see MODx advanced installation for more information) and you want to have your elements folder stored in the core directory, you need to change this to {core_path}.';

$_lang['setting_elementhelper.chunk_path'] = 'Chunk Path';
$_lang['setting_elementhelper.chunk_path_desc'] = 'The path to your chunk directory.';

$_lang['setting_elementhelper.chunk_filetype'] = 'Chunk Filetype';
$_lang['setting_elementhelper.chunk_filetype_desc'] = 'The filetype for chunks. Defaults to "tpl".';

$_lang['setting_elementhelper.template_path'] = 'Template Path';
$_lang['setting_elementhelper.template_path_desc'] = 'The path to your template directory.';

$_lang['setting_elementhelper.template_filetype'] = 'Template Filetype';
$_lang['setting_elementhelper.template_filetype_desc'] = 'The filetype for templates. Defaults to "tpl".';

$_lang['setting_elementhelper.snippet_path'] = 'Snippet Path';
$_lang['setting_elementhelper.snippet_path_desc'] = 'The path to your snippet directory.';

$_lang['setting_elementhelper.snippet_filetype'] = 'Snippet Filetype';
$_lang['setting_elementhelper.snippet_filetype_desc'] = 'The filetype for snippets. Defaults to "php".';

$_lang['setting_elementhelper.plugin_path'] = 'Plugin Path';
$_lang['setting_elementhelper.plugin_path_desc'] = 'The path to your plugin directory.';

$_lang['setting_elementhelper.plugin_filetype'] = 'Plugin Filetype';
$_lang['setting_elementhelper.plugin_filetype_desc'] = 'The filetype for plugins. Defaults to "php".';

$_lang['setting_elementhelper.plugin_events'] = 'Plugin Add Events';
$_lang['setting_elementhelper.plugin_events_desc'] = 'Checks for plugin events behind the string defined in "Plugin Events Key" and attaches the plugin to these events automatically. Defaults to false.';

$_lang['setting_elementhelper.plugin_events_check'] = 'Plugin Check Events';
$_lang['setting_elementhelper.plugin_events_check_desc'] = 'Checks if the event(s) specified in the plugin files comment block is a valid one, e.g. exists in the current installations event table (this helps preventing the creation of unwanted new events due to typos etc.) and if not the event is ignored. Disable this if you use custom events. Defaults to true.';

$_lang['setting_elementhelper.plugin_events_key'] = 'Plugin Events Key';
$_lang['setting_elementhelper.plugin_events_key_desc'] = 'String to identify plugin events inside the opening comment block. Defaults to @Events.';

$_lang['setting_elementhelper.tv_json_path'] = 'Template Variables JSON Path';
$_lang['setting_elementhelper.tv_json_path_desc'] = 'The path to your template variables json file.';

$_lang['setting_elementhelper.tv_access_control'] = 'Template Variable Access Control';
$_lang['setting_elementhelper.tv_access_control_desc'] = 'Allow ElementHelper to give template variables access to the templates you set in the template variable json file. Note: Turning this on will remove template variable access from all templates unless specified in the template variable json file.';

$_lang['setting_elementhelper.auto_remove_elements'] = 'Automatically Remove Elements';
$_lang['setting_elementhelper.auto_remove_elements_desc'] = 'Allow ElementHelper to remove elements if you delete their source files (this will also remove TVs when you remove them from the TV JSON file).';

$_lang['setting_elementhelper.auto_create_elements'] = 'Automatically Create Elements';
$_lang['setting_elementhelper.auto_create_elements_desc'] = 'Allow ElementHelper to create static elements/files from elements that are already existing in the database (but are not found in the elements physical directory/path). At the time this only works for Chunks, Snippets, Plugins and Templates.';

$_lang['setting_elementhelper.auto_create_elements_categories'] = 'Create Elements Categories';
$_lang['setting_elementhelper.auto_create_elements_categories_desc'] = 'Comma separated list (with or without spaces) of categories for which ElementHelper should create the static files for. By default (if "Automatically Create Events" is set to true) ElementHelper just creates static files for elements that are in NO category, if you want to specify categories but also include the elements without category then the first item of the list should be empty, eg. " ,FormIt,Articles". Defaults to elements without category.';

$_lang['setting_elementhelper.element_history'] = 'Element History';
$_lang['setting_elementhelper.element_history_desc'] = "A list of elements created with ElementHelper. You shouldn't ever need to edit this.";

$_lang['setting_elementhelper.source'] = 'Elements media source';
$_lang['setting_elementhelper.source_desc'] = 'Defaults to media source with ID 1, change to according media source if another is used for static elements.';

$_lang['setting_elementhelper.description_key'] = 'Description key';
$_lang['setting_elementhelper.description_key_desc'] = 'String to identify description information for elements inside the opening comment block. Defaults to @Description.';

$_lang['setting_elementhelper.description_default'] = 'Default Description';
$_lang['setting_elementhelper.description_default_desc'] = 'Defines the default description for elements created with ElementHelper if no description is specified in the files comment block.';

$_lang['setting_elementhelper.usergroups'] = 'Usergroups';
$_lang['setting_elementhelper.usergroups_desc'] = 'Comma-delimited list of usergroups where ElementHelper should be active, usually only the group for Administrators/Devs that can change files in the target directories.';

$_lang['setting_elementhelper.debug'] = 'Debug';
$_lang['setting_elementhelper.debug_desc'] = 'If debugging is activated, ElementHelper logs useful information for error finding to the MODx error log.';