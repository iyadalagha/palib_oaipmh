<?php

namespace OCC\OAI2;

class PalibItem extends AbstractItem{

	var $id;
	var $title;
    var $creator;
	var $subject;
	var $description;
	var $contributors;
	var $type;
	var $date;
	var $date_year;
	var $publisher;
	var $format;
	var $identifier;
	var $source;
	var $language;
	var $relation;
	var $coverage;
	var $rights;
	var $supervisor;
	var $isPartof;
	var $isPartofSeries;
	var $keywords;
	var $doi;
	var $datestamp;
	
	
	public function toDublinCore($uri){		
		if (substr($uri, -1, 1) == '/') {
            $stylesheet = $uri.'Resources/Stylesheet.xsl';
        } else {
            $stylesheet = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
            $stylesheet .= $_SERVER['HTTP_HOST'].pathinfo(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), PATHINFO_DIRNAME).'/Resources/Stylesheet.xsl';
        }
		
		$doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->appendChild($doc->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="'.$stylesheet.'"'));
        $record_node = $doc->createElement('oai_dc:dc');
        $record_node->setAttribute('xmlns:oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
        $record_node->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        $record_node->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$record_node->setAttribute('xsi:schemaLocation', 'http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd');
		
		foreach ($this as $key => $value) {
			if($key == 'id'){
				$this->addChild($doc, $record_node, "dc:identifier", $value);
			}else{
				$this->addChild($doc, $record_node, "dc:".$key, $value);
			}
			$doc->appendChild($record_node);
		}
		return $doc; 
	}
	
	private function addChild($doc, $mom_node, $name, $value = '') {
        $added_node = $doc->createElement($name, $value);
        $added_node = $mom_node->appendChild($added_node);		
        return $added_node;
    }
}


?>