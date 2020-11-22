<!-- Modal -->
<div
    class="modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="ubah_password_label"
    aria-hidden="true"
    id="modal_change_password"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubah_password_label">Form Ubah Password</h5>
                <button
                    class="btn-lg close"
                    data-dismiss="modal"
                    aria-label="Close"
                    style="margin-top: 0; margin-bottom: 0; padding-top: 6px; padding-bottom: 2px;" 
                >
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="frmChange" method="POST" action="?content=profil_pengguna&proses=ganti-password" onSubmit="return validatePassword()">
                    <!-- Pesan -->

                    <div class="form-group">
                        <label class="control-label col-md-3">Password Lama</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="currentPassword"/>
                            <span id="currentPassword"  class="required"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Password Baru</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="newPassword"/>
                            <span id="newPassword" class="required"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Konfirmasi Password</label>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="confirmPassword"/>
                            <span id="confirmPassword" class="required"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>