@extends('base.template')
@section('moreCSS')
  <style type="text/css">
    
  .conta {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.conta input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 30px;
  width: 30px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.conta:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.conta input:checked ~ .checkmark {
  background-color: #2196F3;
}

.conta input:disabled ~ .checkmark {
  background-color: #20E254
}


/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.conta input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.conta .checkmark:after {
  left: 13px;
  top: 10px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11 panel panel-default">
            <div class="panel-body">
               <div class="col-md-3" align="center">
                <i class="fa fa-picture-o fa-3x"></i>
                <h3>Foto : {{$jmlGambar}}</h3>
               </div>
               <div class="col-md-4 col-md-offset-1" align="center">
                <i class="fa fa-folder-open-o fa-3x"></i>
                <h3>Folder : 0</h3>
               </div>
               <div class="col-md-3 col-md-offset-1" align="center">
                <i class="fa fa-file-archive-o fa-3x"></i>
                <h3>Lain-lain : 0</h3>
               </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-11">
         @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
        @endif
      </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-3" style="text-align: left;">
                        @if($s0 > 0)
                        <a class="btn btn-warning" disabled ><i class="fa fa-cog fa-2x"></i><h4>Train</h4>
                        </a><br> <b style="color: red;">Ada gambar belum terverifikasi</b>
                        @else
                        <a class="btn btn-warning" href="{{ url('/webtrain/'.$path_file)}}"><i class="fa fa-cog fa-2x"></i><h4>Train</h4></a>
                        @endif  
                      </div>
                      <div class="col-md-4"></div>
                      @if($jmlGambar>0)
                      <div class="col-md-2" style="text-align: right;">
                        <a class="btn btn-success" href="javascript:pilihsemua()"><i class="fa fa-check-square-o"></i></a>
                        <a class="btn btn-danger" href="javascript:bersihkan()"><i class="fa fa-square-o"></i></a>
                      </div>
                      <div class="col-md-2" style="text-align: left;">
                        <form method="post" action="{{ url('/directory/verifImage')}}"/>
                            <input type="hidden" value="{{$image_path}}"  name="nip"/>
                            <input type="hidden" id="nama_file" value="" name="nama_file"/>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <button onclick="getCheckedCheckboxesFor('employee');" type="submit" class="btn btn-info"><i class="fa fa-check-square"></i><b> Verifikasi</b></button>
                        </form>
                      </div>
                      @endif
                    </div>
                  </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Nama File</th>
                          <th style="text-align: center;" scope="col">Image</th>
                          <th scope="col">Status</th>
                          <th style="text-align: center;" scope="col">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($file_foto as $file)
                        <tr>
                            <td><b><h4>{{$file->nama_file}}</h4></b></td>
                            <td style="text-align: center;">
                              <img src="{{URL::asset($image_path.'/'.$file->nama_file)}}" height="128" width="128">
                             </td>
                                @if($file->status == 0)
                                <td>
                                  <label class="conta">
                                    <input onclick="getCheckedCheckboxesFor('employee');" name="employee" type="checkbox" value="{{$file->nama_file}}" />
                                    <span class="checkmark"></span>
                                  </label>
                                </td>
                                @else
                                <td>
                                  <label class="conta">
                                    <input type="checkbox" checked="true" disabled="">
                                    <span class="checkmark"></span>
                                  </label>
                                </td>
                                @endif
                              <td style="text-align: center;">
                                  <form method="post" action="{{ url('/directory/deleteImage')}}"/>
                                  <input type="hidden" value="{{$file->nip}}"  name="nip"/>
                                  <input type="hidden" value="{{$file->nama_file}}"  name="nama_file"/>
                                  <input class="btn btn-danger" type="submit" value="Hapus"/>
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                  </form>
                              </td>
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

@section('moreJS')
  <script type="text/javascript">
    function getCheckedCheckboxesFor(checkboxName) {
    var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
        document.getElementById("nama_file").value= values;
    });
      return values;
    }

    function pilihsemua()
    {
        var daftarku = document.getElementsByName("employee");
        var jml=daftarku.length;
        var b=0;
        for (b=0;b<jml;b++)
        {
            daftarku[b].checked=true;
            
        }
    }

    function bersihkan()
    {
        var daftarku = document.getElementsByName("employee");
        var jml=daftarku.length;
        var b=0;
        for (b=0;b<jml;b++)
        {
            daftarku[b].checked=false;
            
        }
    }

  </script>
@endsection
