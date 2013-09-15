<?php
class ElementHelper
{
    private $modx;
    public $element_history;

    function __construct(modX &$modx, array $config = array()) {
        $this->modx =& $modx;
        $this->history = array();

        // merge passed config options with default ones, the passed onse overwrite the defaults
        $this->config = array_merge(array(
            'debug'         => $this->modx->getOption('elementhelper.debug'),
            'version'       => '1.4.0'
        ), $config);

        if ($this->config['debug'])
        {
            $this->modx->log(modX::LOG_LEVEL_INFO, '[' . __METHOD__ . '] Class successfully constructed!');
        }
    }

    public function create_element($element_type, $file_path, $file_type, $name)
    {
        $content = file_get_contents($file_path);

        // Weirdly MODx uses a different name title for templates
        $name_field = ($element_type['class_name'] === 'modTemplate' ? 'templatename' : 'name');

        // Get the element
        $element = $this->modx->getObject($element_type['class_name'], array($name_field => $name));

        // If the element doesn't exist create it
        if (!isset($element))
        {
            $element = $this->modx->newObject($element_type['class_name']);
            
            $element->set($name_field, $name);
        }

        $category_path = dirname(str_replace(MODX_BASE_PATH . $element_type['path'], '', $file_path));
        $category_names = explode('/', $category_path);
        $description = $this->_get_description($content);

        $element->set('category', $this->get_category_id(end($category_names)));
        $element->set('description', $description);
        $element->set('static', 1);

        // check content of system setting "elementhelper.source"
        $element->set('source', $this->modx->getOption('elementhelper.source'));
        
        // get the base path of the defined media source to determine the right path to set for the static file
        $source = $this->modx->getObject('sources.modMediaSource', array('id' => $element->get('source')));

        // unfortunately necessary, getters will not work without this
        $source->initialize();

        $element->set('static_file', str_replace($source->getBasePath(), '', $file_path));

        $element->setContent($content);

        if ($element->save())
        {
            $this->history[$element_type['class_name']][] = $name;

            // if it's a plugin, check if a events key is present and add system events automatically
            // needs to happen after saving the element/plugin
            // people need to be careful what they add in the @Events identifier, it will add any bullshit you write there to the db
            if ( $element_type['class_name'] === 'modPlugin' && $this->modx->getOption('elementhelper.plugin_events') )
            {                
                $events = $this->_get_events($content);
                $plugin_id = $element->get('id');

                // attach the events to the plugin
                foreach ($events as $event)
                {
                    $plugin_event = $this->modx->getObject('modPluginEvent', array(
                        'pluginid' => $plugin_id,
                        'event' => $event,
                    ));

                    if ($plugin_event == null)
                    {
                        $plugin_event = $this->modx->newObject('modPluginEvent');
                        $plugin_event->set('pluginid', $plugin_id);
                        $plugin_event->set('event', $event);
                        $plugin_event->set('priority', 0); // would be nice to make this also configurable, rarely used...but would be handy if needed
                        $plugin_event->save();
                    }
                }
            }
        }
    }

    public function create_element_files($element_type, $categories = array())
    {
        // get category ids
        $categoryids = array();
        foreach ($categories as $category)
        {
            if (!is_numeric($category))
            {
                $categoryobj = $this->modx->getObject('modCategory', array('category' => $category));
                $categoryids[] = $categoryobj->get('id');
            }
            else
            {
                $categoryids[] = $category;
            }
        }

        $this->modx->log(modX::LOG_LEVEL_ERROR, '[' . __METHOD__ . '] categoryids ' . print_r($categoryids,1));

        // create the element files
        if ($elements = $this->modx->getCollection($element_type['class_name'], array('category:IN' => $categoryids)))
        {
            foreach ($elements as $element) {
                // retrieve again the category name to build the correct path, bad coding but don't know better yet
                if ($categoryobj = $this->modx->getObject('modCategory', array('id' => $element->get('category'))))
                {
                    $categoryname = $categoryobj->get('category');
                }
                else
                {
                    $categoryname = '';
                }
                
                // first check/create the categoryfolder as the filehandler create method for files doesn't write the directory tree if not present
                $this->modx->cacheManager->writeTree($this->modx->getOption('elementhelper.root_path') . $element_type['path'] . $categoryname . '/');

                // Weirdly MODx uses a different name title for templates
                $name_field = ($element_type['class_name'] === 'modTemplate' ? 'templatename' : 'name');

                // initialize the modx fileHandler service
                $this->modx->getService('file', 'modFileHandler');

                // create the file object and do something with it
                $fileobj = $this->modx->file->make($this->modx->getOption('elementhelper.root_path') . $element_type['path'] . $categoryname . '/' . $element->get($name_field) . '.' . $element_type['file_type']);
                
                if (!$fileobj->exists())
                {
                    if (!$fileobj->create($element->get('content')))
                    {
                        $this->modx->log(modX::LOG_LEVEL_ERROR, '[' . __METHOD__ . '] file could not be written at ' . $fileobj->getPath());
                    }
                }
            }
        }
    }

