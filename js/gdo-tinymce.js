"use strict";
$(function(){
	var pathname = window.location.pathname.replace('/index.php', '');
	tinymce.baseURL = window.location.origin + '/' + pathname + "/GDO/TinyMCE/bower_components/tinymce/"; // trailing slash important

	tinymce.init({
		skin_url: window.location.origin + '/' + pathname + '/GDO/TinyMCE/bower_components/tinymce/skins/lightgray',
		selector: '.gdt-message textarea.wysiwyg',
		plugins: "autosave,link,autoresize,autolink,smileys,code,codesample",
		toolbar: "code undo redo restoredraft |  "+
		"alignleft aligncenter alignright alignjustify | "+
		"formatselect | fontselect | fontsizeselect | link smileys codesample",
	    auto_convert_smileys: true,
	    menubar: false,
	    statusbar: false,
	    relative_urls : true,
	    document_base_url : window.location.origin,
	    setup: function(ed) {
	    	ed.on('change', function(e) { ed.save(); });
	    },
	    smileys: window.TINYMCESMILEYS,
	    autosave_ask_before_unload: true
	});
});
