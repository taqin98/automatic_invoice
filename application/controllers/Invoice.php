<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library('session');
		$this->load->library('Pdf');
		$this->load->model('PelangganModel');
		$this->load->model('ProductModel');
	}

	public function index()
	{
		$data['data'] = $this->ProductModel->getAllData();
		$data['Invoice'] = $this;
		$this->load->view('admin/view_invoice', $data);
	}

	public function check()
	{
		$pelanggan 	= $this->PelangganModel->getAllData();
		$product 	= $this->ProductModel->getAllData();
		if ($pelanggan) {
			if ($product) {
				$this->download();
			} else {
				$this->session->set_flashdata('danger','Anda Belum memasukkan produk');
				return redirect('users/dashboard_admin','refresh');
			}
		} else {
			$this->session->set_flashdata('danger','Tidak Ada Data Invoice');
			return redirect('users/dashboard_admin','refresh');
		}
	}

	public function download()
	{
		date_default_timezone_set('Asia/Jakarta');
		$pelanggan = $this->PelangganModel->getAllData();
		$Pdf = new FPDF('p','mm','A4');
        // membuat halaman baru
        $Pdf->AddPage();
        // setting jenis font yang akan digunakan
        $Pdf->SetTextColor(255,255,255);
        $Pdf->SetFont('Arial','B',16);
        // mencetak string 
        $Pdf->Cell(190,15,'Nama Perusahaan Penyedia Layanan',1,1,'C', true);
        $Pdf->Image('https://blog.porinto.com/wp-content/uploads/2018/07/logo-apple-696x576.jpg',40,12,12,10, 'JPG');
        $Pdf->SetFont('Arial','',10);
        $Pdf->SetTextColor(0,0,0);
        $Pdf->Cell(190,7,'Alamat Lengkap dengan nama jalan berserta kode pos wilayah - nomor hp/wa',0,1,'C');

        $Pdf->Cell(10,5,'',0,1);
        $Pdf->SetFont('Arial','',10);
        $Pdf->Cell(30,10,'Nama Pemesan',0,0);
        $Pdf->Cell(40,10,': ' . $pelanggan[0]->nama,0,0);
        $Pdf->Cell(90,10,'No. Invoice : ',0,0,'R');
        $Pdf->Cell(28,10,'#' . date('dmYHi'),0,1,'R');

        $Pdf->Cell(30,0,'Alamat',0,0);
        $Pdf->Cell(40,0,': ' .  $pelanggan[0]->alamat,0,0);
        $Pdf->Cell(90,0,'Tgl Invoice : ',0,0,'R');
        $Pdf->Cell(28,0, date('d-m-Y'),0,1,'R');
        $Pdf->Cell(30,10,'Nomor Hp/WA',0,0);
        $Pdf->Cell(40,10,': ' .  $pelanggan[0]->hp,0,0);
        $Pdf->Cell(90,10,'Batas Invoice : ',0,0,'R');
        $Pdf->Cell(28,10, date('d-m-Y', strtotime(date('d-m-Y'). ' + 5 days')) ,0,0,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
        $Pdf->Cell(10,10,'',0,1); 
        $Pdf->SetFont('Arial','B',10);
        $Pdf->SetFillColor(230,230,230);
        $Pdf->Cell(10,12,'No',1,0,'C',true);
        $Pdf->Cell(55,12,'Produk',1,0,'C',true);

        $Pdf->Cell(45,6,'Size',1,0,'C',true);
        $Pdf->SetY(63);
        $Pdf->SetX(75);
        $Pdf->Cell(15,6,'P',1,0,'C',true);
        $Pdf->Cell(15,6,'L',1,0,'C',true);
        $Pdf->Cell(15,6,'T',1,0,'C',true);

        $Pdf->SetY(-240);
        $Pdf->SetX(120);
        $Pdf->Cell(15,12,'Qty',1,0,'C',true);
        $Pdf->Cell(32,12,'Harga',1,0,'C',true);
        $Pdf->Cell(32,12,'Sub total',1,1,'C',true);
        $Pdf->SetFont('Arial','',10);
        $product = $this->ProductModel->getAllData();
        $nomor=1;
        $total=0;
        foreach ($product as $row){
        	$total+=$row->qty*$row->harga;
            $Pdf->Cell(10,40,$nomor++,1,0);
            $image = $Pdf->Image('assets/data/'. $row->foto, $Pdf->getX()+2,$Pdf->getY()+2,0,30);
            $Pdf->Cell(55,40,$image,1,0,'C');
            $Pdf->Cell(15,40,$row->panjang . ' cm',1,0,'C');
            $Pdf->Cell(15,40,$row->lebar . ' cm',1,0,'C');
            $Pdf->Cell(15,40,$row->tinggi . ' cm',1,0,'C');
            $Pdf->Cell(15,40,$row->qty,1,0,'C');
            $Pdf->Cell(32,40,$this->rupiah($row->harga),1,0,'C');
            $Pdf->Cell(32,40,$this->rupiah($row->qty*$row->harga),1,1,'C');
            // $Pdf->Cell(15,6,$row->tinggi,1);
            // $Pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
        }
        $Pdf->Cell(125,6,' ',1,0,'C');
        $Pdf->SetFont('Arial','B',10);
        $Pdf->Cell(32,6,'Total',1,0,'C');
        $Pdf->Cell(32,6,$this->rupiah($total),1,1,'C');

        $Pdf->Cell(10,5,'',0,1); 
        $Pdf->SetFont('Times','B',12);
        $Pdf->Cell(80,10,'Bank Cabang Kota',0,0,'L');
        $Pdf->Cell(45,10,'Ongkir','B',0,'R');
        $Pdf->Cell(64,10,'Ongkir Ditanggung Pemesan','B',1,'R');

        $Pdf->Cell(80,10,'0999999xxxx',0,0,'L');
        $Pdf->Cell(45,10,'DP 40%','B',0,'R');
        $Pdf->Cell(64,10,$this->rupiah($total*40/100),'B',1,'R');

        $Pdf->Cell(80,10,'Nama pemilik Rekening',0,0,'L');
        $Pdf->Cell(45,10,'PELUNASAN 60%','B',0,'R');
        $Pdf->Cell(64,10,$this->rupiah($total*60/100),'B',1,'R');
        // $Pdf->Output();
        $Pdf->Output('D','#'.date('dmYHi') . '.pdf');
	}

	public function rupiah($angka){

		// $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		$hasil_rupiah = "Rp. " . number_format($angka,0,'','.');
		return $hasil_rupiah;

	}

	public function emptyFiles()
	{
		$this->PelangganModel->deleteAllData();
		$this->ProductModel->deleteAllData();
		$files = glob('assets/data/*'); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file)) {
    			unlink($file); // delete file
			}
		}

	}

}

/* End of file Invoice.php */
/* Location: ./application/controllers/Invoice.php */