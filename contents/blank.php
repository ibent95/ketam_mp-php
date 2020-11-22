<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Recipe</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="receipe-post-area section-padding-80">

    <!-- Receipe Post Search -->
    <div class="receipe-post-search mb-80">
        <div class="container">
            <form action="<?php echo class_static_value::$URL_BASE; ?>/?content=daftar_barang" method="POST">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <select name="id_kategori" id="id_kategori">
                            <option value="">Kategori Barang</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="search" placeholder="Masukan Kata Kunci Pencarian">
                    </div>
                    <div class="col-12 col-lg-3">
                        <button type="submit" class="btn delicious-btn">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Receipe Content Area -->
    <div class="receipe-content-area">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            Nama : 
                            Kategori : 
                            Stock :
                        </div>
                        <div class="col-md-3">
                            Nama : 
                            Kategori : 
                            Stock :
                        </div>
                        <div class="col-md-3">
                            Nama : 
                            Kategori : 
                            Stock :
                        </div>
                        <div class="col-md-3">
                            Nama : 
                            Kategori : 
                            Stock :
                        </div>
                        <div class="col-md-3">
                            Nama : 
                            Kategori : 
                            Stock :
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quas nobis qui repellendus nulla provident porro optio ullam impedit magnam sequi, suscipit aliquam quidem voluptatem iure molestiae alias corporis, ut non.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
