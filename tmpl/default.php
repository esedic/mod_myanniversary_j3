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
 
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if(empty($list)) {
	echo JText::_("MOD_MYANNIVERSARY_NOANNIVERSARY");
	} ?>

<ul class="myanniversary<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="myanniversary<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if($item->years==0) { ?>
			<?php echo JText::_("MOD_MYANNIVERSARY_TODAYWECELEBRATE"); ?> <a href="<?php echo $item->link; ?>" class="myanniversary<?php echo $params->get('moduleclass_sfx'); ?>"><?php echo $item->title; ?></a>
		<?php }
		else
		{ ?>
		<?php echo $item->years; ?><?php echo JText::_("MOD_MYANNIVERSARY_OFEVENT"); ?> <a href="<?php echo $item->link; ?>" class="myanniversary<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php echo $item->title; ?></a>
		<?php } ?>
	</li>
<?php endforeach; ?>
</ul>	