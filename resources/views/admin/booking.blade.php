@extends('layouts/app_admin')
@section('content_admin')
<div class="table-responsive">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Gmail</th>
                <th scope="col">Kamar</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($bookings as $i=>$row)
                
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->datauser->email }}</td>
                <td>{{ $row->product->nama_product }}</td>
                <td>{{ $row->check_in }}</td>
                <td>{{ $row->check_out }}</td>
                <td><span class="@if ($row->status == 'check-in') bg-success text-light rounded-3 pe-2 ps-2 @elseif ($row->status == 'pending') bg-warning text-light rounded-3 pe-2 ps-2 @else  bg-danger text-light rounded-3 pe-2 ps-2 @endif">{{ $row->status }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
</div>
@endsection