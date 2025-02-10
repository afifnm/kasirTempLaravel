@extends('app')
@section('title','Transaction Page')
@section('content')
<div class="grid grid-cols-12 gap-6 mt-10">
    <div class="intro-y col-span-3">
        <!-- BEGIN: Keranjang -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Select product to cart
                </h2>
            </div>
            <div class="p-5">
                <form id="keranjangForm" action="" method="post">
                    @csrf
                    <input type="hidden" name="kode_penjualan" value="">
                    <div class="preview">
                        <div class="mt-1">
                            <label>Invoice</label>
                            <input type="text" class="input w-full border mt-2 bg-gray-100" value="#{{ $invoice }}" disabled>
                        </div>
                        <div class="mt-5">
                            <label>Product</label>
                            <select class="select2 w-full border mt-2 bg-gray-100" name="barcode2" id="product">
                                <option value="">Select Product</option>
                                @foreach($products as $aa)
                                    <option data-id="{{ $aa['id'] }}">
                                        {{ $aa['name'] }} - ({{ $aa['stock'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Tambahkan CSRF Token -->
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="mt-5">
                            <label>Scan Barcode</label>
                            <input type="text" class="input w-full border mt-2 bg-gray-100" name="barcode" id="barcode" autofocus>
                        </div>                        
                    </div>
                </form>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    // Event listener untuk input barcode
                    $('#barcode').keypress(function(e) { // Mengecek apakah tombol yang ditekan adalah Enter (kode 13)
                        if (e.which == 13) {
                            var barcode = $(this).val(); // Ambil nilai barcode yang dimasukkan
                            if (barcode) {
                                $.ajax({
                                    url: "{{ route('transaction.addcartBarcode') }}", // Ganti dengan route yang sesuai untuk menambah ke keranjang
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        barcode: barcode
                                    },
                                    success: function(response) {
                                        // Menampilkan pesan sukses menggunakan SweetAlert2
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Product added successfully',
                                            text: response.message,
                                            confirmButtonText: 'OK'
                                        });
                                        loadCart(); // Memuat ulang tabel keranjang tanpa refresh
                                        $('#barcode').val(''); // Kosongkan input setelah submit
                                    },
                                    error: function(xhr) {
                                        // Menampilkan error jika gagal
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Failed to add product',
                                            text: 'An error occurred, try again.',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            } else {
                                // Jika barcode kosong
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Invalid barcode',
                                    text: 'Please enter a valid barcode.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                    $(document).ready(function() {
                        $('#product').change(function() {
                            var productId = $(this).find(':selected').data('id');
                            if (productId) {
                                $.ajax({
                                    url: "{{ route('transaction.addcart') }}", 
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        product_id: productId
                                    },
                                    success: function(response) {
                                        loadCart(); // Memuat ulang tabel keranjang tanpa refresh
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Failed to add product',
                                            text: 'An error occurred, try again.',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }
                        });
                    });
                    // Fungsi untuk merefresh tabel keranjang
                    function loadCart() {
                        $.ajax({
                            url: "{{ route('cart.list') }}",
                            method: "GET",
                            success: function(data) {
                                $('#cartTable').html(data);
                            },
                            error: function(xhr, status, error) {
                                console.error("XHR Response:", xhr.responseText);
                                console.error("Status:", status);
                                console.error("Error:", error);

                                Swal.fire({
                                    title: 'Terjadi Kesalahan',
                                    text: `Error ${xhr.status}: ${xhr.statusText}`,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                </script>
            </div>
        </div>
        <!-- END: Keranjang -->
    </div>

    <div class="intro-y col-span-9">
        <!-- BEGIN: Bayar -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Product selected
                </h2>
            </div>
            <div class="p-5">
                <div id="cartTable">
                    @include('partials.cart')
                </div>
            </div>
        </div>
        <!-- END: Bayar -->
    </div>
    
@endsection
