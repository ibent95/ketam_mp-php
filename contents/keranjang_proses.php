<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
		$id 			= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		// }
		$nama_barang    = (isset($_POST['nama_barang'])) ? antiInjection($_POST['nama_barang']) : NULL;
		$harga          = (isset($_POST['harga'])) ? antiInjection($_POST['harga']) : NULL;
		$kuantitas      = (isset($_POST['kuantitas'])) ? antiInjection($_POST['kuantitas']) : NULL;
		$jumlah_harga   = (isset($_POST['jumlah_harga'])) ? antiInjection($_POST['jumlah_harga']) : NULL;
	}
	$redirect = (isset($_GET['go'])) ? "?content=" . $_GET['go'] . "&action=tambah" : "?content=keranjang" ;
    switch ($proses) {
		case "add":
			try {
				if (!empty($_POST["kuantitas"])) {
					$barang = mysqli_fetch_array(
						getBarangById($id),
						MYSQLI_BOTH
					);
					if ($kuantitas <= $barang['stok']) {
						$itemArray = array(
							array(
								'id' 			=> $barang["id"],
								'nama_barang' 	=> $barang["nama_barang"],
								'harga' 		=> $barang["harga"],
								'kuantitas'		=> $kuantitas,
								'jumlah_harga'	=> $jumlah_harga
							)
						);
						if (!empty($_SESSION["cart"])) {
							// if (in_array($barang["id"], array_keys($_SESSION["cart"]))) {
							$res = false;
							for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
								// echo $k['id'];
								if ($barang["id"] === $_SESSION["cart"][$i]["id"]) {
									if (empty($_SESSION["cart"][$i]["kuantitas"])) {
										$_SESSION["cart"][$i]["kuantitas"] = 0;
									}
									if (empty($_SESSION["cart"][$i]["jumlah_harga"])) {
										$_SESSION["cart"][$i]["jumlah_harga"] = 0;
									}
									$_SESSION["cart"][$i]["kuantitas"] += $_POST["kuantitas"];
									$_SESSION["cart"][$i]["jumlah_harga"] += $_POST["jumlah_harga"];
									$res = true;
								}
							}
							if ($res == false) {
								$_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
							}
						} else {
							$_SESSION["cart"] = $itemArray;
						}
						$_SESSION['message-type'] = 'success';
						$_SESSION['message-content'] = 'Data telah masuk dalam keranjang..!';
					} else {
						$_SESSION['message-type'] = "danger";
						$_SESSION['message-content'] = "Maaf, jumlah barang yang anda masukan melebihi persediaan yang ada..!";
						$redirect = "?content=daftar_barang";
					}
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			// $redirect = "?content=keranjang";
			break;
		case "remove":
			try {
				if (!empty($_SESSION["cart"])) {
                    for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
                        // for ($j=0; $j < count($_SESSION["cart"][$i]); $j++) {
                            // if (count($_SESSION["cart"]) == 1) {
                            //     unset($_SESSION["cart"]);
                            // } else {
                            	if ($id == $_SESSION["cart"][$i]["id"]) {
                                	unset($_SESSION["cart"][$i]);
                            	}
	                            if (empty($_SESSION["cart"])) {
	                                unset($_SESSION["cart"]);
	                            }
                            // }
                            
                        // }
                    }
				}
                $_SESSION['message-type'] = 'success';
                $_SESSION['message-content'] = 'Data berhasil dihapus..!';
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus";
			}
			// $redirect = "?content=keranjang";
			break;
		case "clear":
			unset($_SESSION["cart"]);
			// $redirect = "?content=keranjang";
			break;
		case "cart_update_item":
			try {
				if (!empty($_SESSION["cart"])) {
                    for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
                        // for ($j=0; $j < count($_SESSION["cart"][$i]); $j++) {
                            if ($id == $_SESSION["cart"][$i]["id"]) {
								// unset($_SESSION["cart"][$i]);
								$_SESSION["cart"][$i]["kuantitas"] 		= $_POST["kuantitas"];
                                $_SESSION["cart"][$i]["jumlah_harga"] 	= $_POST["jumlah_harga"];
                            }
                            if (empty($_SESSION["cart"])) {
                                unset($_SESSION["cart"]);
                            }
                        // }
                    }
				}
                $_SESSION['message-type'] = 'success';
                $_SESSION['message-content'] = 'Data berhasil diubah..!';
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			// $redirect = "?content=keranjang";
			break;
		default:
			# code...
			break;
	}
	echo "
		<script>
			location.replace('$redirect');
		</script>
	";
?>