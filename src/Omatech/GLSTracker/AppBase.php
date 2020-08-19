<?php

namespace Omatech\GLSTracker;

class AppBase {

	public $debug_messages = '';
	protected $params = array();
	protected $show_inmediate_debug = false;
	protected $timings = false;
	
	public function getParams() {
		return $this->params;
	}

	public function setParams($params) {
		$this->params = array_merge($params, $this->params);
		foreach ($params as $key => $value) {
			//echo "Parsing $key=$value\n";
			if (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
	}

	public function __construct($conn, $params = array()) {
		$this->setParams($params);
		$ret=$this->setupCache();
	}
	
	
	function setupCache() {
	// set up the type_of_cache (memcache or memcached) and a handler or false if cache is not available
		if ($this->mc != null && $this->type_of_cache != null)
			return true;

		$memcacheAvailable = false;
		if (extension_loaded('Memcached')) {
			$this->debug("Cache extension Memcached\n");
			$type_of_cache = 'memcached';
			try {
				$mc = new \Memcached;
				$mc->setOption(\Memcached::OPT_COMPRESSION, true);
				$memcacheAvailable = $mc->addServer($this->memcache_host, $this->memcache_port);
			} catch (Exception $e) {
				$this->debug("Error connecting ".$e->getMessage."\n");
				return false;
			}
		} elseif (extension_loaded('Memcache')) {
			$this->debug("Cache extension Memcache\n");
			$type_of_cache = 'memcache';
			try {
				$mc = new \Memcache;
				$memcacheAvailable = $mc->connect($this->memcache_host, $this->memcache_port);
			} catch (Exception $e) {
				$this->debug("Error connecting ".$e->getMessage."\n");
				return false;
			}
		} else {
		  $this->debug("Error no cache extension loaded in PHP\n");
			return false;
		}

		if ($memcacheAvailable) {
			$this->mc = $mc;
			$this->type_of_cache = $type_of_cache;
			return true;
		} else {
			return false;
		}
	}
	
	function setCache($memcache_key, $memcache_value, $expiration=null) {
		
		if ($expiration==null)
		{
			$expiration=$this->cache_expiration;
		}
		
		if ($this->type_of_cache == 'memcached') {
			$this->mc->set($memcache_key, $memcache_value, $expiration);
		} else {// memcache standard
			$this->mc->set($memcache_key, $memcache_value, MEMCACHE_COMPRESSED, $expiration);
		}
	}	

	protected function debug($str) {
		$add = '';
		if ($this->debug) {
			if (is_array($str)) {
				$add .= print_r($str, true);
			} else {// cas normal, es un string
				$add .= $str;
			}

			$this->debug_messages .= $add;
			if ($this->show_inmediate_debug)
				echo $add;
		}
	}
	
}
