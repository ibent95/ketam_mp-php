<?php

	include '../load_files.php';

	$content = (isset($_GET['content'])) ? antiInjection($_GET['content']) : NULL ;

	$respond = "";

	switch ($content) {
		case 'filter_barang':
			$page 			= (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			$record_count 	= (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : 12 ;
			$id_kategori 	= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : "" ;
            $harga1 		= (isset($_POST['harga1']) and $_POST['harga1'] != '0') ? $_POST['harga1'] : null ;
            $harga2 		= (isset($_POST['harga2']) and $_POST['harga2'] != '0') ? $_POST['harga2'] : null ;
            $harga3 		= (isset($_POST['harga3']) and $_POST['harga3'] != '0') ? $_POST['harga3'] : null ;
            $harga4 		= (isset($_POST['harga4']) and $_POST['harga4'] != '0') ? $_POST['harga4'] : null ;
			$result 		= getFilteredBarangAllLimit($id_kategori, $harga1, $harga2, $harga3, $harga4, $page, $record_count);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<div class='col-md-12'>
						<p>Barang tidak ditemukan..!</p>
					</div>
				";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<div class='col-md-4'>
							<div class='single-best-receipe-area mb-30'>
								<a href='" . $csv::$URL_BASE ."/?content=data_barang&id=$data[0]'>
									<img
										src='";
					$respond .= searchFile($data['url_foto'], 'img', 'full');
					$respond .= "'
										alt='$data[nama_barang]'
									>
									<div class='receipe-content'>
										<h5>$data[nama_barang]</h5>
									</div>
								</a>
							</div>
						</div>
					";
				}
			}
			break;
		case 'select_id_barang':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getBarangByIdKategori($id, 'ASC');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<option value=''>-- Silahakan Pilih Kategori Terlebih Dahulu --</option>
				";
			} else {
				$respond .= "
					<option value=''>-- Silahkan Pilih Barang --</option>
				";
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<option value='$data[id_barang]'>$data[nama_barang]</option>
					";
				}
			}
			break;
		case 'search_data_pengguna':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPenggunaByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='7'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[id]</td>
							<td>
								<button
                                    type='button'
                                    class='btn btn-link' data-toggle='modal' data-target='#pengguna_detail'
                                >
                                    $data[nama_lengkap]
                                </button>
							</td>
							<td>$data[alamat]</td>
							<td>$data[no_hp]</td>
							<td>$data[jenis_akun]</td>
							<td>";
					$respond .= setBadges($data['status_akun'], 'success') . "
							</td>
							<td>
					";
					$respond .= "
                                <button
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal'
                                    data-target='#modal_detail_pengguna'
                                    data-id='$data[id]'
                                    data-content='data_pengguna'
                                    id='detail_pengguna'
                                >
                                    Rincian
                                </button>
					";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$respond .= "
								<a
									class='btn btn-primary btn-sm'
									href='?content=data_pengguna_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a
									class='btn btn-danger btn-sm'
									href='?content=data_pengguna_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
						";
					}
					$respond .= "
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_kategori':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchKategoriByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='2'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[nama_kategori]</td>
							<td>
								<a
									class='btn btn-primary btn-sm'
									href='?content=data_kategori_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a
									class='btn btn-danger btn-sm'
									href='?content=data_kategori_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?');\"
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_barang':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchBarangByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='4'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[nama_barang]</td>
							<td>$data[nama_kategori]</td>
							<td class='text-right'>
					";
					$respond .=	format($data['harga'], 'currency');
					$respond .= "
							</td>
							<td>
								<a
									class='btn btn-primary btn-sm'
									href='?content=data_barang_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a
									class='btn btn-danger btn-sm'
									href='?content=data_barang_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?');\"
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_barang':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : 12 ;
			$key_word = (isset($_POST['kata_kunci'])) ? antiInjection($_POST['kata_kunci']) : "" ;
			$id_kategori = (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : "" ;
			$result = getSearchBarangAllLimit($key_word, $id_kategori, $page, $record_count);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<div class='col-md-12'>
						<p>Barang tidak ditemukan..!</p>
					</div>
				";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<div class='col-md-4'>
							<div class='single-best-receipe-area img-thumbnail mb-30'>
								<a href='?content=data_barang&id=$data[0]'>
									<h6>$data[nama_barang]</h6>
								</a>
								<img
									src='";
					$respond .= searchFile("$data[url_foto]", "img", "full");
					$respond .= "'
									alt='$data[nama_barang]'
									style='height: 100%; width: 100%;'
								>
								<div class='text-left'>
									<table>
										<tbody>
											<tr>
												<td>Kategori</td>
												<td>: $data[nama_kategori]</td>
											</tr>
											<tr>
												<td>Harga</td>
												<td>: ";
					$respond .= format($data['harga'], 'currency');
					$respond .= "
												</td>
											</tr>
											<tr>
												<td>Stok</td>
												<td>: $data[stok]</td>
											</tr>
										</tbody>
									</table>
									<div class='row'>
										<div class='col-md-6'>
											<button
												type='button'
												class='
													btn
													btn-success
													btn-block
												'
												data-toggle='modal'
												data-target='#modal_chart_add'
												data-id='<?php echo $data[0]; ?>'
												data-act='cart_add'
												id='cart-add'
												style='width: 100%;'";
					$respond .= ($data['stok'] < 1) ? "disabled" : "" ;
					$respond .= "
											>
												<i class='fa fa-cart-plus'></i>
											</button>
										</div>
										<div class='col-md-6'>
											<button
												type='button'
												class='
													btn 
													btn-primary
													btn-block
												'
												data-toggle='modal'
												data-target='#modal_chart_add'
												data-id='<?php echo $data[0]; ?>'
												data-act='order_item'
												id='order-item'";
					$respond .= ($data['stok'] < 1) ? "disabled" : "" ;
					$respond .= "
											>
												<i class='fa fa-handshake'></i>
												Order
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					";
				}
			}
			break;
		case 'search_pemesanan':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = ($_SESSION['jenis_akun'] == 'admin') ? searchPemesananByKeyWord($key_word, 'tunggu') : searchPemesananByKeyWord($key_word, 'tunggu') ;
			if (mysqli_num_rows($result) < 1) {
				if ($_SESSION['jenis_akun'] == 'admin') {
					$respond .= "
						<tr>
							<td colspan='6'>
								<p align='center'>Hasil pencarian tidak ditemukan..!</p>
							</td>
						</tr>
					";
				} else {
					$respond .= "
						<tr>
							<td colspan='6'>
								<p align='center'>Hasil pencarian tidak ditemukan..!</p>
							</td>
						</tr>
					";
				}
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[tanggal]</td>
							<td>$data[nama_pelanggan]</td>
							<td>$data[total_harga]</td>
							<td>
					";
					$respond .= setBadges($data['diantarkan']) . "
							</td>
							<td>
					";
					$respond .= setBadges($data['status_pemesanan']) . "
							</td>
					";
					$respond .="
							<td>
					";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$respond .= "
	                            <a
	                                class='btn btn-info btn-sm'
	                                href='?content=pemesanan_form&action=ubah&id=$data[0]'
	                            >
	                                Ubah
	                            </a>
	                            <a
	                                class='btn btn-danger btn-sm'
	                                href='?content=pemesanan_proses&proses=remove&id=$data[0]'
	                                onclick='return confirm('Anda yakin ingin menghapus data ini..?');'
	                            >
	                                Hapus
	                            </a>
						";
					}
					$respond .= "
								<button
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal'
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_riwayat_proses':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'proses');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
							<tr>
								<td>$data[tanggal]</td>
								<td>$data[nama_pelanggan]</td>
								<td>$data[total_harga]</td>
								<td>
					";
					$respond .= setBadges($data['diantarkan']) . "
								</td>
								<td>
					";
					$respond .= setBadges($data['status_pemesanan']) . "
								</td>
					";
					$respond .= "
							<td>

                                <button
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal'
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_proses'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_riwayat_selesai':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'selesai');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[tanggal]</td>
							<td>$data[nama_pelanggan]</td>
							<td>$data[total_harga]</td>
							<td>
					";
					$respond .= setBadges($data['diantarkan']) . "
							</td>
							<td>
					";
					$respond .= setBadges($data['status_pemesanan']) . "
							</td>
					";
					$respond .= "
							<td>
                                <button
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal'
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_selesai'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_riwayat_batal':
			$page 			= (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count 	= (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word 		= (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'batal');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					<tr>
						<td colspan='5'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$respond .= "
						<tr>
							<td>$data[tanggal]</td>
							<td>$data[nama_pelanggan]</td>
							<td>$data[total_harga]</td>
							<td>
					";
					$respond .= setBadges($data['diantarkan']) . "
							</td>
							<td>
					";
					$respond .= setBadges($data['status_pemesanan']) . "
							</td>
					";
					$respond .= "
							<td>
                                <button
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal'
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_batal'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'get_pemesanan':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = ($_SESSION['jenis_akun'] == 'admin') ? getPemesananSubJoinAllById($id, 'tunggu') : getPemesananSubJoinAllById($id, 'proses') ;
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= ($data['longlat'] != NULL OR $data['longlat'] != "") ? $data['longlat'] : "Tidak ada Lokasi." ;
					$respond .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_pemesanan']);
					$respond .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_proses':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'proses');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[21]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_pemesanan']);
					$respond .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_selesai':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'selesai');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[21]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_pemesanan']);
					$respond .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_batal':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'batal');
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_pemesanan']);
					$respond .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna_pelanggan':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPelangganById($id);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_akun']);
					$respond .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna_teknisi':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getTeknisiById($id);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_akun']);
					$respond .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPenggunaById($id);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[jenis_akun]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$respond .= setBadges($data['status_akun']);
					$respond .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_teknisi':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getTeknisiById($id);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$respond .= "
						<form class='row'>
							<div class='col-md-9'>
								<div class='form-group row'>
									<label for='inputName' class='col-sm-3 col-form-label'>Name</label>
									<div class='col-sm-9'>
										<input type='email' class='form-control-plaintext' id='inputName' placeholder='Name' value='$data[nama_lengkap]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputNoTelp' class='col-sm-3 col-form-label'>No. Telp</label>
									<div class='col-sm-9'>
										<input type='text' class='form-control-plaintext' id='inputNoTelp' placeholder='Nomor Telepon' value='$data[no_hp]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputEmail' class='col-sm-3 col-form-label'>E-Mail</label>
									<div class='col-sm-9'>
										<input type='email' class='form-control-plaintext' id='inputEmail' placeholder='E-Mail' value='$data[email]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputAlamat' class='col-sm-3 col-form-label'>Alamat</label>
									<div class='col-sm-9'>
										<input type='text' class='form-control-plaintext' id='inputAlamat' placeholder='Alamat' value='$data[alamat]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputStatusAkun' class='col-sm-3 col-form-label'>Alamat</label>
									<div class='col-sm-9'>
					";
					$respond .= setBadges($data['status_akun']);
					$respond .= "
									</div>
								</div>
							</div>
							<div class='col-md-3'>
								<img class='content-image img-fluid img-thumbnail rounded' src='assets/img/teknisi/$data[url_foto]' id='image_gallery'>
							</div>
						</form>
					";
				// }
			}
			break;
		case 'magic-suggest_data_barang':
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchBarangByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$respond .= "
					Tidak ada data..!
				";
			} else {
				$rows = array();
				// foreach ($result as $row) {
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$rows[] = array_map("utf8_encode", $row);
				}
				// }
				$respond = json_encode($rows);
			}
			break;
		case 'change_record_count':
			// $page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			// $record_sum = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : 10 ;
			$record_sum = $_POST['record_count'];
			// class_static_value::$record_count = $record_sum;
			unset($_SESSION['record-count']);
			$_SESSION['record-count'] = $record_sum;
			$respond = $_SESSION['record-count'];
			// case 'change_record_count_data_layanan_jenis_hardware':
			// 	$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			// 	$record_sum = (isset($_GET['record_count'])) ? antiInjection($_GET['record_count']) : 10 ;
			// 	// class_static_value::$record_count = $record_sum;
			// 	$_SESSION['record-count'] = $record_sum;
			// 	$respond .= $_SESSION['record-count'];
			// 	break;
			// case 'change_record_count_data_layanan_jenis_software':
			// 	$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			// 	$record_sum = (isset($_GET['record_count'])) ? antiInjection($_GET['record_count']) : 10 ;
			// 	// class_static_value::$record_count = $record_sum;
			// 	$_SESSION['record-count'] = $record_sum;
			// 	$respond .= $_SESSION['record-count'];
			break;
		case 'set_status_pemesanan':
			$id 	= $_POST['id'];
			$status = $_POST['status_pemesanan'];
			$result = mysqli_query($koneksi, "
				UPDATE `data_pemesanan`
				SET `status_pemesanan` = '$status'
				WHERE `id` = '$id'
			");
			$responf = ($result) ? "success" : "error" ;
			break;
		case 'modal_cart_barang':
			$result = getBarangById($_GET['id']);
			$filter = $_GET['data'];
			$data = mysqli_fetch_array(
				$result, 
				MYSQLI_BOTH
			);
			if ($filter == "nama_barang") {
				$respond = "$data[nama_barang]";
			} elseif ($filter == "harga") {
				$respond = "$data[harga]";
			} elseif ($filter == "stok") {
				$respond = "$data[stok]";
			} elseif ($filter == "url_foto") {
				$respond = "$data[url_foto]";
			}
			break;
		case NULL:
			$respond = 'NULL';
			break;
		default:
			$respond = "Respon untuk konten $content belum tersedia..!";
			break;
	}
?>

<?php echo $respond; ?>