
                 @foreach($months as $month)
                 @if($month->month_id==app('request')->input('month'))
                 <?php $salam=$month->month_days ?>
                 @endif
                 @endforeach


             </div>

             @if (session('status'))
             <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form   >

                <table class="table table-striped table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Tarix</th>
                      <th scope="col">p/u status</th>
                      <th>comment</th>
                  </tr>
              </thead>
              <tbody>
               @for ($i = 1; $i <=$salam ; $i++)
               <tr>
                   <th scope="row">
                    {{$i}}
                </th> 
                @foreach($infos as $info)
                <th scope="row">

                    <select name="gender" class="form-control" id="gender">
                        <option value="1" @if ($info->info_pustatus==1) {{ 'selected' }} @endif>Present</option>
                        <option value="0" @if ($info->info_pustatus==0) {{ 'selected' }} @endif>Upsent</option>
                    </select>
                </th>
                @endforeach

                <th scope="row">
                </div>
                <div class="form-group">
                    <input class="form-control" id="inputdefault" type="text">
                </div>
            </th>        
        </tr>
        @endfor