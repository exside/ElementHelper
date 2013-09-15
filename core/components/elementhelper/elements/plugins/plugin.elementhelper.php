<?php
/**
 * @description Creates elements automatically from static files.
 * @events OnManagerPageInit, OnWebPageInit, OnSiteRefresh
 **/

$packagename = 'elementhelper';
$classname = 'ElementHelper';

// set up basic paths
$packagepath = MODX_CORE_PATH . 'components/' . $packagename . '/';
$modelpath   = $packagepath . 'model/';
$basepath    = $modx->getOption('elementhelper.root_path');

// Turn debug messages on/off
$debug = $modx->getOption('elementhelper.debug');

if ($debug)
{
    $modx->setLogLevel(modX::LOG_LEVEL_INFO);
    $modx->log(modX::LOG_LEVEL_INFO, '[' . $classname . '] Debugging is activated ');
    $timestart = $modx->getMicroTime();
}

// Set up native modx caching
$cacheid = $packagename;
$cachetime = 0;
$cacheoptions = array(
    // Specify folder/partition inside the modx cache folder where cache files get saved in
    xPDO::OPT_CACHE_KEY => $packagename
);

// Get the usergroups where ElementHelper should be active
// (usually only Administrators/Devs that can change files in the target directories)
$usergroups = explode(',', $modx->getOption('elementhelper.usergroups'));

// the element types
$element_types = array(
    'templates' => array(
        'class_name' => 'modTemplate',
        'path' => $modx->getOption('elementhelper.template_path', null, 'core/elements/templates/'),
        'file_type' => $modx->getOption('elementhelper.template_filetype', null, 'tpl')
    ),
    'chunks' => array(
        'class_name' => 'modChunk',
        'path' => $modx->getOption('elementhelper.chunk_path', null, 'core/elements/chunks/'),
        'file_type' => $modx->getOption('elementhelper.chunk_filetype', null, 'tpl')
    ),
    'snippets' => array(
        'class_name' => 'modSnippet',
        'path' => $modx->getOption('elementhelper.snippet_path', null, 'core/elements/snippets/'),
        'file_type' => $modx->getOption('elementhelper.snippet_filetype', null, 'php')
    ),
    'plugins' => array(
        'class_name' => 'modPlugin',
        'path' => $modx->getOption('elementhelper.plugin_path', null, 'core/elements/plugins/'),
        'file_type' => $modx->getOption('elementhelper.plugin_filetype', null, 'php')
    )
);

// Initialize the class
$element_helper = $modx->getService($packagename, $classname, $modelpath . $packagename . '/');

