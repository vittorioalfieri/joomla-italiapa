<?php
/**
 * @package     Joomla.Plugins
 * @subpackage  System.ItaliaPA
 *
 * @author		Helios Ciancio <info (at) eshiol (dot) it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2017 - 2020 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * Template ItaliaPA is free software. This version may have been modified
 * pursuant to the GNU General Public License, and as distributed it includes
 * or is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;

/**
 * Joomla! ItaliaPA Plugin.
 *
 * @since  3.9.0
 */
class PlgSystemItaliaPA extends JPlugin
{
	/**
	 * Application object.
	 *
	 * @var    JApplicationCms
	 * @since  3.9.0
	 */
	protected $app;

	/**
	 * Database object.
	 *
	 * @var    JDatabaseDriver
	 * @since  3.9.0
	 */
	protected $db;

	/**
	 * Load plugin language file automatically so that it can be used inside component
	 *
	 * @var    boolean
	 * @since  3.9.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe.
	 * @param   array   $config    An optional associative array of configuration settings.
	 *
	 * @since   3.9.0
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Adds additional fields to the Newsflash module
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   3.9.0
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!$form instanceof Form)
		{
			$this->subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		$formName = $form->getName();

		if ($formName == 'com_modules.module')
		{
			// If we are on the save command, no data is passed to $data variable, we need to get it directly from request
			$jformData = $this->app->input->get('jform', array(), 'array');

			if ($jformData && !$data)
			{
				$data = $jformData;
			}

			if (is_array($data))
			{
				$data = (object) $data;
			}
			
			Form::addFormPath(dirname(__FILE__) . '/forms');

			if ($data->module == 'mod_articles_news')
			{
				Form::addFormPath(dirname(__FILE__) . '/forms');
				
				$form->loadFile('carousel', false);
			}
		}
	}
}
