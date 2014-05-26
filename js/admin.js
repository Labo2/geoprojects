/**
 * GeoProjects Admin Javascript
 *
 * @package GeoProjects
 */


/********************************
 ******** 3RD PARTY LIBS ********
 ********************************/

/**
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null,
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement('div');
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='youtube.com']",
        "iframe[src*='youtube-nocookie.com']",
        "iframe[src*='kickstarter.com'][src*='video.html']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not("object object"); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );



/*************************
 ******** MY CODE ********
 *************************/


 /**
  * Init the Project Infos Metabox
  */
 function gpInitMboxProjectInfos() {
 	var mboxProjectInfos = jQuery( '#mbox_project_infos' );

 	if ( mboxProjectInfos.length > 0 ) {

 		/* Click on "Choose a file" */

		mboxProjectInfos.on( 'click', '.mbox-project-infos-choose-file', function(e){
			e.preventDefault();

			var chooseFileLink = jQuery( this );
			var currentTD = chooseFileLink.parents( 'td' );
			var deleteFileLink = currentTD.find( '.mbox-project-infos-delete-file' );
			var fileField = currentTD.find( 'input[name=gp-file]' );
			var filePreview = currentTD.find( '.mbox-project-infos-file-preview' );
			
			// Create instance of Media Manager Frame
			var fileMediaManagerFrame = wp.media.frames.fileMediaManagerFrame = wp.media();

			fileMediaManagerFrame.on( 'select', function(){

				// Get file attributes
				var fileAttrs = fileMediaManagerFrame.state().get( 'selection' ).first().attributes;

				// Save file ID in the hidden field
				fileField.val( fileAttrs.id );

				// Display link to see file attached
				var linkToFile = jQuery( '<p>' )
									.append(
										jQuery( '<a>' )
											.attr( 'href', fileAttrs.url )
											.attr( 'target', '_blank' )
											.html( fileAttrs.title )
									);

				filePreview.empty().append( linkToFile );

				// Invert Buttons
				chooseFileLink.hide();
				deleteFileLink.show();

			});

			fileMediaManagerFrame.open();

		});

		/* Click on "Delete a file" */

		mboxProjectInfos.on( 'click', '.mbox-project-infos-delete-file', function(e){
			e.preventDefault();

			mboxProjectInfos.find( '.mbox-project-infos-choose-file' ).show();
			jQuery( this ).hide();
			mboxProjectInfos.find( 'input[name=gp-file]' ).val('');
			mboxProjectInfos.find( '.mbox-project-infos-file-preview' ).empty();

		});

	}


 }


/**
 * Init the Map Preview Metabox
 */
function gpInitMboxMapPreview() {
	var mboxMapPreview = jQuery( '#mbox_map_preview' );

	if ( mboxMapPreview.length > 0 ) {
		mboxMapPreview.find( '.gp-leaflet-map' ).gpLeafletMap();
	}

}


/**
 * Init the Marker Infos Metabox
 */
