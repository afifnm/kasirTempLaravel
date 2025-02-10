@extends('app')
@section('title','Dashboard')
@section('content')
<div class="grid grid-cols-12 gap-6">
	<div class="col-span-9 grid grid-cols-12 gap-6">
		<!-- BEGIN: General Report -->
		<div class="col-span-12 md:col-span-12 mt-8">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="text-2xl font-bold leading-8 mt-6">Rp. <?= number_format($billToday) ?></div>
							<div class="text-base text-gray-600 mt-1">sales today</div>
						</div>
					</div>
				</div>
				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="text-2xl font-bold leading-8 mt-6">Rp. <?= number_format($billMonth) ?></div>
							<div class="text-base text-gray-600 mt-1">sales this month</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
		<div class="xxl:pl-6 grid grid-cols-12 gap-6">
			<!-- BEGIN: Transactions -->
			<div class="col-span-12 mt-3">
				<div class="mt-5">
					@foreach($recents as $aa)
					<a href="{{ route('transaction.invoice',$aa->invoice) }}">
						<div class="intro-x">
							<div class="box px-5 py-3 mb-3 flex items-center zoom-in">
								<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
									<img src="{{ asset('midone/dist/images/profile-14.jpg') }}">
								</div>
								<div class="ml-4 mr-auto">
									<div class="font-small">{{ $aa->date }}</div>
									<div class="text-gray-600 text-xs">#{{ $aa->invoice }}</div>
								</div>
								<div class="text-theme-9 text-right">Rp. {{ number_format($aa->bill)}}</div>
							</div>
						</div>
					</a>
					@endforeach
					<a href="{{ route('transaction') }}"
						class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 text-theme-16">Lihat
						Transaksi Bulan Ini</a>
				</div>
			</div>
			<!-- END: Transactions -->
		</div>
	</div>
</div>
@endsection