<?php

$_lang['setting_elementhelper.root_path'] = 'Root Pfad';
$_lang['setting_elementhelper.root_path_desc'] = 'Dies ist der Pfad an den alle anderen relativen Elemente Pfade angehängt werden. Standard ist {base_path}. Wird das MODx core Verzeichnis ausserhalb des Webroots installiert (was so sein sollte, mehr Infos dazu in MODx advanced Installation) und soll das elements Verzeichnis im core Verzeichnis liegen, so muss hier {core_path} eingetragen werden.';

$_lang['setting_elementhelper.chunk_path'] = 'Chunks Pfad';
$_lang['setting_elementhelper.chunk_path_desc'] = 'Pfad zum Chunks-Ordner.';

$_lang['setting_elementhelper.chunk_filetype'] = 'Chunk Dateityp';
$_lang['setting_elementhelper.chunk_filetype_desc'] = 'Der Dateityp für Chunks. Standardmässig "tpl".';

$_lang['setting_elementhelper.template_path'] = 'Templates Pfad';
$_lang['setting_elementhelper.template_path_desc'] = 'Pfad zum Templates-Ordner.';

$_lang['setting_elementhelper.template_filetype'] = 'Template Dateityp';
$_lang['setting_elementhelper.template_filetype_desc'] = 'Der Dateityp für Templates. Standardmässig "tpl".';

$_lang['setting_elementhelper.snippet_path'] = 'Snippets Pfad';
$_lang['setting_elementhelper.snippet_path_desc'] = 'Pfad zum Snippets-Ordner.';

$_lang['setting_elementhelper.snippet_filetype'] = 'Snippet Dateityp';
$_lang['setting_elementhelper.snippet_filetype_desc'] = 'Der Dateityp für Snippets. Standardmässig "php".';

$_lang['setting_elementhelper.plugin_path'] = 'Plugins Pfad';
$_lang['setting_elementhelper.plugin_path_desc'] = 'Pfad zum Plugins-Ordner.';

$_lang['setting_elementhelper.plugin_filetype'] = 'Plugin Dateityp';
$_lang['setting_elementhelper.plugin_filetype_desc'] = 'Der Dateityp für Plugins. Standardmässig "php".';

$_lang['setting_elementhelper.plugin_events'] = 'Plugin Events Hinzufügen';
$_lang['setting_elementhelper.plugin_events_desc'] = 'ElementHelper nach Events hinter dem in "Plugin Events Identifikations-String" definierten String suchen lassen. Werden Events gefunden so aktiviert ElementHelper diese Events für den Plugin automatisch. Standard ist false.';

$_lang['setting_elementhelper.plugin_events_check'] = 'Plugin Events Prüfen';
$_lang['setting_elementhelper.plugin_events_check_desc'] = 'Überprüft ob die im Kommentarblock des Elements definierten Events auch tatsächlich in der Events Tabelle der MODx Installation vorhanden sind (verhindert ungewollte Erzeugung von neuen Events aufgrund von Schreibfehlern), ist dies nicht der Fall, wird der Event ignoriert. Diese Funktion deaktivieren, wenn Custom Events genutzt werden. Standard ist true.';

$_lang['setting_elementhelper.plugin_events_key'] = 'Plugin Events Identifikations-String';
$_lang['setting_elementhelper.plugin_events_key_desc'] = 'String um Plugin Events im ersten Kommentarblock eines Plugins zu identifizieren. Standard ist @Events';

$_lang['setting_elementhelper.tv_json_path'] = 'Template Variablen JSON Pfad';
$_lang['setting_elementhelper.tv_json_path_desc'] = 'Pfad zum Template Variablen JSON File.';

$_lang['setting_elementhelper.tv_access_control'] = 'Template Variablen Zugriffsberechtigung';
$_lang['setting_elementhelper.tv_access_control_desc'] = 'ElementHelper erlauben, Template Variablen den Zugriff auf die Templates zu geben, die im JSON File angegeben wurden. Achtung: Wird diese Option auf 1 gesetzt, werden alle Zugriffsberechtigungen einer Template Variable entfernt, die nicht im JSON File angegeben sind.';

$_lang['setting_elementhelper.auto_remove_elements'] = 'Elemente automatisch entfernen';
$_lang['setting_elementhelper.auto_remove_elements_desc'] = 'ElementHelper erlauben, Elemente aus dem Manager zu entfernen, sobald die statischen Quelldateien gelöscht werden (das Aktivieren dieser Option wird auch Template Variablen entfernen, die nicht (mehr) im JSON File aufgeführt sind).';

$_lang['setting_elementhelper.auto_create_elements'] = 'Elemente automatisch erstellen';
$_lang['setting_elementhelper.auto_create_elements_desc'] = 'ElementHelper erlauben, statische Elemente/Dateien von schon in der Datenbank bestehenden Elementen zu erstellen, sofern im physischen Pfad des Elementtyps noch keine entsprechende Datei vorhanden ist. Funktioniert im Moment nur für Chunks, Snippets, Plugins und Templates.';

$_lang['setting_elementhelper.auto_create_elements_categories'] = 'Kategorien für zu erstellende Elemente';
$_lang['setting_elementhelper.auto_create_elements_categories_desc'] = 'Kommaseparierte Liste von Kategorien, für die ElementHelper statische Dateien erstellen soll. Standardmässig (wenn "Elemente automatisch erstellen" aktiviert ist) erstelle ElementHelper statische Datien nur für Elemente, die KEINER Kategorie zugewiesen sind. Werden Kategorien festgelegt und auch für Elemente ohne Kategorie sollen statische Dateien erstellt werden, dann muss der erste Listeneintrag leer sein, also z.B. " ,FormIt,Articles". Standard ist "keine Kategorie".';

$_lang['setting_elementhelper.element_history'] = 'Elemente History';
$_lang['setting_elementhelper.element_history_desc'] = "Eine Liste von Elementen die mit ElementHelper angelegt wurden. Sollte nie editiert werden müssen.";

$_lang['setting_elementhelper.source'] = 'Medienquelle für Elemente';
$_lang['setting_elementhelper.source_desc'] = 'Zeigt standardmässig auf die Medienquelle mit der ID 1, auf korrekte Medienquelle ändern, falls eine andere für statische Elemente verwendet wird.';

$_lang['setting_elementhelper.description_key'] = 'Description Identifikations-String';
$_lang['setting_elementhelper.description_key_desc'] = 'String um Elementbeschreibung im ersten Kommentarblock eines Elements zu identifizieren. Standard ist @Description';

$_lang['setting_elementhelper.description_default'] = 'Standardbeschreibung';
$_lang['setting_elementhelper.description_default_desc'] = 'String der standardmässig als Elementbeschreibung eingefügt wird, wenn im Code keine definiert ist.';

$_lang['setting_elementhelper.usergroups'] = 'Benutzergruppen';
$_lang['setting_elementhelper.usergroups_desc'] = 'Kommagetrennte Liste von Benutzergruppen in denen ElementHelper aktiv sein soll bzw. welche die Dateien in den Zielordnern ändern können. Normalerweise reicht hier die Administratoren Gruppe.';

$_lang['setting_elementhelper.debug'] = 'Debugging';
$_lang['setting_elementhelper.debug_desc'] = 'Ist Debugging aktiviert, so schreibt ElementHelper hilfreiche Informationen für die Fehlersuche ins MODx Fehlerprotokoll.';