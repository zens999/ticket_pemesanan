@extends('layouts.app')
@section('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
  <style>
    thead > tr > th, tbody > tr > td{
      vertical-align: middle !important;
    }

    .card-title {
      float: left;
      font-size: 1.1rem;
      font-weight: 400;
      margin: 0;
    }

    .card-text {
      clear: both;
    }

    small {
      font-size: 80%;
      font-weight: 400;
    }

    .text-muted {
      color: #6c757d !important;
    }

    .select2-container .select2-selection--single {
      display: block;
      width: 100%;
      height: calc(1.5em + .75rem + 2px);
      padding: .375rem .75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 2;
      color: #6e707e;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #d1d3e2;
      border-radius: .35rem;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #6e707e;
      line-height: 28px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      display: block;
      padding-left: 0;
      padding-right: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      margin-top: -2px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: calc(1.5em + .75rem + 2px);
      position: absolute;
      top: 1px;
      right: 1px;
      width: 20px;
    }
  </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="height: 600px;">
                <div class="card-header">{{ __('Rute') }}</div>

                <div class="card-body">
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <a href="{{ route('rute.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                      </a>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table
                          class="table table-bordered table-striped table-hover"
                          id="dataTable"
                          width="100%"
                          cellspacing="0"
                        >
                          <thead>
                            <tr>
                              <td>No</td>
                              <td>Name</td>
                              <td>Tujuan & Rute</td>
                              <td>Harga</td>
                              <td>Waktu</td>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($rute as $data)
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                  <h5 class="card-title">{{ $data->transportasi->name }}</h5>
                                  <p class="card-text">
                                    <small class="text-muted">
                                      {{ $data->transportasi->category->name }}
                                    </small>
                                  </p>
                                </td>
                                <td>
                                  <h5 class="card-title">{{ $data->tujuan }}</h5>
                                  <p class="card-text">
                                    <small class="text-muted">
                                      {{ $data->start }} - {{ $data->end }}
                                    </small>
                                  </p>
                                </td>
                                <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                                <td>{{ date('H:i', strtotime($data->jam)) }}</td>
                                <td>
                                  <form
                                    action="{{ route('rute.destroy', $data->id) }}"
                                    method="POST"
                                  >
                                    @csrf
                                    @method('delete')
                                    <a
                                      href="{{ route('rute.edit', $data->id) }}"
                                      type="button"
                                      class="btn btn-warning btn-sm btn-circle"
                                      ><i class="fas fa-edit"></i
                                    ></a>
                                    <button
                                      type="submit"
                                      class="btn btn-danger btn-sm btn-circle"
                                      onclick="return confirm('Yakin');"
                                    >
                                      <i class="fas fa-trash"></i>
                                    </button>
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
        </div>
    </div>
</div>
@endsection
@section('script')
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
    });
    if(jQuery().select2) {
      $(".select2").select2();
    }
    function inputNumber(e) {
      const charCode = (e.which) ? e.which : w.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    };
  </script>
@endsection
