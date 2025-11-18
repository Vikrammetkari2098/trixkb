<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Reset Password - trixflow</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Nunito.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Roboto.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @livewireStyles
</head>
<body class="d-flex justify-content-center align-items-center pt-5 pb-5" style="min-height: 100vh;">
    <div class="container container-sign-in container-signin my-5">
        <div class="card shadow">
            <div class="card-body px-5 py-5 pt-3">
                <div class="row mb-1">
                    <div class="col text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-badge-right-filled"
                             style="font-size: 50px;color: rgb(27,183,204);">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z"
                                  stroke-width="0" fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
                <h4 class="card-title mb-1 text-center fw-bold">
                    <em><span style="color: rgb(13, 67, 141);">TRIXPM</span></em>
                </h4>
                <p class="fw-semibold mb-3 text-center" style="font-size: 13px;">
                    Enter your new password to reset your account
                </p>
                <livewire:auth.reset-password-form />
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/bs-init.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    @livewireScripts
</body>
</html>
