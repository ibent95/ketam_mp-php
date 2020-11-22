(function($) {
    'use strict';

    var browserWindow = $(window);

    // :: 1.0 Preloader Active Code
    browserWindow.on('load', function() {
        $('#preloader').fadeOut('slow', function() {
            $(this).remove();
        });
    });

    // :: 2.0 Newsticker Active Code
    $.simpleTicker($("#breakingNewsTicker"), {
        speed: 1250,
        delay: 3500,
        easing: 'swing',
        effectType: 'roll'
    });

    // :: 3.0 Nav Active Code
    if ($.fn.classyNav) {
        $('#deliciousNav').classyNav();
    }

    // :: 4.0 Search Active Code
    var searchwrapper = $('.search-wrapper');
    $('.search-btn').on('click', function() {
        searchwrapper.toggleClass('on');
    });
    $('.close-btn').on('click', function() {
        searchwrapper.removeClass('on');
    });

    // :: 5.0 Sliders Active Code
    if ($.fn.owlCarousel) {
        var welcomeSlide = $('.hero-slides');
        var receipeSlide = $('.receipe-slider');

        welcomeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            nav: true,
            navText: ['Prev', 'Next'],
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });

        welcomeSlide.on('translate.owl.carousel', function() {
            var slideLayer = $("[data-animation]");
            slideLayer.each(function() {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        welcomeSlide.on('translated.owl.carousel', function() {
            var slideLayer = welcomeSlide.find('.owl-item.active').find("[data-animation]");
            slideLayer.each(function() {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });

        $("[data-delay]").each(function() {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function() {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        var dot = $('.hero-slides .owl-dot');
        dot.each(function() {
            var index = $(this).index() + 1 + '.';
            if (index < 10) {
                $(this).html('0').append(index);
            } else {
                $(this).html(index);
            }
        });

        receipeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            nav: true,
            navText: ['Prev', 'Next'],
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });
    }

    // :: 6.0 Gallery Active Code
    if ($.fn.magnificPopup) {
        $('.videobtn').magnificPopup({
            type: 'iframe'
        });
    }

    // :: 7.0 ScrollUp Active Code
    if ($.fn.scrollUp) {
        browserWindow.scrollUp({
            scrollSpeed: 1500,
            scrollText: '<i class="fa fa-angle-up"></i>'
        });
    }

    // :: 8.0 CouterUp Active Code
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

    // :: 9.0 nice Select Active Code
    if ($.fn.niceSelect) {
        $('select').niceSelect();
    }

    // :: 10.0 wow Active Code
    if (browserWindow.width() > 767) {
        new WOW().init();
    }

    // :: 11.0 prevent default a click
    $('a[href="#"]').click(function($) {
        $.preventDefault()
    });

    $('#modal_chart_add').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var proses = button.data('act');
        var modal = $(this);
        console.log(proses);
        if (proses === "cart_add") {
            modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add");
        } else if (proses === "order_item") {
            modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add&go=pemesanan_form");
        } else {

        }
        modal.find('.modal-body input#id').val(id);
        $.ajax({
            type: "GET",
            url: "functions/function_responds.php?content=modal_cart_barang",
            data: {
                id: id,
                data: "nama_barang"
            },
            dataType: "html",
            success: function(response) {
                // console.log(response);
                modal.find('.modal-body input#nama_barang').val(response);
            }
        });
        $.ajax({
            type: "GET",
            url: "functions/function_responds.php?content=modal_cart_barang",
            data: {
                id: id,
                data: "harga"
            },
            dataType: "html",
            success: function(response) {
                // console.log(response);
                modal.find('.modal-body input#harga').val(parseInt(response));
                modal.find('.modal-body input#jumlah_harga').val(parseInt(response));
            }
        });
        $.ajax({
            type: "GET",
            url: "functions/function_responds.php?content=modal_cart_barang",
            data: {
                id: id,
                data: "stok"
            },
            dataType: "html",
            success: function(response) {
                // console.log(response);
                modal.find('.modal-body input#kuantitas').attr("max", parseInt(response));
            }
        });
        // modal.find('.modal-title').text('New message to ' + recipient);
    });

    $('#modal_chart_update_item').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama = button.data('nama');
        var harga = button.data('harga');
        var kuantitas = button.data('kuantitas');
        var maxKuantitas = button.data('maxkuantitas');
        var jumlahHarga = button.data('jh');
        // console.log(parseInt(button.data('jh')));
        var proses = button.data('act');
        var modal = $(this);
        console.log(proses);
        if (proses === "cart_add") {
            modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add");
        } else if (proses === "order_item") {
            modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add&go=pemesanan_form");
        } else {
            modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=cart_update_item");
        }
        modal.find('.modal-body input#id').val(id);
        modal.find('.modal-body input#nama_barang').val(nama);
        modal.find('.modal-body input#harga').val(parseInt(harga));
        modal.find('.modal-body input#kuantitas').val(parseInt(kuantitas));
        modal.find('.modal-body input#kuantitas').attr("max", parseInt(maxKuantitas));
        modal.find('.modal-body input#jumlah_harga').val(parseInt(jumlahHarga));
        
    });

    $('body').on('change click', 'input#kuantitas', function(event) {
        var harga = parseInt($('input#harga').val());
        var kuantitas = parseInt($(this).val());
        var jumlah_harga = kuantitas * harga;
        $('input#jumlah_harga').val(parseInt(jumlah_harga));
    });

    $('#tanggal, #tanggal_pesan, #tanggal_kerja, #tanggal_awal, #tanggal_akhir, #tanggal_pengantaran').Zebra_DatePicker();

    $('input#tanggal').Zebra_DatePicker({
        onOpen: function() {
            var dateRaw = new Date();
            var dateNow = new Date(dateRaw.getFullYear(), dateRaw.getMonth(), dateRaw.getDate(), dateRaw.getHours(), dateRaw.getMinutes(), 0, 0);
            $(this).data('Zebra_DatePicker').set_date(dateNow);
        }
    });

    $('body').on('change load', 'input#diantarkan', function() {
        if ($(this).is(":checked")) {
            $('div#form-pengantaran').show(250);
            akumulasiHargaPengantaran("+");
        } else {
            $('div#form-pengantaran').hide(250);
            akumulasiHargaPengantaran("-");
        }
    });

    if ($('input#diantarkan').is(":checked")) {
        $('div#form-pengantaran').show(250);
        akumulasiHargaPengantaran("+");
    }

})(jQuery);