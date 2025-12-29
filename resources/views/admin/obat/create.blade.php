<x-layouts.app title="Tambah Obat">
    <div class="container-fluid px-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="mb-4">Tambah Obat</h1>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('obat.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Nama Obat --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nama_obat" class="form-label">
                                        Nama Obat <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           id="nama_obat"
                                           name="nama_obat"
                                           class="form-control @error('nama_obat') is-invalid @enderror"
                                           value="{{ old('nama_obat') }}"
                                           placeholder="Contoh: Paracetamol"
                                           required>
                                    @error('nama_obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kemasan --}}
                                <div class="col-md-6 mb-3">
                                    <label for="kemasan" class="form-label">Kemasan</label>
                                    <input type="text"
                                           id="kemasan"
                                           name="kemasan"
                                           class="form-control @error('kemasan') is-invalid @enderror"
                                           value="{{ old('kemasan') }}"
                                           placeholder="Strip / Botol / Tube">
                                    @error('kemasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">
                                        Harga <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           id="harga"
                                           name="harga"
                                           class="form-control @error('harga') is-invalid @enderror"
                                           value="{{ old('harga') }}"
                                           min="0"
                                           step="1"
                                           placeholder="Contoh: 5000"
                                           required>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="col-md-6 mb-3">
                                    <label for="stok" class="form-label">
                                        Stok Awal <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           id="stok"
                                           name="stok"
                                           class="form-control @error('stok') is-invalid @enderror"
                                           value="{{ old('stok', 0) }}"
                                           min="0"
                                           step="1"
                                           required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Button --}}
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('obat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
