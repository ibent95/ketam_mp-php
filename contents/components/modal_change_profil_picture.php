<!-- Modal -->
<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="change_profil_picture"
    aria-hidden="true"
    id="modal_change_profil_picture"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="change_profil_picture">Form Ubah Foto Profil</h5>
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
                    action="?content=profil&proses=ganti_foto_profil"
                    method="POST"
                    name="frmChange"
                    enctype="multipart/form-data"
                >
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Foto</label>
                        <div class="col-md-9">
                            <input class="form-control" type="file" name="url_foto" placeholder="Silahkan pilih File Foto Anda..."/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-md-3 col-md-9">
                            <div class="pull-right">
                                <input
                                    type="submit"
                                    name="simpan"
                                    value="Simpan"
                                    class="btn btn-primary"
                                >
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