<?php


namespace EJM;


class JsonToClass
{
    protected $className;
    protected $classHead = [];
    public function __construct($jsonData,$className)
    {
        $this->className = $className;
        $data = json_decode($jsonData,true);
        $this->initObject($data,$className);
    }


    protected function initObject($data,$className)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($data[$key]) && !is_numeric($key))
            {
                $initVal = !is_array($value) ? $value : '[]';
                $this->classHead[$className][] = "* @method ".MainMapper::buildStringKey($key).' get'.MainMapper::buildStringKey($key)."()"." $key $initVal";
                $this->initObject($data[$key],MainMapper::buildStringKey($key));
            }else if (is_numeric($key))
            {
                $this->initObject($value,$className);
            }else{
                $this->classHead[$className][] = "* @method get".MainMapper::buildStringKey($key)."() $key $value";
            }
        }
    }




    public function createClassBody()
    {
        $this->clearHead();
        $maps = [];
        foreach ($this->classHead as $className => $classValue)
        {
            $constantsMap = '';

            $buildMap = "<?php\n\n";
            $buildMap .= "/**\n";
            foreach ($classValue as $methodInfo)
            {

                $cropMethod = explode(" ",$methodInfo);
                $isClassName = count($cropMethod) === 6;
                $put = ($isClassName) ? $cropMethod[3] : null;
                $buildMap .=  "$cropMethod[0] $cropMethod[1] $cropMethod[2] ". $put."\n";

                if ($isClassName){
                    $constantsMap .= "\t '".$cropMethod['4']."' => '{$cropMethod['2']}',\n";
                }else{
                    $constantsMap .= "\t '".$cropMethod['3']."' => 'string',\n";
                }

            }
            $buildMap .= "*/\n\n";
            $buildMap .= "class $className{\n";
            $buildMap .= "\tconst MAP = \n\t[\n".$constantsMap."\t];\n";
            $buildMap .= "}\n";
            $maps[] = $buildMap;
        }
        return $maps;
    }


    protected function clearHead()
    {
        foreach ($this->classHead as $className => $classValues)
        {
            $flipData = array_unique(array_flip($classValues));
            $fixed    = array_values(array_flip($flipData));
            $this->classHead[$className] = $fixed;
        }

    }


}