    public function create_tv($tv)
    {
        $element = $this->modx->getObject('modTemplateVar', array('name' => $tv->name));

        // If the element doesn't exist create it
        if (!isset($element))
        {
            $element = $this->modx->newObject('modTemplateVar');
            $element->set('name', $tv->name);
        }

        // Set to no category by default in case it gets
        // set and then removed from template_variables.json
        $element->set('category', 0);

        foreach ($tv as $property => $value)
        {
            // Get the category id
            $value = ($property === 'category' ? $this->get_category_id($value) : $value);

            // input_properties fix, manualy convert to array before passing into set()
            if ($property == 'input_properties')
            {
                foreach ($value as $key => $item)
                {
                    // MIGX Fix, convert array object into json string
                    if ($key == 'formtabs' || $key == 'columns')
                    {
                        $input_properties[$key] = json_encode($item);
                    }
                    else
                    {
                        $input_properties[$key] = $item;
                    }
                }

                $element->set('input_properties', $input_properties);
            }

            if ($property !== 'name' && $property !== 'template_access' && $property !== 'input_properties')
            {
                $element->set($property, $value);
            }
        }

        if ($element->save())
        {
            $this->history['modTemplateVar'][] = $tv->name;
        }

        if ($this->modx->getOption('elementhelper.tv_access_control') == true)
        {
            $templates = $this->modx->getCollection('modTemplate');

            // Remove all tv access for each template
            foreach ($templates as $template)
            {
                $this->_remove_template_access($tv->name, $template->get('templatename'));
            }

            if (isset($tv->template_access))
            {
                // Add tv access to the specified templates
                foreach ($tv->template_access as $template)
                {
                    $this->_add_template_access($tv->name, $template);
                }
            }
        }
    }

    public function create_category($name, $parent_id)
    {
        $category = $this->modx->getObject('modCategory', array('category' => $name));

        // If the category doesn't exist create it
        if (!isset($category))
        {
            $category = $this->modx->newObject('modCategory');

            $category->set('category', $name);
        }

        $category->set('parent', $parent_id);

        $category->save();
    }

    // Get the files recursively from the passed directory path
    public function get_files($directory_path, $log = true)
    {
        $timestart = $this->modx->getMicroTime();
        $file_list = array();

        if (is_dir($directory_path))
        {
            $directory = opendir($directory_path);

            // Get a list of files from the element types directory
            while (($item = readdir($directory)) !== false)
            {   
                if ($item !== '.' && $item !== '..')
                {
                    $item_path = $directory_path . $item;

                    if (is_file($item_path))
                    {
                        $file_list[] = $item_path;
                    }
                    else
                    {
                        $file_list = array_merge($this->get_files($item_path . '/', false), $file_list);
                    }
                }
            }

            closedir($directory);
        }

        if ($this->config['debug'] && $log)
        { 
            //$this->modx->log(modX::LOG_LEVEL_INFO, '[' . __METHOD__ . '] The following files were found in .  ' . $directory_path . ': ' . print_r($file_list,1));
            $timeend = $this->modx->getMicroTime();
            //$this->modx->log(modX::LOG_LEVEL_INFO, '[' . __METHOD__ . '] executed in ' . sprintf('%2.4f s', $timeend - $timestart));
        }

        return $file_list;
    }

