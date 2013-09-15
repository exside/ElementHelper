ElementHelper for MODx Revolution
==================================

ElementHelper is a MODx plugin that automatically creates elements from static files without the need for the manager. It is especially helpful if you like to manage your elements without copying/pasting them to your editor and back to save them.

Installation
------------

Install through the MODx package manager. [A guide for the package manager can be found here](http://rtfm.modx.com/display/revolution20/Package+Management)

Usage
-----

### Note

It is recommend that you only use this plugin during development of your site ~~as it runs every time a page is loaded~~. You can disable it by simply going to the Elements tab in the manager and selecting 'Plugin Disabled' on the 'element_helper' plugin. As of ElementHelper v1.3.0 this is not an issue anymore as ElementHelper just runs if you're logged in as a member of a specific usergroup (default "Administrator") and then caches it's last run. ElementHelper now runs only when you change a file in the specified directories and should only have a minimal impact on the site performance.

### Initial Setup

To start using ElementHelper create a folder named 'elements' in the core or assets directory of your MODx installation and then create folders for chunks, snippets, templates and plugins within the elements folder (See the configuration section below if you want to change where ElementHelper looks for your elements). Finally simply create your elements within those folders e.g. create a header.tpl file within the chunks folder or a get_menu.php file within your snippets folder. These elements will then automatically appear as elements in your MODx manager when you reload the manager or a frontend page as a memer of the authorized usergroup.

### Chunks, Templates, Snippets, Plugins

Simply create your chunks, templates, snippets and plugins within their respective folders and they will automatically be created when you reload the manager or a frontend page.

### Template Variables

Template Variables are managed using a JSON file, if you're using the default settings create a template_variables.json file within your elements folder. To create a simple text template variable add the following to your template_variables.json file:

```json
[{
    "name": "example_text_tv",
    "caption": "Example Text TV",
    "type": "text"
}]
```

Expanding on that example you could add an image template variable that is assigned to two templates called 'home' and 'standard_page' with the following:

Note: The "Template Variable Access Control" setting must be set to "Yes" for the template_access feature to work. See the Configuration section for more information.

```json
[{
    "name": "example_text_tv",
    "caption": "Example Text TV",
    "type": "text"

},{
    "name": "example_image_tv",
    "caption": "Example Image TV",
    "type": "image",
    "template_access": ["home", "standard_page"]
}]
```

###### Template Variable Properties

* "type" The input type of this TV (all types should be lowercase)
* "name" The name of this TV, and key by which it will be referenced in tags
* "caption" The caption that will be used to display the name of this TV when on the Resource page
* "description" A user-provided description of this TV
* "category" The Category for this TV, or 0 if not in one
* "locked" Whether or not this TV can only be edited by an Administrator
* "elements" Default values for this TV
* "rank" The rank of the TV when sorted and displayed relative to other TVs in its Category
* "display" The output render type of this TV
* "default_text" The default value of this TV if no other value is set
* "properties" An array of default properties for this TV
* "input_properties" An array of input properties related to the rendering of the input of this TV
* "output_properties" An array of output properties related to the rendering of the output of this TV

Configuration / System Settings
-------------------------------

The following configuration options can be found by going to System Settings within your MODX manager and selecting the 'elementhelper' namespace.
* Automatically Remove Elements: Allow ElementHelper to remove elements if you delete their source files (this will also remove TVs when you remove them from the TV JSON file).
* Automatically Create Elements: Allow ElementHelper to create static elements/files from elements that are already existing in the database (but are not found in the elements physical directory/path). At the time this only works for Chunks, Snippets, Plugins and Templates.
* Create Elements Categories: Comma separated list (with or without spaces) of categories for which ElementHelper should create the static files for. By default (if "Automatically Create Events" is set to true) ElementHelper just creates static files for elements that are in NO category, e.g. "0", if you want to specify categories but also include the elements without category then 0 also has to be included in the list, e.g. "0,FormIt,Articles".
* Root Path: This is the path all the other relative element paths get appended to. Defaults to {base_path}. If you have your MODx core outsite of the webroot (which you should, see [MODx advanced installation](http://www.sepiariver.ca/blog/modx-web/benefits-of-the-modx-advanced-installation) for more information) and you want to have your 'elements' folder stored in the core directory, you need to change this to {core_path}. Additionally you could also specify another MODx path constant here, e.g. {assets_path} if you want to store your elements in the assets folder (then you don't need to specify assets/elements/chunks/ but just elements/chunks/ as the path/to/your/modxinstallation/assets/ is already prepended).
* Chunk Path: Set the path to your chunk elements.
* Chunk Filetype: The filetype for chunks. Defaults to "tpl".
* Plugin Path: Set the path to your plugin elements.
* Plugin Filetype: The filetype for plugins. Defaults to "php".
* Plugin Add Events: Checks for system events behind the string defined in "Plugin Events Key" and attaches the plugin to these system events automatically.
* Plugin Check Events: Checks if the system event(s) specified in the plugin file comment block are valid ones, e.g. exists in the current MODx installations event table (this helps preventing the creation of unwanted new events due to typos etc.) and if not the event is ignored. This should not impose any problems with custom system events as it simply reads the database table and accecpts everything that is already in there.
* Plugin Events Key: String to identify plugin events inside the opening comment block. Defaults to @Events.
* Snippet Path: Set the path to your snippet elements.
* Snippet Filetype: The filetype for snippets. Defaults to "php".
* Template Path: Set the path to your template elements.
* Template Filetype: The filetype for templates. Defaults to "tpl".
* Template Variables JSON Path: Set the path to your template variable JSON file.
* Template Variable Access Control: Allow ElementHelper to give template variables access to the templates you set in the template variable JSON file. Note: Turning this on will remove template variable access from all templates unless specified in the template variable JSON file.
* Element History: Keeps track of elements created with ElementHelper. You shouldn't ever need to edit this.
* Elements media source: Set a media source for your static elements.
* Description key: Set a key that will be used to find descriptions for your element files, defaults to @Description.
* Default Description: Set a default description for elements created with ElementHelper.
* Usergroups: Set usergroups that ElementHelper should run for. Defaults to Administrator.
* Debug: Activate/deactivate logging of debug messages into the MODx error log.
