@extends('app')
@section('title','User Page')
@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
		class="button inline-block bg-theme-1 text-white mr-auto">Add User </a>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full">
		<thead>
			<tr>
				<th class="border-b-2 whitespace-no-wrap">NO </th>
				<th class="border-b-2 whitespace-no-wrap">NAME </th>
				<th class="border-b-2 whitespace-no-wrap">EMAIL </th>
				<th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td class="text-left border-b">{{ $loop->iteration }}</td>
				<td class="text-left border-b">{{ $user->name }}</td>
				<td class="text-left border-b">{{ $user->email }}</td>
				<td class="border-b w-5">
					<div class="flex sm:justify-center items-center">
					<a href="javascript:;" onclick="edit(
						{{ $user->id }},
						'{{ $user->name }}',
						'{{ $user->email }}'
						)" class="flex items-center mr-3" data-toggle="modal" data-target="#edit-data">
					<i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
				</a>
					<!-- Tombol Hapus -->
					<form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
						@csrf
						@method('DELETE')
						<button type="button" class="text-theme-6 flex items-center" onclick="confirmDelete({{ $user->id }})">
							<i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
						</button>
					</form>
					</div>
				</td>
				
				<script>
					function confirmDelete(userId) {
						Swal.fire({
							title: 'Are you sure?',
							text: "You won't be able to revert this!",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonText: 'Yes, delete it!',
							cancelButtonText: 'No, cancel!',
							reverseButtons: true
						}).then((result) => {
							if (result.isConfirmed) {
								// If 'Yes' is clicked, submit the form
								document.getElementById('delete-form-' + userId).submit();
							}
						});
					}
				</script>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="modal" id="header-footer-modal-preview">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">ADD USER </h2>
		</div>
		<form action="{{ route('user.store') }}" method="POST">
            @csrf
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-12"><label>Name </label><input type="text" name="name"
						class="input w-full border mt-2 flex-1"> </div>
				<div class="col-span-12 sm:col-span-12"><label>Email</label><input type="email" name="email"
						class="input w-full border mt-2 flex-1"> </div>
				<div class="col-span-12 sm:col-span-12"><label>Password</label><input type="password" name="password"
						class="input w-full border mt-2 flex-1"> </div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Save</button>
			</div>
		</form>
	</div>
</div>
<!-- BEGIN: EDIT Confirmation Modal -->
<div class="modal" id="edit-data">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">EDIT USER </h2>
		</div>
		<form id="edit-form" method="POST">
			@csrf
            @method('PUT')
			<input type="hidden" name="id" id="id" class="input w-full border mt-2">
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-12">
					<label>Name </label>
					<input type="text" name="name" id="name" class="input w-full border mt-2 flex-1">
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Email</label>
					<input type="text" name="email" class="input w-full border mt-2 flex-1" id="email" readonly>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
			</div>
		</form>
	</div>
</div>
<script>
    function edit(id, name, email) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        var form = document.getElementById('edit-form');
        form.action = '/user/' + id;  // Sesuaikan URL dengan route Anda
    }
</script>
<!-- END: EDIT Confirmation Modal -->
@endsection
