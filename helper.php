<?php
 /**
*
* MyAnniversary tells you about anniversaries of a current day
*
* Copyright (C) 2012-2013 my-j.ru. All rights reserved. 
*
* Author is:
* Denis E Mokhin < denis[at]my-j.ru >
* http://my-j.ru
*
* @license GNU GPL, see http://www.gnu.org/licenses/gpl-2.0.html
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
**/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.utilities.utility' );

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');
$categories = JModelLegacy::getInstance('Categories', 'ContentModel', array('ignore_request' => true));

abstract class modMyAnniversaryHelper
{   
   public static function getList(&$params)
   {
   
		// Get the dbo
		$db = JFactory::getDbo();

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app       = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);

		// Access filter
		$access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		$user		= JFactory::getUser();
		$count		= (int) $params->get('count', 5);
		$catid		= trim( $params->get('catid') );		
		
		// Ordering
		$ordering   = (int) $params->get(' ORdering', 0);
		switch ($ordering)
		{
			case 1:
				$ordering		= 'modified DESC, created DESC';
				break;
			case 0:
			default:
				$ordering		= 'created DESC';
				break;
		}
		
		// $currdate = JHtml::date('now','Y-m-d','UTC');
		
		// $date = JHtml::date('now','Y-m-d','UTC'); // returns 2016-03-09
		// $daymonth = JHtml::date('now','-m-d','UTC'); // returns -03-09
		// $currentyear = JHtml::date('now','Y','UTC');
		// $year1 = $currentyear - 1;
		// $year2 = $currentyear - 2;
		// $year3 = $currentyear - 3;
		// $year4 = $currentyear - 4;
		// $year5 = $currentyear - 5;
		// $year6 = $currentyear - 6;
		// $year7 = $currentyear - 7;
		// $year8 = $currentyear - 8;
		// $year9 = $currentyear - 9;
		// $year10 = $currentyear - 10;

		$query = $db->getQuery(true);

		//$query = 'SELECT * FROM `#__content` WHERE catid IN('.$catid.') AND (state = 1 AND created LIKE \'%'.$year1.$daymonth.'%\' OR created LIKE \'%'.$year2.$daymonth.'%\' OR created LIKE \'%'.$year3.$daymonth.'%\' OR created LIKE \'%'.$year4.$daymonth.'%\' OR created LIKE \'%'.$year5.$daymonth.'%\' OR created LIKE \'%'.$year6.$daymonth.'%\' OR created LIKE \'%'.$year7.$daymonth.'%\' OR created LIKE \'%'.$year8.$daymonth.'%\' OR created LIKE \'%'.$year9.$daymonth.'%\' OR created LIKE \'%'.$year10.$daymonth.'%\') AND (publish_down = \'0000-00-00 00:00:00\') ORDER BY '.$ordering.' LIMIT 0 , 10';

		$query = 'SELECT * FROM `#__content` WHERE catid IN('.$catid.') AND (state = 1 AND MONTH(created) = MONTH(CURDATE()) AND DAY(created) = DAY(CURDATE())) ORDER BY '.$ordering.' LIMIT 0 , 10';

		$db->setQuery($query);
		$items = $db->loadObjectList();					

		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid;

			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}						
		}

		return $items;
	}
}
?>