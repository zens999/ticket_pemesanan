@extends('layouts.admin')

@section('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
  <style>
    thead > tr > th, tbody > tr > td {
      vertical-align: middle !important;
    }

    .card-title {
      float: left;
      font-size: 1.1rem;
      font-weight: 400;
      margin: 0;
    }

    .ctr {
      text-align: center !important;
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
  </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="height: 600px;">
                <div class="card-header">{{ __('Transportasi') }}</div>

                <div class="card-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <a href="{{ route('transportasi.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Transportasi
                          </a>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <td>No</td>
                                  <td>Kode</td>
                                  <td>Name</td>
                                  <td>Jumlah Kursi</td>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($transportasi as $data)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->kode }}</td>
                                    <td>
                                      <h5 class="card-title">{{ $data->name }}</h5>
                                      <p class="card-text">
                                        <small class="text-muted">{{ $data->category->name }}</small>
                                      </p>
                                    </td>
                                    <td>{{ $data->jumlah }} Kursi</td>
                                    <td>
                                      <form action="{{ route('transportasi.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('transportasi.edit', $data->id) }}" class="btn btn-warning btn-sm btn-circle">
                                          <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle" onclick="return confirm('Yakin');">
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

@section('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('.select2').select2();
    });
</script>
@endsection
