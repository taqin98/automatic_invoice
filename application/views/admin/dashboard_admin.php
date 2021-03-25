<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/icon/192x192.png">
    <link rel="preload" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:400,500,700&amp;display=swap" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>" async>
    <!-- <link rel="stylesheet" href="https://res.cloudinary.com/taqin/raw/upload/v1586263241/assets/css/style_i2j0lr.css"> -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/helper.css') ?>" async>
    <!-- <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" data-stencil-namespace="ionicons"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js" data-stencil-namespace="ionicons"></script> -->
    <!-- <link rel="manifest" href="/__manifest.json"> -->
    <style type="text/css">
        .p-5px{padding:5px}.card .card-body{padding:5px;line-height:1.4em}.bg-white{background:#fff}
        body.dark-mode-active .appHeader.scrolled.bg-primary.is-active {
            background: #16417f !important;
        }
        body.dark-mode-active .bg-primary {
            background: #16417f !important;
            color: #FFF;
        }
        body.dark-mode-active .profileBox {
            background: #16417f !important;
        }
        body.dark-mode-active .dark-mode-image {
            filter:invert(1);mix-blend-mode:screen
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .profile-head {
            display: flex;
            align-items: center;
        }
        .profile-head .avatar {
            margin-right: 16px;
        }
        .card.product-card .image {
            width: 100%;
            border-radius: 6px;
        }
        .card.product-card .card-body {
            padding: 8px;
        }

    </style>
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- App Header -->
    <div class="appHeader bg-primary scrolled is-active text-white">
        <div class="left">
            <a href="#" class="headerButton" hidden="" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <?php $this->load->view('layout/title_app'); ?>
        <div class="right">
            <a href="javascript:;" class="headerButton toggle-searchbox" hidden="">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form" hidden="">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->

    <!-- App Capsule --> <!-- Content -->
    <div id="appCapsule">
        <div class="header-large-title">
            <h4 class="subtitle">Aplikasi Automatic Invoice</h4>
        </div>
        <div class="section mt-2">
            <?php if ($this->session->flashdata('success') !== NULL) {
                ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            } else {
                echo "";
            }
            ?>
            <?php if ($this->session->flashdata('danger') !== NULL) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?php echo $this->session->flashdata('danger'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            } else {
                echo "";
            }
            ?>
            <div class="subtitle">Invoice</div>
            <div class="card">
                <ul class="listview flush transparent image-listview">
                    <li>
                        <a href="<?= base_url('pelanggan') ?>" class="item">
                            <div class="icon-box bg-primary">
                                1
                            </div>
                            <div class="in">
                                <div>Input Data Pemesan </div>
                            </div>
                            <?php
                            if ($this->db->get('tb_pelanggan')->num_rows() == 0) {
                                ?>
                                <div class="icon-box bg-danger">
                                    <ion-icon name="close-outline"></ion-icon>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="icon-box bg-success">
                                    <ion-icon name="checkmark-outline"></ion-icon>
                                </div>
                                <?php
                            }
                            ?>
                        </a>
                    </li>
                </ul>
                <ul class="listview flush transparent image-listview">
                    <li>
                        <a href="<?= base_url('product') ?>" class="item">
                            <div class="icon-box bg-primary">
                                2
                            </div>
                            <div class="in">
                                <div>Input Data Produk</div>
                            </div>
                            <?php
                            if ($this->db->get('tb_product')->num_rows() == 0) {
                                ?>
                                <div class="icon-box bg-danger">
                                    <ion-icon name="close-outline"></ion-icon>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="icon-box bg-success">
                                    <ion-icon name="checkmark-outline"></ion-icon>
                                </div>
                                <?php
                            }
                            ?>
                        </a>
                    </li>
                </ul>
                <ul class="listview flush transparent image-listview">
                    <li>
                        <a href="<?= base_url('invoice/check'); ?>" target="_blank" class="item" id="download">
                            <div class="icon-box bg-primary">
                                3
                            </div>
                            <div class="in">
                                <div>Invoice</div>
                            </div>
                            <?php
                            if ($this->db->get('tb_pelanggan')->num_rows() == 0 || $this->db->get('tb_product')->num_rows() == 0) {
                                ?>
                                <div class="icon-box bg-danger">
                                    <ion-icon name="close-outline"></ion-icon>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="in">
                                    <div>Invoice already</div>
                                </div>
                                <div class="icon-box bg-success">
                                    <ion-icon name="checkmark-outline"></ion-icon>
                                </div>
                                <?php
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!-- app footer -->

        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <?php $this->load->view('layout/menu_app'); ?>
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <!-- * App Sidebar -->

    <!-- welcome notification  -->
    <!-- * welcome notification -->
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
    <!-- Bootstrap-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- Ionicons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" async></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.0.0/dist/ionicons/ionicons.js" async></script>
    <script type="text/javascript">
        $(document).on("click", "a#download", function(){
            setTimeout(function(){
                dropAllData();
            },5000);
            console.log('click download');
        });

        function dropAllData(){
            var base_url = '<?php echo base_url() ?>';
            $.ajax({
                type: "POST",
                url: base_url + 'invoice/emptyFiles',
                success:function(res){
                    console.log('Drop Data Success');
                    location.reload();
                }
            })
        }
    </script>
</body>
</html>