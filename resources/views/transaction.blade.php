@extends('app')
@section('title','Transaction Page')
@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<a href="{{ route('transaction.sell') }}" class="button ml-4 mr-auto inline-block bg-theme-1 text-white">Add Transaction</a>
</div>
<div class="modal" id="import">
	<div class="modal__content modal__content--lg">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">LAPORAN</h2>
		</div>
		<form action="" target="_blank">
			<div class="intro-y box p-5">
				<div class="mt-3">
					<label>Dari</label>
					<div class="relative mt-2">
						<input type="date" name="tanggal1" class="input w-full border col-span-4" required>
					</div>
				</div>
				<div class="mt-3">
					<label>Sampai</label>
					<div class="relative mt-2">
						<input type="date" name="tanggal2" class="input w-full border col-span-4" required>
					</div>
				</div>
				<div class="mt-3">
					<label>Jenis Produk</label>
					<div class="relative mt-2">
						<select name="jenis" class="input w-full border mt-2 flex-1">
							<option value="Usman">Usman</option>
							<option value="Umum">Umum</option>
						</select>
					</div>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-30 bg-theme-1 text-white">Tampilkan</button>
			</div>
		</form>
	</div>
</div>
<div class="modal" id="nota">
	<div class="modal__content modal__content--lg">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">CEK NOTA</h2>
		</div>
		<form action="" method="GETS">
			<div class="intro-y box p-5">
				<div class="mt-3">
					<label>Masukan nomor nota</label>
					<div class="relative mt-2">
						<input type="text" name="kode_penjualan" class="input w-full border col-span-4" required>
					</div>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-30 bg-theme-1 text-white">Tampilkan</button>
			</div>
		</form>
	</div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full">
		<thead>
			<tr>
				<th class="border-b-2 whitespace-no-wrap">NO </th>
				<th class="border-b-2 whitespace-no-wrap">INVOICE </th>
				<th class="border-b-2 whitespace-no-wrap">DATE </th>
				<th class="border-b-2 whitespace-no-wrap text-right">BILL </th>
				<th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
@endsection
