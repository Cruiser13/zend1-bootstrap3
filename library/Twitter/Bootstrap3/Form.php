<?php
/**
 * Twitter Bootstrap v.3 Form for Zend Framework v.1
 * 
 * @category Forms
 * @package Twitter
 * @subpackage Bootstrap3
 * @author Ilya Serdyuk <ilya.serdyuk@youini.org>
 */

/**
 * This is the base abstract form for the Twitter's Bootstrap UI
 * 
 * @category Forms
 * @package Twitter
 * @subpackage Bootstrap3
 */
abstract class Twitter_Bootstrap3_Form extends Zend_Form
{
    /**#@+
     * Disposition type constants
     */
    const DISPOSITION_HORIZONTAL = 'horizontal';
    const DISPOSITION_VERTICAL   = 'vertical';
    const DISPOSITION_INLINE     = 'inline';
    const DISPOSITION_INLINE_LABEL = 'inlinelabel';
    
    /**
     * Disposition type class
     * @var array 
     */
    static public $_dispositionClasses = array(
        self::DISPOSITION_HORIZONTAL => 'form-horizontal',
        self::DISPOSITION_VERTICAL => 'form-vertical',
        self::DISPOSITION_INLINE => 'form-inline',
        self::DISPOSITION_INLINE_LABEL => 'form-inline',
    );
    
    /**
     * Disposition
     * @var integer 
     */
    protected $_disposition;
    
    /**
     * Default class for elements with status successfully
     * @var string 
     */
    protected $_elementsSuccessClass = 'has-success';
    
    /**
     * Default class for elements warning status
     * @var string 
     */
    protected $_elementsWarningClass = 'has-warning';
    
    /**
     * Default class for elements with the status of the error
     * @var string 
     */
    protected $_elementsErrorClass = 'has-error';
    
    /**
     * Should we render state icon in element?
     * @var bool 
     */
    protected $_renderElementsStateIcons = true;
    
    /**
     * Default elements success icon
     * @var string 
     */
    protected $_elementsSuccessIcon = 'glyphicon glyphicon-ok';
    
    /**
     * Default elements warning icon
     * @var string 
     */
    protected $_elementsWarningIcon = 'glyphicon glyphicon-warning-sign';
    
    /**
     * Default elements error icon
     * @var string 
     */
    protected $_elementsErrorIcon = 'glyphicon glyphicon-remove';
    
    /**
     * Default display group class
     * @var string
     */
    protected $_defaultDisplayGroupClass = 'Twitter_Bootstrap3_Form_DisplayGroup';
    
    /**
     * Prefixes is initialized?
     * @var bool 
     */
    protected $_prefixesInitialized = false;
    
    /**
     * Global decorators to apply to all elements types: text, password, dateTime, 
     * dateTimeLocal, date, month, time, week, number, email, url, search, tel and color
     * @var array 
     */
    protected $_simpleElementDecorators;

    /**
     * Global decorators to apply to all elements type file
     * @var array
     */
    protected $_fileElementDecorators;
    
    /**
     * Global decorators to apply to all elements type checkbox
     * @var array 
     */
    protected $_checkboxDecorators;
    
    /**
     * Global decorators to apply to all elements type captcha
     * @var array 
     */
    protected $_captchaDecorators;
    
    /**
     * Global decorators to apply to all elements types: button, submit and reset
     * @var array 
     */
    protected $_buttonsDecorators;
    
    /**
     * Global decorators to apply to all elements type image
     * @var array 
     */
    protected $_imageDecorators;
    
    /**
     * Override the base form constructor
     *
     * @param mixed $options
     */
    public function __construct($options = null)
    {
        $this->_initializePrefixes();
        $this->loadDefaultElementDecorators();
        
        parent::__construct($options);
    }
    