function gpInitMboxMarkerInfos() {
	var mboxMarkerInfos = jQuery( '#mbox_marker_infos' );

	if ( mboxMarkerInfos.length > 0 ) {
		var mboxMarkerIconPreview = jQuery( '.mbox-marker-icon-preview' );
		var mboxMarkerIconsListsWrap = mboxMarkerInfos.find( '.mbox-marker-icons-lists-wrap' );
		var mboxMarkerIconsList = mboxMarkerInfos.find( '.mbox-marker-icons-list' );
		var inputMarkerIconType = mboxMarkerInfos.find( 'input[name=gp-icon-type]' );
		var inputMarkerIconFilename = mboxMarkerInfos.find( 'input[name=gp-icon-filename]' );
		var inputMarkerContentOrder = mboxMarkerInfos.find( 'input[name=gp-popup-content-order]' );
		var mboxMarkerContentList = mboxMarkerInfos.find( '.mbox-marker-content-list' );
		var mboxMarkerContentAddChoice = mboxMarkerInfos.find( '.mbox-marker-content-add-choice' );
		var mboxMarkerContentEditPan = mboxMarkerInfos.find( '.mbox-marker-content-edit-pan' );
		var mboxMarkerContentEditImageWrap = mboxMarkerInfos.find( '.mbox-marker-content-edit-image-wrap' );
		var mboxMarkerContentEditVideoWrap = mboxMarkerInfos.find( '.mbox-marker-content-edit-video-wrap' );
		var mboxMarkerContentEditAudioWrap = mboxMarkerInfos.find( '.mbox-marker-content-edit-audio-wrap' );
		var mboxMarkerMap = mboxMarkerInfos.find( '#mbox-marker-map' );


		/* Init Map */

		mboxMarkerMap.gpLeafletMap();


		/* Click on "Change icon" */

		mboxMarkerInfos.on( 'click', '.mbox-marker-icon-change', function(e){
			e.preventDefault();
			if ( mboxMarkerIconsListsWrap.is( ':visible' ) ) {
				mboxMarkerIconsListsWrap.hide();
			}
			else {
				mboxMarkerIconsListsWrap.show();
			}
		});


		/* Switch between icons list types */

		mboxMarkerInfos.on( 'change', 'input[name=gp-marker-icons-list]:radio', function(e){
			var listTypeRequested = jQuery( '.' + jQuery( this ).attr( 'id' ) );

			if ( !listTypeRequested.is( ':visible' ) ) {
				mboxMarkerIconsListsWrap.find( '.mbox-marker-icons-list' ).hide();
				listTypeRequested.show();

				// Load custom icons if requested
				if ( jQuery( this ).val() == 'custom' ) {

					// If not already in cache
					if ( listTypeRequested.find( 'ul' ).length == 0 ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {action: 'gp-get-markers-icons-list', list_type: 'custom' },
							success: function( resp ){
								listTypeRequested.empty().html( resp );
							},
							dataType: 'html'
						});

					}
					
				}

			}
		});


		/* Click on a marker icon */

		mboxMarkerIconsList.on( 'click', 'a', function(e){
			e.preventDefault();
			var clickedIcon = jQuery( this );
			var clickedIconType = clickedIcon.data( 'icon-type' );
			var clickedIconFilename = clickedIcon.data( 'icon-filename' );
			var iconBaseUrl = ( clickedIconType == 'default' ) ? gpGlobalVars.urlToDefaultMarkersIcons : gpGlobalVars.urlToCustomMarkersIcons;

			// Close icon selection box
			mboxMarkerIconsListsWrap.hide();

			// Store values in hidden inputs
			inputMarkerIconType.val( clickedIconType );
			inputMarkerIconFilename.val( clickedIconFilename );

			// Change selected icon
			mboxMarkerIconPreview.find( 'img' ).attr( 'src', iconBaseUrl + '/' + clickedIconFilename );

			// Update icon on map
			//gpSetDragMarkerIcon( clickedIconType, clickedIconFilename );
			mapConcerned = mboxMarkerMap.data( 'plugin_gpLeafletMap');
			mapConcerned.setDragMarkerIcon( clickedIconType, clickedIconFilename );

		});


		/* Make Content types choosen sortables */
		jQuery( '.content-types-sortable' ).sortable({
			update: function( event, ui ) {
				var contentOrderList = new Array();
				mboxMarkerContentList.find( 'li:visible' ).each(function(){
					contentOrderList.push( jQuery( this ).find( '.mbox-marker-content-edit' ).data( 'content-to-edit' ) );
				});
				inputMarkerContentOrder.val( contentOrderList.join( ',' ) );
			}
		});


		/* Click for adding a Popup content type */

		mboxMarkerContentAddChoice.on( 'click', 'a', function(e){
			e.preventDefault();
			var requestedTypeElt = jQuery( this );
			var requestedType = requestedTypeElt.data( 'content-to-add' );
			var typeToShow = mboxMarkerContentList.find( '.mbox-marker-content-' + requestedType );

			// If requested content type does not exists
			if ( !typeToShow.is( ':visible' ) ) {

				// Hide requested type button
				requestedTypeElt.parent( 'li' ).hide();

				// Unactivate previous type
				mboxMarkerContentList.find( 'li' ).removeClass( 'active' );

				// Show requested type
				mboxMarkerContentList.append( typeToShow.show().addClass( 'active' ) );

				// Show edit pan (and hide others)
				mboxMarkerContentEditPan.hide();
				mboxMarkerInfos.find( '.mbox-marker-content-edit-' + requestedType + '-wrap' ).show();

				// Save content types order
				var contentOrderList = new Array();
				mboxMarkerContentList.find( 'li:visible' ).each(function(){
					contentOrderList.push( jQuery( this ).find( '.mbox-marker-content-edit' ).data( 'content-to-edit' ) );
				});
				inputMarkerContentOrder.val( contentOrderList.join( ',' ) );

			}
		});


		/* Click for editing a Popup content type */

		mboxMarkerContentList.on( 'click', '.mbox-marker-content-edit', function(e){
			e.preventDefault();
			var typeToEditElt = jQuery( this );
			var typeToEdit = typeToEditElt.data( 'content-to-edit' );

			// If not already shown
			if ( !typeToEditElt.parent( 'li' ).hasClass( 'active') ) {

				// Unactivate all types
				mboxMarkerContentList.find( 'li' ).removeClass( 'active' );

				// Activate current type
				typeToEditElt.parent( 'li' ).addClass( 'active' );

				// Show edit pan (and hide others)
				mboxMarkerContentEditPan.hide();
				mboxMarkerInfos.find( '.mbox-marker-content-edit-' + typeToEdit + '-wrap' ).show();

			}

		});


		/* Click for deleting a Popup content type */

		mboxMarkerContentList.on( 'click', '.mbox-marker-content-delete', function(e){
			e.preventDefault();
			var typeToDeleteElt = jQuery( this );
			var typeToDelete = typeToDeleteElt.data( 'content-to-delete' );
			var typeToAdd = mboxMarkerContentAddChoice.find( '.mbox-marker-content-choice-' + typeToDelete );

			// Hide edit pans
			mboxMarkerContentEditPan.hide();

			// Unactivate all types
			mboxMarkerContentList.find( 'li' ).removeClass( 'active' );

			// Hide current type
			typeToDeleteElt.parent( 'li' ).hide();

			// Show type in the add list
			typeToAdd.show();

			// Save content types order
			var contentOrderList = new Array();
			mboxMarkerContentList.find( 'li:visible' ).each(function(){
				contentOrderList.push( jQuery( this ).find( '.mbox-marker-content-edit' ).data( 'content-to-edit' ) );
			});
			inputMarkerContentOrder.val( contentOrderList.join( ',' ) );

		});


		/* Click on "Choose an image" */

		mboxMarkerContentEditImageWrap.on( 'click', '.mbox-marker-content-edit-image-choose', function(e){
			e.preventDefault();

			var chooseImageLink = jQuery( this );
			var deleteImageLink = mboxMarkerContentEditImageWrap.find( '.mbox-marker-content-edit-image-delete' );
			var imageField = mboxMarkerContentEditImageWrap.find( 'input[name=gp-popup-image]' );
			var imagePreview = mboxMarkerContentEditImageWrap.find( '.mbox-marker-content-edit-image-preview' );

			var imageMediaManagerFrame = wp.media.frames.imageMediaManagerFrame = wp.media({
				title: gpGlobalI18n.i18nMediaManagerForImage,
				library: {
					type: 'image'
				},
				button: {
					text: gpGlobalI18n.i18nLinkChooseImage
				}
			});

			imageMediaManagerFrame.on( 'select', function(){

				// Get image ID
				var imageID = imageMediaManagerFrame.state().get( 'selection' ).first().id;

				// Save image ID in the hidden field
				imageField.val( imageID );

				// Display image preview
				jQuery.ajax({
					url: ajaxurl,
					data: { action: 'gp-get-mbox-image-preview', id: imageID },
					success: function( html ) {
						imagePreview.html( html );
						chooseImageLink.hide();
						deleteImageLink.show();
					},
					dataType: 'html'
				});

			});

			imageMediaManagerFrame.open();

		});


		/* Click on "Delete an image" */

		mboxMarkerContentEditImageWrap.on( 'click', '.mbox-marker-content-edit-image-delete', function(e){
			e.preventDefault();

			mboxMarkerContentEditImageWrap.find( '.mbox-marker-content-edit-image-choose' ).show();
			jQuery( this ).hide();
			mboxMarkerContentEditImageWrap.find( 'input[name=gp-popup-image]' ).val('');
			mboxMarkerContentEditImageWrap.find( '.mbox-marker-content-edit-image-preview' ).empty();

		});


		/* Init Fitvids on video preview */

		mboxMarkerContentEditVideoWrap.find( '.mbox-marker-content-edit-video-preview' ).fitVids();


		/* Value change in the URL input of the video */

		mboxMarkerContentEditVideoWrap.on( 'change paste keyup', '#mbox-marker-content-edit-video-url', function(e){
			var curInput = jQuery( this );
			var delay = 500;
			var videoPreview = mboxMarkerContentEditVideoWrap.find( '.mbox-marker-content-edit-video-preview' );

			// Clear TimeOut
			clearTimeout( curInput.data( 'timer' ) );

			// Show Video preview
			videoPreview.show();

			// If input is cleared
			if ( curInput.val() == '' ) {
				curInput.data( 'url', curInput.val() );
				videoPreview.empty().hide();
				mboxMarkerContentEditVideoWrap.find( '.mbox-marker-content-edit-video-delete' ).hide();
				return;
			}

			// Re-set Timer
			curInput.data( 'timer', setTimeout( function() {
				curInput.removeData( 'timer' );

				// If not the same url requested
				if ( curInput.data( 'url' ) != curInput.val() ) {

					// Request video oEmbed
					jQuery.ajax({
						url: ajaxurl,
						data: { action: 'gp-get-video-player', url: curInput.val() },
						success: function( html ) {
							if ( html != '' ) {
								videoPreview.html( html );
								videoPreview.fitVids();
								curInput.data( 'url', curInput.val() );
								mboxMarkerContentEditVideoWrap.find( '.mbox-marker-content-edit-video-delete' ).show();
							}
						},
						dataType: 'html'
					});
				}

			}, delay ));
		});

		// "Enter" key in the video url field
		mboxMarkerContentEditVideoWrap.on( 'keypress', '#mbox-marker-content-edit-video-url', function(e){
			if ( e.keyCode == 13 ) {
				jQuery( this ).trigger( 'change' );
				return false;
			}
		});


		/* Click on "Remove video" */

		mboxMarkerContentEditVideoWrap.on( 'click', '.mbox-marker-content-edit-video-delete', function(e){
			e.preventDefault();

			jQuery( this ).hide();
			mboxMarkerContentEditVideoWrap.find( '.mbox-marker-content-edit-video-preview' ).empty().hide();
			mboxMarkerContentEditVideoWrap.find( '#mbox-marker-content-edit-video-url' ).val('').data( 'url', '' );

		});


		/* Click on "Choose MP3 file" */

		mboxMarkerContentEditAudioWrap.on( 'click', '.mbox-marker-content-edit-audio-choose', function(e){
			e.preventDefault();

			var chooseAudioLink = jQuery( this );
			var deleteAudioLink = mboxMarkerContentEditAudioWrap.find( '.mbox-marker-content-edit-audio-delete' );
			var audioField = mboxMarkerContentEditAudioWrap.find( 'input[name=gp-popup-audio]' );
			var audioPreview = mboxMarkerContentEditAudioWrap.find( '.mbox-marker-content-edit-audio-preview' );

			var audioMediaManagerFrame = wp.media.frames.audioMediaManagerFrame = wp.media({
				title: gpGlobalI18n.i18nMediaManagerForAudio,
				library: {
					type: 'audio/mpeg'
				},
				button: {
					text: gpGlobalI18n.i18nLinkChooseAudio
				}
			});

			audioMediaManagerFrame.on( 'select', function(){

				// Get audio ID
				var audioID = audioMediaManagerFrame.state().get( 'selection' ).first().id;

				// Save audio ID in the hidden field
				audioField.val( audioID );

				// Display audio preview
				jQuery.ajax({
					url: ajaxurl,
					data: { action: 'gp-get-mbox-audio-preview', id: audioID },
					success: function( html ) {
						audioPreview.html( html );
						chooseAudioLink.hide();
						deleteAudioLink.show();

						// Init audio player
						var meSettings = {};

						if ( typeof _wpmejsSettings !== 'undefined' ) {
							meSettings.pluginPath = _wpmejsSettings.pluginPath;
						}

						audioPreview.find( '.wp-audio-shortcode' ).mediaelementplayer( meSettings );
					},
					dataType: 'html'
				});

			});

			audioMediaManagerFrame.open();
			
		});

		
		/* Click on "Delete audio" */

		mboxMarkerContentEditAudioWrap.on( 'click', '.mbox-marker-content-edit-audio-delete', function(e){
			e.preventDefault();

			mboxMarkerContentEditAudioWrap.find( '.mbox-marker-content-edit-audio-choose' ).show();
			jQuery( this ).hide();
			mboxMarkerContentEditAudioWrap.find( 'input[name=gp-popup-audio]' ).val('');
			mboxMarkerContentEditAudioWrap.find( '.mbox-marker-content-edit-audio-preview' ).empty();

		});

	}

}


/**
 * Init the Settings page
 */
function gpInitSettingsPage() {
	var settingsMap = jQuery( '.gp-leaflet-map-container' );

	if ( settingsMap.length > 0 ) {

        // Init Map
		settingsMap.find( '.gp-leaflet-map' ).gpLeafletMap();

        // Init ColorPickers
        var titleColPick = jQuery( '#setting-title-color' ).wpColorPicker();
        var taglineColPick = jQuery( '#setting-tagline-color' ).wpColorPicker();
        var primaryColPick = jQuery( '#setting-primary-color' ).wpColorPicker();
        var secondaryColPick = jQuery( '#setting-secondary-color' ).wpColorPicker();
	}

}


/**
 * DOM ready
 */
jQuery(document).ready(function($) {

	// Init Mbox Project Infos
	gpInitMboxProjectInfos();

	// Init Mbox Map Preview
	gpInitMboxMapPreview();

	// Init Mbox Marker infos
	gpInitMboxMarkerInfos();

	// Init Settings page
	gpInitSettingsPage();

});