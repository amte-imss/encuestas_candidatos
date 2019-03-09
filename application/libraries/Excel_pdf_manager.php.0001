<?php
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';
 
class Excel_pdf_manager
{      
   /* function import($filename)
    {
    //creando un objeto lector y cargando el fichero
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($filename);
	 
	//iterando por el contenido de las celdas
	$objWorksheet = $objPHPExcel->getActiveSheet();
	foreach ($objWorksheet->getRowIterator() as $row) 
	{
	    $record = array();
	    $cellIterator = $row->getCellIterator();
	    $cellIterator->setIterateOnlyExistingCells(false);
	    foreach ($cellIterator as $cell)
	    {
	        $record[] = $cell->getValue();
	    }
	    … 
	}       
*/ 
    function export($table,$datosevento,$datosconteo)
    {

    	
		$objPHPExcel = new PHPExcel();                                               //creando un objeto excel
		$objPHPExcel->getProperties()->setCreator("CORAD");    //propiedades
		$objPHPExcel->setActiveSheetIndex(0);                                 //poniendo active hoja 1
		$objPHPExcel->getActiveSheet()->setTitle("Hoja1");//título de la hoja 1
		 if (file_exists('images/logo_ccc.png')) {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('CORAD');
        $objDrawing->setDescription('CORAD');
        //Path to signature .jpg file
        $signature = FCPATH.'images/logo_ccc.png';    
        $objDrawing->setPath($signature);
        $objDrawing->setOffsetX(8);                     //setOffsetX works properly
        $objDrawing->setCoordinates('A1');             //set image to cell E38
        $objDrawing->setHeight(75);                     //signature height  
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save      
        }
  		

        /******************************************************************************/
  		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Nombre de evento:')
            ->setCellValue('E2', 'Hotel:')
            ->setCellValue('E3', 'Sede:')
			->setCellValue('E4', 'Fecha inicio:')	
			->setCellValue('E5', 'Fecha fin:')
			->setCellValue('E6', 'Costos:')	
			->setCellValue('E7', 'Orden de pago:');
       $row1=1;
        foreach ($datosevento as $key => $value) {

        	
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row1, $value);
               $row1++;

        }

        

        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'ESTATUS')
            ->setCellValue('L1', 'PAX');


        $column1=10;
        $row2=2;

        foreach ($datosconteo as $record)
            {
                foreach ($record as $value2)
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column1, $row2, $value2);
                    $column1++;
                }
                $column1 = 10;
                $row2++;
            }
  		
        /***********************************************************************************************/
		$tablename='Reporte'.date('d/m/Y');
		$ext='.xls';
		 
		//llenando celdas
		$column = 0;
		$row = 10;
		//var_dump($table);
		//die();
     	foreach ($table as $record)
		    {
		        foreach ($record as $value)
		        {
		            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);
		            $column++;
		        }
		        $column = 0;
		        $row++;
		    }
		 
		//poniendo en negritas la fila de los títulos
		$styleArray = array('font' => array('bold' => true));
		$objPHPExcel->getActiveSheet()->getStyle('A10:BB10')-> applyFromArray($styleArray);  

		 
		//poniendo columnas con tamaño auto según el contenido, asumiendo N como la última
		for ($i = 'A'; $i<= 'N'; $i++)
		    $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true); 
		






	    $objPHPExcel->setActiveSheetIndex(0);  
        /*****************************************/
        /*****************************************/
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex('1');  
        $objPHPExcel->getActiveSheet()->setTitle('Grafica');

$objPHPExcel->getActiveSheet()->fromArray(
array(
    array('',   2010,   2011,   2012),
    array('Q1',   12,   15,     21),
    array('Q2',   56,   73,     86),
    array('Q3',   52,   61,     69),
    array('Q4',   30,   32,     0),
    )
);

$dataseriesLabels = array(
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1), //    2010
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1), //    2011
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1), //    2012
);

/*Set the X-Axis Labels
Datatype
Cell reference for data
Format Code
Number of datapoints in series
Data values
Data Marker*/
$xAxisTickValues = array(
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$5', NULL, 4), //    Q1 to Q4
);

/*Set the Data values for each data series we want to plot
Datatype
Cell reference for data
Format Code
Number of datapoints in series
Data values
Data Marker*/
$dataSeriesValues = array(
    new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$5', NULL, 4),
    new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$5', NULL, 4),
    new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$5', NULL, 4),
);

//Build the dataseries
$series = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_BARCHART,        // plotType
    PHPExcel_Chart_DataSeries::GROUPING_STANDARD,    // plotGrouping
    range(0, count($dataSeriesValues)-1),            // plotOrder
    $dataseriesLabels,                               // plotLabel
    $xAxisTickValues,                                // plotCategory
    $dataSeriesValues                                // plotValues
);

/*Set additional dataseries parameters
Make it a vertical column rather than a horizontal bar graph*/
$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

//Set the series in the plot area
$plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));

//Set the chart legend
$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL,false);
$title = new PHPExcel_Chart_Title('Test Column Chart');
$yAxisLabel = new PHPExcel_Chart_Title('Value ($k)');

//Create the chart
$chart = new PHPExcel_Chart(
    'chart1',           // name
    $title,             // title
    $legend,            // legend
    $plotarea,          // plotArea
    true,               // plotVisibleOnly
    0,                  // displayBlanksAs
    NULL,               // xAxisLabel
    $yAxisLabel         // yAxisLabel
);
$chart->setTopLeftPosition('K1');
$chart->setBottomRightPosition('O15');
$objPHPExcel->getActiveSheet()->addChart($chart);





$objPHPExcel->setActiveSheetIndex(0);



		//creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$tablename.$ext);
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');







      
    }    
}