<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require 'vendor/phpspreadsheet/autoload.php';

class Welcome extends CI_Controller {
	function __construct() {
		parent::__construct();

        if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        } 

        ## load model here 
        $this->load->model('MTperangkat', 'MTperangkat');
        $this->load->model('MTRuangan', 'MTRuangan');
        $this->load->model('MTKendaraan', 'MTKendaraan');
	}

	public function index() {	
		$data['parent'] = 'dashboard';

        $data['perangkat']['pengajuan'] = count($this->MTperangkat->getByStatus(1));
        $data['perangkat']['pending'] = count($this->MTperangkat->getByStatus(2));
        $data['perangkat']['ditolak'] = count($this->MTperangkat->getByStatus(3));
        $data['perangkat']['disetujui'] = count($this->MTperangkat->getByStatus(4));
        $data['perangkat']['selesai'] = count($this->MTperangkat->getByStatus(5));
        
        $data['ruangan']['pengajuan'] = count($this->MTRuangan->getByStatus(1));
        $data['ruangan']['pending'] = count($this->MTRuangan->getByStatus(2));
        $data['ruangan']['ditolak'] = count($this->MTRuangan->getByStatus(3));
        $data['ruangan']['disetujui'] = count($this->MTRuangan->getByStatus(4));
        $data['ruangan']['selesai'] = count($this->MTRuangan->getByStatus(5));

        $data['kendaraan']['pengajuan'] = count($this->MTKendaraan->getByStatus(1));
        $data['kendaraan']['pending'] = count($this->MTKendaraan->getByStatus(2));
        $data['kendaraan']['ditolak'] = count($this->MTKendaraan->getByStatus(3));
        $data['kendaraan']['disetujui'] = count($this->MTKendaraan->getByStatus(4));
        $data['kendaraan']['selesai'] = count($this->MTKendaraan->getByStatus(5));

        $this->load->view('welcome_message',$data);
	}

    public function fetchindex() {  
        $data['perangkat'] = count($this->MTperangkat->getByStatus(1));

        $data['ruangan'] = count($this->MTRuangan->getByStatus(1));

        $data['kendaraan'] = count($this->MTKendaraan->getByStatus(1));
        
        // $data['kendaraan'] = rand(1,20);

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;   
    }

	public function fpdf() {
        $filename="./uploads/bast/test.pdf";
        

        $height = 6;
        $border = 0;
        $tableBorder = 1; 
        $ln = 2;

		$pdf = new FPDF('P','mm','A4');
          // membuat halaman baru
        $pdf->AddPage();
        
        // setting font untuk Header
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(15,$height,'',$border,0,'C');
        $pdf->Cell(10,$height,'No.',$tableBorder,0,'C');
        $pdf->Cell(125,$height,'Jenis Barang',$tableBorder,0,'C');
        $pdf->Cell(25,$height,'Kuantitas',$tableBorder,1,'C');

        $y = $pdf->getY();
        $pdf->setY($y);
        $pdf->setX(25);
        $pdf->Cell(10,35,'A', 1,0, 'C');
        $pdf->Multicell(125,5,"laptop acer \n 2\n 2\n 2\n 2\n 2\n 2",1,"LT");
        $pdf->setY(16);
        $pdf->setX(160);
        $pdf->Cell(25,35,'A', 1,0, 'C');

        $y = $pdf->getY();
        $pdf->setY($y + 35);
        $pdf->setX(25);
        $pdf->Cell(10, 5*2,'A', 1,0, 'C');
        $pdf->Multicell(125,5,"1bbckck acer \n bmn",1,"LT");
        $pdf->setY($y + 35);
        $pdf->setX(160);
        $pdf->Cell(25, 5*2,'A', 1,0, 'C');

        $y = $pdf->getY();
        $pdf->setY($y + 5 * 2);
        $pdf->setX(25);
        $pdf->Cell(10, 5*3,'A', 1,0, 'C');
        $pdf->Multicell(125,5,"1bbckck acer \n bmn \n bmn",1,"LT");
        $pdf->setY($y + 5 * 2);
        $pdf->setX(160);
        $pdf->Cell(25, 5*3,'A', 1,0, 'C');


        $y = $pdf->getY();
        $pdf->setY($y + 5 * 3);
        $pdf->setX(25);
        $pdf->Cell(10, 5*5,'A', 1,0, 'C');
        $pdf->Multicell(125,5,"1bbckck acer \n bmn \n bmn \n bmn ",1,"LT");
        $pdf->setY($y + 5 * 3);
        $pdf->setX(160);
        $pdf->Cell(25, 5*5,'A', 1,0, 'C');

     
        $pdf->Output();
	}

    public function mbast() {
        $filename="./uploads/bast/test.pdf";        

        $height = 6;
        $border = 0;
        $tableBorder = 1; 
        $ln = 2;

        $bulan = date("m");
        $tahun = date("Y");

        //Setting orientasi dan ukuran halaman
        $pdf = new FPDF('P','mm','A4');

        // membuat halaman baru
        $pdf->AddPage();
        
        // setting font untuk Header
        $pdf->SetFont('Arial','B',12);
        
        // mencetak string header
        $pdf->Cell(0,$height,'BERITA ACARA SERAH TERIMA',$border,$ln,'C');
        $pdf->Cell(0,$height,'PERANGKAT KOMPUTERISASI PERKANTORAN',$border,$ln,'C');
        $pdf->Cell(0,$height,'PERWAKILAN BPK-RI DI JAKARTA',$border,$ln,'C');
        $pdf->Cell(0,$height,'TAHUN ANGGARAN 2021',$border,$ln,'C');
        // end mencetak string header

        // re-setting font
        $pdf->SetFont('Arial','',10);
        
        // mencetak string nomor bast      
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'No.   / BAST / INV / '.$bulan.' / '.$tahun,$border,$ln,'C');
        // end mencetak string nomor bast

        // mencetak string pernyataan
        $pdf->Cell(0,$height,'Pada hari ini Selasa, tanggal Lima Belas bulan Juni tahun Dua Ribu Dua Puluh Satu, yang bertanda tangan dibawah ini:',$border,$ln,'C');
        $pdf->Cell(0,4,'',$border,$ln,'C');
        // end mencetak string pernyataan
        

        // MENCETAK DATA PIHAK PERTAMA

        // Nama
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Nama',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Dasril Awal',$border,1,'L');

        // Jabatan
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Jabatan',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Kepala Subbagian Umum dan TI',$border,1,'L');

        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'',$border,0,'L');
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(0,$height,'BPK-RI Perwakilan Provinsi DKI Jakarta',$border,1,'L');

        // Alamat
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Alamat',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Jl. MT Haryono Kav. 34 Jakarta',$border,1,'L');

        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(50,$height,'Selanjutnya disebut sebagai ',$border,0,'L');

        // re-setting font bold
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,$height,'PIHAK PERTAMA',$border,1,'L');
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        
        // re-setting font normal
        $pdf->SetFont('');

        // END MENCETAK DATA PIHAK PERTAMA


        // MENCETAK DATA PIHAK KEDUA

        // Nama
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Nama',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Rina Hanilisma',$border,1,'L');

        // Jabatan
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Jabatan',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Analis Pengelolaan Keuangan APBN Ahli Madya',$border,1,'L');

        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'',$border,0,'L');
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(0,$height,'BPK-RI Perwakilan Provinsi DKI Jakarta',$border,1,'L');

        // Alamat
        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'Alamat',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Jl. MT Haryono Kav. 34 Jakarta',$border,1,'L');

        $pdf->Cell(20,$height,'',$border,0,'C');
        $pdf->Cell(50,$height,'Selanjutnya disebut sebagai ',$border,0,'L');

        // re-setting font bold
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,$height,'PIHAK KEDUA',$border,1,'L');
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        
        // re-setting font normal
        $pdf->SetFont('');

        // END MENCETAK DATA PIHAK KEDUA


        // Mencetak pernyataan
        // overflow
        // $pdf->Cell(0,$height,'Pihak Pertama menyerahkan kepada Pihak Kedua berupa perangkat komputerisasi perkantoran dengan rincian sebagai berikut:',$border,$ln,'L');

        $pdf->MultiCell( 0, $height, "Pihak Pertama menyerahkan kepada Pihak Kedua berupa perangkat komputerisasi perkantoran dengan rincian sebagai berikut:", 0);
        $pdf->Cell(0,3,'',$border,1,'C');

        // Mencetak tabel perangkat yang dipinjam
        $pdf->Cell(15,$height,'',$border,0,'C');
        $pdf->Cell(10,$height,'No.',$tableBorder,0,'C');
        $pdf->Cell(105,$height,'Jenis Barang',$tableBorder,0,'C');
        $pdf->Cell(45,$height,'Kuantitas',$tableBorder,1,'C');
        // End Mencetak tabel perangkat yang dipinjam


        $pdf->Cell(15,$height,'',$border,0,'L');
        $pdf->Cell(10,$height,'',$tableBorder,0,'L');
        $pdf->Cell(105,$height,'Acer',$tableBorder,0,'L');
        $pdf->Cell(45,$height,'',$tableBorder,1,'L');

        $pdf->Cell(15,$height,'',$border,0,'L');
        $pdf->Cell(10,$height,'',$tableBorder,0,'L');
        $pdf->Cell(105,$height,'abc',$tableBorder,0,'L');
        $pdf->Cell(45,$height,'',$tableBorder,1,'L');

        $pdf->Cell(15,$height,'',$border,0,'L');
        $pdf->Cell(10,$height,'',$tableBorder,0,'L');
        $pdf->Cell(105,$height,'def',$tableBorder,0,'L');
        $pdf->Cell(45,$height,'',$tableBorder,1,'L');
        // $y = $pdf->getY();
        // $pdf->setY($y);
        // $pdf->setX(25);
        // $pdf->Cell(10,35,'A', 1,0, 'C');
        // $pdf->Multicell(105,5,"laptop acer \n 2\n 2\n 2\n 2\n 2\n 2",1,"LT");
        // $pdf->setY($y);
        // $pdf->setX(140);
        // $pdf->Cell(45,35,'A', 1,0, 'C');

        // $y = $pdf->getY();
        // $pdf->setY($y + 5*7);
        // $pdf->setX(25);
        // $pdf->Cell(10,35,'A', 1,0, 'C');
        // $pdf->Multicell(105,5,"laptop acer \n 2\n 2\n 2\n 2\n 2\n 2",1,"LT");
        // $pdf->setY($y + 5*7);
        // $pdf->setX(140);
        // $pdf->Cell(45,35,'A', 1,0, 'C');

        // $y = $pdf->getY();
        // $pdf->setY($y + 5*7);
        // $pdf->setX(25);
        // $pdf->Cell(10,10,'A', 1,0, 'C');
        // $pdf->Multicell(105,5,"laptop acer \n 2",1,"LT");
        // $pdf->setY($y + 5*7);
        // $pdf->setX(140);
        // $pdf->Cell(45,10,'A', 1,0, 'C');
        



        // Mencetak penutupan
        $y = $pdf->getY();
        $pdf->setY($y+35);
        $pdf->Cell(0,$height,'',$border,1,'C');
        $pdf->MultiCell( 0, $height, "Dengan demikian mulai saat penandatanganan berita acara ini, maka penggunaan dan pengelolaan serta pengurusan barang menjadi wewenang dan tanggung jawab PIHAK KEDUA. Namun Perangkat TI tersebut dapat ditarik kembali apabila sewaktu-waktu diperlukan", 0);
        $pdf->Cell(0,$height,'',$border,1,'C');

        // TANDA TANGAN

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(95,$height,'PIHAK KEDUA',$border,0,'C');
        $pdf->Cell(95,$height,'PIHAK PERTAMA',$border,1,'C');

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(95,$height,'Yang Menerima,',$border,0,'C');
        $pdf->Cell(95,$height,'Yang Menyerahkan,',$border,1,'C');

        $pdf->Cell(0,$height,'',$border,1,'C');
        $pdf->Cell(0,$height,'',$border,1,'C');

        $pdf->SetFont('Arial','Bu',10);
        $pdf->Cell(95,$height,'Rina Hanilisma',$border,0,'C');
        $pdf->Cell(95,$height,'Dasril Awal',$border,1,'C');
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(95,$height,'NIP. 197510261999032002',$border,0,'C');
        $pdf->Cell(95,$height,'NIP. 197504212002122004',$border,1,'C');

        // END TANDA TANGAN

        // Mencetak Garis dibawah header
        $pdf->SetLineWidth(0.8);
        $pdf->Line(40,37,170,37);
        // End Mencetak Garis dibawah header

        $pdf->Output();
        // $pdf->Output($filename,'F');
    }

    public function mpinjam() {
        $height = 6;
        $border = 0;
        $tableBorder = 1; 
        $ln = 2;

        //Setting orientasi dan ukuran halaman
        $pdf = new FPDF('P','mm','A4');

        // membuat halaman baru
        $pdf->AddPage();

        // setting font Header
        $pdf->SetFont('Arial','B',14);
        
        // mencetak header 
        $pdf->Cell(0,$height,'Form Peminjaman Barang Milik Negara',$border,$ln,'C');
        $pdf->Cell(0,$height,'Badan Pemeriksa Keuangan Perwakilan Provinsi DKI Jakarta',$border,$ln,'C');
        // end mencetak header

        // re-setting font
        $pdf->SetFont('Arial','B',10);        
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        // MENCETAK DATA PEMINJAM

        $pdf->Cell(0,$height,'I. Data Peminjam : ',$border,$ln,'L');
        
        //Reset Font
        $pdf->SetFont('Arial','',10);
        
        // Nama
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'1 Nama',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Gerget Sih Fisika Dewi',$border,1,'L');

        // NIP
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'2 NIP',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'240008271',$border,1,'L');

        // Jabatan
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'3 Jabatan',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Sekretaris',$border,1,'L');

        // Unit Kerja
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'4 Unit Kerja',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'BPK Perwakilan Provinsi DKI Jakarta',$border,1,'L');
        
        // END MENCETAK DATA PEMINJAM

        // re-setting font
        $pdf->SetFont('Arial','B',10);        
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        // MENCETAK DATA BMN
        $pdf->Cell(0,$height,'II. Data BMN : ',$border,$ln,'L');
        
        // mencetak tabel uraian bmn
        $pdf->Cell(5,$height,'',$border,0,'C');
        $pdf->Cell(15,$height,'No',$tableBorder,0,'C');
        $pdf->Cell(55,$height,'Nomor BMN',$tableBorder,0,'C');
        $pdf->Cell(110,$height,'Uraian BMN',$tableBorder,1,'C');
        // end mencetak tabel uraian bmn

        //Reset Font
        $pdf->SetFont('Arial','',10);

        // END MENCETAK DATA BMN


        // TANDA TANGAN

        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        $pdf->Cell(95,$height,'Diserahkan Oleh',$border,0,'C');
        $pdf->Cell(95,$height,'Diterima Oleh',$border,1,'C');

        $pdf->Cell(95,$height,'Kepala Sub Bagian Umum dan TI,',$border,0,'C');
        $pdf->Cell(95,$height,'Peminjam BMN,',$border,1,'C');

        $pdf->Cell(0,$height,'',$border,1,'C');
        $pdf->Cell(0,$height,'',$border,1,'C');

        $pdf->Cell(95,$height,'Dasril Awal',$border,0,'C');
        $pdf->Cell(95,$height,'Gerget Sih Fisika Dewi',$border,1,'C');
        
        $pdf->Cell(95,$height,'NIP. 240002424',$border,0,'C');
        $pdf->Cell(95,$height,'NIP. 240008271',$border,1,'C');

        $pdf->Cell(95,$height,'Tanggal :  25 Juni 2021',$border,0,'C');
        $pdf->Cell(95,$height,'Tanggal :  25 Juni 2021',$border,1,'C');

        // END TANDA TANGAN

        // Catatan Tambahan
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'Catatan Tambahan : ',$border,$ln,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,$height,'Tes 12 33 1 13 131 ',$border,1,'L');
        // End Catatan Tambahan

        $pdf->Output();
    }

    public function mkembali() {
        $height = 6;
        $border = 0;
        $tableBorder = 1; 
        $ln = 2;

        //Setting orientasi dan ukuran halaman
        $pdf = new FPDF('P','mm','A4');

        // membuat halaman baru
        $pdf->AddPage();

        // setting font Header
        $pdf->SetFont('Arial','B',14);
        
        // mencetak header 
        $pdf->Cell(0,$height,'Form Pengembalian Barang Milik Negara',$border,$ln,'C');
        $pdf->Cell(0,$height,'Badan Pemeriksa Keuangan Perwakilan Provinsi DKI Jakarta',$border,$ln,'C');
        // end mencetak header

        // re-setting font
        $pdf->SetFont('Arial','B',10);        
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        // MENCETAK DATA PEMINJAM

        $pdf->Cell(0,$height,'I. Data Peminjam : ',$border,$ln,'L');
        
        //Reset Font
        $pdf->SetFont('Arial','',10);
        
        // Nama
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'1 Nama',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Gerget Sih Fisika Dewi',$border,1,'L');

        // NIP
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'2 NIP',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'240008271',$border,1,'L');

        // Jabatan
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'3 Jabatan',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'Sekretaris',$border,1,'L');

        // Unit Kerja
        $pdf->Cell(10,$height,'',$border,0,'C');
        $pdf->Cell(40,$height,'4 Unit Kerja',$border,0,'L');
        $pdf->Cell(10,$height,':',$border,0,'C');
        $pdf->Cell(0,$height,'BPK Perwakilan Provinsi DKI Jakarta',$border,1,'L');
        
        // END MENCETAK DATA PEMINJAM

        // re-setting font
        $pdf->SetFont('Arial','B',10);        
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        // MENCETAK DATA BMN
        $pdf->Cell(0,$height,'II. Data BMN : ',$border,$ln,'L');
        
        // mencetak tabel uraian bmn
        $pdf->Cell(5,$height,'',$border,0,'C');
        $pdf->Cell(15,$height,'No',$tableBorder,0,'C');
        $pdf->Cell(55,$height,'Nomor BMN',$tableBorder,0,'C');
        $pdf->Cell(110,$height,'Uraian BMN',$tableBorder,1,'C');
        // end mencetak tabel uraian bmn

        //Reset Font
        $pdf->SetFont('Arial','',10);

        // END MENCETAK DATA BMN


        // TANDA TANGAN

        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'',$border,$ln,'C');

        $pdf->Cell(95,$height,'Dikembalikan Oleh',$border,0,'C');
        $pdf->Cell(95,$height,'Diterima Oleh',$border,1,'C');

        $pdf->Cell(0,$height,'',$border,1,'C');
        $pdf->Cell(0,$height,'',$border,1,'C');

        $pdf->Cell(95,$height,'Gerget Sih Fisika Dewi',$border,0,'C');
        $pdf->Cell(95,$height,'Dasril Awal',$border,1,'C');
        
        $pdf->Cell(95,$height,'NIP. 240008271',$border,0,'C');
        $pdf->Cell(95,$height,'NIP. 240002424',$border,1,'C');

        $pdf->Cell(95,$height,'Tanggal :  25 Juni 2021',$border,0,'C');
        $pdf->Cell(95,$height,'Tanggal :  25 Juni 2021',$border,1,'C');

        // END TANDA TANGAN

        // Catatan Tambahan
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,$height,'',$border,$ln,'C');
        $pdf->Cell(0,$height,'Catatan Tambahan : ',$border,$ln,'L');

        // re-setting font
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5,$height,'',$border,0,'L');
        $pdf->Cell(0,$height,'Laptop dalam keadaan baik dan Lengkap Charger',$border,$ln,'L');

        // End Catatan Tambahan

        $pdf->Output();
    }

}
