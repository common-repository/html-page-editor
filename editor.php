<?php

// sets the editor object within the database as an option
require( 'init.php' );

// loads all resources (js, css, etc)
require( 'resources.php' );


function wpas_html_editor_config() {
	// get editor object from DB
	$e = get_option( 'wpas_editor' );

	?>

    <!-- editor tools container -->
    <div id="wpas_tools_container" style="display: none">
		<?php
		include( "layout/editorTools.php" );
		?>

    </div>
    <!-- editor toggles -->
    <div id="editorToggles" style="display: none">
		<?php include( "layout/editorToggles.php" ); ?>
    </div>

    <!-- editor visual editor preview -->

    <iframe id="wpas_preview" class="wpas_page_preview" style="padding:0 10px;"></iframe>

    <script>
        // load the files for the theme saved in the db - path
        var newTheme = '<?php echo plugin_dir_url( __FILE__ ) . 'css/themes/'; ?>';

        // replace
        document.getElementById('wpas-editor-theme-css').setAttribute('href', newTheme + '<?php echo $e->theme; ?>.css');

        // variables with paths, current mode and other information
        var wpas_href = window.location.href,
              wpas_pathurl = window.location.pathname,
              wpas_page = (window.location.pathname).split('/').pop().replace('.php', ''),
              wpas_css = (window.location.pathname).split('css'),
              wpas_content = 'content',
              wpas_mode = '<?php echo (string) $e->mode; ?>';

        // if page is theme-editor page, set to css and target 'newcontent'
        if (wpas_page === 'theme-editor.php' && wpas_css >= 2) {
            wpas_content = 'newcontent';
            wpas_mode = 'css';
        }

        // make the admin menu folded by default
        var editor_page_body = document.querySelector('body');

        // check if post type === page
        if (editor_page_body.classList.contains('post-type-page')) {
            var newPost = document.createElement("span");
            newPost.className += 'new-post-button';
            newPost.innerHTML = '<a href="/wp-admin/post-new.php?post_type=page"> <i class="fa fa-plus" aria-hidden="true"> </i>&nbsp;new page</a>';
            var newPostParent = document.getElementById('title').parentNode;
            var newPostButton = document.getElementById('title');
            newPostParent.insertBefore(newPost, newPostButton);
        }

        // initialize our editor and target along with options
        var wpas_editor_element = document.getElementById(wpas_content);
        var wpas_editor = CodeMirror.fromTextArea(wpas_editor_element, {
            lineNumbers: <?php echo $e->lineNumbers; ?>,
            extraKeys: {
                "Ctrl-Q": function (cm) {
                    cm.setOption('foldGutter', !cm.setOption('foldGutter'));
                },
                "Ctrl-S": function (cm) {
                    jQuery('#post').submit();
                }
                ,
                "F11": function (cm) {
                    wpas_html_editor_fs_toggle();
                },
                "Esc": function (cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                },
                "Ctrl-Space": "autocomplete",
                "Alt-F": "findPersistent"
            },
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter", "CodeMirror-lint-markers"]
        });

        jQuery('div.CodeMirror').attr('id', 'wpas-editor');
        var charWidth = wpas_editor.defaultCharWidth(), basePadding = 4;
        wpas_editor.on("renderLine", function (cm, line, elt) {
            var off = CodeMirror.countColumn(line.text, null, cm.getOption("tabSize")) * charWidth;
            elt.style.textIndent = "-" + off + "px";
            elt.style.paddingLeft = (basePadding + off) + "px";
        });
        wpas_editor.refresh();

        // for preview functionality - start
        var delay;

        wpas_editor.on("change", function () {
            clearTimeout(delay);
            delay = setTimeout(wpas_html_editor_updatePreview, 300);
        });

        function wpas_html_editor_updatePreview() {
            var previewFrame = document.getElementById('wpas_preview');
            var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
            preview.open();
            preview.write(wpas_editor.getValue());
            preview.close();
        }

        setTimeout(wpas_html_editor_updatePreview, 300);
        setInterval(wpas_html_editor_updateFSEditor, 300);
        wpas_editor.refresh();
        // preview functionality - end

        // set all extra options for our editor
        window.onload = function () {
            wpas_editor.setOption('keyMap', '<?php echo $e->keyMap; ?>');
            wpas_editor.setOption('styleActiveLine', <?php echo $e->styleActiveLine; ?>);
            wpas_editor.setOption('autoCloseBrackets', <?php echo $e->autoCloseBrackets; ?>);
            wpas_editor.setOption('autoCloseTags', <?php echo $e->autoCloseTags; ?>);
            wpas_editor.setOption('autoFocus', <?php echo $e->autoFocus; ?>);
            wpas_editor.setOption('autohint', <?php echo $e->autohint; ?>);
            wpas_editor.setOption('highlightSelectionMatches', '<?php echo $e->highlightSelectionMatches; ?>');
            wpas_editor.setOption('fullscreen', <?php echo $e->fullscreen; ?>);
            wpas_editor.setOption('hint', <?php echo $e->hint; ?>);
            wpas_editor.setOption('indentUnit', <?php echo $e->indentUnit; ?>);
            wpas_editor.setOption('indentWithTabs', <?php echo $e->indentWithTabs; ?>,);
            wpas_editor.setOption('lineWrapping', <?php echo $e->lineWrapping; ?>);
            wpas_editor.setOption('lineNumbers', <?php echo $e->lineNumbers; ?>);
            wpas_editor.setOption('lint', <?php echo $e->lint; ?>);
            wpas_editor.setOption('matchBrackets', <?php echo $e->matchBrackets; ?>);
            wpas_editor.setOption('matchTags', <?php echo $e->matchTags; ?>);
            wpas_editor.setOption('mode', wpas_mode);
            wpas_editor.setOption('profile', 'xhtml');
            wpas_editor.setOption('theme', '<?php echo $e->theme; ?>');
            wpas_editor.setOption('foldGutter', <?php echo $e->foldGutter; ?>);

            wpas_editor.foldCode(CodeMirror.Pos(0, 10));
            emmetCodeMirror(wpas_editor);

            wpas_editor.refresh();
        };

        // prepare tools container
        var wpas_tools = jQuery('#wpas_tools_container');
        // prepare tools toggle
        var wpas_toggle = jQuery('#wpas_tools_toggle');
        // insert tools container before editor
        var wpas_container = '#' + wpas_content;

        wpas_container = document.getElementById(wpas_content);
        jQuery(wpas_tools).insertBefore(wpas_container);
        jQuery('iframe#wpas_preview').insertBefore('body');

        jQuery(wpas_tools).css({'display': 'unset'});


        // display information for going full-screen under the editor
        var editorToggles = document.getElementById('wp-word-count');

        editorToggles.innerHTML = document.getElementById('editorToggles').innerHTML;


        var post_delete_link = jQuery('a.submitdelete').attr('href');

        function wpas_html_editor_delete_post() {
            jQuery('a.save-post').attr('href', post_delete_link);
        }

        function wpas_html_editor_save_post() {
            jQuery('#post').submit();
        }

        var etToggle = 0;

        function wpas_html_editor_et_toggle() {
            var width = jQuery(window).width();
            var tools_container = jQuery('#wpas-editor-tools');
            if (width <= 425) {
                jQuery('#wpas-editor-tools').fadeToggle();
            }
            else if (etToggle === 0 && width > 425) {
                tools_container.animate({left: '-100%'});
                etToggle = 1;
                jQuery('.CodeMirror').animate({
                    top: '-100px',
                    marginBottom: '-100px'
                });

            } else {
                tools_container.animate({left: '1px'});
                etToggle = 0;
                jQuery('.CodeMirror').animate({
                    top: '0px',
                    marginBottom: '0px',
                    overflow: 'hidden'
                });
                jQuery('#post-status-info').animate({
                    top: '0',
                    position: 'relative'
                });
            }
        }

        var expandToggle = 0;

        function wpas_html_editor_expand_toggle() {
            if (expandToggle === 0) {
                var editor_width = window.innerWidth;
                jQuery('#post-body-content').animate({width: (editor_width - 60) + 'px'});
                expandToggle = 1;
            } else {
                jQuery('#post-body-content').animate({width: '100%'});
                expandToggle = 0;
            }
        }

        // listener for when screen is resized - resized the editor tool as well.
        window.addEventListener('resize', function () {
            jQuery('#post-body-content').animate({width: '100%'});
            expandToggle = 0;
        });
        var soToggle = 0;


        function wpas_html_editor_so_toggle() {
            var screen_meta_links = jQuery('#screen-meta-links');
            soToggle === 0 ? (screen_meta_links.animate({top: '-30px'})) && (soToggle = 1) : (screen_meta_links.animate({top: '0px'})) && (soToggle = 0);

        }

        var psToggle = 0;

        function wpas_html_editor_ps_toggle() {
            var post_sidebar = jQuery('#postbox-container-1');
            psToggle === 0 ? (post_sidebar.animate({top: '-1000px'})) && (psToggle = 1) : (post_sidebar.animate({top: '0px'})) && (psToggle = 0);

        }

        function wpas_html_editor_fs_toggle() {
            jQuery('div#wpadminbar').fadeToggle('fast');
            jQuery('#wpas_preview').fadeToggle('fast').toggleClass('previewFSS');
            jQuery('.CodeMirror').toggleClass('previewFSS');
            jQuery('#wp-word-count').fadeToggle('fast');
            wpas_editor.setOption("fullScreen", !wpas_editor.getOption("fullScreen"));
            jQuery(' <button class="close_preview" onclick="wpas_html_editor_closePreview()">x</button>').insertBefore('#wpas_preview');
        }

        function wpas_html_editor_updateFSEditor() {
            wpas_editor.setOption('lineWrapping', true);
            wpas_editor.refresh();
        }

        var toggle = 1;

        function wpas_html_editor_pl_toggle() {
            var permalink = jQuery('#wp-content-wrap');
            toggle === 0 ? (permalink.animate({marginTop: '45px'})) && (toggle = 1) : (permalink.animate({marginTop: '0px'})) && (toggle = 0);
        }

        function wpas_html_editor_closePreview() {
            wpas_html_editor_fs_toggle();
            jQuery('.close_preview').remove();
        }

        // toggle tools display
        wpas_toggle.on('click', function () {
            jQuery('#wpas-editor-tools').fadeToggle('fast');
        });

        // toggle tools display
        jQuery('#wpas_preview_toggle').on('click', function () {
            jQuery('iframe#wpas_preview').fadeToggle('fast');
        });

        var isCollapsed = 0;
        jQuery('#collapse-menu').on('click', function () {
            isCollapsed === 0 ? (jQuery('div#wpcontent').css({'padding-left': '155px'})) && (isCollapsed = 1) : (jQuery('div#wpcontent').css({'padding-left': '33px'})) && (isCollapsed = 0);
        });

        var fs_tools = '<div id="wpas-visual-editor-tools">' +
            '<a class="editor-tools-toggle btn btn-secondary" onclick="return wpas_html_editor_et_toggle();" style="margin-left: 5px;">Editor Tools</a> ' +
            '</div>';

        // set font size for editor
        jQuery(".CodeMirror *").css('font-family', '<?php echo $e->font; ?>');
        jQuery(".CodeMirror *").css('font-size', '<?php echo $e->fontsize; ?>' + 'px');
        jQuery(".CodeMirror *").css('line-height', '<?php echo $e->lineHeight ?>' + "em");

        // function to set editor options
        function wpas_html_editor_setOption($i) {
            var option_label = String($i.id);
            var option_element = document.getElementById(option_label);
            var element_type = option_element.getAttribute('type');

            var option_to_update = option_element.getAttribute('wpas-option');
            var option_value = option_element.value;

            if (element_type === "checkbox") {
                var check = option_element.checked;
                option_value = Boolean(check);
                wpas_editor.setOption(option_to_update, option_value);
            }

            if (option_to_update === 'theme') {
                var themeSheet = '<?php echo plugin_dir_url( __FILE__ ) . 'css/themes/'; ?>';
                var updateTheme = themeSheet + option_value + '.css';
                document.getElementById('wpas-editor-theme-css').setAttribute('href', updateTheme);
                wpas_editor.setOption(option_to_update, option_value);
            }
            else if (option_to_update === 'font') {
                jQuery(".CodeMirror *").css('font-family', option_value);
            }
            else if (option_to_update === "fontsize") {
                jQuery(".CodeMirror *").css('font-size', option_value + "px");
            }
            else if (option_to_update === "lineHeight") {
                jQuery(".CodeMirror *").css('line-height', option_value + "em");
            }

            console.log('option set successfully');

            var http = new XMLHttpRequest();
            var postdata = 'option=' + option_to_update + '&value=' + option_value;
            http.open("POST", "", true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.send(postdata);

        }

        if (jQuery(window).width() >= 768) {
            var menu_stack = jQuery('#adminmenu').html();

            jQuery('#wp-admin-bar-wp-logo').html('<div class="">' +
                '  <button id="wpas_menu_button" class="btn btn-primary " type="button"  >MENU  +' +
                '  <span class="caret"></span></button>' +
                '  <ul class="wpas_dropdown_menu hidden" >' +
                menu_stack +
                '  </ul>' +
                '</div>');
            jQuery('#adminmenumain').hide();

            jQuery('#wpas_menu_button').on('click', function () {
                jQuery('.wpas_dropdown_menu').toggle();
            });
            jQuery('.wp-has-submenu').on('mouseenter', function (event) {

                jQuery(this).children('ul.wp-submenu').show();
            });

            jQuery('ul.wp-submenu').on('mouseleave', function () {
                jQuery(this).hide();
            });
        }
    </script>
	<?php

	if ( isset( $_POST ) && ! empty( $_POST ) ) {
		if ( isset( $_POST['option'] ) && isset( $_POST['value'] ) ) {
			$option = sanitize_text_field( $_POST['option'] );
			$value  = sanitize_text_field( $_POST['value'] );
			if ( $option === 'theme' ) {
				$ed        = (object) ( get_option( 'wpas_editor' ) );
				$ed->theme = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'font' ) {
				$ed       = (object) ( get_option( 'wpas_editor' ) );
				$ed->font = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'fontsize' ) {
				$ed           = (object) ( get_option( 'wpas_editor' ) );
				$ed->fontsize = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'lineHeight' ) {
				$ed             = (object) ( get_option( 'wpas_editor' ) );
				$ed->lineHeight = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'keyMap' ) {
				$ed         = (object) ( get_option( 'wpas_editor' ) );
				$ed->keyMap = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'indentUnit' ) {
				$ed             = (object) ( get_option( 'wpas_editor' ) );
				$ed->indentUnit = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'lineWrapping' ) {
				$ed               = (object) ( get_option( 'wpas_editor' ) );
				$ed->lineWrapping = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'lineNumbers' ) {
				$ed              = (object) ( get_option( 'wpas_editor' ) );
				$ed->lineNumbers = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'foldGutter' ) {
				$ed             = (object) ( get_option( 'wpas_editor' ) );
				$ed->foldGutter = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'matchBrackets' ) {
				$ed                = (object) ( get_option( 'wpas_editor' ) );
				$ed->matchBrackets = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'matchTags' ) {
				$ed            = (object) ( get_option( 'wpas_editor' ) );
				$ed->matchTags = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'autoCloseTags' ) {
				$ed                = (object) ( get_option( 'wpas_editor' ) );
				$ed->autoCloseTags = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'autoCloseBrackets' ) {
				$ed                    = (object) ( get_option( 'wpas_editor' ) );
				$ed->autoCloseBrackets = $value;
				update_option( 'wpas_editor', (object) $ed );
			} else if ( $option === 'lint' ) {
				$ed       = (object) ( get_option( 'wpas_editor' ) );
				$ed->lint = $value;
				update_option( 'wpas_editor', (object) $ed );
			}
		}
	}

}


add_action( 'admin_footer', 'wpas_html_editor_config' );

?>