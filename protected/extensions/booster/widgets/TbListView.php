<?php
/**
 * ## TbListView class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 */

Yii::import('zii.widgets.CListView');

/**
 * Bootstrap Zii list view.
 *
 * @package booster.widgets.grouping
 */
class TbListView extends CListView {
	
	/**
	 * @var string the CSS class name for the pager container. Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';

	/**
	 * @var array the configuration for the pager.
	 * Defaults to <code>array('class'=>'ext.booster.widgets.TbPager')</code>.
	 */
	public $pager = array('class' => 'booster.widgets.TbPager');

	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init() {
		
		parent::init();

        $booster = Booster::getBooster();
		$popover = $booster->popoverSelector;
		$tooltip = $booster->tooltipSelector;

		$afterAjaxUpdate = "js:function() {
			jQuery('.popover').remove();
			jQuery('{$popover}').popover();
			jQuery('.tooltip').remove();
			jQuery('{$tooltip}').tooltip();
		}";

		if (!isset($this->afterAjaxUpdate)) {
			$this->afterAjaxUpdate = $afterAjaxUpdate;
		}
	}
}
