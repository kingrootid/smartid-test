@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Pengisian Periode {{ $schedule['date_start'].' - '.$schedule['date_end'] }}</h6>
            </div>
            <div class="card-body">
                @foreach($masterKlaster as $mk)
                <h6>{{ $mk['name'] }}</h6>
                <ul>
                    @foreach(getSubKlasterData($mk['uuid']) as $subK)
                    <li>
                        <span>{{ $subK['name'] }}</span>
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">User</th>
                                    <th scope="col">Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(getInputUser($schedule['uuid'], $subK['uuid']) as $gi)
                                <tr>
                                    <td>{{ $gi['id'] }}</td>
                                    <td>{{ $gi['user'] }}</td>
                                    <td>{!! $gi['label'] !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </li>
                    @endforeach
                </ul>
                @endforeach
            </div>
            <div class="card-footer">
                <a href="{{ url('admin/schedule') }}" class="btn btn-danger">Back</a>
                <a href="{{ url('export/'.$schedule['uuid']) }}" class="btn btn-success">Export To Word</a>
            </div>
        </div>
    </div>
</div>
@endsection