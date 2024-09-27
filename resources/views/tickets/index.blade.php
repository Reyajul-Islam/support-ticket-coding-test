@extends('layouts.app')



@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2>Tickets</h2>

            </div>

            <div class="pull-right">

                @can('ticket-create')

                <a class="btn btn-success mb-2" href="{{ route('tickets.create') }}"> Create New Product</a>

                @endcan

            </div>

        </div>

    </div>



    @if ($message = Session::get('success'))

        <div class="alert alert-success">

            <p>{{ $message }}</p>

        </div>

    @endif

    @if ($message = Session::get('error'))

        <div class="alert alert-danger">

            <p>{{ $message }}</p>

        </div>

    @endif



    <table class="table table-bordered">

        <tr>

            <th>SL No</th>

            <th>Ticket No</th>

            <th>Customer</th>

            <th>Issue</th>

            <th>Status</th>

            @can('ticket-edit')
            <th width="280px">Action</th>
            @endcan

        </tr>

        @foreach ($tickets as $ticket)

            <tr>

                <td>{{ ++$i }}</td>

                <td>{{ $ticket->ticket }}</td>

                <td>{{ $ticket->customer->name }}</td>

                <td>{{ $ticket->issue }}</td>

                <td>{{ $ticket->status }}</td>

                @can('ticket-edit')
                <td>
                    @if($ticket->status == 'opened')
                    <form action="{{ route('tickets.update',$ticket->id) }}" method="POST">
                        @csrf

                        @method('PUT')


                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to close this ticket?')">Close</button>


                    </form>
                    @endif
                </td>
                @endcan

            </tr>

        @endforeach

    </table>



    {!! $tickets->links() !!}

@endsection