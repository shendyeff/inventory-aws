@extends('layouts.master', ['title' => 'User'])

@section('content')
<x-container>
    <div class="col-12">
        <x-card title="DAFTAR USER" class="card-body p-0">
            <x-table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $i => $user)
                        <tr>
                            <td>{{ $i + $users->firstItem() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                <!-- Button for edit modal -->
                                <x-button-modal :id="$user->id" title="" icon="edit" style="" class="btn btn-info btn-sm" />
                                
                                <!-- Modal for editing user -->
                                <x-modal :id="$user->id" title="Ubah Data">
                                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <!-- Nama -->
                                        <x-input name="name" type="text" title="Nama" :value="$user->name" />
                                        
                                        <!-- Email -->
                                        <x-input name="email" type="email" title="Email" :value="$user->email" />
                                        
                                        <!-- Nomor HP -->
                                        <x-input name="phone_number" type="text" title="Nomor HP" :value="$user->phone_number" />
                                        
                                        <!-- Alamat -->
                                        <x-input name="address" type="text" title="Alamat" :value="$user->address" />
                                        
                                        <!-- Role -->
                                        <x-select title="Role" name="role">
                                            <option value="">Silahkan Pilih</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @selected($user->roles()->find($role->id))>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        
                                        <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </x-card>
    </div>
</x-container>
@endsection
