@extends('layouts.master', ['title' => 'Order'])

@section('content')
<x-container>
    <div class="col-12 col-lg-8">
        <x-card title="DAFTAR PERMINTAAN BARANG" class="card-body p-0">
            <x-table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Kuantitas</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Kode Konfirmasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                            <tbody>
                @foreach ($orders as $i => $order)
                <tr>
                    <td>{{ $i + $orders->firstItem() }}</td>
                    <td>
                        <span class="avatar rounded avatar-md"
                            style="background-image: url({{ $order->image }})"></span>
                    </td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->unit }}</td>
                    <td
                        class="{{ $order->status == App\Enums\OrderStatus::Pending ? 'text-danger' : 'text-success' }}">
                        {{ $order->status->value }}
                    </td>
                    <td>{{ $order->confirmation_code }}</td>
                    <td>
                        @if ($order->status == App\Enums\OrderStatus::Pending)
                        <x-button-modal :id="$order->id" title="" icon="edit" style=""
                            class="btn btn-info btn-sm" />
                        <x-modal :id="$order->id" title="Ubah Data">
                            <form action="{{ route('customer.order.update', $order->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <x-input name="image" type="file" title="Foto Barang" placeholder=""
                                    :value="$order->image" />
                                <x-input name="name" type="text" title="Nama Barang" placeholder="Nama Barang"
                                    :value="$order->name" />
                                <x-input name="quantity" type="number" title="Kuantitas" placeholder="Kuantitas"
                                    :value="$order->quantity" />
                                <x-input name="unit" type="text" title="Satuan" placeholder="Satuan"
                                    :value="$order->unit" />
                                <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
                            </form>
                        </x-modal>

                        <x-button-delete :id="$order->id" :url="route('customer.order.destroy', $order->id)"
                            title="" class="btn btn-danger btn-sm" />

                        <!-- Tombol WhatsApp di sebelah kanan tombol hapus -->
                        @php
                            // Format pesan WhatsApp dengan baris baru (%0A)
                            $waMessage = urlencode("Halo Admin,%0A".
                                                "Saya ingin mengajukan permintaan barang dengan detail berikut:%0A%0A".
                                                "Nama User: {{ $order->user->name }}%0A".
                                                "Kode Verifikasi: {{ $order->confirmation_code }}%0A".
                                                "Permintaan Barang: {{ $order->name }}%0A%0A".
                                                "Terima kasih.");
                        @endphp
                        <a href="https://wa.me/+6289514851100?text=Halo%20Admin,%0ASaya%20ingin%20mengajukan%20permintaan%20barang%20dengan%20detail%20berikut:%0A%0ANama%20User:%20{{ urlencode($order->user->name) }}%0AKode%20Verifikasi:%20{{ urlencode($order->confirmation_code) }}%0APermintaan%20Barang:%20{{ urlencode($order->name) }}%0A%0ATerima%20kasih."
                        target="_blank" class="btn btn-success btn-sm">
                        <i class="fa fa-paper-plane"></i> Kirim
                        </a>
                        @endif <!-- Tambahkan endif di sini untuk menutup blok if pertama -->

                        @if ($order->status == App\Enums\OrderStatus::Success)
                            @if(isset($product[0]))
                            <form action="{{ route('cart.order', $product[0]->slug) }}" method="POST">
                                @csrf
                                <x-button-save title="Tambahkan Keranjang" icon="shopping-cart"
                                    class="btn btn-primary btn-sm" />
                            </form>
                            @else
                                <p>Produk tidak ditemukan.</p>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            </x-table>
        </x-card>
    </div>
    <div class="col-lg-4 col-12">
        <x-card title="TAMBAH PERMINTAAN BARANG" class="card-body">
                <form action="{{ route('customer.order.store') }}" method="POST">
                @csrf
                <x-select name="product_id" title="Nama Barang">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
                </x-select>


                <x-input name="quantity" type="number" title="Kuantitas" placeholder="Masukkan kuantitas" />

                <x-select name="unit" title="Satuan">
                <option value="pcs">Pcs</option>
                <option value="pack">Pack (25pcs)</option>
                </x-select>

                <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
                </form>
        </x-card>
    </div>
</x-container>
@endsection