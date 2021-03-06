<?php
namespace GDO\TinyMCE;

use GDO\Core\GDO_Module;
use GDO\Core\Module_Core;
use GDO\DB\GDT_Enum;

/**
 * Adds tiny-mce to GDT_Message fields.
 * Offers a configurable smiley set.
 * 
 * @author gizmore
 * @version 6.10
 * @since 6.05
 */
final class Module_TinyMCE extends GDO_Module
{
	public $module_priority = 18;
	
	public function onLoadLanguage() { $this->loadLanguage('lang/tinymce'); }
	
	public function getBlockedModules() { return ['CKEditor']; }

	public function thirdPartyFolders() { return ['/3p/']; }
	
	##############
	### Config ###
	##############
	public function getConfig()
	{
		return [
			GDT_Enum::make('smiley_set')->enumValues('smileys_default', 'smileys_gwf4')->initial('smileys_default'),
		];
	}
	public function cfgSmileySet() { return $this->getConfigVar('smiley_set'); }
	
	##############
	### Assets ###
	##############
	public function onIncludeScripts()
	{
		$min = Module_Core::instance()->cfgMinifyJS() !== 'no' ? '.min' : '';
		
		# TinyMCE
		$this->addBowerJavascript("tinymce/tinymce$min.js");
		$this->addBowerJavascript("tinymce/jquery.tinymce$min.js");
// 		$this->addBowerJavascript("tinymce/plugins/link/plugin$min.js");
// 		$this->addBowerJavascript("tinymce/plugins/autolink/plugin$min.js");
// 		$this->addBowerJavascript("tinymce/plugins/autoresize/plugin$min.js");
// 		$this->addBowerJavascript("tinymce/plugins/preview/plugin$min.js");
// 		$this->addBowerJavascript("tinymce/plugins/codesample/plugin$min.js");
		$this->addBowerJavascript("tinymce/themes/mobile/theme$min.js");
	
		# Smiley plugin
		$this->addJavascript("3p/Smileys/smileys/plugin$min.js");
	
		# GDO smiley pack
		$this->onIncludeGDOScripts();
	}

	private function onIncludeGDOScripts()
	{
		switch ($this->cfgSmileySet())
		{
			case 'smileys_default': $this->addJavascript('js/gdo-default-icons.js'); break;
			case 'smileys_gwf4': $this->addJavascript('js/gdo-gwf4-icons.js'); break;
		}
		$this->addJavascript('js/gdo-tinymce.js');
		$this->addCSS('css/gdo6-material-tinymce.css');
		# Prism code highlight,
		$this->addJavascript('3p/prism/prism.js');
		$this->addCSS('3p/prism/prism.css');

// 		Javascript::addJavascriptInline('console.log(window.Prism);');
	}
	
}
