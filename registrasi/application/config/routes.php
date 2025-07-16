<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|   $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|       my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'csession';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// dashboard
$route['dashboard'] = 'cdashboard';
$route['dashboard-perkembangan'] = 'cdashboard/perkembangan';
$route['dashboard-mengaji'] = 'cdashboard/mengaji';
$route['capaian-indikator'] = 'ccapaianindikator';
$route['capaian-indikator/detail/(:any)'] = 'ccapaianindikator/detailcapaian/$1';

// referensi
$route['role'] = 'crole';
$route['tahun'] = 'ctahun';
$route['pengguna'] = 'cpengguna';
$route['imunisasi'] = 'cimunisasi';
$route['penyakit'] = 'cpenyakit';
$route['kelas'] = 'ckelas';
$route['kembang-anak'] = 'ckembanganak';
$route['aspek'] = 'caspek';
$route['usia'] = 'cusia';
$route['uraian'] = 'curaian';
$route['uraian-tagihan'] = 'ctagihan';
$route['items'] = 'citems';

// session
$route['login'] = 'csession';
$route['logout'] = 'csession/logout';
$route['register'] = 'csession/register';
$route['profile'] = 'csession/profile';

// register
$route['register-anak'] = 'cranak';
$route['register-orangtua'] = 'crorangtua';
$route['register-rekam-medik'] = 'crrekammedik';
$route['register-berkas'] = 'crberkas';
$route['kelas-anak'] = 'ckelasanak';

// observasi
$route['observasi-anak'] = 'coanak';
$route['observasi-pertumbuhan'] = 'cotumbuh';
$route['observasi-perkembangan'] = 'cokembang';
$route['observasi-hasil'] = 'cohasil';
$route['penentuan-zona'] = 'cozona';

// pembayaran
$route['pembayaran-tagihan'] = 'cptagihan';

// absensi
$route['absensi-anak'] = 'cabsensianak';
$route['absensi-barang'] = 'cabsensibarang';
$route['absensi-barang/lihat-data/(:any)'] = 'cabsensibarang/lihatdata/$1';
$route['absensi-educator'] = 'cabsensieducator';
$route['absensi-items'] = 'cabsensiitems';
$route['absensi-pengasuh'] = 'cabsensipengasuh';

//medical checkup
$route['medical-checkup'] = 'cmedicalcheckup';
$route['medical-checkup/lihat-data/(:any)'] = 'cmedicalcheckup/lihatdata/$1';
$route['mc-backdate'] = 'cmedicalcheckup/backdate';
$route['mc-backdate/lihat-data/(:any)'] = 'cmedicalcheckup/lihatdatabackdate/$1';

// aktivitas
$route['aktivitas-anak'] = 'caktivitas';
$route['aktivitas-harian'] = 'caktivitasharian';
$route['aktivitas-harian/lihat-data/(:any)'] = 'caktivitasharian/lihataktivitas/$1';
$route['dokumentasi-harian'] = 'cdokumentasiharian';
$route['aktivitasharian-anak'] = 'caktivitashariananak';
$route['laporan-absensianak'] = 'claporanabsensianak';
$route['laporan-absensieducator'] = 'claporanabsensieducator';
$route['laporan-medicalcheckup'] = 'claporanmedicalcheckup';
$route['laporan-medicalcheckup/lihat-data/(:num)'] = 'claporanmedicalcheckup/lihatdata/$1';
$route['laporan-mengaji'] = 'claporanmengaji';

// laporan 
$route['laporan-tumbuh-kembang'] = 'claporan/tumbuhkembangf';
$route['hasil-laporan-tumbuh-kembang/(:any)'] = 'claporan/tumbuhkembangrpp/$1';

$route['laporan-pembayaran'] = 'claporan/pembayaranf';
$route['hasil-laporan-pembayaran/(:any)'] = 'claporan/pembayaranrpp/$1';

$route['laporan-harian'] = 'claporan/harianf';
$route['hasil-laporan-harian/(:any)'] = 'claporan/harianrpp/$1';

$route['rencana-belajar'] = 'crencanabelajar';
$route['rencana-pelaksanaan'] = 'crencanapelaksanaan';

$route['laporan-rencana-belajar'] = 'crencanabelajar/rencanaf';
$route['laporan-pelaksanaan-belajar/(:any)'] = 'crencanapelaksanaan/pelaksanaanrpp/$1';

$route['tematik-bulanan'] = 'ctematikbulanan';
$route['tematik-bulanan/(:num)'] = 'ctematikbulanan/lihatdata/$1';

$route['jadwal-harian'] = 'cjadwalharian';
$route['jadwal-harian/(:num)/jadwalharian/(:num)'] = 'cjadwalharian/lihatjadwalharian/$1/$2';

$route['template-jadwal'] = 'ctemplatejadwal';
$route['template-jadwal/edit/(:num)'] = 'ctemplatejadwal/lihatdata/$1';
$route['template-stimulus'] = 'ctemplatestimulus';

$route['catatan-mengaji'] = 'ccatatanmengaji';
$route['catatan-mengaji/lihat-data/(:any)'] = 'ccatatanmengaji/lihatdata/$1';

$route['data-ekstrakulikuler'] = 'cdataekstrakulikuler';
$route['data-ekstrakulikuler/edit/(:num)'] = 'cdataekstrakulikuler/lihatdata/$1';

$route['catat-ekstrakulikuler'] = 'ccatatanekstra';
$route['catat-ekstrakulikuler/lihat-data/(:any)'] = 'ccatatanekstra/lihatdata/$1';

// $route['peminjaman-kendaraan'] = 'ctkendaraan';
// $route['peminjaman-kendaraan/pengembalian'] = 'ctkendaraan/pengembalian';

// $route['peminjaman-ruangan'] = 'ctruangan';
// $route['peminjaman-ruangan/pengembalian'] = 'ctruangan/pengembalian';

// $route['peminjaman-perangkat-it'] = 'ctperangkat';
// $route['peminjaman-perangkat-it/pengembalian'] = 'ctperangkat/pengembalian';
// $route['detail/peminjaman-perangkat-it/(:num)'] = 'ctperangkatitem/detail/$1';
