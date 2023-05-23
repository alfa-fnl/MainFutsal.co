<?php 
$con = mysqli_connect($hostname,$username,$password,$database) or die("Connection Corrupt");
$rg = new lsp();
$function = new lsp();

class User {
	private $email;
	private $password;

	public function login($email,$password){
            global $con;
            
            $sql = "SELECT * FROM table_user WHERE email ='$email'";
            $query = mysqli_query($con,$sql);
            $rows  = mysqli_num_rows($query);
            $assoc = mysqli_fetch_assoc($query);
            if($rows > 0){
                if(base64_decode($assoc['password']) == $password){
                    return ['response'=>'positive','alert'=>'Berhasil Login','level'=>$assoc['level']];
                }else{
                    return ['response'=>'negative','alert'=>'Password Salah'];    
                }
            }else{
                
                return ['response'=>'negative','alert'=>'Email atau Password Salah'];
            }
        }

	public function logout(){
            session_destroy();
            header("Location:index.php");
    }
}

class Customer extends User {
	public $username;
	public $noTelpon;

	public function daftarAkun($email,$username,$password,$level,$noTelpon){
            
            global $con;
            global $rg;
            
            if($email == " " || empty($email) || $username == " " || empty($username) || $password == " " || empty($password) || $level == " " || empty($level) || $noTelpon == " " || empty($noTelpon){
                return ['response'=>'negative','alert'=>'Lengkapi Form'];
            }
            
            $sql     = "SELECT * FROM table_user WHERE username = '$username'";
            $query   = mysqli_query($con,$sql);
            $rows    = mysqli_num_rows($query);            

            
            if($rows == 0){
                
                $email     = htmlspecialchars($email);                
                $username = strtolower(htmlspecialchars($username));
                $password = htmlspecialchars($password);
                $confirm  = htmlspecialchars($confirm);
                $noTelpon = htmlspecialchars($noTelpon);
                
                if($password == $confirm){
                    $password = base64_encode($password);
                    $sql = "INSERT INTO table_user VALUES('$email','$username','$password','$level', '$noTelpon')";
                    $query   = mysqli_query($con,$sql);
                    if($query){
                        return ['response'=>'positive','alert'=>'Registrasi Berhasil','redirect'=>$redirect];
                    }else{
                        
                        return ['response'=>'negative','alert'=>'Registrasi Error'];
                    }
                }else{
                    
                    return ['response'=>'negative','alert'=>'Password Tidak Cocok'];
                }
            
            }else if($rows == 1){
                
                return ['response'=>'negative','alert'=>'Email telah digunakan'];
            }
	}

	public function updateProfil($table,$values,$where,$whereValues,$redirect){
            global $con;
            $sql   = "UPDATE $table SET $values WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
                if($query){
                    return ['response'=>'positive','alert'=>'Berhasil update data','redirect'=>$redirect];
                }else{
                    echo mysqli_error($con);
                    return ['response'=>'negative','alert'=>'Gagaal Update Data'];
                }
        }
}

class Manager extends User {
	private $username;

	public function updateLapangan($table,$values,$where,$whereValues,$redirect){
            global $con;
            $sql   = "UPDATE $table SET $values WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
                if($query){
                    return ['response'=>'positive','alert'=>'Berhasil update data','redirect'=>$redirect];
                }else{
                    echo mysqli_error($con);
                    return ['response'=>'negative','alert'=>'Gagaal Update Data'];
                }
        }
}

class Lapangan {
	private $nama;
	private $alamat;
	private $fasilitas;
	private $harga;

	public function addLapangan($table, $values, $redirect){
    		global $con;
    		$sql   = "INSERT INTO $table VALUES($values)";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menambahkan Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menambahkan Data'];
            }
    	}

 public function delete($table,$where,$whereValues,$redirect){
            global $con;
            $sql = "DELETE FROM $table WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menghapus Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menghapus Data'];
            }
        }

	public function searchLapangan($keyword)
	{
		$sql = "SELECT * FROM $table WHERE $where LIKE '%$keyword%'";
		$query = mysqli_query($con,$sql);

		if (mysqli_num_rows($query) == 0) {
        return array();
    }
    
    $hasil_pencarian = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $hasil_pencarian[] = $row;
    }

    return $hasil_pencarian;
	}
}

class Pesanan {
	private $pesananID;
	private $hargaTotal;
	private $waktuPemesanan;
}

class Keranjang {
	private $keranjangID;

	public function addKeranjang($table, $values, $redirect){
    		global $con;
    		$sql   = "INSERT INTO $table VALUES($values)";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menambahkan Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menambahkan Data'];
            }
    	}

	public function deleteKeranjang($table,$where,$whereValues,$redirect){
            global $con;
            $sql = "DELETE FROM $table WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menghapus Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menghapus Data'];
            }
        }
}

class Jadwal {
	private $tanggal;
	private $jam;
	private $durasi;

	public function addJadwal($table, $values, $redirect){
    		global $con;
    		$sql   = "INSERT INTO $table VALUES($values)";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menambahkan Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menambahkan Data'];
            }
    	}

	public function deleteJadwal($table,$where,$whereValues,$redirect){
            global $con;
            $sql = "DELETE FROM $table WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menghapus Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menghapus Data'];
            }
        }
}

class LapanganFavorit {
	private $favoriteID;

	public function addFavorit($table, $values, $redirect){
    		global $con;
    		$sql   = "INSERT INTO $table VALUES($values)";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menambahkan Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menambahkan Data'];
            }
    	}

	public function deleteFavorit($table,$where,$whereValues,$redirect){
            global $con;
            $sql = "DELETE FROM $table WHERE $where = '$whereValues'";
            $query = mysqli_query($con,$sql);
            if($query){
                return ['response'=>'positive','alert'=>'Berhasil Menghapus Data','redirect'=>$redirect];
            }else{
                echo mysqli_error($con);
                return ['response'=>'negative','alert'=>'Gagal Menghapus Data'];
            }
        }
}
?>