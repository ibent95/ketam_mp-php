$(function() {
    "use strict";
    $(function() {
            $(".preloader").fadeOut();
        }),

        jQuery(document).on("click", ".mega-dropdown", function(i) {
            i.stopPropagation();
        });
    var i = function() {
        (window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 1170 ? ($("body").addClass("mini-sidebar"),
            $(".navbar-brand span").hide(),
            $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
            $(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"),
            $(".navbar-brand span").show());
        var i = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
        (i -= 70) < 1 && (i = 1), i > 70 && $(".page-wrapper").css("min-height", i + "px");
    };

    var i = function() {
        (window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 1170 ? ($("body").addClass("mini-sidebar"),
            $(".navbar-brand span").hide(), $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
            $(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"),
            $(".navbar-brand span").show());
        var i = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
        (i -= 70) < 1 && (i = 1), i > 70 && $(".page-wrapper").css("min-height", i + "px");
    };

    $(window).ready(i), $(window).on("resize", i), $(".sidebartoggler").on("click", function() {
            $("body").hasClass("mini-sidebar") ? ($("body").trigger("resize"), $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible"),
                $("body").removeClass("mini-sidebar"), $(".navbar-brand span").show()) : ($("body").trigger("resize"),
                $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
                $("body").addClass("mini-sidebar"), $(".navbar-brand span").hide());
        }),

        $(".fix-header .header").stick_in_parent({}), $(".nav-toggler").click(function() {
            $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
                $(".nav-toggler i").addClass("mdi mdi-close");
        }),

        $(".search-box a, .search-box .app-search .srh-btn").on("click", function() {
            $(".app-search").slideToggle(200);
        }), 1

    $(".floating-labels .form-control").on("focus blur", function(i) {
            $(this).parents(".form-group").toggleClass("focused", "focus" === i.type || this.value.length > 0);
        }).trigger("blur"), $(function() {
            for (var i = window.location, o = $("ul#sidebarnav a").filter(function() {
                    return this.href == i;
                }).addClass("active").parent().addClass("active");;) {
                if (!o.is("li")) break;
                o = o.parent().addClass("in").parent().addClass("active");
            }
        }),

        $(function() {
            $("#sidebarnav").metisMenu();
        }),

        $(".scroll-sidebar").slimScroll({
            position: "left",
            size: "5px",
            height: "100%",
            color: "#dcdcdc"
        }),

        $(".message-center").slimScroll({
            position: "right",
            size: "5px",
            color: "#dcdcdc"
        }),

        $(".aboutscroll").slimScroll({
            position: "right",
            size: "5px",
            height: "80",
            color: "#dcdcdc"
        }),

        $(".message-scroll").slimScroll({
            position: "right",
            size: "5px",
            height: "570",
            color: "#dcdcdc"
        }),

        $(".chat-box").slimScroll({
            position: "right",
            size: "5px",
            height: "470",
            color: "#dcdcdc"
        }),

        $(".slimscrollright").slimScroll({
            height: "100%",
            position: "right",
            size: "5px",
            color: "#dcdcdc"
        }),

        $("body").trigger("resize"), $(".list-task li label").click(function() {
            $(this).toggleClass("task-done");
        }),

        $("#to-recover").on("click", function() {
            $("#loginform").slideUp(), $("#recoverform").fadeIn();
        }),

        $('a[data-action="collapse"]').on("click", function(i) {
            i.preventDefault(), $(this).closest(".card").find('[data-action="collapse"] i').toggleClass("ti-minus ti-plus"),
                $(this).closest(".card").children(".card-body").collapse("toggle");
        }),

        $('a[data-action="expand"]').on("click", function(i) {
            i.preventDefault(), $(this).closest(".card").find('[data-action="expand"] i').toggleClass("mdi-arrow-expand mdi-arrow-compress"),
                $(this).closest(".card").toggleClass("card-fullscreen");
        }),

        $('a[data-action="close"]').on("click", function() {
            $(this).closest(".card").removeClass().slideUp("fast");
        });

    $('#tanggal, #tanggal_pesan, #tanggal_kerja, #tanggal_awal, #tanggal_akhir').Zebra_DatePicker();

    $('input#tanggal').Zebra_DatePicker({
        onOpen: function() {
            var dateRaw = new Date();
            var dateNow = new Date(dateRaw.getFullYear(), dateRaw.getMonth(), dateRaw.getDate(), dateRaw.getHours(), dateRaw.getMinutes(), 0, 0);
            $(this).data('Zebra_DatePicker').set_date(dateNow);
        }
    });

    // Select2 untuk memilih data barang
    var select2 = $('.pilih_barang').select2({
        placeholder: 'Silahkan cari barang dengan memasukan ID Barang atau Nama Barang',
        ajax: {
            url: '../functions/function_responds.php?content=magic-suggest_data_barang',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    key_word: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            kategori: item.nama_kategori,
                            text: item.nama_barang,
                            harga: item.harga
                        }
                    })
                };
            },
            cache: true
        },
        templateSelection: function(data) {
            if (!data.id) {
                return data.text;
            }
            var $formatList = $(
                '<span>' +
                '(' + data.id + ') ' + data.text +
                '</span>'
            );
            return $formatList;
        },
        templateResult: function(data) {
            if (!data.id) {
                return data.text;
            }
            var $formatList = $(
                '<span>' +
                '(' + data.id + ') ' + data.text +
                '</span>'
            );
            return $formatList;
        },
        // selectOnClose: true
    });

    $(select2).on('select2:select keypress', function(e) {
        // console.log(e.params.data);
        var html = '';
        html += '<tr>';
        html += '<td><input type="hidden" name="id_detail[]" value="NULL"><input type="text" name="item_id[]" class="form-control item_id" value="' + e.params.data.id + '" readonly  id="item_id_' + e.params.data.id + '" /></td>';
        html += '<td><input type="text" name="item_nama[]" class="form-control item_nama" value="' + e.params.data.text + '" readonly id="item_nama_' + e.params.data.id + '" /></td>';
        html += '<td><input type="number" min="1" maxlength="13" name="item_harga[]" class="form-control item_harga" value="' + e.params.data.harga + '" readonly id="item_harga_' + e.params.data.id + '" /></td>';
        html += '<td><input type="number" min="1" maxlength="13" name="item_kuantitas[]" class="form-control item_kuantitas" value="1" id="item_kuantitas_' + e.params.data.id + '" / > '; // * tambahkan attribute onChange="getJumlahHarga(' + e.params.data.id + ', ' + "'.item_jumlah_harga'" + ');" dan atau ganti paremeter pencarian class jika ingin pakai id ==> _" + e.params.data.id + "
        html += '</td>';
        html += '<td><input type="number" min="1" maxlength="13" name="item_jumlah_harga[]" class="form-control item_jumlah_harga" value="' + (1 * e.params.data.harga) + '" readonly id="item_jumlah_harga_' + e.params.data.id + '" /></td>';
        html += '<td> <button type="button" class="btn btn-danger btn-sm remove"> <i class="fas fa-times"> </i> Hapus </button> </td>';
        html += '</tr>';

        $('tbody#keranjang').append(html);
        $(this).val(null).trigger('change');
        updateTotalHarga();
    });

    $('body').on('change keypress', '.item_kuantitas', function(e) {
        var hargaBarang = parseInt($(this).closest('tr').find('.item_harga').val());
        var kuantitasBarang = parseInt($(this).closest('tr').find('.item_kuantitas').val());
        var jumlahHarga = (kuantitasBarang > 1) ? kuantitasBarang * hargaBarang : 1 * hargaBarang;
        // console.log("hargaBarang : " + hargaBarang);
        // console.log("kuantitasBarang : " + kuantitasBarang);
        // console.log("jumlahHarga : " + jumlahHarga);
        $(this).closest('tr').find('.item_jumlah_harga').val(jumlahHarga);
        updateTotalHarga();
    });

    $('body').on('click keypress', '.remove', function(e) {
        $(this).closest('tr').remove();
        updateTotalHarga();
    });

    $('body').on('change keypress', 'input#total_bayar', function(e) {
        var total_harga = parseInt($('input#total_harga').val());
        var total_bayar = ($('input#total_bayar').val()) ? parseInt($('input#total_bayar').val()) : 0;
        var total_kembali = (total_bayar > total_harga) ? total_bayar - total_harga : 0;
        if (total_kembali > 0) {
            $('input#total_kembali').val(total_kembali);
        } else {
            $('input#total_kembali').val(0);
        }
    });

    $('body').on('change', 'select#id_kategori', function(e) {
        $.ajax('../functions/function_responds.php?content=select_id_barang', {
            type: 'POST',
            data: {
                id: $(this).val()
            },
            dataType: 'html',
            success: function(html) {
                $('select#id_barang').html(html);
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // var magicsuggest = $('#magicsuggest').magicSuggest({
    //     style: 'border-color: #4680ff; ', // border-radius: 100px !important
    //     useZebraStyle: true,
    //     data: '../functions/function_responds.php?content=magic-suggest_data_barang',
    //     valueField: 'id',
    //     displayField: 'id',
    //     groupBy: 'nama_kategori',
    //     toggleOnClick: true,
    //     allowFreeEntries: false,
    //     noSuggestionText: 'Data barang dengan id : {{query}} tidak ditemukan..!',
    //     strictSuggest: true,
    //     infoMsgCls: ' alert-danger text-dark',
    //     // selectionStacked: true,
    //     selectionPosition: 'inner', // bottom | right
    //     // mode: 'remote',
    //     renderer: function(data) {
    //         return '<div class="data_barang">' +
    //             '<div class="item">(' + data.id + ') ' + data.nama_barang + '</div>' +
    //             '</div>';
    //     },
    //     // resultAsString: true,
    //     selectionRenderer: function(data) {
    //         return '<div class="item">(' + data.id + ') ' + data.nama_barang + '</div>';
    //     }
    // });

    // $(magicsuggest).on('selectionchange', function(e, cb, s) {
    //     alert(cb.getValue());
    // });
});

function updateTotalHarga() {
    var jumlahHargaAll = 0;
    var totalBayar = parseInt($('.total_bayar').val());
    var totalKembali = 0;
    $("input[name='item_jumlah_harga[]']").each(function() {
        jumlahHargaAll += parseInt($(this).val());
    });
    if (totalBayar > jumlahHargaAll) {
        totalKembali = totalBayar - jumlahHargaAll;
    }
    // console.log(jumlahHargaAll);
    $('.total_harga').val(jumlahHargaAll);
    $('.total_kembali').val(totalKembali);
}

// Functions
function refreshPageForChangeRecordCount(content) {
    var recordPerPage = $('select#record_per_page').val();
    // console.log(recordPerPage);
    $.ajax({
        url: '../functions/function_responds.php?content=change_record_count',
        // url : '/service-panggil/admin/?content=' + content,
        type: 'POST',
        // async: false,
        data: {
            record_count: recordPerPage
        },
        success: function(data) {
            // console.log(data);
            window.location.replace('/service-panggil/admin/?content=' + content);
            // window.location.location('/service-panggil/admin/?content=' + content);
        }
    });
}

function search(page, record_count, content, key_word) {
    $.ajax({
        url: '../functions/function_responds.php?content=search_' + content,
        type: 'POST',
        data: {
            page: page,
            record_count: record_count,
            key_word: key_word
        },
        success: function(data) {
            $('tbody#data_list').html(data);
            // console.log(data);
        }
    });
}

function confirmDelete(urlDelete, urlRefresh) {
    swal({
        title: 'Anda yakin ingin menghapus data ini?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value == true) {
            $.ajax({
                url: urlDelete,
                type: "GET",
                dataType: "text",
                success: function() {
                    // window.location.replace(urlRefresh);
                    refreshPage(urlRefresh);
                    // swal("Suskses!", "Data berhasil dihapus.", "success");
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                    swal("Error!", "Data tidak berhasil dihapus.", "error");
                }
            });
        }
    })
}

function refreshPage(sendURL) {
    window.location.replace(sendURL);
}

// JQuery
$('body').on('click', 'button#detail_pemesanan', function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    var content = $(this).data('content');
    console.log(id);
    $.ajax({
            url: '../functions/function_responds.php?content=get_' + content,
            type: 'POST',
            dataType: 'html',
            data: {
                id: id
            },
        }).done(function(data) {
            $('tbody#form_list').html(data);
            console.log("success");
        }).fail(function() {
            console.log("error");
        })
        // .always(function() {
        //     console.log("complete");
        // })
    ;

});

function printElement(tagClassId) {
    //Get the HTML of div
    // console.log(tagClassId);
    // console.log(document.getElementById(tagClassId).innerHTML);
    var printElements = document.getElementById(tagClassId).innerHTML;
    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the page's HTML with div's HTML only
    document.body.innerHTML =
        "<html> " +
        "<head> " +
        "<title> " +
        "</title> " +
        "</head> " +
        "<body> " +
        printElements +
        "</body> " +
        "</html> ";

    //Print Page
    window.print();

    //Restore orignal HTML
    document.body.innerHTML = oldPage;
}

$('body').on('click', 'button#detail_pengguna', function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    var content = $(this).data('content');
    console.log(id);
    $.ajax({
            url: '../functions/function_responds.php?content=get_' + content,
            type: 'POST',
            dataType: 'html',
            data: {
                id: id
            },
        }).done(function(data) {
            $('tbody#form_list').html(data);
            console.log("success");
        }).fail(function() {
            console.log("error");
        })
        // .always(function() {
        //     console.log("complete");
        // })
    ;
});

$(".pilih_toko").select2({
    placeholder: 'Silahkan Cari atau Pilih Toko...',
    minimumResultsForSearch: 5 // Infinity untuk configurasi Select2 agar tidak menampilkan searchbox / kotak pencarian
});