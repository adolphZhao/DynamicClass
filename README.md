# DynamicClass
# Code for PHP
# you can create your class by array;
# patch stdClass can not contain dynamic functions.

#example 


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
]);

