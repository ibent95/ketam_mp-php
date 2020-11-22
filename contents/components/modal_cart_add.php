<!-- Modal -->
<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="cart_add_label"
    aria-hidden="true"
    id="modal_chart_add"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cart_add_label">Form Tambah ke Keranjang</h5>
                <button
                    class="btn-lg close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form
                    class="form-horizontal"
                    action="?content=keranjang_proses&proses=add"
                    method="POST"
                    id="item"
                >
                    <input type="hidden" name="id" id="id" />

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Barang</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="text" name="nama_barang" id="nama_barang" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Harga (Rp)</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="number" name="harga" id="harga" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kuantitas</label>
                        <div class="col-md-9">
                            <input class="form-control" type="number" name="kuantitas" id="kuantitas" min="1" value="1" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Jumlah Harga (Rp)</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="number" name="jumlah_harga" id="jumlah_harga" min="1" value="1" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-md-3 col-md-9">
                            <div class="pull-right">
                                <input
                                    class="btn btn-primary"
                                    type="submit"
                                    name="simpan"
                                    value="Simpan"
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>