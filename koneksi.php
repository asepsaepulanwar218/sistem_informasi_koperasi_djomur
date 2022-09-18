<?php
    // koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "koperasi_djoyo");


    //fungsi query
    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            $rows [] = $row;
        }
        return $rows;
    }


    //ambil jasa
    $jasa = mysqli_query($conn, "select nominal from global_param where nama_param = 'Jasa'");
    $data_jasa = mysqli_fetch_array($jasa);
    $data_jasa = $data_jasa["nominal"];
    
// Fungsi format Tgl Indo
    function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    // Fungsi format bulan Indo
    function bln_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }


// function untuk menampilkan nama hari ini dalam bahasa indonesia 
function hari_ini(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini ;

}

// Cetak Kas
if (isset($_POST['print'])) {
    $t_awal = htmlspecialchars($_POST["t_awal"]);
    $t_akhir = htmlspecialchars($_POST["t_akhir"]);
    if ($t_awal != 0 or $t_akhir != 0) {
        $ambil=mysqli_query($conn, "SELECT * from kas where tanggal between '$t_awal' and '$t_akhir' order by tanggal asc");

        $sum = mysqli_query($conn, "SELECT sum(kas_masuk) masuk, sum(kas_keluar) keluar, sum(kas_masuk)-sum(kas_keluar) total from kas where tanggal between '$t_awal' and '$t_akhir'");
        $k_awal = mysqli_query($conn, "select sum(kas_masuk) masuk, sum(kas_keluar) keluar from kas where tanggal < '$t_awal'");
        $sum = mysqli_fetch_array($sum);
        $k_awal = mysqli_fetch_array($k_awal);


        $periode = tgl_indo($t_awal).' - '.tgl_indo($t_akhir);
        $masuk = $sum["masuk"];
        $keluar = $sum["keluar"];
        $awal = $k_awal["masuk"]-$k_awal["keluar"];
        $akhir = $awal+$masuk-$keluar;

    } else {
        $ambil=mysqli_query($conn, "SELECT * from kas order by tanggal asc");

        $sum = mysqli_query($conn, "SELECT sum(kas_masuk) masuk, sum(kas_keluar) keluar, sum(kas_masuk)-sum(kas_keluar) total from kas");
        $k_awal = mysqli_query($conn, "select sum(kas_masuk) masuk, sum(kas_keluar) keluar from kas");
        $sum = mysqli_fetch_array($sum);
        $k_awal = mysqli_fetch_array($k_awal);


        $periode = '-';
        $masuk = $sum["masuk"];
        $keluar = $sum["keluar"];
        $awal = 0;
        $akhir = $awal+$masuk-$keluar;
    }

}

// Cetak SHU
if (isset($_POST['print_shu'])) {
    $t_awal = htmlspecialchars($_POST["t_awal"]);
    $t_akhir = htmlspecialchars($_POST["t_akhir"]);

    if ($t_awal != 0 or $t_akhir != 0) {
        $ambil_shu=mysqli_query($conn, "SELECT * from hasil_usaha where tanggal between '$t_awal' and '$t_akhir' order by tanggal asc");

        $sum = mysqli_query($conn, "SELECT sum(debet) debet, sum(kredit) kredit, sum(debet)-sum(kredit) total from hasil_usaha where tanggal between '$t_awal' and '$t_akhir'");
        $sum = mysqli_fetch_array($sum);
        $k_awal = mysqli_query($conn, "select sum(debet) debet, sum(kredit) kredit from hasil_usaha where tanggal < '$t_awal'");
        $k_awal = mysqli_fetch_array($k_awal);


        $periode = tgl_indo($t_awal).' - '.tgl_indo($t_akhir);
        $debet = $sum["debet"];
        $kredit = $sum["kredit"];
        $awal = $k_awal["debet"]-$k_awal["kredit"];
        $akhir = $awal+$sum["total"];
        $mutasi = $sum["total"];

    } else {
        $ambil_shu=mysqli_query($conn, "SELECT * from hasil_usaha order by tanggal asc");

        $sum = mysqli_query($conn, "SELECT sum(debet) debet, sum(kredit) kredit, sum(debet)-sum(kredit) total from hasil_usaha");
        $sum = mysqli_fetch_array($sum);

        $periode = '-';
        $debet = 0;
        $kredit = 0;
        $mutasi = $sum["total"];
        $awal = 0;
        $akhir = $awal+$sum["total"];
    }
}

?>