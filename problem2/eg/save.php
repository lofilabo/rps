<?php
	include('btc.php');
	btc::ZADD('data:key:001', 1, 
		array( 	array('one-one' , 'one-two' , 'one-three'),
				array('two-one' , 'two-two' , 'two-three'),
				array('three-one' , 'three-two' , 'three-three')
		)
	
	);
?>