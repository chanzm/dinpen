
@extends('base.template')


@section('content')
<br>
<div class="fixed-top">
  <div class="container">
      <div class="row">
        <div class="col-md-11">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="btn btn-success">
                  <i class="fa fa-external-link-square"></i> : Foto Terkirim
                </span>
                <span class="btn btn-primary">
                  <i class="fa fa-check-circle"></i> : Foto Terverivikasi
                </span>
                <span class="btn btn-danger">
                  <i class="fa fa-window-close"></i> : Foto Belum Terverivikasi
                </span>
                <span class="btn btn-warning">
                  <i class="fa fa-cogs"></i> : Foto Tertrain
                </span>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">NIP</th>
                          <th scope="col" colspan="4" style="text-align: center;">Status Foto</th>
                          <th style="text-align: center;" scope="col">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($nips as $n)
                        <tr>
                         <td><b><h4>{{$n->nip}}</h4></b></td>
                          <td>
                            <a href="#" class="btn btn-success"><i class="fa fa-external-link-square"></i> : {{$n->jumlah0 + $n->jumlah1 + $n->jumlah2}}</a>
                          </td>
                          <td>
                            <a href="#" class="btn btn-primary"><i class="fa fa-check-circle"></i> : {{$n->jumlah1}}</a>
                          </td>
                          <td>
                            <a href="#" class="btn btn-danger"><i class="fa fa-window-close"></i> : {{$n->jumlah0}}</a>
                          </td>
                          <td>
                            <a href="#" class="btn btn-warning"><i class="fa fa-cogs"></i> : {{$n->jumlah2}}</a>
                          </td>
                          <td style="text-align: center;"><a class="btn btn-success" href="{{ url('/image/'.$n->nip) }}">Buka</a> 
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
