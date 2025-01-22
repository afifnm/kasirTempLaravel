@if($temps->isEmpty())
<div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">
    There are no products selected yet, please select the product in your cart first.
</div>
@else
<table class="table">
    <thead>
        <tr>
            <th class="border-b-2 whitespace-no-wrap">#</th>
            <th class="border-b-2 whitespace-no-wrap">Barcode</th>
            <th class="border-b-2 whitespace-no-wrap">Name Product</th>
            <th class="border-b-2 whitespace-no-wrap">QTY</th>
            <th class="border-b-2 whitespace-no-wrap text-right">Price</th>
            <th class="border-b-2 whitespace-no-wrap text-right">Total</th>
            <th class="border-b-2 whitespace-no-wrap text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach($temps as $row)
            <tr>
                <td class="border-b whitespace-no-wrap">{{ $loop->iteration }}</td>
                <td class="border-b whitespace-no-wrap">{{ $row->product->barcode }}</td>
                <td class="border-b whitespace-no-wrap">{{ $row->product->name }}</td>
                <td class="border-b whitespace-no-wrap">
                    <form action="{{ route('cart.update') }}" method="post" id="updateCartForm{{ $row->id }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $row->id }}">
                        <input type="hidden" name="product_id" value="{{ $row->product_id }}">
                        <input type="number" name="qty" value="{{ $row->qty }}" min="1" class="input w-20 border qty" data-id="{{ $row->id }}" onchange="updateCart({{ $row->id }})">
                    </form>
                </td>
                <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($row->product->price) }}</td>
                <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($row->qty * $row->price) }}</td>
                <td class="border-b whitespace-no-wrap">
                    <div class="flex sm:justify-center items-center">
                        <form action="{{ route('cart.delete', $row->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-theme-6">delete</button>
                        </form>
                    </div>
                </td>                               
            </tr>
            @php
                $total += $row->qty * $row->price;
            @endphp
        @endforeach
        <tr>
            <td colspan="5" class="border-b whitespace-no-wrap">-</td>
            <td class="border-b whitespace-no-wrap text-right">Rp. {{ number_format($total) }}</td>
            <td class="border-b whitespace-no-wrap">-</td>
        </tr>
    </tbody>
</table>

<form action="{{ route('transaction.pay') }}" method="post" id="form_pembayaran" enctype="multipart/form-data">
    @csrf
    <div class="mt-3 pr-10 pl-10">
        <input 
            type="number" 
            class="input w-full border mt-2 text-xl" 
            placeholder="Uang yang dibayar" 
            min="1" 
            required 
            name="pay" 
            id="pay" 
            onkeyup="validatePayment()"
        >
    </div>
    <div class="mt-3 pr-10 pl-10">
        <input type="hidden" name="bill" value="{{ $total }}" id="bill">
        <input type="hidden" name="invoice" value="{{ $invoice }}">
        <h1 class="input w-full border mt-2 text-xl" id="sisa">Rp. 0</h1>
        <button 
            type="submit" 
            class="button w-32 mr-2 mb-2 mt-5 flex items-center justify-center bg-theme-1 text-white text-lg w-full" 
            id="pay_button" 
            disabled
        >
            <i data-feather="dollar-sign" class="w-4 h-4 mr-2"></i> Pay
        </button>
    </div>
</form>

<script>
    function validatePayment() {
        var pay = parseInt(document.getElementById('pay').value) || 0;
        var totalHarga = parseInt(document.getElementById('bill').value) || 0;
        var sisa = pay - totalHarga;

        // Tampilkan sisa pempayan
        document.getElementById('sisa').innerText = "Rp. " + sisa.toLocaleString('id-ID');

        // Cek apakah jumlah pay cukup, jika kurang tombol dinonaktifkan
        var payButton = document.getElementById('pay_button');
        if (sisa >= 0) {
            payButton.removeAttribute('disabled');
        } else {
            payButton.setAttribute('disabled', 'disabled');
        }
    }
</script>


@endif