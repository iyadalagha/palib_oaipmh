<?php

namespace OCC\OAI2;

interface IDBConnector
{
	public function getAllItems();
	public function getItem($id);
}
?>