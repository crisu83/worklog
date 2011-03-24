<?php

Yii::import('zii.widgets.jui.CJuiInputWidget');
class JuiSelectMenu extends CJuiInputWidget
{
	public $assetUrl;
	public $scriptFile='jquery.ui.selectmenu.js';
	public $widgetCssFile='jquery.ui.selectmenu.css';
	public $items=array();
	public $debug=false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->resolvePackagePath();
		$this->resolveAssetUrl();
		$this->registerScripts();
	}
	
	/**
	 * Detemines the asset URL.
	 * This method will also publish the folder if necessary.
	 */
	public function resolveAssetUrl()
	{
		$am=Yii::app()->getAssetManager();
		$assetsPath = Yii::getPathOfAlias('application.extensions.juiselectmenu.assets');
		if($this->debug)
			$this->assetUrl = $am->publish($assetsPath, false, -1, true); // Republish when debugging.
		else
			$this->assetUrl = $am->publish($assetsPath);
	}
	
	/**
	 * Registers the script files.
	 * This method registers jquery and JUI JavaScript files and the CSS file(s).
	 */
	public function registerScripts()
	{
		parent::registerCoreScripts();
		$cs=Yii::app()->getClientScript();		
		$cs->registerCoreScript('jquery.ui');
		$cs->registerCssFile($this->assetUrl.'/'.$this->widgetCssFile);
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		list($name,$id)=$this->resolveNameID();
		
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		
		if($this->hasModel())
			echo CHtml::activeDropDownList($this->model,$this->attribute,$this->items,$this->htmlOptions);
		else
			echo CHtml::dropDownList($name,null,$this->items,$this->htmlOptions);
		
		$options=empty($this->options) ? '' : CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').selectmenu($options);");
	}
	
	/**
	 * Registers a JavaScript file under the asset url.
	 * Note that by default, the script file will be rendered at the end of a page to improve page loading speed.
	 * @param string $fileName JavaScript file name
	 * @param integer $position the position of the JavaScript file. Valid values include the following:
	 * <ul>
	 * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
	 * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
	 * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
	 * </ul>
	 */
	protected function registerScriptFile($fileName,$position=CClientScript::POS_END)
	{
		Yii::app()->getClientScript()->registerScriptFile($this->assetUrl.'/'.$fileName,$position);
	}
}
