<?php

// creates our editor object to save our options
function wpas_html_editor_first_run(){
    // check if initial run has been executed before
    if (!get_option('wpas_editor_initial_config')) {
    // set default arguments for editor on first run
	    $e = new stdClass();
	    $e->styleActiveLine = 'true';
	    $e->autoCloseBrackets = 'true';
	    $e->autoCloseTags = 'true';
	    $e->autoFocus = 'true';
	    $e->autohint = 'true';
	    $e->scrollbarStyle = 'overlay';
	    $e->foldGutter = 'true';
	    $e->fullscreen = 'false';
	    $e->hint = 'true';
	    $e->indentUnit = 4;
	    $e->highlightSelectionMatches = "showToken: /\w/, annotateScrollbar: true";
	    $e->extraKeys = '"F11": function (cm) { cm.setOption("fullScreen", !cm.getOption("fullScreen")); }, "Esc": function (cm) { if (cm.getOption("fullScreen"))   cm.setOption("fullScreen", false); }, "Ctrl-Space": "autocomplete", "Alt-F": "findPersistent"';
	    $e->indentWithTabs = 'true';
	    $e->keyMaps = ['sublime' => 'subline', 'vim' => 'vim', 'emacs' => 'emacs'];
	    $e->keyMap = 'sublime';
	    $e->lineNumbers = 'true';
	    $e->lineWrapping = 'true';
	    $e->lint = 'true';
	    $e->matchBrackets = 'true';
	    $e->matchTags = 'true';
	    $e->mode = 'php';
	    $e->profile = "xhtml";
	    $e->gutters = "CodeMirror-linenumbers, CodeMirror-foldgutter, CodeMirror-lint-markers";

	    // editor tools
	    $e->lineHeight = 1;  // update_option('editor_lineHeight', '1');
	    $e->fontsize = 12;
	    $e->font = 'arial';
	    $e->fonts = ['Arial' => 'Arial', 'Arial Black' => 'Arial Black', 'Lucida Sans Unicode' => 'Lucida Sans Unicode', 'Tahoma' => 'Tahoma', 'Trebuchet MS' => 'Trebuchet MS', 'Verdana' => 'Verdana', 'Courier New' => 'Courier New', 'Lucida Console' => 'Lucida Console', 'Georgia' => 'Georgia'];
	    $e->themes =  ['monokai' => 'monokai',  'material' => 'material',  'elegant' => 'elegant',  'base16-light' => 'base16-light',  'lesser-dark' => 'lesser-dark',  'mbo' => 'mbo',  'mdn-like' => 'mdn-like',  'neo' => 'neo',  'railscasts' => 'railscasts',  'ttcn' => 'ttcn'];
	    $e->theme = 'material';

	    // set flag
	    update_option('wpas_editor_initial_config', 'true');

	    // update editor object
	    update_option('wpas_editor', $e);

    }

}
add_action('plugins_loaded', 'wpas_html_editor_first_run');