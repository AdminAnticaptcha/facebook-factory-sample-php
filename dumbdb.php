<?php

/*
 * Attention!
 * Never use this class in production! Something on your own or use ready database wrappers!
 * This class is for testing purposes only.
 */

class DumpDB {
    
    private $dbfile         =   "";
    private $lineNumber     =   0;
    private $maxRecordId    =   0;
    
    public function setDBFile($file) {
        $this->dbfile       =   $file;
        $this->lineNumber   =   0;
        $this->maxRecordId  =   0;
    }
    
    public function insertOrUpdateRecord($recordId, $data) {
        
        $existingRecord =   $this->getRecordById($recordId);
        if ($existingRecord != false) {
            $rowsData   =   explode("\n", file_get_contents($this->dbfile));
            $rowsData[$this->lineNumber] = $recordId.";;".serialize($data);
            file_put_contents($this->dbfile, implode("\n", $rowsData));
        } else {
            if ($recordId == 0) {
                $insertId   =   $this->maxRecordId+1;
            } else {
                $insertId   =   $recordId;
            }
            file_put_contents($this->dbfile, "$insertId;;".serialize($data)."\n", FILE_APPEND);
        }
        
    }
    
    public function removeRecord($recordId) {
        $existingRecord =   $this->getRecordById($recordId);
        if ($existingRecord != false) {
            $rowsData   =   explode("\n", file_get_contents($this->dbfile));
            unset($rowsData[$this->lineNumber]);
            file_put_contents($this->dbfile, implode("\n", $rowsData));
        }
    }
    
    public function getRecordById($recordId) {
        
        $data   =   explode("\n", file_get_contents($this->dbfile));
        foreach ($data as $this->lineNumber => $row) {
            $rowId  =   (int)substr($row, 0, strpos($row,";;"));
            if ($rowId > $this->maxRecordId) $this->maxRecordId = $rowId;
            if ($rowId === $recordId) {
                return unserialize( substr($row, strpos($row, "$rowId;;") + strlen("$rowId;;")) );
            }
        }
        return false;
        
    }
    
    public function getAllRecords() {
        $data   =   explode("\n", file_get_contents($this->dbfile));
        $result =   array();
        foreach ($data as $row) {
            if (strlen($row) > 1) {
                $rowData        =   unserialize(substr($row, strpos($row, ";;") + 2));
                $rowData["id"]  =   substr($row, 0, strpos($row,";;"));
                $result[] = $rowData;
            }
        }
        return $result;
    }
}