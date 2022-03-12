<?php

namespace OCC\OAI2;

abstract class AbstractItem{

	var $id;
	var $datestamp;

	public function __construct($id, $datestamp)
    {
        $this->id = $id;
		$this->datestamp = $datestamp;
    }	
	
	public abstract function toDublinCore($uri);
}
?>