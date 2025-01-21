@extends('app')
@section('title','Transaction Page')
@section('content')
<div class="grid grid-cols-12 gap-6 mt-10">
    <div class="intro-y col-span-3">
        <!-- BEGIN: Keranjang -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Pilih produk terlebih dahulu
                </h2>
            </div>
            <div class="p-5">
                <form id="keranjangForm" action="{{ route('admin.penjualan.addtemp2') }}" method="post">
                    @csrf
                    <input type="hidden" name="kode_penjualan" value="{{ $nota }}">
                    <div class="preview">
                        <div class="mt-1">
                            <input type="hidden" name="id_pelanggan" value="{{ $id_pelanggan }}">
                            <label>Pelanggan</label>
                            <input type="text" class="input w-full border mt-2 bg-gray-100" value="{{ \App\Models\Pelanggan::find($id_pelanggan)->nama }}" disabled>
                        </div>
                        <div class="mt-1">
                            <label>Nomor Nota</label>
                            <input type="text" class="input w-full border mt-2 bg-gray-100" value="#{{ $nota }}" disabled>
                        </div>
                        <div class="mt-5">
                            <label>Produk</label>
                            <select class="select2 w-full border mt-2 bg-gray-100" name="kode_produk2" id="produk" onchange="submitForm()">
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $aa)
                                    <option value="{{ $aa['kode_produk'] }}" data-stok="{{ $aa['stok'] }}">
                                        {{ $aa['nama'] }} - ({{ $aa['stok'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-5">
                            <label>Masukkan Barcode Produk</label>
                            <input type="text" class="input w-full border mt-2 bg-gray-100" name="kode_produk" id="barcode_produk" autofocus>
                        </div>
                    </div>
                </form>
                <script>
                    document.getElementById('barcode_produk').addEventListener('keydown', function(event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            document.getElementById('keranjangForm').submit();
                        }
                    });
                    function submitForm() {
                        var produk = document.getElementById('produk').value;
                        if (produk) {
                            document.getElementById('keranjangForm').submit();
                        }
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
                    Produk yang dipilih
                </h2>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    @if($temp == NULL)
                        <div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">
                            Belum ada produk yang dipilih, silahkan pilih produk ke keranjang terlebih dahulu.
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 whitespace-no-wrap">#</th>
                                    <th class="border-b-2 whitespace-no-wrap">Kode Barang</th>
                                    <th class="border-b-2 whitespace-no-wrap">Produk</th>
                                    <th class="border-b-2 whitespace-no-wrap">Jumlah</th>
                                    <th class="border-b-2 whitespace-no-wrap text-right">Harga</th>
                                    <th class="border-b-2 whitespace-no-wrap text-right">Total</th>
                                    <th class="border-b-2 whitespace-no-wrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $no = 1;
                                @endphp
                                @foreach($temp as $row)
                                    <tr>
                                        <td class="border-b whitespace-no-wrap">{{ $no }}</td>
                                        <td class="border-b whitespace-no-wrap">{{ $row->kode_produk }}</td>
                                        <td class="border-b whitespace-no-wrap">{{ $row->nama }}</td>
                                        <td class="border-b whitespace-no-wrap">
                                            <form action="{{ route('admin.penjualan.update_temp') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_temp" value="{{ $row->id_temp }}">
                                                <input type="hidden" name="kode_produk" value="{{ $row->kode_produk }}">
                                                <input type="number" name="jumlah" value="{{ $row->jumlah }}" min="1" class="input w-20 border" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($row->harga) }}</td>
                                        <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($row->jumlah * $row->harga) }}</td>
                                        <td class="border-b whitespace-no-wrap">
                                            <div class="flex sm:justify-center items-center">
                                                <a onClick="return confirm('Apakah anda yakin menghapus produk dari keranjang?')" href="{{ route('admin.penjualan.hapus_temp', $row->id_temp) }}" class="flex items-center text-theme-6">
                                                    <i data-feather="trash" class="w-4 h-4 mr-1 ml-2"></i> hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $total += $row->jumlah * $row->harga;
                                        $no++;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" class="border-b whitespace-no-wrap">Total Harga</td>
                                    <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($total) }}</td>
                                    <td class="border-b whitespace-no-wrap">-</td>
                                </tr>
                            </tbody>
                        </table>
    
                        <form action="{{ route('admin.penjualan.bayarv2') }}" method="post" id="form_pembayaran" enctype="multipart/form-data" onsubmit="return validateForm()">
                            @csrf
                            <div class="mt-3 pr-10 pl-10">
                                <input type="number" class="input w-full border mt-2 text-xl" placeholder="Uang yang dibayar" min="1" required name="bayar" id="bayar" onkeyup="total()">
                            </div>
                            <div class="mt-3 pr-10 pl-10">
                                <select name="pembayaran" class="input w-full border mt-2 text-xl" id="metode_pembayaran" onchange="toggleBuktiInput()">
                                    <option value="Tunai">Tunai (Cash)</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="mt-1 pr-10 pl-10" id="bukti_transfer_container" style="display: none;">
                                <label for="bukti" class="input border text-xl" id="bukti_label">Masukan bukti transfer</label>
                                <input type="file" class="input border text-lg" placeholder="Bukti transfer" name="bukti" id="bukti" accept=".jpeg, .jpg" onchange="updateBuktiLabel(this)">
                            </div>
                            <div class="mt-3 pr-10 pl-10">
                                <input type="hidden" name="id_pelanggan" value="{{ $id_pelanggan }}">
                                <input type="hidden" name="total_harga" value="{{ $total }}" id="total_harga">
                                <h1 class="input w-full border mt-2 text-xl" id="sisa"> Rp. 0</h1>
                                <button type="submit" class="button w-32 mr-2 mb-2 mt-5 flex items-center justify-center bg-theme-1 text-white text-lg w-full" id="bayar_button">
                                    <i data-feather="dollar-sign" class="w-4 h-4 mr-2"></i> Bayar
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- END: Bayar -->
    </div>
    
@endsection
