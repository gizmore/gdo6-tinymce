<?php
namespace GDO\TinyMCE;

use GDO\Core\GDO_Module;
use GDO\Core\Module_Core;
use GDO\DB\GDT_Enum;

/**
 * Adds tiny-mce to GDT_Message fields.
 * @author gizmore
 * @version 6.05
 */
final class Module_TinyMCE extends GDO_Module
{
	public $module_priority = 18;

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
			GDT_Enum::make('smiley_set')->enumValues('default', 'gwf4')->initial('default'),
		);
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
		$this->addBowerJavascript("tinymce/plugins/link/plugin$min.js");
		$this->addBowerJavascript("tinymce/plugins/autolink/plugin$min.js");
		$this->addBowerJavascript("tinymce/plugins/autoresize/plugin$min.js");
		$this->addBowerJavascript("tinymce/plugins/preview/plugin$min.js");
		$this->addBowerJavascript("tinymce/themes/modern/theme$min.js");
	
		# Smiley plugin
		$this->addJavascript("3p/Smileys/smileys/plugin$min.js");
	
		# GDO smiley pack
		$this->onIncludeGDOScripts();
	}

	private function onIncludeGDOScripts()
	{
		switch ($this->cfgSmileySet())
		{
			case 'default': $this->addJavascript('js/gdo-default-icons.js'); break;
			case 'gwf4': $this->addJavascript('js/gdo-gwf4-icons.js'); break;
		}
		$this->addJavascript('js/gdo-tinymce.js');
		$this->addCSS('css/gdo6-material-tinymce.css');
	}
	
}
