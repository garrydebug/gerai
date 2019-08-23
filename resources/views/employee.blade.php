@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-striped table-dark">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Days</th>
                          <th scope="col">Status</th>
                      </tr>
                  </thead>
                  <tbody>
                     @foreach($months as $key=> $value)
                     <tr>

                      <th scope="row">{{ $key+1}}</th>
                      <td><a href="{{route('edit',['id'=>$value['month_id']])}}"><button class="btn btn-success">{{ $value['month_name']}}</button></a></td>
                      <td>{{ $value['month_days']}}</td>
                      @if( $value['month_status']=='1')
                      <td>Aktiv</td>
                      @else if( $value['month_status']=='0')
                      <td>Passiv</td>
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
@endsection
