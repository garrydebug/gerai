@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @php
                        $id = request()->route('id');
                        $userPermisson = Auth::user()->permisson;
                        $userName = Auth::user()->name;
                        $userID = Auth::id();
                        $userTL=Auth::user()->teamleader_id;
                    @endphp
                    <input type="hidden" class="month" value="{{$id}}">
                    @foreach($months as $key => $value)
                        @if($key+1==$id)
                            @php
                                $salam = $value['month_days'];
                                 $ay = $value['month_name'];

                            @endphp
                        @endif
                    @endforeach
                    <input type="hidden" class="days" value="{{$salam}}">

                    <div class="card-header"><h4>{{$ay}}</h4></div>
                    <div class="card-body">

                        @if($userPermisson==5 )

                            <div class="form-group">
                                <select id="user" name="user_id" class="form-control" style="width:350px">
                                    <option value="{{$userID}}" >{{$userName}}</option>
                                    @foreach($users as $value)
                                        @if($value['id']==$userID)
                                            @continue
                                        @endif
                                        <option value="{{$value['id']}}"> {{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>


                            @elseif($userPermisson==0)

                              @if($userTL==0)
                                <select id="user" name="user_id" class="form-control" style="width:350px">
                                    <option value="{{$userID}}" >{{$userName}}</option>
                                    @foreach($users as $value)
                                            @if($value['teamleader_id']!=$userID)
                                                @continue
                                            @endif
                                            <option value="{{$value['id']}}"> {{$value['name']}}</option>
                                    @endforeach
                                </select>

                                @elseif($userTL!=0)
                                <div class="form-group">
                                    <select disabled id="user" name="user_id" class="form-control" style="width:350px">
                                        @foreach($users as $value)
                                            @if($value['id']==$userID)
                                                <option selected value="{{$value['id']}}"> {{$value['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                              @endif
                        @endif
                    </div>

                </div>
                <table class="table ">
                    <thead>
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Tag</th>
                        <th>Hours</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <a href="{{ url()->previous() }}"><button type="button"  style="float: right" class="btn btn-danger btn-lg btn-block">GERİ QAYIT
                        </button></a>

                    @foreach($info as $infos)

                        @for ($i = 1; $i <=$salam ; $i++)
                            <tr class="infos">
                                <input type="hidden" class="info_id" id="info_id_{{$i}}">
                                <input type="hidden" class="day" value="{{$i}}">
                                <th scope="row">
                                    <p name="day" class="day">{{$i}}</p>
                                </th>
                                <th scope="row">
                                    <select name="tag" class="tag form-control" id="tag_{{$i}}">
                                        <option value="R">Regular</option>
                                        <option value="R/">Short day</option>
                                        <option value="W">Weekend</option>
                                        <option value="H">Holiday</option>
                                        <option value="S">Sick Leave</option>
                                        <option value="V">Vacation</option>
                                        <option value="O">Overtime</option>
                                    </select>
                                </th>
                                <th scope="row">
                                    <select disabled name="hours" class="hours form-control" id="hours_{{$i}}">
                                    </select>

                                    <input name="hidden" class=" hidden form-control" type="hidden" id="hidden_{{$i}}">

                                </th>
                                <th scope="row">
                                    <div class="form-group">
                                        <input type="text" value="" name="comment" class="comment form-control" id="comment_{{$i}}" type="text">
                                    </div>
                                </th>

                            </tr>
                        @endfor

                        @break

                    @endforeach

                    <div class="form-group">
                        <input type="hidden" value="{{$id}}" class="form-control" id="id" type="text">
                    </div>

                </table>


                <table class="table ">
                    <thead>
                    <tr>
                        <th scope="col">Monthly Working Days</th>
                        <th scope="col">Monthly Working Hours</th>
                        <th scope="col">Monthly Sick Leave</th>
                        <th scope="col">Monthly Vacation Days</th>
                        <th scope="col">Monthly Vacation Days</th>
                        <th scope="col">Monthly Overtime Hours</th>
                        <th scope="col">Holidays and Non-working days</th>


                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                        <th scope="row">X</th>
                    </tr>

                    </tbody>


                </table>
                <button type="submit" id="submitForm"  style="float: right"  class="btn btn-primary btn-lg btn-block">MƏLUMATLARI YENİLƏ</button>
            </div>
        </div>
    </div>
    </div>
    </div>



@endsection

@section("scripts")
    <script type="text/javascript">


        $(document).ready(function () {

            jQuery(function($) {
                $('#user').on('change', function() {
                        var monthID = $('#id').val();
                        var userID = $("#user").val();
                        $.ajax({
                            url: '{{url('get-info')}}',
                            type: "POST",
                            dataType: "json",
                            data: {"_token": "{{ csrf_token() }}", "user_id": userID, "month_id": monthID},
                            success: function (data) {
                                $('.info_id').val('');
                                $('.tag').val('');
                                $('.comment').val('');
                                $('.hours').val('');

                                if (data) {
                                    $('input[name=tag]').empty();
                                    $.each(data, function (key, value) {
                                        $('#info_id_' + value['day']).val(value['info_id']);
                                        $('#tag_' + value['day']).val(value['tag']);
                                        $('#hours_' + value['day']).val(value['hours']);
                                        $('#comment_' + value['day']).val(value['comment']);

                                        jQuery(function($) {
                                            $('#tag_'+ value['day']).on('change', function() {
                                                if ($('#tag_'+ value['day']).val()=='R'){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="8">8 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='R/'){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="7">7 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='W' ){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="0">0 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='H' ){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="0">0 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='S' ){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="0">0 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='V' ){
                                                    $('#hours_'+ value['day']).prop( "disabled", true ).empty().append('<option selected="selected" value="0">0 hours</option>')
                                                }
                                                else if ($('#tag_'+ value['day']).val()=='O'  ){
                                                    $('#hours_'+ value['day']).empty();
                                                    for (var i = 1; i <= 24; i++) {
                                                        $('#hours_'+ value['day']).prop( "disabled", false ).append('<option  value="'+i+'">'+i+' hours</option>').val(value['hours']);
                                                    }
                                                }}).trigger('change');
                                        });

                                    });

                                } else {
                                    $('input[name=tag]').empty();
                                }


 },
                        });


                }).trigger('change');
            });

            $("#submitForm").click(function () {
                var edits = [];
                /*            var yenis = [];
                */
                $( ".infos" ).each(function( index ) {
                    var edit = [];
/*
                    var yeni = [];
*/
                    if($( this ).find(".info_id").val()){
                        edit.push($( this ).find(".info_id").val());
                        edit.push($( this ).find(".tag").val());
                        edit.push($( this ).find(".comment").val());
                        edit.push($( this ).find(".hours").val());

                        edits.push(edit);
                    }
                });
                $.ajax({
                    url: '{{url('update-info')}}',
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", "edits": edits/*, "yenis": yenis*/},
                    success: function (data) {
                        $(window).scrollTop(0);
                        alert('yeniləndi');
                    }
                });
            });


        });




    </script>
@endsection
