<?php

	if(!isset($argv[1]) || !isset($argv[2])){
		echo("ERROR. Velocity and String both required");
		echo( chr(13) . chr(10) );
		die;
	}
	

	$a = new Animation();
	$a->animate( $argv[1] , $argv[2] );
	
	
	class Animation{
		
		protected $width;
		protected $speed;
		protected $counter;
		
		
		public function animate($speed, $init){
			
			$this->counter = 0;
			$this->width = strlen($init)-1; //determine the width of the chamber
			$this->speed = $speed;
			//turn the string $init into an arrays, 
			//i.e:
			//"..R...."
			//will become:
			//arr String [ '.' , '.' , 'R' , '.' , '.' , '.' , '.'  ]
			
			$arrParticles = array();
			
			for( $i = 0; $i <= $this->width; $i++ ) {
			    $char = substr( $init, $i, 1 );
			    array_push( $arrParticles , $char );
			} 
			
			
			//make a 2 working copies of the array!
			//one to move 'left', one to move 'right'
			$arrCopyR = $arrParticles;
			$arrCopyL = $arrParticles;
			
			for($i = 0; $i <= $this->width; $i++){
				//cleanse the working copies such that
				//arrCopyR only contains 'R' or '.', and
				//arrCopyL contains only 'L' or '.'
				
				//note, we could include another block, say, of
				//static particles 'O' here.
				
				//we can use this method because the particles 'pass through' each other
				//without imparting momentum to each other.  Real neutrons do not do this ;)
				if($arrCopyR[$i]=='L'){
					$arrCopyR[$i]=".";
				}
				if($arrCopyL[$i]=='R'){
					$arrCopyL[$i]=".";
				}
			}
			

			$this->printRoutine($arrCopyL , $arrCopyR);
			for($i = 0; $i <= $this->width; $i++){
				$x=0;
				$y=0;
				
				//the actual animation algorithm.  Because we now have two
				//arrays sorted into 'left-motion' and 'right-motion', we
				// can use unshift/pop and puch/shift to 'move' the arrays
				// L-R and R-L.
				//NOTE.  It is not recommended to try making an actual
				//graphical animation routine this way ;)
				for($j = 0; $j < $this->speed; $j++){
					array_pop($arrCopyR);
					array_unshift($arrCopyR, ".");
					
					array_shift($arrCopyL);
					array_push($arrCopyL, ".");
					//it would be interesting to modify the model to simulate
					//Quantum Cavitation (where the particles bounce off the walls
					//of the chamber) or a Wormhole (where the particles exit from 
					//the left, and re-enter from the right.
					
				}
				
				$this->printRoutine($arrCopyL,$arrCopyR );
				usleep(50000);
			}
		}
	

	
		public function printRoutine($arrCopyL , $arrCopyR){
			
			//a printing routine.  Handles possible conflicts between
			//the two arrays.  Terminates the program when the exit condition is reached.
			
			$this->counter++;
			$curchardotcount=0;
			
			$notDot = 0; //an exit condition.  When a 'line' contains only '.', we terminate.
			for($i = 0; $i <= $this->width; $i++){
				
				if ( $arrCopyL[$i] == '.' && $arrCopyR[$i]=='.' ){
					echo( "." );
				}elseif( $arrCopyL[$i] == 'L' && $arrCopyR[$i]=='.' ){
					echo( "L" );//for debug and demo.  Printing "L"
					$notDot++;
				}elseif( $arrCopyL[$i] == '.' && $arrCopyR[$i]=='R' ){
					echo( "R" );//for debug and demo.  Printing "R"
					$notDot++;
				}elseif( $arrCopyL[$i] == 'L' && $arrCopyR[$i]=='R' ){
					//collision detection!! If a space is occupied by
					//R + L, print an X.
					echo( "X" );
					$notDot++;
				}
			}

			echo( chr(13) . chr(10) );
			
			if($notDot==0){
				//trap the exit condition; exit.
				die;
			}
		}
	
	}


?>