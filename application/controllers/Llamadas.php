<?php 
require(APPPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

defined('BASEPATH') OR exit('No direct script access allowed');
class Llamadas extends CI_Controller {
 public function __construct(){
    parent::__construct();
    $this->load->model('llamada_model'); 
 }
 public function download()
 {
	 

 $spreadsheet = new Spreadsheet();
	 $sheet = $spreadsheet->getActiveSheet();
	 $sheet->setCellValue('A1', 'Hello World !');
	 
	 $writer = new Xlsx($spreadsheet);

	 $filename = 'name-of-the-generated-file.xlsx';

	 $writer->save($filename); // will create and save the file in the root of the project

	 $filename = 'name-of-the-generated-file';

	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	 header('Cache-Control: max-age=0');
	 
	 $writer->save('php://output'); // download file 

 }
 public function buscar_llamadas_get(){
    $this->load->view('llamadas/buscar_llamadas',
       array('buscando' => false, 'id_cliente' => null 
    ));
 }
 public function buscar_llamadas_post(){
    $id_cliente = $this->input->post('id_cliente');
    $llamadas = $this->llamada_model->listarPorCliente($id_cliente);
    $this->load->view('llamadas/buscar_llamadas',
       array('buscando' => true, 'id_cliente' => $id_cliente, 'llamadas' => $llamadas )); 
 }
 public function generar_excel($id_cliente=null){
    $llamadas = $this->llamada_model->listarPorCliente($id_cliente);
    if(count($llamadas) > 0){
        //Cargamos la librería de excel.
        
		$spreadsheet = new Spreadsheet();
		$spreadsheet ->setActiveSheetIndex(0);
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Llamadas');
        //Contador de filas
        $contador = 1;
        //Le aplicamos ancho las columnas.
		$sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(100);
        //Le aplicamos negrita a los títulos de la cabecera.
        $sheet->getStyle("A{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("B{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("C{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $sheet->setCellValue("A{$contador}", 'Número de teléfono');
        $sheet->setCellValue("B{$contador}", 'Fecha');
        $sheet->setCellValue("C{$contador}", 'Mensaje');
        //Definimos la data del cuerpo.        
        foreach($llamadas as $l){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.
		   $sheet->setCellValue("A{$contador}", $l->telefono);
           $sheet->setCellValue("B{$contador}", $l->fecha);
           $sheet->setCellValue("C{$contador}", $l->mensaje);
        }
        //Le ponemos un nombre al archivo que se va a generar.
		$writer = new Xls($spreadsheet);
		
		$filename = "prueba1";
        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xls"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save($filename); 
		$writer->save('php://output');
     }else{
        echo 'No se han encontrado llamadas';
        exit;        
     }
  }
}
?>