    /**
     * Prefixes initialize of all form elements
     */
    protected function _initializePrefixes()
    {
        if (!$this->_prefixesInitialized) {
            if (null !== $this->getView()) {
                $this->getView()->addHelperPath('Twitter/Bootstrap3/View/Helper', 'Twitter_Bootstrap3_View_Helper');
            }
            
            $this->addPrefixPath('Twitter_Bootstrap3_Form_Element', 'Twitter/Bootstrap3/Form/Element', 'element');
            $this->addElementPrefixPath('Twitter_Bootstrap3_Form_Decorator', 'Twitter/Bootstrap3/Form/Decorator', 'decorator');
            $this->addDisplayGroupPrefixPath('Twitter_Bootstrap3_Form_Decorator', 'Twitter/Bootstrap3/Form/Decorator');
            
            $this->_prefixesInitialized = true;
        }
    }
    
    /**
     * Override the default decorators
     *
     * @return Twitter_Bootstrap3_Form
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                 ->addDecorator('Form');
        }
        
        return $this;
    }
    
    /**
     * Load the default decorators for all elements
     * 
     * @return Twitter_Bootstrap3_Form
     */
    public function loadDefaultElementDecorators()
    {
        $this->_simpleElementDecorators = $this->getDefaultSimpleElementDecorators();
        $this->_captchaDecorators = $this->getDefaultCaptchaDecorators();
        $this->_checkboxDecorators = $this->getDefaultCheckboxDecorators();
        $this->_buttonsDecorators = $this->getDefaultButtonsDecorators();
        $this->_imageDecorators = $this->getDefaultImageDecorators();
        $this->_fileElementDecorators = $this->getDefaultFileElementDecorators();

        return $this;
    }
    
