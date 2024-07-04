@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Rute') }}</div>

                <div class="card-body">
                    <form action="{{ route('rute.update', $rute->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <input
                                type="text"
                                class="form-control"
                                id="tujuan"
                                name="tujuan"
                                value="{{ $rute->tujuan }}"
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
                                value="{{ $rute->start }}"
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
                                value="{{ $rute->end }}"
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
                                value="{{ $rute->harga }}"
                                onkeypress="return inputNumber(event)"
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
                                value="{{ $rute->jam }}"
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
                                <option value="" disabled>-- Pilih Transportasi --</option>
                                @foreach ($transportasi as $data)
                                    <option value="{{ $data->id }}" {{ $data->id == $rute->transportasi_id ? 'selected' : '' }}>
                                        {{ $data->kode }} - {{ $data->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
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
