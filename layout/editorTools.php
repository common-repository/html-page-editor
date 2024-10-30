<?php
$_e_ = get_option( 'wpas_editor' );
?>

<form id="wpas_editor_tools" action="" method="post">
<div id="wpas-editor-wrapper">
    <div id="wpas-editor-tools" >


        <div class="container-fluid"> 
                <div class="row">

                    <div class="col-md-2 col-sm-6 col-6">
                        <label>Theme<br/>
                            <select id="editor_theme" wpas-option="theme" name="editor_theme"
                                    onchange=" return wpas_html_editor_setOption(this); ">
								<?php
								echo '<option value="' . $_e_->theme . '"  >' . $_e_->theme . '</option>';
								foreach ( $_e_->themes as $theme ) {
									if ( $theme !== $_e_->theme ) {
										echo '<option value="' . $theme . '"  >' . $theme . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6 col-6">
                        <label>Font<br/>
                            <select id="editor_font" wpas-option="font" name="editor_font"
                                    onChange="  return wpas_html_editor_setOption(this); ">
								<?php
								echo '<option value="' . $_e_->font . '"  >' . $_e_->font . '</option>';
								$fonts = $_e_->fonts;
								foreach ( $fonts as $font ) {
									if ( $font !== $_e_->font ) {
										echo '<option value="' . $font . '"  >' . $font . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6 col-6">
                        <label>Font Size<br/>
                            <select id="editor_fontsize" wpas-option="fontsize" name="editor_fontsize" onchange=" return wpas_html_editor_setOption(this); ">
								<?php
								echo '<option value="' . $_e_->fontsize . '"  >' . $_e_->fontsize . 'px</option>';
								for ( $i = 8; $i <= 50; $i += 2 ) {
									if  ($i !== $_e_->fontsize ) {
										echo '<option value="' .  $i . '"  >' .  $i . 'px</option>';
									}
								}
								?>

                            </select>
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6 col-6">
                        <label>Line Height<br/>
                            <select id="editor_lineHeight" wpas-option="lineHeight" name="editor_lineHeight" onchange=" return wpas_html_editor_setOption(this); ">
								<?php
								echo '<option value="' . $_e_->lineHeight . '"  >' . $_e_->lineHeight . '</option>';
								for ( $i = 1; $i <= 4; $i += 0.5 ) {
									if ( $i !== $_e_->lineHeight ) {
										echo '<option value="' .  $i . '"  >' .  $i . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6 col-6">
                        <label>Keymap<br/>
                            <select id="editor_keyMap" wpas-option="keyMap" name="editor_keyMap" onchange=" return wpas_html_editor_setOption(this); ">
								<?php
								$keymaps = $_e_->keyMaps;
								echo '<option value="' . $_e_->keyMap . '"  >' . $_e_->keyMap . '</option>';
								foreach ($keymaps as $keyMap) {
									if ( $_e_->keyMap !== $keyMap ) {
										echo '<option value="' . $keyMap . '"  >' . $keyMap . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6 col-6 ">
                        <label>Indent<br/>
                            <select id="indentUnit" wpas-option="indentUnit" name="indentUnit"
                                    onchange=" return wpas_html_editor_setOption(this); ">
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                            </select>
                        </label>
                    </div>

                    <div class="col-lg-14 col-md-3 col-sm-4 col-4 xsmtop15 xmstop0">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Match Brackets </span>
                                <input id="matchBrackets" name="matchBrackets" type="checkbox" wpas-option="matchBrackets" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->matchBrackets === 'true' || $_e_->matchBrackets === true ) {
										print 'checked';
									} ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-3 col-sm-4 col-4 xsmtop15 xmstop0">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Match Tags</span>
                                <input id="matchTags" name="matchTags" type="checkbox" wpas-option="matchTags" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->matchTags === 'true' || $_e_->matchTags === true ) {
										print 'checked';
									} ?>>
                                <span> </span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-3 col-sm-4 col-4 xsmtop15 xmstop0">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Close Tags</span>
                                <input id="autoCloseTags" name="autoCloseTags" type="checkbox" wpas-option="autoCloseTags"  onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->autoCloseTags === 'true' || $_e_->autoCloseTags === true ) {
										print 'checked';
									} ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-3  col-sm-3 col-3 xsmtop15">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Close Brackets</span>
                                <input id="autoCloseBrackets" name="autoCloseBrackets" wpas-option="autoCloseBrackets" type="checkbox" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->autoCloseBrackets === 'true' || $_e_->autoCloseBrackets === true ) {
										print 'checked';
									} ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-4  col-sm-3 col-3 xsmtop15 mdtop15">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Numbering</span>
                                <input id="lineNumbers" name="lineNumbers" wpas-option="lineNumbers" type="checkbox" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->lineNumbers === 'true' || $_e_->lineNumbers === true ) {
										print 'checked';
									} ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-4  col-sm-3 col-3 xsmtop15 mdtop15">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Folding</span>
                                <input id="foldGutter" name="foldGutter" type="checkbox" wpas-option="foldGutter" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->foldGutter === 'true' || $_e_->foldGutter === true ) { echo 'checked'; } ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-14 col-md-4  col-sm-3 col-3 xsmtop15 mdtop15">
                        <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                            <label>
                                <span>Linting</span>
                                <input id="lint" name="lint" wpas-option="lint" type="checkbox" onchange=" return wpas_html_editor_setOption(this); "
									<?php if ( $_e_->lint === 'true' || $_e_->lint === true ) {
										print 'checked';
									} ?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>
</form>