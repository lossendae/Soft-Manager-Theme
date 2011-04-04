<?php
/**
 * Ask if we set the new theme as current theme for the manager
 *
 * @package soft
 * @subpackage build
 */
 
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
		
			$modx =& $object->xpdo;
			
			if( isset($options['set_default']) ){
		
				$modx->log(modX::LOG_LEVEL_INFO,'Set the theme as default for the manager...');
				
				/* Set the themme as default */
				$setting = $modx->getObject('modSystemSetting',array(
					'key' => 'manager_theme',
				));
				
				$value = $setting->get('value');
				if($value == 'default'){
					$setting->set('value', 'soft');
					$setting->save();
				}
				
				/* Disable CSS and js compression */
				$settings = array(
					'compress_css',
					'compress_js',
				);
				
				foreach($settings as $key){
					$setting = $modx->getObject('modSystemSetting',array(
						'key' => $key,
					));
					$value = $setting->get('value');
					if($value == 1){
						$setting->set('value', 0);
						$setting->save();
					}
				}					
				unset($settings, $setting, $value);
				
				$modx->log(modX::LOG_LEVEL_INFO,'Refresh your browser to view the Soft theme in action!');
			}		
		break;
		/* Does not work */
		case xPDOTransport::ACTION_UNINSTALL:
		
			$modx =& $object->xpdo;
					
			$setting = $modx->getObject('modSystemSetting',array(
				'key' => 'manager_theme',
			));			
			$value = $setting->get('value');
			if($value == 'soft'){
				$setting->set('value', 'default');
				$setting->save();
			}
			
			/* Re enable CSS compression */
			$settings = array(
				'compress_css',
				'compress_js',
			);
			
			foreach($settings as $key){
				$setting = $modx->getObject('modSystemSetting',array(
					'key' => $key,
				));
				$value = $setting->get('value');
				if($value == 0){
					$setting->set('value', 1);
					$setting->save();
				}
			}					
			unset($settings, $setting, $value);
			
			$modx->log(modX::LOG_LEVEL_INFO,'Refresh your browser to reload the default theme');
		break;
    }
}
return true;
		