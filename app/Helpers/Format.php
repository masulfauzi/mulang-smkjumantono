<?php
namespace App\Helpers;

use DateTime;

class Format 
{
	public static function tanggal($tanggal, $cetak_hari = false, $cetak_waktu = true)
	{
		if($tanggal == null || $tanggal == ''){
			return '';
		}
		$hari = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);

		// if(app()->getLocale() == 'en'){
		// 	$hari = array (1 =>'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday');
		// }

		$bulan = array (1 =>   'Januari',
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

		// if(app()->getLocale() == 'en'){
		// 	$bulan = array (1 =>   'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November','December');
		// }
		
		$split1 	  = explode('-', $tanggal);
		if (strlen($split1[2]) != 2) {
			$split = array();
			foreach ($split1 as $key => $value) {
				if ($key==2) {
					$a	  = explode(' ', $value);
					$split[] = array_push($split, $a[0],$a[1]);
				}else{
					$split[] = $value;
				}
			}
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0].' | '. $split[3];
		}else{
			$split	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		}

		if($cetak_waktu == false){
			$split	  = explode('-', $tanggal);
			$tgl_indo = substr($split[2], 0, 2) . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		}

		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}

		return $tgl_indo;
	}

	public static function konversi_nip($nip, $batas = " ")
	{
		$nip = trim($nip," ");
		$panjang = strlen($nip);
		
		if($panjang == 18) {
			$sub[] = substr($nip, 0, 8); // tanggal lahir
			$sub[] = substr($nip, 8, 6); // tanggal pengangkatan
			$sub[] = substr($nip, 14, 1); // jenis kelamin
			$sub[] = substr($nip, 3, 3); // nomor urut
			
			return $sub[0].$batas.$sub[1].$batas.$sub[2].$batas.$sub[3];
		} elseif($panjang == 15) {
			$sub[] = substr($nip, 0, 8); // tanggal lahir
			$sub[] = substr($nip, 8, 6); // tanggal pengangkatan
			$sub[] = substr($nip, 14, 1); // jenis kelamin
			
			return $sub[0].$batas.$sub[1].$batas.$sub[2];
		} elseif($panjang == 9) {
			$sub = str_split($nip,3);
			
			return $sub[0].$batas.$sub[1].$batas.$sub[2];
		} else {
			return $nip;
		}
	}

	public static function getIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	public static function escapeString($input){

		$input = str_replace('&#39;',"'",$input);
		$input = str_replace('&quot;','"',$input);
		$input = str_replace('&lt;',"<",$input);
		$input = str_replace('&gt;',">",$input);
		$input = str_replace('&amp;',"&",$input);

		return $input;
	}

	public static function rupiah($nominal)
	{
		return empty($nominal) ? '' : 'Rp '.number_format($nominal, 0, ',', '.');
	}

	public static function timeElapsed($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public static function terbilang($bilangan)
	{
		if ($bilangan == '' || $bilangan == 0)
			return "nol";
		$angka = array(
			'0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
			'0', '0', '0', '0', '0', '0'
		);
		$kata = array(
			'', 'satu', 'dua', 'tiga', 'empat', 'lima',
			'enam', 'tujuh', 'delapan', 'sembilan'
		);
		$tingkat = array('', 'ribu', 'juta', 'milyar', 'triliun');

		$panjang_bilangan = strlen($bilangan);

		/* pengujian panjang bilangan */
		if ($panjang_bilangan > 15) {
			$kalimat = "Diluar Batas";
			return $kalimat;
		}

		/* mengambil angka-angka yang ada dalam bilangan,
         dimasukkan ke dalam array */
		for ($i = 1; $i <= $panjang_bilangan; $i++) {
			$angka[$i] = substr($bilangan, - ($i), 1);
		}

		$i = 1;
		$j = 0;
		$kalimat = "";


		/* mulai proses iterasi terhadap array angka */
		while ($i <= $panjang_bilangan) {

			$subkalimat = "";
			$kata1 = "";
			$kata2 = "";
			$kata3 = "";

			/* untuk ratusan */
			if ($angka[$i + 2] != "0") {
				if ($angka[$i + 2] == "1") {
					$kata1 = "seratus";
				} else {
					$kata1 = $kata[$angka[$i + 2]] . " ratus";
				}
			}

			/* untuk puluhan atau belasan */
			if ($angka[$i + 1] != "0") {
				if ($angka[$i + 1] == "1") {
					if ($angka[$i] == "0") {
						$kata2 = "sepuluh";
					} elseif ($angka[$i] == "1") {
						$kata2 = "sebelas";
					} else {
						$kata2 = $kata[$angka[$i]] . " belas";
					}
				} else {
					$kata2 = $kata[$angka[$i + 1]] . " puluh";
				}
			}

			/* untuk satuan */
			if ($angka[$i] != "0") {
				if ($angka[$i + 1] != "1") {
					$kata3 = $kata[$angka[$i]];
				}
			}

			/* pengujian angka apakah tidak nol semua,
           lalu ditambahkan tingkat */
			if (($angka[$i] != "0") or ($angka[$i + 1] != "0") or
				($angka[$i + 2] != "0")
			) {
				$subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
			}

			/* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
           ke variabel kalimat */
			$kalimat = $subkalimat . $kalimat;
			$i = $i + 3;
			$j = $j + 1;
		}

		/* mengganti satu ribu jadi seribu jika diperlukan */
		if (($angka[5] == "0") and ($angka[6] == "0")) {
			$kalimat = str_replace("satu ribu", "seribu", $kalimat);
		}

		return trim($kalimat);
	}

	public static function inisial($str)
	{
		if(empty($str)) return 'AA';
		$words = explode(' ', $str);
        if (count($words) >= 2) {
            $str =  mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') . 
                mb_substr(end($words), 0, 1, 'UTF-8'), 
            'UTF-8');
        }

		preg_match_all('#([A-Z]+)#', $str, $capitals);
		if (count($capitals[1]) >= 2) {
			$str = mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
		}
		$str = mb_strtoupper(mb_substr($str, 0, 2, 'UTF-8'), 'UTF-8');

		return $str;
	}
	
}
