#Dynamic class
# you can create your class by array;
# to patch stdClass can not continue dynamic function

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
]);;