if ($modx->user->isMember($usergroups) && $element_helper instanceof $classname)
{
    if ($modx->event->name !== 'OnSiteRefresh')
    {
        // initialize element history and prevent errors with merging when there's noting in it
        $element_history = unserialize($modx->getOption('elementhelper.element_history'));
        $element_history = is_array($element_history) ? $element_history : array();

        // Create all the templates, snippets, chunks and plugins
        foreach ($element_types as $element_type)
        {
            $log_prefix = '[' . $classname. '] ' . $element_type['class_name'] . ': ';

            // create static files from elements for the specified categories if system setting is set to true
            if ($modx->getOption('elementhelper.auto_create_elements'))
            {
                $categories = array_map('trim', explode(',', $modx->getOption('elementhelper.auto_create_elements_categories')));
                $element_helper->create_element_files($element_type, $categories);
            }

            $file_list = $element_helper->get_files($basepath . $element_type['path']);
            
            // experiment if only checking the directories last modified time is faster than checking each file...
            // seems not really to be the case, have to check with larger amounts of elements
            //if ( $debug ) { $modx->log(modX::LOG_LEVEL_INFO, '[' . $classname . '] Folder ' . $element_type['path'] . ' last modified check ' . strftime('%d.%m.%Y %H:%M:%S', max($element_helper->get_directory_lastmod($basepath . $element_type['path'])))); }
            
            $file_name = array();

            // Stores the time the file was modified at
            $modified = array();

            // Go through all files in $file_list
            foreach ($file_list as $file) {
                $file_type = explode('.', $file);
                $file_type = '.' . end($file_type);
                $file_name = basename($file, $file_type);

                $file_names[] = $file_name;

                // should prevent problems when files have the same timestamp and would have the 
                // same array key... just adding a small random number of seconds to the filemtime
                if (array_key_exists(filemtime($file), $file_list))
                {
                    if (touch($file, filemtime($file) + mt_rand(1, 100)))
                    {
                        $modified[] = filemtime($file);
                    }
                    else
                    {
                        $modx->log(modX::LOG_LEVEL_ERROR, $log_prefix . 'could not touch() to change file last accessed time for ' . $file . '. You may have unexpected caching issues because of this, e.g. not refreshing the elements even if they should.');
                    }
                }
                else
                {
                    $modified[] = filemtime($file);
                }
            }

            if ( !empty($file_list))
            {
                // Set the modified file times as the keys for the files
                $file_list = array_combine($modified, $file_list);

                // Sort the $files array backwards with key = timestamp of last modified
                krsort($file_list);

                // Cut the array at first item = most recently modified file as that's all we need to check if a file was updated
                $last_mod = key(array_slice($file_list, 0, 1, true));

                // Remove elements that are in the element history but no longer exist in the elements dir
                if ($modx->getOption('elementhelper.auto_remove_elements', null, true))
                {
                    $element_type_name = $element_type['class_name'];

                    // Check if a history for this element type exists
                    if (isset($element_history[$element_type_name]))
                    {
                        // Loop through the element history for this element type
                        foreach ($element_history[$element_type_name] as $old_element_name)
                        {
                            // Remove the element if it's not in the list of files
                            if (!in_array($old_element_name, $file_names))
                            {
                                $name_field = ($element_type_name === 'modTemplate' ? 'templatename' : 'name');

                                $element = $modx->getObject($element_type_name, array($name_field => $old_element_name));

                                $element->remove();

                                if ($debug)
                                {
                                    $modx->log(modX::LOG_LEVEL_INFO, '[' . $classname . '] Removed ' . $element_type_name . ' ' . $old_element_name . ' from database');
                                }
                            }
                        }
                    }
                }

                // Check if cachefile exists / should be renewed / or cached if not there already
                if (is_null($modx->cacheManager->get($cacheid . '.' . $element_type['class_name'], $cacheoptions)) || $modx->cacheManager->get($cacheid . '.' . $element_type['class_name'], $cacheoptions) !== $last_mod)
                {
                    // Cache the newest filetime for that element class
                    $modx->cacheManager->set($cacheid . '.' . $element_type['class_name'], $last_mod, $cachetime, $cacheoptions);

                    $file_names = array();

                    foreach ($file_list as $file)
                    {
                        $file_type = explode('.', $file);
                        $file_type = '.' . end($file_type);
                        $file_name = basename($file, $file_type);

                        $file_names[] = $file_name;

                        $category_path = dirname(str_replace($basepath . $element_type['path'], '', $file));
                        $category_names = explode('/', $category_path);

                        // If it's not the current directory
                        if ($category_path !== '.')
                        {
                            foreach ($category_names as $i => $category_name)
                            {
                                $parent_id = $i !== 0 ? $element_helper->get_category_id($category_names[$i - 1]) : 0;

                                $element_helper->create_category($category_name, $parent_id);
                            }
                        }

                        $element_helper->create_element($element_type, $file, $file_type, $file_name);
                    }

                    // Refresh the cache to make the changed elements visible on the site
                    $modx->cacheManager->refresh(array(
                        'resource' => array()
                    ));

                    if ($debug)
                    {
                        $modx->log(modX::LOG_LEVEL_INFO, $log_prefix . 'updated and cache refreshed!');
                    }
                }
                else
                {
                    if ($debug)
                    {
                        $modx->log(modX::LOG_LEVEL_INFO, $log_prefix . 'nothing changed! Last modified file is from: ' . strftime('%d.%m.%Y %H:%M:%S', $modx->cacheManager->get($cacheid . '.' . $element_type['class_name'], $cacheoptions)));
                    }
                }
            }
            else
            {
                if ($debug)
                { 
                    $modx->log(modX::LOG_LEVEL_INFO, $log_prefix . 'there seem to be no files in ' . $element_type['path']);
                }
            }
        }

        $tv_json_path = $basepath . $modx->getOption('elementhelper.tv_json_path', null, 'core/elements/template_variables.json');

        // Get the template variables
        if (file_exists($tv_json_path))
        {
            $log_prefix = '[' . $classname . '] modTemplateVar: ';

            $tv_json = file_get_contents($tv_json_path);
            $tvs = ($tv_json === '' ? json_decode('[]') : json_decode($tv_json));
            $tv_names = array();
            $last_mod = filemtime($tv_json_path);

            // Check if cachefile exists / should be renewed / or cached if not there already
            if (is_null($modx->cacheManager->get($cacheid . '.modTemplateVar', $cacheoptions)) || $modx->cacheManager->get($cacheid . '.modTemplateVar', $cacheoptions) !== $last_mod)
            {
                // Cache last mod time
                $modx->cacheManager->set($cacheid . '.modTemplateVar', $last_mod, $cachetime, $cacheoptions);

                // Check if there are some TVs to loop through
                if ($tvs !== null)
                {
                    // Create all the template variables
                    foreach ($tvs as $tv)
                    {
                        $tv_names[] = $tv->name;

                        if (isset($tv->category))
                        {
                            $element_helper->create_category($tv->category, 0);
                        }

                        $element_helper->create_tv($tv);
                    }

                    // Remove elements that are in the element history but no longer exist in the TV JSON file
                    if ($modx->getOption('elementhelper.auto_remove_elements', null, true))
                    {
                        // Check if a history for this element type exists
                        if (isset($element_history['modTemplateVar']))
                        {
                            // Loop through the element history for this element type
                            foreach ($element_history['modTemplateVar'] as $old_element_name)
                            {
                                // Remove the element if it's not in the list of files
                                if (!in_array($old_element_name, $tv_names))
                                {
                                    $element = $modx->getObject('modTemplateVar', array('name' => $old_element_name));

                                    $element->remove();

                                    if ($debug)
                                    {
                                        $modx->log(modX::LOG_LEVEL_INFO, '[' . $classname . '] Removed modTemplateVar ' . $old_element_name . ' from database');
                                    }
                                }
                            }
                        }
                    }
                }


                // Refresh the cache to make the changed elements visible on the site
                $modx->cacheManager->refresh(array(
                    'resource' => array()
                ));

                if ($debug)
                {
                    $modx->log(modX::LOG_LEVEL_INFO, $log_prefix . 'updated and cache refreshed!');
                }
            }
            else
            {
                if ($debug)
                {
                    $modx->log(modX::LOG_LEVEL_INFO, $log_prefix . 'nothing changed! Last mod: ' . strftime('%d.%m.%Y %H:%M:%S', $modx->cacheManager->get($cacheid . '.modTemplateVar', $cacheoptions)));
                }
            }
        }

        $element_history = array_merge($element_history, $element_helper->history);

        // Save the updated list of created elements, moved it outside the loops make performance better
        // even with small amounts of elements this step took about 300ms for each elementType,
        // this adds up, in consequence doing it only once speeds things up and additionally I'm also not sure, if it really worked...
        // I have had always only the last element category that was updated in the history, not all elements
        // I think this was due to a missing merge between old and updated history
        $element_history_setting = $modx->getObject('modSystemSetting', 'elementhelper.element_history');
        $element_history_setting->set('value', serialize($element_history));
        $element_history_setting->save();

        if ($debug)
        { 
            $timeend = $modx->getMicroTime();
            $modx->log(modX::LOG_LEVEL_INFO, '{modPlugin}: ' . $packagename . ' executed in ' . sprintf('%2.4f s', $timeend - $timestart));
            
            // Set logLevel back to ERROR, preventing a lot of crap getting logged
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
        }
    }
    else
    {
        // system event OnSiteRefresh triggered, deleting ElementHelper cache partition
        foreach ($element_types as $element_type)
        {
            $modx->cacheManager->delete($cacheid . '.' . $element_type['class_name'], $cacheoptions);
        }

        if ($debug)
        {
            $modx->log(modX::LOG_LEVEL_INFO, '[' . $classname . '] Deleted ElementHelper cache files!');
        }
    }
}