<?php
namespace EJM;

/**
 * Class MainMapper
 */
class MainMapper
{
    /**
     * @var array
     */
    protected $mapData   = [];
    /**
     * @var array
     */
    protected $arrayData = [];

    /**
     * MainMapper constructor.
     */
    public function __construct($arrayData)
    {
        $class = get_class($this);
        if (is_array($arrayData))
        {
            $this->arrayData = $arrayData;
        }
        $this->mapData   = $class::MAP;
        $this->init();
    }

    protected function init(){

        foreach ($this->mapData as $key => $value){
            $set     = 'set'.self::buildStringKey($key);
            $hasKey  = array_key_exists($key,$this->arrayData);


            if (!$hasKey){
                $this->$set(($this->isArrayClass($value)) ? [] : null);
                continue;
            }

            if ($this->propertyIsCorrect($value)){
                $this->$set($this->arrayData[$key]);
                continue;
            }

            if ($this->isArrayClass($value) && $this->isClass($this->getSafeClassName($value))){
                $arrayDataBuilder = [];
                foreach ($this->arrayData[$key] as $itemKey => $itemValue){
                    $class = $this->getSafeClassName($value);
                    $arrayDataBuilder[] = new $class($itemValue);
                }
                $this->$set($arrayDataBuilder);
                continue;
            }

            if ($this->isArrayClass($value)){
                $this->$set([]);
            }

            if ($this->isClass($value)){
                $this->$set(new $value($this->arrayData[$key]));
                continue;
            }


            $this->$set('');

        }

    }


    /**
     * @param $property
     * @return bool
     */
    protected function propertyIsCorrect($property): bool
    {
        return in_array($property, Property::PROPERTIES, true);
    }

    /**
     * @param $className
     * @return false|int
     */
    protected function isArrayClass($className)
    {
        return strpos($className, '[]');
    }

    /**
     * @param $className
     * @return string
     */
    protected function getSafeClassName($className): string
    {
        if ($this->isArrayClass($className)) {
            return trim($className, '[]');
        }
        return $className;
    }

    /**
     * @param $className
     * @return bool
     */
    protected function isClass($className): bool
    {
        return class_exists($className);
    }

    /**
     * @param $key
     * @return string
     */
    public static function buildStringKey($key): string
    {
        if (strpos($key, '_')) {
            $myMap = array_map(static function ($item) {
                return ucfirst(strtolower($item));
            }, explode('_', $key));
            return implode('', $myMap);
        }
        return ucfirst(strtolower($key));
    }

    /**
     * @param $name
     * @param $arguments
     * @return |null
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/^get(.+)/', $name, $matches)) {
            $var_name = $matches[1];
            return $this->$var_name;
        }
        //do a set
        if (preg_match('/^set(.+)/', $name, $matches)) {
            $var_name = $matches[1];

            $this->$var_name = $arguments[0];
        }

        if (preg_match('/^has(.+)/',$name,$matches)){
            $var_name = $matches[1];

            return isset($this->$var_name);
        }

        return null;
    }

    /**
     * @param $name
     * @return |null
     */
    public function __get($name)
    {
        return $this->$name ?? null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @param $name
     */
    public function __isset($name)
    {
        $this->$name = null;
    }

    /**
     * @param $name
     * @return null
     */
    public function __unset($name)
    {
        return null;
    }

    public function asJson()
    {
        return json_encode($this->arrayData);
    }

    public function asArray()
    {
        return $this->arrayData;
    }

}
