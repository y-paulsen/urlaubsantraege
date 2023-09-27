<?php

class className extends JobRouter\Engine\Runtime\PhpFunction\DialogFunction
{
	public function execute($rowId = null)
	{
        $this->setLogFilePath('./output/log/urlaubsantrag');
	    $this->setLogFilename('getHolidays.log');

        $von = $this->getParameter('von');
        $bis = $this->getParameter('bis');

        $jobDB = $this->getDBConnection('JobDataTest');
	    $sql01 = 'SELECT beginDate, endDate FROM DATA_SCHOOLHOLIDAYS WHERE (bankHoliday = 1 AND beginDate BETWEEN \''. $von .'\' AND \''. $bis .'\') OR (bankHoliday = 1 AND endDate BETWEEN \''. $von .'\' AND \''. $bis .'\')';
        $result01 = $jobDB->query($sql01);

        $arr = array();
        $i = 0;

        $this->debug($i);

        if ($result01 === false) {
            throw new JobRouterException($jobDB->getErrorMessage());
        }while ($row = $jobDB->fetchRow($result01)) {
            $arr[$i] = $row;
            $i = $i + 1;
            $this->debug(array_values($arr));
            $this->setReturnValue('arr', $arr);
        }
	}
}
?>