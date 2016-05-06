<?php

abstract class abstractDynamicClass
{
	private  $methods = array();

	function __call($n,$p)
	{
		if(strpos($n,'get')===0)
		{
			$key =strtolower( str_replace('get','',$n));
			if(property_exists($this,$key))
				return $this->$key;
			else
				return null;
		}
		else if (strpos($n,'set')===0)
		{
			$key =strtolower( str_replace('set','',$n));
			return $this->$key=array_shift($p);
		}
		else
		{
			return call_user_func_array($this->methods[$n],$p);
		}
	}

	public function addFunc($n,$m)
	{
		$this->methods[$n] = Closure::bind($m,$this);
	}
	
	public function addGate($n,$m,$p)
	{
		$this->methods[$n] =  Closure::bind(function ()
                			use($m,$p)
        				{
               					return call_user_func_array($m,$p);
        				},null);
	}
	
	public static function map(array $array)
	{
		$clsName = get_called_class();
		$obj = new $clsName();
		array_walk($array,function ($item,$key) use ($obj){
			if(is_callable($item))
			{
				$obj->addFunc($key,$item);		
			}
			else
			{
				$obj->$key = $item;
			}
		});
		return $obj;
	}
}


class Request extends abstractDynamicClass
{
	public $id;
	public $name = 'adolph';
}

/* example for use dynamic class */

$cls = Request::map(
[
	'send'=>function (){
		$props = get_object_vars($this);
        	foreach($props as $n => $v){
                	echo $n.'='.$v."\n";
        	}
	},
	'echo'=>function (){
		 $this->send();
	},
	'sex'=>'Famale',
	'id'=>'100'
]);;

echo $cls -> getId()."\n";
$cls->send();
$cls->echo();

$cls->addGate('f',function ($a,$b,$c)
{
	echo $a."-".$b."-".$c;
},array($cls->getId(),2,3));


$cls->f();


