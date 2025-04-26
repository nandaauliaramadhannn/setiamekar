<!doctype html>
<html lang="en" class="minimal-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('template') }}/images/favicon-32x32.png" type="image/png" />

    {{-- Styles --}}
    <link href="{{ asset('template') }}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/style.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" crossorigin="anonymous">
    <link href="{{ asset('template') }}/css/pace.min.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/dark-theme.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/light-theme.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/semi-dark.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/css/header-colors.css" rel="stylesheet" />
    <title>{{ config('app.name') }} | {{ $title }}</title>
</head>
<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('layouts.header')
        @include('layouts.sidebar')

        <main class="page-content">
            @yield('content')
        </main>

        <div class="overlay nav-toggle-icon"></div>
        <a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('template') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template') }}/js/jquery.min.js"></script>
    <script src="{{ asset('template') }}/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('template') }}/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('template') }}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{ asset('template') }}/js/pace.min.js"></script>
    <script src="{{ asset('template') }}/js/app.js"></script>
    <script src="{{ asset('template') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('template') }}/js/table-datatable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Waktu Jakarta
        function updateDateTimeJakarta() {
            const options = {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const formatter = new Intl.DateTimeFormat('id-ID', options);
            const jakartaTime = formatter.format(new Date());
            const datetimeElem = document.getElementById('datetime-jakarta');
            if (datetimeElem) {
                datetimeElem.innerText = jakartaTime + ' WIB';
            }
        }
        updateDateTimeJakarta();
        setInterval(updateDateTimeJakarta, 1000);

        // Tampilkan / Sembunyikan Field Berdasarkan Keterangan
        document.addEventListener('DOMContentLoaded', function () {
            const keterangan = document.getElementById('keterangan');
            const izinFields = document.getElementById('izinFields');
            const hadirFields = document.getElementById('hadirFields');

            if (keterangan) {
                function toggleFields() {
                    if (keterangan.value === 'izin') {
                        izinFields.style.display = 'block';
                        hadirFields.style.display = 'none';
                    } else if (keterangan.value === 'hadir') {
                        izinFields.style.display = 'none';
                        hadirFields.style.display = 'block';
                    } else {
                        izinFields.style.display = 'none';
                        hadirFields.style.display = 'none';
                    }
                }
                keterangan.addEventListener('change', toggleFields);
                toggleFields();
            }
        });

        // Konfirmasi Aksi
        function confirmAction(url, action) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan " + action + " mobilitas ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ' + action + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Konfirmasi Hapus User
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "User akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

        // Live Search
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                let keyword = this.value;
                fetch(`{{ url()->current() }}?search=` + keyword)
                    .then(response => response.text())
                    .then(data => {
                        let parser = new DOMParser();
                        let html = parser.parseFromString(data, 'text/html');
                        let result = html.getElementById('mobilitas-list');
                        if (result) {
                            document.getElementById('mobilitas-list').innerHTML = result.innerHTML;
                        }
                    });
            });
        }
    </script>

    {{-- JS tambahan dari halaman child --}}
    @stack('js')
</body>
</html>
