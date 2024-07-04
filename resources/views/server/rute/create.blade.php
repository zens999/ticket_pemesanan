@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Rute') }}</div>

                <div class="card-body">
                    <form action="{{ route('rute.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <input
                                type="text"
                                class="form-control"
                                id="tujuan"
                                name="tujuan"
                                placeholder="Tujuan"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="start">Rute Awal</label>
                            <input
                                type="text"
                                class="form-control"
                                id="start"
                                name="start"
                                placeholder="Rute Awal"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="end">Rute Akhir</label>
                            <input
                                type="text"
                                class="form-control"
                                id="end"
                                name="end"
                                placeholder="Rute Akhir"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input
                                type="text"
                                class="form-control"
                                id="harga"
                                name="harga"
                                onkeypress="return inputNumber(event)"
                                placeholder="Harga"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="jam">Jam Berangkat</label>
                            <input
                                type="time"
                                class="form-control"
                                id="jam"
                                name="jam"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="transportasi_id">Transportasi</label><br>
                            <select
                                class="select2 form-control"
                                id="transportasi_id"
                                name="transportasi_id"
                                required
                                style="width: 100%; color: #6e707e;"
                            >
                                <option value="" disabled selected>-- Pilih Transportasi --</option>
                                @foreach ($transportasi as $data)
                                    <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah') }}
                                </button>
                                <a href="{{ route('rute.index') }}" class="btn btn-secondary">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
  <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
  <script>
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
