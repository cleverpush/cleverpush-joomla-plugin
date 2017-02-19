<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * CleverPush plugin class
 *
 * @package     Joomla.plugin
 * @subpackage  System.cleverPush
 */
class plgSystemCleverPush extends JPlugin
{
	function onAfterRender()
	{
		$mainframe = JFactory::getApplication();

		if ($mainframe->isAdmin() || strpos($_SERVER['PHP_SELF'], 'index.php') === false || JRequest::getVar('format', 'html') != 'html'){
			return;
		}

		$cleverpush_id = $this->params->get('cleverpush_id', '');

		if ($cleverpush_id == '')
		{
			return;
		}

		$buffer = JResponse::getBody();

		$javascript ='
		<script>
		(function(c,l,v,r,p,s,h){c[\'CleverPushObject\']=p;c[p]=c[p]||function(){(c[p].q=c[p].q||[]).push(arguments)},c[p].l=1*new Date();s=l.createElement(v),h=l.getElementsByTagName(v)[0];s.async=1;s.src=r;h.parentNode.insertBefore(s,h)})(window,document,\'script\',\'//' . $cleverpush_id . '.cleverpush.com/loader.js\',\'cleverpush\'); cleverpush(\'triggerOptIn\'); cleverpush(\'checkNotificationClick\');
		</script>
		';

		$buffer = JResponse::getBody();
		$buffer = preg_replace ('/<\/head>/', "\n\n" . $javascript . "\n\n</head>", $buffer);
		JResponse::setBody($buffer);

		return true;
	}
}

?>
