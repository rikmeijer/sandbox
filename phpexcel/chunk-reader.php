<?php
$excelReader = PHPExcel_IOFactory::createReaderForFile($tempPHPBacklog);

class ChunkReader implements PHPExcel_Reader_IReadFilter
{
    private $offset;
    private $limit;
    private $columns;
    
    public function __construct($offset, $limit, array $columns)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->columns = $columns;
    }

    public function readCell($column, $row, $worksheetName = '')
    {
        if ($row < $this->offset) {
            return false;
        } elseif (($row - $this->offset) >= $this->limit) {
            return false;
        }
        
        return in_array($column, $this->columns);
    }
}

//$excelReader->setReadFilter(new  ChunkReader(8, 2, range('C', 'D')));

$excelReader->setReadDataOnly(true);
$excelReader->load($tempPHPBacklog);