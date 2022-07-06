<?php
class Plugin{
	public $pluginName;
	public $pluginDB;
	 public function __construct()
    {
		$this->pluginName = basename(dirname(get_class($this)));
		$this->pluginDB = DATA_PLUGINS . $this->pluginName. '.dat.json';        
    }	
	
	public static function isValidHook($hook, $plugin)
	{
		return function_exists($plugin. '_' .$hook);
	}
	
	public static function myHook($hook, $plugin, $param = null)
	{
		$hookFunc = $plugin. '_' .$hook;
		return $hookFunc($param);
	}
	public static function hook($name, $param = null)
	{
		global $plugins;
		$out = '';
		foreach($plugins as $plugin)
		{
		
			if(Plugin::isValidHook($name, $plugin))					
				$out .= Plugin::myHook($name, $plugin, $param);
		}
		return $out;
	}
	
}
?>