@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Transportasi') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transportasi.update', $transportasi->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $transportasi->name }}" placeholder="Name Transportasi" required>
                        </div>

                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" value="{{ $transportasi->kode }}" placeholder="Kode Transportasi" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah Kursi</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ $transportasi->jumlah }}" onkeypress="return inputNumber(event)" placeholder="Jumlah Kursi" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="" disabled>-- Pilih Category --</option>
                                @foreach ($category as $data)
                                    <option value="{{ $data->id }}" {{ $data->id == $transportasi->category_id ? 'selected' : '' }}>{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('transportasi.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function inputNumber(e) {
        const charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
@endsection
