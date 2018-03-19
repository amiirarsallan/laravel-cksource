/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	//Custom Fonts
	config.contentsCss = '/vendor/amiirarsallan/laravel-cksource/src/assets/ckeditor/fonts.css';
	config.font_names = 'Poppins/Poppins;Raleway/Raleway;Roboto/Roboto;Source Sans Pro/Source Sans Pro;Titillium Web/Titillium+Web;SegoeUI/SegoeUI;Calibri/Calibri;نازنین/Nazanin;ایران سانس/IranSans;یکان/Yekan;' + config.font_names;

	//CK Finder Set-up
	// config.filebrowserBrowseUrl= '/ckfinder/ckfinder.html',
	// config.filebrowserImageBrowseUrl= '/ckfinder/ckfinder.html?type=Images',
	// config.filebrowserFlashBrowseUrl= '/ckfinder/ckfinder.html?type=Flash',
	// config.filebrowserUploadUrl= '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	// config.filebrowserImageUploadUrl= '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	// config.filebrowserFlashUploadUrl= '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

};
