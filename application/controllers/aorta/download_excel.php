<?php

class download_spkl_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/download_spkl_m');
    }


    public function excel()
    {
        $this->load->library('Excel');

        $data['content'] = 'aorta/download_spkl/manage_download_spkl_v';
        $this->load->view($this->layout, $data);

        // require(APPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        // require(APPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        $object = new PHPExcel();

        $object->getProperties()->setCreator("Aisin Indonesia");
        $object->getProperties()->setLastModifiedBy("Aisin Indonesia");
        $object->getProperties()->setTitle("SPKL");

        $object->setActiveSheetIndex();
        $worksheet = $object->getActiveSheet();

        $worksheet->setCellValue('A1', 'No');
        $worksheet->setCellValue('B1', 'No SPKL');

        $baris = 2;
        $no = 1;

        foreach ($data['content'] as  $data) {
            $worksheet->setCellValue('A' . $baris, $no++);
            $worksheet->setCellValue('b' . $baris, $data->no_spkl);

            $baris++;
        }

        $worksheet->setTitle("SPKL");

        header('Content->Type: application/ vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createwriter($object, 'excel2007');
        $writer->save('php://output');

        exit;
    }
}
