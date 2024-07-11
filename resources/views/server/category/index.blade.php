
@extends('layouts.admin')

@section('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="height: 600px;">
                <div class="card-header">{{ __('Category') }}</div>


                <div class="card-body">
                    <div class="card shadow mb-4"></div>
                    <div class="table-responsive">
                        <div class="card-header py-3">
                            <a href="{{ route('category.create') }}" class="btn btn-success btn-sm float-right">
                                <i class="fas fa-plus"></i> Add Category
                            </a>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <form action="{{ route('category.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('category.edit', $data->id) }}" class="btn btn-warning btn-sm btn-circle btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                                onclick="return confirm('Anda yakin ingin menghapus kategori ini?')">
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
  <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $(".btn-add").click(function(){
        $("#modal").modal("show");
        $(".modal-title").html("Tambah Category");
        $("#id").val("");
        $("#name").val("");
    });

    $("#dataTable").on("click", ".btn-edit", function () {
        let id = $(this).data("id");
        let name = $(this).data("name");
        $("#modal").modal("show");
        $(".modal-title").html("Edit Category");
        $("#id").val(id);
        $("#name").val(name);
    });
  </script>
@endsection