    // Get last modified date of folders recursively
    public function get_directory_lastmod($directory_path, $log = true)
    {
        $timestart = $this->modx->getMicroTime();
        $modified = array();

        if (is_dir($directory_path))
        {
            $modified[] = filemtime($directory_path);

            $directory = opendir($directory_path);

            // Get a list of files from the element types directory
            while (($item = readdir($directory)) !== false)
            {   
                if ($item !== '.' && $item !== '..')
                {
                    $item_path = $directory_path . $item;

                    if (is_dir($item_path))
                    {
                        $modified = array_merge($this->get_directory_lastmod($item_path . '/', false), $modified);
                    }
                }
            }

            closedir($directory);
        }

        if ($this->config['debug'] && $log)
        { 
            //$this->modx->log(modX::LOG_LEVEL_INFO, '[' . __METHOD__ . '] Directory structure lastmod for ' . $directory_path . ': ' . print_r($modified,1));
            $timeend = $this->modx->getMicroTime();
            //$this->modx->log(modX::LOG_LEVEL_INFO, '[' . __METHOD__ . '] executed in ' . sprintf('%2.4f s', $timeend - $timestart));
        }

        return $modified;
    }

    private function _add_template_access($tv_name, $template_name)
    {
        $tv = $this->modx->getObject('modTemplateVar', array('name' => $tv_name));
        $template = $this->modx->getObject('modTemplate', array('templatename' => $template_name));

        if ($template !== null)
        {
            $tv_template = $this->modx->getObject('modTemplateVarTemplate', array('tmplvarid' => $tv->get('id'), 'templateid' => $template->get('id')));

            if (!isset($tv_template))
            {
                $tv_template = $this->modx->newObject('modTemplateVarTemplate');

                $tv_template->set('templateid', $template->get('id'));
                $tv_template->set('tmplvarid', $tv->get('id'));

                $tv_template->save();
            }
        }
    }

    private function _remove_template_access($tv_name, $template_name)
    {
        $tv = $this->modx->getObject('modTemplateVar', array('name' => $tv_name));
        $template = $this->modx->getObject('modTemplate', array('templatename' => $template_name));

        $tv_template = $this->modx->getObject('modTemplateVarTemplate', array('tmplvarid' => $tv->get('id'), 'templateid' => $template->get('id')));

        if (isset($tv_template))
        {
            $tv_template->remove();
        }
    }

    private function _get_comments($file_contents)
    {
        $tokens = token_get_all($file_contents);

        $comments = array();

        foreach ($tokens as $token)
        {
            if ($token[0] === T_COMMENT || $token[0] === T_DOC_COMMENT)
            {
                $comments[] = $token[1];
            }
        }

        return $comments;
    }

    private function _get_description($file_contents)
    {
        $description = $this->modx->getOption('elementhelper.description_default');
        $comments = $this->_get_comments($file_contents);

        foreach ($comments as $comment)
        {
            $comment_lines = explode("\n", $comment);
            
            foreach($comment_lines as $comment_line)
            {
                // get string to search for description from system setting
                if (preg_match('/' . $this->modx->getOption('elementhelper.description_key') . ' (.*)/', $comment_line, $match))
                {
                    $description = $match[1];
                }
            }
        }

        return $description;
    }

    private function _get_events($file_contents)
    {
        $comments = $this->_get_comments($file_contents);

        foreach ($comments as $comment)
        {
            $comment_lines = explode("\n", $comment);
            
            foreach($comment_lines as $comment_line)
            {
                // get string to search for events from system setting
                if (preg_match('/' . $this->modx->getOption('elementhelper.plugin_events_key') . ' (.*)/', $comment_line, $match))
                {
                    $events = $match[1];
                }
            }
        }

        // strip spaces from event names
        $events = array_filter(array_map('trim', explode(',', $events)));

        // check for valid/existing events in the MODx database events table (if checking is enabled) and filter out not existing events
        // this prevents the errant creation of unwanted events due to typos
        if ($this->modx->getOption('elementhelper.plugin_events_check') && !empty($events)) {
            $modx_events = $this->modx->getCollection('modEvent');
            $valid_events = array();

            foreach ($modx_events as $modx_event) {
                $valid_events[] = $modx_event->get('name');
            }

            // filter out all non existing events
            $events = array_intersect($valid_events, $events);
        }

        return $events;
    }

    public function get_category_id($name)
    {
        $category = $this->modx->getObject('modCategory', array('category' => $name));
        $category_id = isset($category) ? $category->get('id') : 0;
        
        return $category_id;
    }
}
