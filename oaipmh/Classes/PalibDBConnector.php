<?php
namespace OCC\OAI2;

class PalibDBConnector implements IDBConnector{
	
	public $db_name = "palib";
	public $table_name="item";
	public $mysqli;

	public function __construct($uri, $username, $password) {		
		$this->mysqli = new \mysqli($uri, $username, $password, $this->db_name);	
		// Check connection
		if($this->mysqli === false){
			die("ERROR: Could not connect. " . $this->mysqli->connect_error);
		}
	}
	
	public function getAllItems() {
		$sql = "SELECT * FROM item ORDER BY datestamp";
		if($result = $this->mysqli->query($sql)){
			if($result->num_rows > 0){
				$palib_items=array();
				while($row = $result->fetch_array()){
					$palibItem = $this->rowToItem($row);
					$palib_items[] = $palibItem;
				}
				$result->free();
				return $palib_items;
			} else{
				echo "No records matching your query were found.";
			}
		} else{
			echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
		}        
    }
	
	public function getItem($id) {
		$sql = "SELECT * FROM item WHERE id = $id";
		if($result = $this->mysqli->query($sql)){
			if($result->num_rows > 0){
				while($row = $result->fetch_array()){
					$palibItem = $this->rowToItem($row);
				}
				$result->free();
				return $palibItem;
			} else{
				echo "No records matching your query were found.";
			}
		} else{
			echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
		}        
    }
	
	private function rowToItem($row){
		$palibItem = new PalibItem($row['id'], $row['datestamp']);
		$palibItem->title = $row['title'];
		$palibItem->creator = $row['creator'];
		$palibItem->subject = $row['subject'];
		$palibItem->description = $row['description'];
		$palibItem->contributors = $row['contributors'];
		$palibItem->type = $row['type'];
		$palibItem->date = $row['date'];
		$palibItem->date_year = $row['date_year'];
		$palibItem->publisher = $row['publisher'];
		$palibItem->format = $row['format'];
		$palibItem->identifier = $row['identifier'];
		$palibItem->source = $row['source'];
		$palibItem->language = $row['language'];
		$palibItem->relation = $row['relation'];
		$palibItem->coverage = $row['coverage'];
		$palibItem->rights = $row['rights'];
		$palibItem->supervisor = $row['supervisor'];
		$palibItem->isPartof = $row['isPartof'];
		$palibItem->isPartofSeries = $row['isPartofSeries'];
		$palibItem->keywords = $row['keywords'];
		$palibItem->doi = $row['doi'];
		return 	$palibItem;
	}
	
}

 

 
// Attempt select query execution
 
// Close connection
//$mysqli->close();
?>