<?php

include "btree.php";

final class btc{
	
	/**
	 * BTree File Location.
	 * Note.  The directory notpublic is assumed to exist, typically parallel to a directory
	 * called publichtml or public, and with the correct permissions on it.  
	 * It's your job to make sure that it does.
	 * @var String
	 */
	public static $treepath = "frbasis001.tree";
	
	/**
	 *  The class instance of the btree which we will use.
	 *  Assumes that the calss btree can be called from this filesystem location.
	 */
	public static $btree = null;
	
	
	public static function init(){
		
		btc::$btree = btree::open(btc::$treepath);

	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $val
	 * 
	 * return the score of a certain key and a certain value
	 */
	public static function ZSCORE($key, $val){
		//ZSCORE($redis_key, $storyID);
		
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $score
	 * @param unknown $val
	 * 
	 * place a score against a certain value for a given key.
	 */
	public static function ZADD($key, $score, $val){
		
		$earr = btc::$btree->get($key);
		
		$earr[$score] = $val;

		btc::$btree->set($key, $earr);
		
		return(sizeof($earr));

	}
	
	public static function SADD($key, $val){
		
		$earr = btc::$btree->get($key);
		
		$earr[] = $val;

		btc::$btree->set($key, $earr);
		
		return(sizeof($earr));

	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $incrval
	 * @param unknown $val
	 * 
	 * increment the score of a certain value by incrval, against a certain key.
	 */
	public static function ZINCRBY($key, $incrval, $val){
		$earr = btc::$btree->get($key);

		$ret = 0;

		if (in_array($val, $earr)){
		    $earr[array_search($val, $earr)] += $incrval;
		    $ret = 1;
		}

		btc::$btree->set($key, $earr);


		return $ret;
		
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $val
	 * 
	 * for a certain key, remove all traces of a given value.
	 */
	public static function ZREM($key, $val){

		$earr = btc::$btree->get($key);

		$ret = 0;

		if (in_array($val, $earr)){
		    unset($earr[array_search($val,$earr)]);
		    $ret = 1;
		}

		btc::$btree->set($key, $earr);


		return $ret;

	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $val
	 * 
	 * for a certain key, remove all traces of a given value.
	 */	
	public static function SREM($key, $val){

		$earr = btc::$btree->get($key);

		$ret = 0;

		if (in_array($val, $earr)){
		    unset($earr[array_search($val,$earr)]);
		    $ret = 1;
		}

		btc::$btree->set($key, $earr);


		return $ret;
	}
	
	/**
	 * 
	 * @param unknown $key
	 *
	 * remove all traces of a given key.
	 */
	public static function ZDEL($key){

		btc::$btree->set($key, null);

	}
	
	/**
	 * 
	 * @param unknown $key
	 * 
	 * Supernumenary (not in Redis)
	 * Return an array of all of the Contents of a certain key.
	 */
	public static function ZGET($key){

		return btc::$btree->get($key);

	}

}


/** 
 * There is probably a better way on initiallising the class,
 * but this accomplishes the task quite well.
 */
btc::init();