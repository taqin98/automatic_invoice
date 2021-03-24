<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library('session');
		$this->load->library('pdf');
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
		$pdf = new FPDF('p','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,15,'Nama Perusahaan Penyedia Layanan',1,1,'C', true);
        $pdf->Image('https://blog.porinto.com/wp-content/uploads/2018/07/logo-apple-696x576.jpg',40,12,12,10, 'JPG');
        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(190,7,'Alamat Lengkap dengan nama jalan berserta kode pos wilayah - nomor hp/wa',0,1,'C');

        $pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,10,'Nama Pemesan',0,0);
        $pdf->Cell(40,10,': ' . $pelanggan[0]->nama,0,0);
        $pdf->Cell(90,10,'No. Invoice : ',0,0,'R');
        $pdf->Cell(28,10,'#' . date('dmYHi'),0,1,'R');

        $pdf->Cell(30,0,'Alamat',0,0);
        $pdf->Cell(40,0,': ' .  $pelanggan[0]->alamat,0,0);
        $pdf->Cell(90,0,'Tgl Invoice : ',0,0,'R');
        $pdf->Cell(28,0, date('d-m-Y'),0,1,'R');
        $pdf->Cell(30,10,'Nomor Hp/WA',0,0);
        $pdf->Cell(40,10,': ' .  $pelanggan[0]->hp,0,0);
        $pdf->Cell(90,10,'Batas Invoice : ',0,0,'R');
        $pdf->Cell(28,10, date('d-m-Y', strtotime(date('d-m-Y'). ' + 5 days')) ,0,0,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,10,'',0,1); 
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(230,230,230);
        $pdf->Cell(10,12,'No',1,0,'C',true);
        $pdf->Cell(55,12,'Produk',1,0,'C',true);

        $pdf->Cell(45,6,'Size',1,0,'C',true);
        $pdf->SetY(63);
        $pdf->SetX(75);
        $pdf->Cell(15,6,'P',1,0,'C',true);
        $pdf->Cell(15,6,'L',1,0,'C',true);
        $pdf->Cell(15,6,'T',1,0,'C',true);

        $pdf->SetY(-240);
        $pdf->SetX(120);
        $pdf->Cell(15,12,'Qty',1,0,'C',true);
        $pdf->Cell(32,12,'Harga',1,0,'C',true);
        $pdf->Cell(32,12,'Sub total',1,1,'C',true);
        $pdf->SetFont('Arial','',10);
        $product = $this->ProductModel->getAllData();
        $nomor=1;
        $total=0;
        foreach ($product as $row){
        	$total+=$row->qty*$row->harga;
            $pdf->Cell(10,40,$nomor++,1,0);
            $image = $pdf->Image('assets/data/'. $row->foto, $pdf->getX()+2,$pdf->getY()+2,0,30);
            $pdf->Cell(55,40,$image,1,0,'C');
            $pdf->Cell(15,40,$row->panjang . ' cm',1,0,'C');
            $pdf->Cell(15,40,$row->lebar . ' cm',1,0,'C');
            $pdf->Cell(15,40,$row->tinggi . ' cm',1,0,'C');
            $pdf->Cell(15,40,$row->qty,1,0,'C');
            $pdf->Cell(32,40,$this->rupiah($row->harga),1,0,'C');
            $pdf->Cell(32,40,$this->rupiah($row->qty*$row->harga),1,1,'C');
            // $pdf->Cell(15,6,$row->tinggi,1);
            // $pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
        }
        $pdf->Cell(125,6,' ',1,0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(32,6,'Total',1,0,'C');
        $pdf->Cell(32,6,$this->rupiah($total),1,1,'C');

        $pdf->Cell(10,5,'',0,1); 
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(80,10,'Bank Cabang Kota',0,0,'L');
        $pdf->Cell(45,10,'Ongkir','B',0,'R');
        $pdf->Cell(64,10,'Ongkir Ditanggung Pemesan','B',1,'R');

        $pdf->Cell(80,10,'0999999xxxx',0,0,'L');
        $pdf->Cell(45,10,'DP 40%','B',0,'R');
        $pdf->Cell(64,10,$this->rupiah($total*40/100),'B',1,'R');

        $pdf->Cell(80,10,'Nama pemilik Rekening',0,0,'L');
        $pdf->Cell(45,10,'PELUNASAN 60%','B',0,'R');
        $pdf->Cell(64,10,$this->rupiah($total*60/100),'B',1,'R');
        $pdf->Output();
        // $pdf->Output('D','#'.date('dmYHi') . '.pdf');
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