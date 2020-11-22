<!-- Modal -->
<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="ubah_password_label"
    aria-hidden="true"
    id="modal_change_password"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubah_password_label">Form Ubah Password</h5>
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
                    name="frmChange"
                    method="POST"
                    action="?content=profil&proses=ganti-password"
                    onSubmit="return validatePassword()"
                >
                    <!-- Pesan -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Password Lama</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="currentPassword"/>
                            <span id="currentPassword"  class="required"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Password Baru</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="newPassword"/>
                            <span id="newPassword" class="required"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="confirmPassword"/>
                            <span id="confirmPassword" class="required"></span>
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