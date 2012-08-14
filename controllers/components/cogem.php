<?php 
/**
 * Componente que armazena informações de inflexão e retorna em mensagens
 *
 * Compatível com PHP 4 e 5
 *
 * Licenciado pela Creative Commons 3.0
 *
 * @filesource
 * @copyright   Copyright 2011, Pedro Elsner (http://pedroelsner.com/)
 * @author      Pedro Elsner <pedro.elsner@gmail.com>
 * @license     Creative Commons 3.0 (http://creativecommons.org/licenses/by/3.0/br/)
 * @since       v 1.0
 */
 

/**
 * Cogem Component
 * 
 * @use         Object
 * @package     cogem
 * @subpackage  cogem.cogem
 * @link        http://www.github.com/pedroeslner/cogem
 */
class CogemComponent extends Object
{
    
/**
 * Configurações de inflexão
 *
 * @var array
 * @access private
 */
    private $_inflections = array();
    
/**
 * Armazena as mensagens do sistema
 *
 * @var array
 * @access private
 */
    private $_messages = array();
    
    
/**
 * Initialize
 *
 * Executado antes do Controller::beforeFiler()
 *
 * @param object $controller Passa por referencia o Controller
 * @param array $settings
 * @access public
 * @link http://book.cakephp.org/pt/view/996/Criando-Componentes
 */
    function initialize(&$controller, $settings = null)
    {
        $this->controller =& $controller;
        
        
        /**
         * Configura inflections padrões
         */
        $this->_inflections = array(
            'new' => array(
                'singular' => __('novo', true)
            ),
            'view' => array(
                'singular' => __('exibido', true)
            ),
            'add' => array(
                'singular' => __('adicionado', true)
            ),
            'edit' => array(
                'singular' => __('editado', true)
            ),
            'delete' => array(
                'singular' => __('excluído', true)
            ),
            'item' => array(
                'singular' => __('registro', true)
            ),
            'selected' => array(
                'singular' => __('selecionado', true)
            ),
            'finded' => array(
                'singular' => __('encontrado', true)
            ),
            'the' => array(
                'singular' => __('o', true)
            ),
            'a' => array(
                'singular' => __('um', true)
            ),
            'no' => array(
                'singular' => __('nenhum', true)
            )
            
        );
        
        if (isset($settings['inflections']))
        {
            $this->_inflections = array_merge($this->_inflections, $settings['inflections']);
        }
        
        
        /**
         * Configura mensagens padrões
         */
        $this->_messages = array(
            'add' => array(
                'success' => __('{ucfirst{item}} #{id} foi {add}.', true),
                'error'   => __('Não foi possível adicionar {the} {item}.', true)
            ),
            'edit' => array(
                'failure' => __('{ucfirst{item}} não pode ser {edit}.', true),
                'success' => __('{ucfirst{item}} #{id} foi {edit}.', true),
                'error'   => __('Não foi possível editar {the} {item} #{id}.', true)
            ),
            'delete' => array(
                'failure' => __('{ucfirst{item}} não pode ser {delete}.', true),
                'success' => __('{ucfirst{item}} #{id} foi {delete}.', true),
                'error'   => __('Não foi possível excluir {the} {item} #{id}.', true)
            ),
            'view' => array(
                'failure' => __('{ucfirst{item}} não pode ser {view}.', true)
            ),
            'log' => array(
                'add'    => __('{ucfirst{item}} #{id} foi {add}.', true),
                'edit'   => __('{ucfirst{item}} #{id} foi {edit}.', true),
                'delete' => __('{ucfirst{item}} #{id} foi {delete}.', true)
            ),
            'parent' => array(
                'error' => __('<strong>{ucfirst{no}} {parent} foi {finded}.</strong><br />Você precisa cadastrar primeiro {a} {parent}.', true)
            )
        );
        
        if (isset($settings['messages']))
        {
            $this->_inflections = array_merge($this->_inflections, $settings['messages']);
        }
        
    }
    
    
/**
 * Startup
 *
 * Executado depois do Controller::beforeFiler()
 * mas antes de executar a Action solicitada
 *
 * @param object $controller Passa por referencia o Controller
 * @access public
 * @link http://book.cakephp.org/pt/view/996/Criando-Componentes
 */
    function startup(&$controller)
    {
    
    }
    
    
/**
 * Before Render
 *
 * Executado antes do Controller:beforeRender()
 *
 * @param object $controller Passa por referencia o Controller 
 * @access public
 * @link http://book.cakephp.org/pt/view/996/Criando-Componentes
 */
    function beforeRender(&$controller)
    {
        $controller->set('Cogem', $this);
    }
    
    
/**
 * Shutdown
 *
 * Executado depois do Controller:render()
 *
 * @param object $controller Passa por referencia o Controller 
 * @access public
 * @link http://book.cakephp.org/pt/view/996/Criando-Componentes
 */
    function shutdown(&$controller)
    {
    
    }
    
    
/**
 * Before Redirect
 *
 * Executado antes do Controller:redirect()
 *
 * @param object $controller Passa por referencia o Controller
 * @param array $url
 * @param string $status
 * @param boolean $exit
 * @access public
 * @link http://book.cakephp.org/pt/view/996/Criando-Componentes
 */
    function beforeRedirect(&$controller, $url, $status=null, $exit=true)
    {
    
    }
    
    
/**
 * Set Inflections
 *
 * @param string $type
 * @param string $singular
 * @param string $plural
 * @return boolean
 * @access public
 */
    function setInflections($options = array())
    {    
        if ( !(is_array($options)) )
        {
            return false;
        }
        
        
        $this->_inflections = array_merge($this->_inflections, $options);
        return true;
    }
    
    
/**
 * Get Inflection
 *
 * Retorna definição do inflection configurado
 *
 * @param string $type
 * @param string $inflection Pode ser 'singular' ou 'plural'
 * @return string
 * @access public
 */
    function getInflection($type, $inflection = 'singular')
    {
        
        if ( (!($inflection == 'singular')) && (!($inflection == 'plural')) )
        {
            return '';
        }
        
        
        
        if ( !(isset($this->_inflections[$type][$inflection])) )
        {
            if ($inflection == 'plural')
            {
                if (isset($this->_inflections[$type]['singular']))
                {
                    return Inflector::pluralize($this->_inflections[$type]['singular']);
                }
                return '';
            }
            else
            {
                if (isset($this->_inflections[$type]['plural']))
                {
                    return Inflector::singularize($this->_inflections[$type]['plural']);
                }
                return '';
            }
        }
        else
        {
            return $this->_inflections[$type][$inflection];
        }
    }
    
    
/**
 * Get All Inflections
 *
 * Retorna array com todas as inflections cadastradas
 *
 * @param string $inflection Pode ser 'singular' ou 'plural'
 * @return array
 * @access public
 */
    function getAllInflections($inflection = 'singular')
    {
        if ( (!($inflection == 'singular')) && (!($inflection == 'plural')) )
        {
            return array();
        }
        
        
        $result = array();
        
        foreach ($this->_inflections as $key => $value)
        {
            $result += array(
                $key => $this->getInflection($key, $inflection)
            );
        }
        
        return $result;
    }
    
    
/**
 * Get Message
 *
 * Retorna mensagem com valores das inflections
 *
 * @var string $key1
 * @var string $key2
 * @var string $inflection
 * @var integer $id
 * @access public
 */
    function getMessage($key1, $key2, $inflection = 'singular', $id = 0)
    {
        
        if ( !(isset($this->_messages[$key1][$key2])) )
        {
            return '';
        }
        
        
        $message = $this->_messages[$key1][$key2];
        $message = str_replace('{id}', $id, $message);
        
        foreach ($this->getAllInflections($inflection) as $key => $value)
        {
            $message = str_replace('{ucfirst{'.$key.'}}', ucfirst($value), $message);
            $message = str_replace('{'.$key.'}', $value, $message);
        }
        
        return $message;
    }
    
    
/**
 * Write Message
 *
 * Retorna mensagem com valores das inflections
 *
 * @var string $message
 * @var string $inflection
 * @var integer $id
 * @access public
 */
    function writeMessage($message, $inflection = 'singular', $id = 0)
    {
        
        if ( !(isset($message)) )
        {
            return '';
        }
        
        if ( !(is_string($message)) )
        {
            return '';
        }
        
        
        $message = str_replace('{id}', $id, $message);
        
        foreach ($this->getAllInflections($inflection) as $key => $value)
        {
            $message = str_replace('{ucfirst{'.$key.'}}', ucfirst($value), $message);
            $message = str_replace('{'.$key.'}', $value, $message);
        }
        
        return $message;
    }
    
}
