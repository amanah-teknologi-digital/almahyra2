<?php  

	class Mdashboard extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        function getAnakByOrangtua($id_orangtua){
            $sql = "SELECT a.*, d.id_kelas, e.nama as nama_kelas
                FROM registrasi_data_anak a 
                JOIN data_user b ON b.id = a.id_orangtua
                JOIN v_kategori_usia c ON c.id = a.id
                JOIN map_kelasusia d ON d.id_usia = c.id_usia
                JOIN ref_kelas e ON e.id_kelas = d.id_kelas
                WHERE a.id_orangtua = $id_orangtua AND a.is_active = 1 ORDER BY a.anak_ke ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

    }
?>