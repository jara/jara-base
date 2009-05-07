<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Tool
 * @subpackage Framework
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @see Zend_Tool_Project_Provider_Abstract
 */
require_once 'Zend/Tool/Project/Provider/Abstract.php';

/**
 * @see Zend_Tool_Framework_Registry
 */
require_once 'Zend/Tool/Framework/Registry.php';

/**
 * @see Zend_Tool_Project_Provider_View
 */
require_once 'Zend/Tool/Project/Provider/View.php';

/**
 * @see Zend_Tool_Project_Provider_Exception
 */
require_once 'Zend/Tool/Project/Provider/Exception.php';

/**
 * @category   Zend
 * @package    Zend_Tool
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Tool_Project_Provider_Controller extends Zend_Tool_Project_Provider_Abstract
{

    /**
     * createResource will create the controllerFile resource at the appropriate location in the
     * profile.  NOTE: it is your job to execute the create() method on the resource, as well as
     * store the profile when done.
     *
     * @param Zend_Tool_Project_Profile $profile
     * @param string $controllerName
     * @param string $moduleName
     * @return Zend_Tool_Project_Profile_Resource
     */
    public static function createResource(Zend_Tool_Project_Profile $profile, $controllerName, $moduleName = null)
    {
        if (!is_string($controllerName)) {
            throw new Zend_Tool_Project_Provider_Exception('Zend_Tool_Project_Provider_Controller::createResource() expects \"controllerName\" is the name of a controller resource to create.');
        }
        
        $controllersDirectory = self::_getControllersDirectoryResource($profile, $moduleName);
        $newController = $controllersDirectory->createResource('controllerFile', array('controllerName' => $controllerName));

        return $newController;
    }
    
    /**
     * hasResource()
     *
     * @param Zend_Tool_Project_Profile $profile
     * @param string $controllerName
     * @param string $moduleName
     * @return Zend_Tool_Project_Profile_Resource
     */
    public static function hasResource(Zend_Tool_Project_Profile $profile, $controllerName, $moduleName = null)
    {
        if (!is_string($controllerName)) {
            throw new Zend_Tool_Project_Provider_Exception('Zend_Tool_Project_Provider_Controller::createResource() expects \"controllerName\" is the name of a controller resource to create.');
        }
        
        $controllersDirectory = self::_getControllersDirectoryResource($profile, $moduleName);
        return (($controllersDirectory->search(array('controllerFile' => array('controllerName' => $controllerName)))) instanceof Zend_Tool_Project_Profile_Resource);
    }
    
    /**
     * _getControllersDirectoryResource()
     *
     * @param Zend_Tool_Project_Profile $profile
     * @param string $moduleName
     * @return Zend_Tool_Project_Profile_Resource
     */
    protected static function _getControllersDirectoryResource(Zend_Tool_Project_Profile $profile, $moduleName = null)
    {
        $profileSearchParams = array();

        if ($moduleName != null && is_string($moduleName)) {
            $profileSearchParams = array('modulesDirectory', 'moduleDirectory' => $moduleName);
        }

        $profileSearchParams[] = 'controllersDirectory';
        
        return $profile->search($profileSearchParams);
    }

    /**
     * Enter description here...
     *
     * @param string $name The name of the controller to create.
     * @param bool $indexActionIncluded Whether or not to create the index action.
     */
    public function create($name, $indexActionIncluded = true)
    {
        $this->_loadProfile(self::NO_PROFILE_THROW_EXCEPTION);
        
        // determine if testing is enabled in the project
        require_once 'Zend/Tool/Project/Provider/Test.php';
        $testingEnabled = Zend_Tool_Project_Provider_Test::isTestingEnabled($this->_loadedProfile);
        
        if (self::hasResource($this->_loadedProfile, $name)) {
            throw new Zend_Tool_Project_Provider_Exception('This project already has a controller named ' . $name);
        }
        
        try {
            $controllerResource = self::createResource($this->_loadedProfile, $name);
            if ($indexActionIncluded) {
                $indexActionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'index', $name);
                $indexActionViewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile, $name, 'index');
            }
            if ($testingEnabled) {
                $testControllerResource = Zend_Tool_Project_Provider_Test::createApplicationResource($this->_loadedProfile, $name, 'index');
            }
            
        } catch (Exception $e) {
            $response = $this->_registry->getResponse();
            $response->setException($e);
            return;
        }

        // do the creation
        if ($this->_registry->getRequest()->isPretend()) {
            
            $this->_registry->getResponse()->appendContent('Would create a controller at '  . $controllerResource->getContext()->getPath());
            
            if (isset($indexActionResource)) {
                $this->_registry->getResponse()->appendContent('Would create an index action method in controller ' . $name);
                $this->_registry->getResponse()->appendContent('Would create a view script for the index action method at ' . $indexActionViewResource->getContext()->getPath());
            }
            
            if ($testControllerResource) {
                $this->_registry->getResponse()->appendContent('Would create a controller test file at ' . $testControllerResource->getContext()->getPath());
            }
            
        } else {
            
            $this->_registry->getResponse()->appendContent('Creating a controller at ' . $controllerResource->getContext()->getPath());
            $controllerResource->create();
            
            if (isset($indexActionResource)) {
                $this->_registry->getResponse()->appendContent('Creating an index action method in controller ' . $name);
                $indexActionResource->create();
                $this->_registry->getResponse()->appendContent('Creating a view script for the index action method at ' . $indexActionViewResource->getContext()->getPath());
                $indexActionViewResource->create();
            }
            
            if ($testControllerResource) {
                $this->_registry->getResponse()->appendContent('Creating a controller test file at ' . $testControllerResource->getContext()->getPath());
                $testControllerResource->create();
            }
            
            $this->_storeProfile();
        }

    }



}
