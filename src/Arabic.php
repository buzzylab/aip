<?php

namespace Buzzylab\Aip;

class Arabic
{

    /**
     * @var string
     */
    private $_modelPath = __DIR__.'/Models';

    /**
     * Init all support services
     *
     * @var array
     */
    private $allSupportClasses = [];


    /**
     * @var string
     */
    private $_inputCharset  = 'utf-8';

    /**
     * @var string
     */
    private $_outputCharset = 'utf-8';

    /**
     * @var array
     */
    private $_lazyLoading   = [];
    
    /**
     * @ignore
     */
    public $myObject;
    
    /**
     * @ignore
     */
    public $myClass;
    
    /**
     * @ignore
     */
    public $myFile;

    /**
     * Arabic constructor.
     */
    public function __construct()
    {
        //Set internal character encoding to UTF-8
        mb_internal_encoding("utf-8");

        $this->loadAllModels();

        // Bind all services as arabic class parameter
        foreach ($this->allSupportClasses as $key => $className){

            // First letter is Capital
            $this->{$key} = new $className();

            // First letter is small
            $this->{strtolower($key)} = new $className();
        }
    }


    /**
     * @param $methodName
     * @param $arguments
     * @return array|mixed
     */                       
    public function __call($methodName, $arguments)
    {
        $className = $this->_lazyLoading[$methodName];

        $object = new $className();

        // Create an instance of the ReflectionMethod class
        $method = new \ReflectionMethod($className, $methodName);

        $newParameters = [];
        $methodParameters = $method->getParameters();


        // Set new parameters
        foreach ($methodParameters as $parameter) {

            // parameter name
            $name  = $parameter->getName();

            // parameter value
            $value = array_shift($arguments);

            if (is_null($value) && $parameter->isDefaultValueAvailable()) {
                $value = $parameter->getDefaultValue();
            }

            // encoding $parameters
            if ($methodName == 'decompress' || ($methodName == 'search' && $name == 'bin') || ($methodName == 'length' && $name == 'bin')) {
                $newParameters[$name] = $value;
            } else {
                $newParameters[$name] = iconv($this->getInputCharset(), 'utf-8', $value);
            }
        }


        // Result of the method
        $result = call_user_func_array([&$object, $methodName], $newParameters);

        // Encode result
        if(!in_array($methodName , ['compress' , 'getPrayTime' , 'str2graph'])){

            if ($methodName == 'tagText') {

                $outputCharset = $this->getOutputCharset();

                foreach ($result as $key => $text) {
                    $value[$key][0] = iconv('utf-8', $outputCharset, $text[0]);
                }

            }else{
                $result = !is_object($result) && !is_array($result) ? iconv('utf-8', $this->getOutputCharset(), $result) : $result;
            }
        }


        // The final method result
        return $result;
    }



    /**
     * Set charset used in class input Arabic strings
     *          
     * @param string $charset Input charset [utf-8|windows-1256|iso-8859-6]
     *      
     * @return TRUE if success, or FALSE if fail
     * @author Khaled Al-Shamaa <khaled@ar-php.org>
     */
    public function setInputCharset($charset)
    {
        $flag = true;
        
        $charset  = strtolower($charset);
        $charsets = ['utf-8', 'windows-1256', 'cp1256', 'iso-8859-6'];
        
        if (in_array($charset, $charsets)) {
            if ($charset == 'windows-1256') {
                $charset = 'cp1256';
            }
            $this->_inputCharset = $charset;
        } else {
            $flag = false;
        }
        
        return $flag;
    }
    
    /**
     * Set charset used in class output Arabic strings
     *          
     * @param string $charset Output charset [utf-8|windows-1256|iso-8859-6]
     *      
     * @return boolean TRUE if success, or FALSE if fail
     * @author Khaled Al-Shamaa <khaled@ar-php.org>
     */
    public function setOutputCharset($charset)
    {
        $flag = true;
        
        $charset  = strtolower($charset);
        $charsets = ['utf-8', 'windows-1256', 'cp1256', 'iso-8859-6'];
        
        if (in_array($charset, $charsets)) {
            if ($charset == 'windows-1256') {
                $charset = 'cp1256';
            }
            $this->_outputCharset = $charset;
        } else {
            $flag = false;
        }
        
        return $flag;
    }

    /**
     * Get the charset used in the input Arabic strings
     *      
     * @return string return current setting for class input Arabic charset
     * @author Khaled Al-Shamaa <khaled@ar-php.org>
     */
    public function getInputCharset()
    {
        if ($this->_inputCharset == 'cp1256') {
            $charset = 'windows-1256';
        } else {
            $charset = $this->_inputCharset;
        }
        
        return $charset;
    }
    
    /**
     * Get the charset used in the output Arabic strings
     *         
     * @return string return current setting for class output Arabic charset
     * @author Khaled Al-Shamaa <khaled@ar-php.org>
     */
    public function getOutputCharset()
    {
        if ($this->_outputCharset == 'cp1256') {
            $charset = 'windows-1256';
        } else {
            $charset = $this->_outputCharset;
        }
        
        return $charset;
    }


    protected function loadAllModels()
    {
        $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->_modelPath));

        foreach ($allFiles as $file) {

            $fileName = $file->getFileName();
            if(!in_array($fileName ,['..','.'])){

                // Init required variables
                $classKey = str_replace('.'.$file->getExtension(),'',$fileName);
                $className = "Buzzylab\\Aip\\Models\\".$classKey;
                $classMethods = get_class_methods($className);

                // Lazy load methods
                foreach ($classMethods as $key => $method){
                    if(!in_array($method,['__construct'] )){
                        $this->_lazyLoading[$method] = $className;
                    }
                }

                // All support classess
                $this->allSupportClasses[$classKey] = $className ;
            }
        }
    }


    /**
     * Garbage collection, release child objects directly
     *
     * @author Khaled Al-Shamaa <khaled@ar-php.org>
     */
    public function __destruct()
    {
        $this->_inputCharset  = null;
        $this->_outputCharset = null;
        $this->myObject      = null;
        $this->myClass       = null;
    }
}