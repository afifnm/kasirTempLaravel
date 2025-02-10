@extends('app')
@section('title','Transaction Page')
@section('content')
<div class="intro-y box overflow-hidden mt-5">
	<div class="border-b border-gray-200 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 font-semibold text-3xl">INVOICE</div>
			<div class="mt-2"> No. <span class="font-medium">#<?= $transactions->invoice ?></span> </div>
			<div class="mt-1">
				<?php
                $date=date_create($transactions->date);
                echo date_format($date,"D, d M Y");
                ?>
			</div>
			<div class="mt-1">
				<a href="{{ route('transaction.struk', $transactions->invoice) }}" target="_blank">Print Invoice</a>
			</div>
		</div>
	</div>
	<div class="px-5 sm:px-16 py-10 sm:py-20">
		<div class="overflow-x-auto">
			<table class="table">
				<thead>
					<tr>
						<th class="border-b-2 whitespace-no-wrap">PRODUCT NAME</th>
						<th class="border-b-2 text-right whitespace-no-wrap">QTY</th>
						<th class="border-b-2 text-right whitespace-no-wrap">PRICE</th>
						<th class="border-b-2 text-right whitespace-no-wrap">TOTAL</th>
					</tr>
				</thead>
				<tbody>
                    @php $total =0; @endphp
					@foreach($details as $row)
					<tr>
						<td class="border-b">
							<div class="font-medium whitespace-no-wrap"><?= $row->product['name'] ?></div>
							<div class="text-gray-600 text-xs whitespace-no-wrap"><?= $row->product['barcode'] ?></div>
						</td>
						<td class="text-right border-b w-32"><?= $row['qty'] ?></td>
						<td class="text-right border-b w-32">Rp. <?= number_format($row->product['price']) ?></td>
						<td class="text-right border-b w-32 font-medium">Rp.
							<?=  number_format($row['qty']*$row['price']) ?></td>
					</tr>
                    @php $total += $row['qty'] * $row['price']; @endphp
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
		<div class="text-center sm:text-right sm:ml-auto">
			<div class="text-base text-gray-600">Bill</div>
			<div class="text-xl text-theme-1 font-medium mt-2">Rp. {{ number_format($total) }}</div>
		</div>
	</div>
</div>
@endsection