<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Webpixels">
    <title>Dashboard - Klaim Hadiah</title>
    <!-- Preloader -->
    <style>
        @keyframes hidePreloader {
            0% {
                width: 100%;
                height: 100%;
            }

            100% {
                width: 0;
                height: 0;
            }
        }

        body>div.preloader {
            position: fixed;
            background: white;
            width: 100%;
            height: 100%;
            z-index: 1071;
            opacity: 0;
            transition: opacity .5s ease;
            overflow: hidden;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body:not(.loaded)>div.preloader {
            opacity: 1;
        }

        body:not(.loaded) {
            overflow: hidden;
        }

        body.loaded>div.preloader {
            animation: hidePreloader .5s linear .5s forwards;
        }

        #navbar-logo {
            width: 150px;
            height: auto;
        }
    </style>
    <script>
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.querySelector('body').classList.add('loaded');
            }, 300);
        });
    </script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- Quick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/quick-website.css') }}" id="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Go Pro -->
    <a href="javascript:;" class="btn btn-block btn-dark text-truncate rounded-0 py-2 d-none d-lg-block" style="z-index: 1000;">
        <strong>Selamat datang.</strong> Klaim hadiah anda sekarang.
    </a>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="Image placeholder" src="{{ asset('img/logo.png') }}" id="navbar-logo">
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mt-4 mt-lg-0 ml-auto">

                </ul>
                <!-- Button -->
                <a class="navbar-btn btn btn-sm btn-primary d-lg-inline-block ml-3" href="{{ route('dashboard.logout') }}">
                    Keluar
                </a>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <section class="slice slice-lg pb-0 pb-lg-6 bg-section-secondary">
        <div class="container">
            <!-- Title -->
            <!-- Section title -->
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-6">
                    <span class="badge badge-soft-success badge-pill badge-lg mb-3">
                        Form Klaim
                    </span>
                    <br>
                    @if($tes->count() > 0)

                    @if ($image = Session::get('image'))
                        @foreach($image as $data)
                        <a href="{{ asset('img/certificate/'.$data) }}" download class="btn btn-block btn-info rounded-0 py-2 mt-5" style="z-index: 1000;">
                            <strong>Download Sertifikat</strong>
                        </a>
                        <img src="{{ asset('img/certificate/'.$data) }}" alt="sertifikat" class="img-fluid">
                        @endforeach
                    @else
                    <form action="{{ url('/generate-certificate') }}" method="post">
                        @csrf
                        <input type="hidden" name="nama_lengkap" id="nama_lengkap" value="{{ auth()->user()->user_firstname }}">
                        <button type="submit" class="btn btn-block btn-info rounded-0 py-2 mt-5" style="z-index: 1000;">
                            <strong>Sertifikat tersedia.</strong> Klik disini untuk generate sekarang.
                        </button>
                    </form>
                    @endif

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-5">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block mt-5">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <form id="form-klaim" class="mt-5" method="POST" action="{{ url('/claim') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Nama Lengkap</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="input-nama" placeholder="Nama Lengkap" name="nama" value="{{ auth()->user()->user_firstname }}" required>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Email</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="mail"></i></span>
                                </div>
                                <input type="email" class="form-control" id="input-email" placeholder="Email" name="email" value="{{ auth()->user()->user_email }}" required>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">No. WA</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="phone"></i></span>
                                </div>
                                <input type="number" class="form-control" id="input-wa" placeholder="No. Whatsapp" name="wa" required>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Provinsi</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="home"></i></span>
                                </div>
                                <select name="id_propinsi" id="propinsi" class="form-control" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($propinsi as $pv)
                                        <option value="{{$pv->id_propinsi}}">{{$pv->nama_propinsi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Kabupaten / Kota</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="home"></i></span>
                                </div>
                                <select name="id_kotakab" id="kotakab" class="form-control" required>
                                    <option value="">Pilih Kab/Kota</option>
                                    
                                </select>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Kecamatan</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="home"></i></span>
                                </div>
                                <select name="id_kecamatan" id="kecamatan" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    
                                </select>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Alamat</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="home"></i></span>
                                </div>
                                <textarea name="alamat" class="form-control" id="input-alamat" cols="30" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Pilih Paket Klaim / Mapel</label>
                                </div>
                            </div>
                            <div id="accordion" class="text-left">
                                @foreach($tes as $key => $value)
                                <div class="card">
                                    <div class="w-100" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                        <h5 class="mb-0 btn btn-link">
                                            {{$value->tes_nama}}
                                        </h5>
                                    </div>

                                    <div id="collapse{{$key}}" class="collapse {{ ($loop->first) ? 'show' : '' }}" data-parent="#accordion">
                                        <div class="card-body">
                                            @foreach($paket as $pkt)
                                                <div class="form-check pt-1">
                                                    <input class="form-check-input" type="radio" name="paket{{$key}}" data-tes="{{$value->tes_nama}}" data-key="{{$key}}" data-paket="{{ $pkt->nama_paket }}" data-harga="{{ $pkt->harga }}" value="{{ $pkt->nama_paket }}">
                                                    <label class="form-check-label"><h6>PAKET {{ $pkt->nama_paket }} (Rp {{ number_format($pkt->harga, 0, ".", ".") }})</h6></label>
                                                    <p class="justify">{{ $pkt->deskripsi }}</p>
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-8" style="text-align: right !important;">
                                <h6>ITEM : </h6>
                                <h6>ONGKIR : </h6>
                                <h6>DISKON : </h6>
                                <h6>TOTAL : </h6>
                            </div>
                            <div class="col-4">
                                <h6 id="item">Rp 0</h6>
                                <h6 id="ongkir">Rp 0</h6>
                                <h6 id="diskon">Rp {{ number_format(Auth::user()->discount_claim, 0, ".", ".") }}</h6>
                                <h6 id="total">Rp 0</h6>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Transfer ke (A.n Ahmad Qomaruddin)</label>
                                </div>
                            </div>
                            <div class="h6" style="text-align: left !important;">
                                <div>BCA 6595599699</div>
                                <div>DANA 085215090131</div>
                                <div>GOPAY 085215090131</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Upload Bukti Transfer (Maks. 2 MB)</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="file" class="form-control" name="bukti" id="bukti" required>
                            </div>
                            <div class="form-text text-danger"></div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">Catatan</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="tinggalkan catatan jika ada"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="item_val" id="item_val" value="0">
                        <input type="hidden" name="ongkir_val" id="ongkir_val" value="0">
                        <input type="hidden" name="" id="ongkir_val2">
                        <input type="hidden" name="diskon_val" id="diskon_val" value="{{ Auth::user()->discount_claim }}">
                        <input type="hidden" name="total_val" id="total_val" value="0">
                        <input type="hidden" name="detail_paket" id="detail_paket">
                        <input type="hidden" name="" id="include_ongkir">

                        <div class="mt-4">
                            <button type="submit" id="btn-submit-klaim" class="btn btn-block btn-primary">Klaim</button>
                        </div>
                    </form>
                    @else
                        <h6 class="mt-5">Tidak ada olimpiade yang diikuti.</h6>
                        <img src="{{ asset('img/logo.png') }}" class="img-fluid">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <footer class="position-relative" id="footer-main">
        <div class="footer pt-lg-7 footer-dark bg-dark">
            <!-- SVG shape -->
            <div class="shape-container shape-line shape-position-top shape-orientation-inverse">
                <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class=" fill-section-secondary">
                    <polygon points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <!-- Footer -->
            <div class="container pt-4">
                <hr class="divider divider-fade divider-dark my-4">
                <div class="row align-items-center justify-content-md-between pb-4">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            &copy; 2022 <a href="https://gypem.com" class="font-weight-bold" target="_blank">Gypem</a>. All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Core JS  -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/svg-injector/dist/svg-injector.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <!-- Quick JS -->
    <script src="{{ asset('assets/js/quick-website.js') }}"></script>
    <script src="{{ asset('js/dashboard.js' . '?time=' . date("Ymdhisu")) }}"></script>

    <!-- Feather Icons -->
    <script>
        feather.replace({
            'width': '1em',
            'height': '1em'
        })
    </script>
</body>

</html>