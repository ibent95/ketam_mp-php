<!-- Modal -->
<div 
    class="modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="modal-label" 
    aria-hidden="true"
    id="modal_detail_pengguna" 
    >
    <div class="modal-dialog " role="document">  <!-- modal-lg -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-label">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="" width="100%">
                    <tbody>
                        <tr>
                            <td width="30%">
                                Nama Lengkap
                            </td>
                            <td width="10%" align="center"> : </td>
                            <td rowspan="8" width="100%" align="left">
                                <table class="" width="100%" align="left">
                                    <tbody id="form_list" align="left">
                                        <tr>
                                            <td align="left">Belum ada data..!</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">
                                Email
                            </td>
                            <td width="10%" style="text-align: center;"> : </td>
                        </tr>
                        <tr>
                            <td width="30%">
                                No. Handphone
                            </td>
                            <td width="10%" style="text-align:center;"> : </td>
                        </tr>
                        <tr>
                            <td width="30%">
                                Alamat
                            </td>
                            <td width="10%" style="text-align: center;"> : </td>
                        </tr>
                        <tr>
                            <td width="30%">
                                Username
                            </td>
                            <td width="10%" style="text-align: center;"> : </td>
                        </tr>
                        <?php if ($content == 'data_pengguna'): ?>
                            <tr>
                                <td width="30%">
                                    Jenis Akun
                                </td>
                                <td width="10%" style="text-align: center;"> : </td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td width="30%">
                                Status Akun
                            </td>
                            <td width="10%" style="text-align: center;"> : </td>
                        </tr>
                        <tr>
                            <td width="30%">
                                Foto
                            </td>
                            <td width="10%" style="text-align: center;"> : </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>