<?php
/*
Plugin Name: Simple Background Sound
Description: This is a simple plugin to add a background sound in your website with wordpress.
Author: Rafael Memmel
Author URI: http://www.rafamemmel.com
Version: 1.0.0
License: GPL2
Text Domain: simple-bg-sound
Domain Path: /languages/
*/

/* Load plugin textdomain. */
load_plugin_textdomain( 'simple-bg-sound', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/* Read the file txt */
function file_sbgs(){
	$fp = fopen( plugins_url( 'sbgs_settings.txt', __FILE__ ),'r');

	if (!$fp) {
		echo __('ERROR: It had not been possible to open the file. Review your name and your permissions.', 'simple-bg-sound');
		exit;
	} 
	else 
	{
		$loop = 0;

		while (!feof($fp)) {
			$loop++;
			$line = fgets($fp);
			$field[$loop] = explode ('|', $line);

			$fmp3 = $field[$loop][0]; //MP3 File
			$fogg = $field[$loop][1]; //OGG File
			$bgplayer = $field[$loop][2]; //Background Color
			$lrplayer = $field[$loop][3]; //Place (left or right)
			$bgsautplay = $field[$loop][4]; //Autoplay
			$bgsloop = $field[$loop][5]; //Loop
			$bgsicoplay = $field[$loop][6]; //Play Icon
			$bgsicopause = $field[$loop][7]; //Pause Icon
			$bgsicostop = $field[$loop][8]; //Stop Icon
			$bgsicovd = $field[$loop][9]; //Volume Down Icon
			$bgsicovu = $field[$loop][10]; //Volume Up Icon
			$playin = $field[$loop][11]; //Play in
			$vol = $field[$loop][12]; //Hide Volume
			$fp++;
		}

		if ( $fmp3 == ''){
			$fmp3 = plugins_url( "bensound-straight.mp3", __FILE__ );
		}

		if ( $fogg == ''){
			$fogg = plugins_url( "bensound-straight.ogg", __FILE__ );
		}

		if ( $bgplayer == ''){
			$bgplayer = '#000';
		}

		if ( $lrplayer == ''){
			$lrplayer = 'left';
		}

		if ( $playin == ''){
			$playin = 'c';
		}

		if ( $vol == ''){
			$vol = 'b';
		}

		if ( $bgsicoplay == ''){
			$bgsicoplay = plugins_url( "images/bgsplay.png", __FILE__ );
		}

		if ( $bgsicopause == ''){
			$bgsicopause = plugins_url( "images/bgspause.png", __FILE__ );
		}

		if ( $bgsicostop == ''){
			$bgsicostop = plugins_url( "images/bgsstop.png", __FILE__ );
		}

		if ( $bgsicovd == ''){
			$bgsicovd = plugins_url( "images/bgsvdown.png", __FILE__ );
		}

		if ( $bgsicovu == ''){
			$bgsicovu = plugins_url( "images/bgsvup.png", __FILE__ );
		}

		fclose($fp);

		return array ($fmp3, $fogg, $bgplayer, $lrplayer, $bgsautplay, $bgsloop, $bgsicoplay, $bgsicopause, $bgsicostop, $bgsicovd, $bgsicovu, $playin, $vol);
	}
}

/* Admin Background Sound */
function simple_bg_sound_plugin_setup_menu(){
    add_menu_page( 'Simple BG Sound Page', 'Simple BG Sound', 'manage_options', 'simple-bg-sound', 'admin_sbgs', 'dashicons-controls-volumeon' );
}
 
function admin_sbgs(){

	echo '<div class="wrap">';

    echo '<h2>Simple Background Sound</h2>';

    echo '<form name="redirectpost" method="post" action="' .plugins_url( "sgbs_save.php", __FILE__ ). '">';

    echo '<p>';
    echo __('Configure here all the MP3 and OGG files for the background sound...', 'simple-bg-sound');
    echo '</p>';

    echo '<h3 class="title">';
    echo __('Audio Files', 'simple-bg-sound');
    echo '</h3>';

    echo '<p>';
    echo __('You can upload the files by using the ', 'simple-bg-sound');
    echo '<a href="' . admin_url( 'media-upload.php?TB_iframe=true&width=700', __FILE__ ) . '" class="thickbox"><strong>'.__('Wordpress Media library', 'simple-bg-sound').'</strong></a>';
    echo __(', copy the url and paste in the following text fields:', 'simple-bg-sound');
    echo '</p>';

    echo '<table class="form-table">
		<tbody><tr>
			<th><label for="fmp3">'.__('MP3 File URL', 'simple-bg-sound').'</label></th>
			<td><input name="fmp3" id="fmp3" type="text" value="' .file_sbgs()[0]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="fogg">'.__('OGG File URL', 'simple-bg-sound').'</label></th>
			<td><input name="fogg" id="fogg" type="text" value="' .file_sbgs()[1]. '" class="regular-text code"></td>
		</tr>
		</tbody></table>';

	mensa_max_size();

	echo '<h3 class="title">';
    echo __('Audio Player Settings', 'simple-bg-sound');
    echo '</h3>';

	echo '<p>';
    echo __('You can also customize the sound player, if you wish.', 'simple-bg-sound');
    echo '</p>';

	echo '<table class="form-table">
		<tbody><tr>
			<th><label for="bgplayer">'.__('Background Color', 'simple-bg-sound').'</label></th>
			<td> <input name="bgplayer" id="bgplayer" type="text" value="' .file_sbgs()[2]. '" class="regular-text code"> <span style="font-size:85%">'.__('Use an hexadecimal code or transparency. Example:', 'simple-bg-sound').' <code>#2C3E50</code> | <code>transparent</code>.</span></td>
		</tr>
		<tr>
			<th><label for="lrplayer">'.__('Place', 'simple-bg-sound').'</label></th>';

			$le = __('Left', 'simple-bg-sound');

			$ra = __('Right', 'simple-bg-sound');

			$lr = file_sbgs()[3];

			if ( $lr == 'left'){
				echo '
				<td>
					<label>
						<input name="lrplayer" type="radio" value="left" checked="checked">
						'.$le.'
					</label>&nbsp;
					<label>
						<input name="lrplayer" type="radio" value="right">
						'.$ra.'
					</label>
				</td>';
			} else {
				echo '
				<td>
					<label>
						<input name="lrplayer" type="radio" value="left">
						'.$le.'
					</label>&nbsp;
					<label>
						<input name="lrplayer" type="radio" value="right" checked="checked">
						'.$ra.'
					</label>
				</td>';
			}
			
		echo '
		</tr>
		<tr>
			<th><label for="bgsautplay">'.__('Autoplay', 'simple-bg-sound').'</label></th>';

			$yebg = __('Yes', 'simple-bg-sound');

			$nobg = __('No', 'simple-bg-sound');

			$ap = file_sbgs()[4];

			if ( $ap == 'autoplay'){
				echo '
			<td>
				<label>
					<input name="bgsautplay" type="radio" value="autoplay" checked="checked">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="bgsautplay" type="radio" value="">
					'.$nobg.'
				</label>
			</td>';
			} else {
				echo '
			<td>
				<label>
					<input name="bgsautplay" type="radio" value="autoplay">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="bgsautplay" type="radio" value="" checked="checked">
					'.$nobg.'
				</label>
			</td>';
			}

		echo '
		</tr>
		<tr>
			<th><label for="bgsloop">'.__('Loop', 'simple-bg-sound').'</label></th>';

			$lp = file_sbgs()[5];

			if ( $lp == 'loop'){
				echo '
			<td>
				<label>
					<input name="bgsloop" type="radio" value="loop" checked="checked">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="bgsloop" type="radio" value="">
					'.$nobg.'
				</label>
			</td>';
			} else {
				echo '
			<td>
				<label>
					<input name="bgsloop" type="radio" value="loop">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="bgsloop" type="radio" value="" checked="checked">
					'.$nobg.'
				</label>
			</td>';
			}

			echo '
		</tr>
		<tr>
			<th><label for="pin">'.__('Play only in', 'simple-bg-sound').'</label></th>';

			$pi = file_sbgs()[11];

			$ph = __('Posts Home', 'simple-bg-sound');

			$sph = __('Static Page Home', 'simple-bg-sound');

			$alw = __('Always Play (Default)', 'simple-bg-sound');

			if ( $pi == 'a'){
				echo '
			<td>
				<label>
					<input type="radio" name="pin" value="a" checked="checked">
					'.$ph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="b">
					'.$sph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="c">
					'.$alw.'
				</label>
			</td>';
			} else if ( $pi == 'b') {
				echo '
			<td>
				<label>
					<input type="radio" name="pin" value="a">
					'.$ph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="b" checked="checked">
					'.$sph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="c">
					'.$alw.'
				</label>
			</td>';
			} else {
				echo '
			<td>
				<label>
					<input type="radio" name="pin" value="a">
					'.$ph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="b">
					'.$sph.'
				</label>&nbsp;
				<label>
					<input type="radio" name="pin" value="c" checked="checked">
					'.$alw.'
				</label>
			</td>';
			}

			echo '
		</tr>
		<tr>
			<th><label for="hi">'.__('Hide Volume Control', 'simple-bg-sound').'</label></th>';

			$vo = file_sbgs()[12];

			if ( $vo == 'a'){
				echo '
			<td>
				<label>
					<input name="hi" type="radio" value="a" checked="checked">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="hi" type="radio" value="b">
					'.$nobg.'
				</label>
			</td>';
			} else {
				echo '
			<td>
				<label>
					<input name="hi" type="radio" value="a">
					'.$yebg.'
				</label>&nbsp;
				<label>
					<input name="hi" type="radio" value="b" checked="checked">
					'.$nobg.'
				</label>
			</td>';
			}

			echo '
		</tr>
		<tr>
			<th><label for="plicon">'.__('Play Icon', 'simple-bg-sound').'</label></th>
			<td><input name="plicon" id="plicon" type="text" value="' .file_sbgs()[6]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="paicon">'.__('Pause Icon', 'simple-bg-sound').'</label></th>
			<td><input name="paicon" id="paicon" type="text" value="' .file_sbgs()[7]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="sticon">'.__('Stop Icon', 'simple-bg-sound').'</label></th>
			<td><input name="sticon" id="sticon" type="text" value="' .file_sbgs()[8]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="vdicon">'.__('Volume Down Icon', 'simple-bg-sound').'</label></th>
			<td><input name="vdicon" id="vdicon" type="text" value="' .file_sbgs()[9]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="vuicon">'.__('Volume Up Icon', 'simple-bg-sound').'</label></th>
			<td><input name="vuicon" id="vuicon" type="text" value="' .file_sbgs()[10]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="vuicon">'.__('Display only in posts home', 'simple-bg-sound').'</label></th>
			<td><input name="vuicon" id="vuicon" type="text" value="' .file_sbgs()[10]. '" class="regular-text code"></td>
		</tr>
		<tr>
			<th><label for="vuicon">'.__('Volume Up Icon', 'simple-bg-sound').'</label></th>
			<td><input name="vuicon" id="vuicon" type="text" value="' .file_sbgs()[10]. '" class="regular-text code"></td>
		</tr>
		</tbody></table>';

	echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__('Save Changes', 'simple-bg-sound').'"></p>';

	echo '</form>';

	echo '<p style="text-align:right"><br>'.__('Powered by:', 'simple-bg-sound').' <a href="http://www.paraguapp.com" target="_blank">Paraguapp</a> | '.__('Default music by:', 'simple-bg-sound').' <a href="http://www.bensound.com" target="_blank">Bensound</a> | <a a href="http://www.rafamemmel.com/donate/" target="_blank">'.__('Donate', 'simple-bg-sound').'</a></p>';

	echo '<p style="text-align:right;">'.__('Share this plugin on Twitter:', 'simple-bg-sound').' &nbsp;<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.paraguapp.com/simple-background-sound" data-text="Simple Background Sound - WordPress Plugin" data-via="rafamem" data-related="rafamem" data-hashtags="wordpress" data-dnt="true">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></p>';

	echo '</div>';

}

add_action('admin_menu', 'simple_bg_sound_plugin_setup_menu');

add_action('admin_init', 'init_popup');
 
function init_popup() {
   add_thickbox();
}

function mensa_max_size() {
	$max_upload = (int)(ini_get('upload_max_filesize'));

	if ( $max_upload < 20) {
		echo '<div class="card">
		    <p>'.__('<strong>Tip:</strong> Your server limits the upload to the size of ', 'simple-bg-sound').$max_upload.__(' MB, if your file is bigger, you could search a plugin to increase the “Upload Max Filesize”. We recommend you that the audio files not exceed the 10 MB.', 'simple-bg-sound').'</p>
		</div>';
	}
}

function simple_bg_sound(){
	echo '<div id="sound-bar" style="background:' . file_sbgs()[2] . ';z-index:999;padding-top:5px;position:fixed;top:100%;'.file_sbgs()[3].':10px;height:36px;margin:0;margin-top:-36px;opacity:0.85;">
			<audio ' . file_sbgs()[5] . ' id="audiobg" preload="auto">
				<source src="' . file_sbgs()[0] . '" type="audio/mpeg">
				<source src="' . file_sbgs()[1] . '" type="audio/ogg">
				<p>Your browser does not support the audio element.</p>
			</audio>
			<a class="playback" href="javascript:void(0);" style="display:inline-block;padding:3px 5px 12px 12px;text-decoration:none;background:transparent">';
			if ( file_sbgs()[4] == 'autoplay' ){
				echo '<span id="control"><img src="' . file_sbgs()[7] . '"></span>';
			} else {
				echo '<span id="control"><img src="' . file_sbgs()[6] . '"></span>';
			}
			echo '
			</a>
			<a class="stopbgs" href="javascript:void(0);" style="display:inline-block;padding:3px 5px 12px 5px;text-decoration:none;background:transparent">
				<span id="control"><img src="' . file_sbgs()[8] . '"></span>
			</a>
			<a class="vdown" href="javascript:void(0);" style="display:inline-block;padding:3px 4px 12px 5px;text-decoration:none;background:transparent" onclick="volumeDown()">
				<span id="control"><img src="' . file_sbgs()[9] . '"></span>
			</a>
			<a class="vup" href="javascript:void(0);" style="display:inline-block;padding:3px 12px 12px 4px;text-decoration:none;background:transparent" onclick="volumeUp()">
				<span id="control"><img src="' . file_sbgs()[10] . '"></span>
			</a>
		</div>';

	echo '
    	<script type="text/javascript">
    		//Preload images
			jQuery.preloadImages = function() {
			for (var i = 0; i < arguments.length; i++) {
				jQuery("<img>").attr("src", arguments[i]);
				}
			}
			jQuery.preloadImages("'.file_sbgs()[7].'","'.file_sbgs()[6].'");

    		jQuery("document").ready(function () {';

				if ( file_sbgs()[4] == 'autoplay' ){
					echo 'jQuery("#audiobg").trigger("play");';
				}

				if ( file_sbgs()[12] == 'a' ){
					//echo file_sbgs()[12];
					echo 'jQuery(".vdown").hide();
						jQuery(".vup").hide();
						jQuery(".stopbgs").css("padding-right","12px");';
				}

				echo '

				//Play - Pause
				jQuery(function() {
					jQuery(".playback").click(function(e) {
						e.preventDefault();
						var song = jQuery("#audiobg").get(0);
						if (song.paused){
							jQuery("#audiobg").trigger("play");
							jQuery( \'#control\' ).replaceWith( \'<span id="control"><img src="' . file_sbgs()[7] . '"></span>\' );
						} else {
							jQuery("#audiobg").trigger("pause");
							jQuery( \'#control\' ).replaceWith( \'<span id="control"><img src="' . file_sbgs()[6] . '"></span>\' );
						}		       	
					});
				});

				//Stop
				jQuery(".stopbgs").click(function(e) {
					e.preventDefault();
					var song = jQuery("#audiobg").get(0);
					if (song.paused){
						//set play time to 0
						jQuery("#audiobg").prop("currentTime",0);
						jQuery( \'#control\' ).replaceWith( \'<span id="control"><img src="' . file_sbgs()[6] . '"></span>\' );
					} else {
						//pause playing
						jQuery("#audiobg").trigger("pause");
						//set play time to 0
						jQuery("#audiobg").prop("currentTime",0);
						jQuery( \'#control\' ).replaceWith( \'<span id="control"><img src="' . file_sbgs()[6] . '"></span>\' );
					}		       	
				});

				//Volume Down
				if(jQuery(".vdown").length) {
					jQuery(".vdown").mousedown(function(e) {
						e.preventDefault();
						var volume = jQuery("#audiobg").prop("volume")-0.2;
					    if(volume <0){
					        volume = 0;
					    }
					    jQuery("#audiobg").prop("volume",volume);		       	
					});
				}

				//Volume Up
				if(jQuery(".vup").length) {
					jQuery(".vup").mousedown(function(e) {
						var volume = jQuery("#audiobg").prop("volume")+0.2;
					    if(volume >1){
					        volume = 1;
					    }
					    jQuery("#audiobg").prop("volume",volume);		       	
					});
				}
			});
		</script>';
}

/* Add Background Sound */
function add_simple_bg_sound(){
	switch ( file_sbgs()[11] ) {
	    case 'a':
	        if( is_home() && !wp_is_mobile() ) {
				echo simple_bg_sound();
			}
	        break;
	    case 'b':
	        if( is_front_page() && !wp_is_mobile() ) {
				echo simple_bg_sound();
			}
	        break;
	    case 'c':
	        if( !wp_is_mobile() ){
				echo simple_bg_sound();
			}
	        break;
	}
}

add_action('wp_footer', 'add_simple_bg_sound');

?>