@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header">Transaksi</div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kamar</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Check In</th>
                                        <th scope="col">Check out</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $i => $row)
                                        <tr>
                                            <th scope="row">{{ ++$i }}</th>
                                            <td>{{ $row->product->nama_product }}</td>

                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->check_in }}</td>
                                            <td>{{ $row->check_out }}</td>
                                            <td>Rp.{{ number_format($row->harga, 2, ',', '.') }}</td>
                                            <td><span
                                                    class="@if ($row->status == 'pending') bg-warning text-light rounded-3 pe-2 ps-2 @elseif ($row->status == 'success') bg-success text-light rounded-3 pe-2 ps-2 @endif">{{ $row->status }}</span>
                                            </td>
                                            @if ($row->status == 'pending')
                                                <td class="bg-danger">
                                                    <form action="/transaksi/{{ $row->token }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="return confirm('Yakin Ingin Membatalkan ?');"
                                                            type="submit" class="btn btn-danger btn-sm p-0">Cancel</button>
                                                    </form>
                                                </td>

                                                <td class="bg-success"><a href="/transaksi/{{ $row->token }}"
                                                        class="btn btn-success btn-sm p-0">Pay</a></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