    /**
     * Retrieve all decorators for all simple type elements
     * 
     * @return array
     */
    public function getDefaultSimpleElementDecorators()
    {
        return array(
            array('ViewHelper'),
            array('Addon'),
            array('Feedback_State', array(
                'renderIcon' => $this->_renderElementsStateIcons,
                'successIcon' => $this->_elementsSuccessIcon,
                'warningIcon' => $this->_elementsWarningIcon,
                'errorIcon' => $this->_elementsErrorIcon,
            )),
            array('Errors'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('Label', array(
                'class' => 'control-label',
            )),
            array('Container'),
            array('FieldSize'),
        );
    }
	
    /**
     * Retrieve all decorators for file type elements
     *
     * @return array
     */
    public function getDefaultFileElementDecorators()
    {
        return array(
            array('File'),
            array('Addon'),
            array('Feedback_State', array(
                'renderIcon' => $this->_renderElementsStateIcons,
                'successIcon' => $this->_elementsSuccessIcon,
                'warningIcon' => $this->_elementsWarningIcon,
                'errorIcon' => $this->_elementsErrorIcon,
            )),
            array('Errors'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('Label', array(
                'class' => 'control-label',
            )),
            array('Container'),
            array('FieldSize'),
        );
    }
    
    /**
     * Retrieve all decorators for all captcha elements
     * 
     * @return array
     */
    public function getDefaultCaptchaDecorators()
    {
        return array(
            array('Errors'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('Label', array(
                'class' => 'control-label',
            )),
            array('Container'),
            array('FieldSize'),
        );
    }
    
    /**
     * Retrieve all decorators for all checkbox elements
     * 
     * @return array
     */
    public function getDefaultCheckboxDecorators()
    {
        return array(
            array('ViewHelper'),
            array('CheckboxLabel'),
            array('Errors'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('CheckboxControls'),
            array('Container'),
            array('FieldSize'),
        );
    }
    
    /**
     * Retrieve all decorators for all elements types: button, submit and reset
     * 
     * @return array
     */
    public function getDefaultButtonsDecorators()
    {
        return array(
            array('Tooltip'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('ViewHelper'),
            array('Container'),
            array('FieldSize'),
        );
    }
    
    /**
     * Retrieve all decorators for all elements type image
     * 
     * @return array
     */
    public function getDefaultImageDecorators()
    {
        return array(
            array('Tooltip'),
            array('Description', array(
                'tag' => 'p',
                'class' => 'help-block',
				'escape' => false,
            )),
            array('Image'),
            array('Errors'),
            array('Container'),
            array('FieldSize'),
        );
    }
    
    /**
     * Override the create an element
     * 
     * @param  string            $type
     * @param  string            $name
     * @param  array|Zend_Config $options
     * @return Zend_Form_Element
     */
    public function createElement($type, $name, $options = null)
    {
        if (null !== $options && $options instanceof Zend_Config) {
            $options = $options->toArray();
        }
        
        // Load default decorators
        if ((null === $options) || !is_array($options)) {
            $options = array();
        }
        
        if (!array_key_exists('decorators', $options)) {
            $decorators = $this->getDefaultDecoratorsByElementType($type);
            if (!empty($decorators)) {
                $options['decorators'] = $decorators;
            }
        }
        
        // Elements type use 'form-control' class
        $element_fc = array(
            // all input:
            'text', 'password', 'dateTime', 'dateTimeLocal', 'date', 'month', 
            'time', 'week', 'number', 'email', 'url', 'search', 'tel', 'color',
            // and other:
            'textarea', 'select', 'multiselect',
        );
        if (in_array($type, $element_fc)) {
            if (null === $options) {
                $options = array('class' => 'form-control');
            } elseif (array_key_exists('class', $options)) {
                if (!strstr($options['class'], 'form-control')) {
                    $options['class'] .= ' form-control';
                    $options['class'] = trim($options['class']);
                }
            } else {
                $options['class'] = 'form-control';
            }
        }
        
//        // Button use 'btn' class
//        $btnTypres = array('button', 'submit', 'reset', 'image');
//        if (in_array($type, $btnTypres)) {
//            if (null === $options) {
//                $options = array('class' => 'btn');
//            } elseif (array_key_exists('class', $options)) {
//                if (!strstr($options['class'], 'btn')) {
//                    $options['class'] .= ' btn';
//                    $options['class'] = trim($options['class']);
//                }
//            } else {
//                $options['class'] = 'btn';
//            }
//        }
        
        return parent::createElement($type, $name, $options);
    }

    /**
     * Add a new element
     *
     * $element may be either a string element type, or an object of type
     * Zend_Form_Element. If a string element type is provided, $name must be
     * provided, and $options may be optionally provided for configuring the
     * element.
     *
     * If a Zend_Form_Element is provided, $name may be optionally provided,
     * and any provided $options will be ignored.
     *
     * @param  string|Zend_Form_Element $element
     * @param  string $name
     * @param  array|Zend_Config $options
     * @throws Zend_Form_Exception on invalid element
     * @return Zend_Form
     */
    public function addElement($element, $name = null, $options = null)
    {
        if ($element instanceof Zend_Form_Element) {
            // type string
			$exploderesult = explode('_', $element->getType());
            $type = lcfirst(trim(end($exploderesult)));

            if (null !== $options && $options instanceof Zend_Config) {
                $options = $options->toArray();
            }

            // Load default decorators
            if ((null === $options) || !is_array($options)) {
                $options = array();
				//Class is maybe not properly transfered to this element. We'll add class if it exists here.
				if($element->class){
					$options['class'] = $element->class;
				}
            }

			//Set HTML5 required attribute if this element is required and not excluded
			$types_for_html5_excluded = array('note', 'html', 'multiCheckbox', 'radio');
			if(!in_array($type,$types_for_html5_excluded)){
				if($element->isRequired()){
					$element->setAttrib('required','required');
				}
			}
			
            if (!array_key_exists('decorators', $options)) {
                $decorators = $this->getDefaultDecoratorsByElementType($type);
                if (!empty($decorators)) {
                    $options['decorators'] = $decorators;
                }
            }

            // Elements type use 'form-control' class
            $element_fc = array(
                // all input:
                'text', 'password', 'dateTime', 'dateTimeLocal', 'date', 'month',
                'time', 'week', 'number', 'email', 'url', 'search', 'tel', 'color',
                // and other:
                'textarea', 'select', 'multiselect',
            );
            if (in_array($type, $element_fc)) {
                if (null === $options) {
                    $options = array('class' => 'form-control');
                } elseif (array_key_exists('class', $options)) {
                    if (!strstr($options['class'], 'form-control')) {
                        $options['class'] .= ' form-control';
                        $options['class'] = trim($options['class']);
                    }
                } else {
                    $options['class'] = 'form-control';
                }
            }

            $element->setOptions($options);

        }

        parent::addElement($element, $name, $options);
    }
    
    /**
     * Retrieve a registered decorator for type element
     * 
     * @param  string $type
     * @return array
     */
    public function getDefaultDecoratorsByElementType($type)
    {
        switch ($type) {
            case 'button':
            case 'submit':
            case 'reset':
                if (is_array($this->_buttonsDecorators)) {
                    return $this->_buttonsDecorators;
                }
                break;
            case 'image':
                if (is_array($this->_imageDecorators)) {
                    return $this->_imageDecorators;
                }
                break;
            case 'checkbox':
                if (is_array($this->_checkboxDecorators)) {
                    return $this->_checkboxDecorators;
                }
                break;
            case 'captcha':
                if (is_array($this->_captchaDecorators)) {
                    return $this->_captchaDecorators;
                }
                break;
            case 'text':    case 'password':  case 'dateTime':  case 'dateTimeLocal':
            case 'date':    case 'month':     case 'time':      case 'week':
            case 'number':  case 'email':     case 'url':       case 'search':
            case 'tel':     case 'color':
                if (is_array($this->_simpleElementDecorators)) {
                    return $this->_simpleElementDecorators;
                }
                break;
            case 'file':
                if (is_array($this->_fileElementDecorators)) {
                    return $this->_fileElementDecorators;
                }
                break;
			case 'html':
				return array('ViewHelper');
            case 'note':  case 'static':    case 'select':  case 'multiselect': 
            case 'textarea':  case 'radio':   case 'multiCheckbox':
                if (is_array($this->_simpleElementDecorators)) {
                    $decorators = $this->_simpleElementDecorators;
                    $removeI = null;
                    foreach ($decorators as $i => $decorator) {
                        if (is_string($decorator[0])) {
                            if ($decorator[0] == 'Feedback_State') {
                                $removeI = $i;
                            }
                        } elseif (is_array($decorator[0]) && in_array('Feedback_State', $decorator[0])) {
                            $removeI = $i;
                        }
                    }
                    if (null !== $removeI) {
                        array_splice($decorators, $removeI, 1);
                    }
                    return $decorators;
                }
                break;
            case 'hidden':
            case 'hash':
                return array('ViewHelper');
            default:
                if (is_array($this->_elementDecorators)) {
                    return $this->_elementDecorators;
                }
                break;
        }
        
        return array();
    }
    
    /**
     * Set form disposition
     * 
     * @param  string $disposition
     * @return Twitter_Bootstrap3_Form
     */
    public function setDisposition($disposition)
    {
        if (array_key_exists($disposition, self::$_dispositionClasses)) {
            $this->_disposition = $disposition;
        }
        
        return $this;
    }
    
    /**
     * Get form disposition
     * 
     * @return null|string
     * @throws Twitter_Bootstrap3_Exception
     */
    public function getDisposition()
    {
        if (null !== ($disposition = $this->getAttrib('disposition'))) {
            if (in_array($disposition, self::$_dispositionClasses)) {
                $this->_disposition = $disposition;
                $this->removeAttrib('disposition');
            } else {
                throw new Twitter_Bootstrap3_Exception('Set invalid disposition for form');
            }
        }
        
        return $this->_disposition;
    }
    
    /**
     * Override the render form
     * 
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        if (null !== ($disposition = $this->getDisposition())) {
            $this->addClass(self::$_dispositionClasses[$disposition]);
        }
        
        return parent::render();
    }
    
    /**
     * Override validation form
     * 
     * @param  array $data
     * @return bool
     */
    public function isValid($data)
    {
        $valid = parent::isValid($data);
        
        foreach ($this->getElements() as $key => $element) {
            if (!$element->hasErrors()) {
                $element->setAttrib('success', true);
            }
        }
        
        return $valid;
    }
    
    /**
     * Add a class for form
     * 
     * @param  string $class
     * @return Twitter_Bootstrap3_Form
     */
    public function addClass($class)
    {
        $class = trim(' ' . $this->getAttrib('class') . ' ' . $class);
        $this->setAttrib('class', $class);
        return $this;
    }
}
