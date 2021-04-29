@extends('layouts.base') @section('title', '| Login') @section('head') @parent
<link href="assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" /> @endsection @section('body')
<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(images/blue-geo.png);background-size: cover; background-position: top center;">

                <img style="margin: 0 auto;display: block;position: relative;width: 95%;max-width: 200px;margin-top: 20px;" class="aligncenter" src="/images/title.png" alt="intelipag" />

                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="width: 100%;min-width: 300px;max-width: 400px;">
                    <div class="kt-portlet loginPortlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label" style="margin: auto">
                                <h2 class="kt-portlet__head-title">
                                    Login
                                </h2>
                            </div>
                        </div>

                        <!--begin::Form-->
                        <form method="POST" action="{{ route('login') }}" class="kt-form kt-form--fit kt-form--label-right">
                            @csrf
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first" style="margin-bottom:0">
                                    @if(session()->has('error'))
                                    <div class="form-group">
                                        <span class="kt-font-danger">
                                            {{ session()->get('error') }}
                                        </span>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input id="username" type="input" class="form-control" name="username" required autofocus> @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password:</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <button style="width:100%" type="submit" class="btn btn-pill btn-brand radius login">LOGIN</button>
                                    </div>
                                    <div class="form-group">
                                        <a href="/register" style="width:100%" class="btn btn-pill btn-brand radius login">SIGN UP</a>
                                    </div>
                                    <!-- <div class="form-group">
                                            <center><a href="/password/reset" class="resetPassword">Forgot Password</a></center>
                                        </div> -->
                                </div>
                            </div>
                        </form>

                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": [
                        "#c5cbe3",
                        "#a1a8c3",
                        "#3d4465",
                        "#3e4466"
                    ],
                    "shape": [
                        "#f0f3ff",
                        "#d9dffa",
                        "#afb4d4",
                        "#646c9a"
                    ]
                }
            }
        };
    </script>

    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Scripts(used by this page) -->
    <script src="assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>

    <!--end::Page Scripts -->
</body>

<!-- end::Body -->
@endsection