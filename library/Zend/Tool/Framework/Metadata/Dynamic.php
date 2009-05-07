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
 * @see Zend_Tool_Framework_Manifest_Metadata
 */
require_once 'Zend/Tool/Framework/Manifest/Metadata.php';

/**
 * @category   Zend
 * @package    Zend_Tool
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Tool_Framework_Metadata_Dynamic extends Zend_Tool_Framework_Metadata_Interface
{
    
    /**
     * @var string
     */
    protected $_type = 'Dynamic';
    
    /**
     * @var array
     */
    protected $_dynamicAttributes = array();
    
    /**
     * __isset()
     * 
     * Check if an attrbute is set
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->_dynamicAttributes[$name]);
    }
    
    /**
     * __unset()
     *
     * @param string $name
     * @return null
     */
    public function __unset($name)
    {
        unset($this->_dynamicAttributes[$name]);
        return;
    }
    
    /**
     * __get() - Get a property via property call $metadata->foo
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists($this, 'get' . $name)) {
            return $this->{'get' . $name}();
        } elseif (array_key_exists($name, $this->_dynamicAttributes)) {
            return ;
        } else {
            require_once 'Zend/Tool/Framework/Registry/Exception.php';
            throw new Zend_Tool_Framework_Registry_Exception('Property ' . $name . ' was not located in this metadata.');
        }
    }
    
    /**
     * __set() - Set a property via the magic set $metadata->foo = 'foo'
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (method_exists($this, 'set' . $name)) {
            $this->{'set' . $name}($value);
            return;
        } else {
            require_once 'Zend/Tool/Framework/Registry/Exception.php';
            throw new Zend_Tool_Framework_Registry_Exception('Property ' . $name . ' was not located in this registry.');            
        }
    }
    
}
