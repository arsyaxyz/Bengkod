<x-layouts.app title="Periksa Pasien">

    {{-- ALERT ERROR (stok habis / validasi backend) --}}
    @if ($errors->any())
        <div class="container-fluid px-4 mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">Periksa Pasien</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('periksa-pasien.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                            {{-- PILIH OBAT --}}
                            <div class="form-group mb-3">
                                <label for="obat" class="form-label">Pilih Obat</label>
                                <select id="select-obat" class="form-select">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id }}"
                                            data-nama="{{ $obat->nama_obat }}"
                                            data-harga="{{ $obat->harga }}"
                                            data-stok="{{ $obat->stok }}"
                                            {{ $obat->stok == 0 ? 'disabled' : '' }}>
                                            {{ $obat->nama_obat }}
                                            @if ($obat->stok > 0 && $obat->stok <= 5)
                                                (Menipis)
                                            @elseif ($obat->stok == 0)
                                                (Habis)
                                            @endif
                                            - Rp{{ number_format($obat->harga) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CATATAN --}}
                            <div class="form-group mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control">{{ old('catatan') }}</textarea>
                            </div>

                            {{-- OBAT TERPILIH --}}
                            <div class="form-group mb-3">
                                <label>Obat Terpilih</label>
                                <ul id="obat-terpilih" class="list-group mb-2"></ul>

                                <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">
                                <input type="hidden" name="obat_json" id="obat_json">
                            </div>

                            {{-- TOTAL --}}
                            <div class="form-group mb-3">
                                <label>Total Harga</label>
                                <p id="total-harga" class="fw-bold">Rp 0</p>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('periksa-pasien.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    const selectObat = document.getElementById('select-obat');
    const listObat = document.getElementById('obat-terpilih');
    const inputBiaya = document.getElementById('biaya_periksa');
    const inputObatJson = document.getElementById('obat_json');
    const totalHargaEl = document.getElementById('total-harga');

    let daftarObat = [];

    selectObat.addEventListener('change', () => {
        const selectedOption = selectObat.options[selectObat.selectedIndex];
        const id = selectedOption.value;
        const nama = selectedOption.dataset.nama;
        const harga = parseInt(selectedOption.dataset.harga || 0);
        const stok = parseInt(selectedOption.dataset.stok || 0);

        if (!id || daftarObat.some(o => o.id == id)) {
            selectObat.selectedIndex = 0;
            return;
        }

        daftarObat.push({ id, nama, harga, stok });
        renderObat();
        selectObat.selectedIndex = 0;
    });

    function renderObat() {
        listObat.innerHTML = '';
        let total = 0;

        daftarObat.forEach((obat, index) => {
            total += obat.harga;

            const item = document.createElement('li');
            item.className = 'list-group-item d-flex justify-content-between align-items-center';

            item.innerHTML = `
                <div>
                    ${obat.nama} - Rp ${obat.harga.toLocaleString()}
                    ${obat.stok > 0 && obat.stok <= 5 ? '<span class="badge bg-warning text-dark ms-2">Menipis</span>' : ''}
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusObat(${index})">Hapus</button>
            `;

            listObat.appendChild(item);
        });

        inputBiaya.value = total;
        totalHargaEl.textContent = `Rp ${total.toLocaleString()}`;
        inputObatJson.value = JSON.stringify(daftarObat.map(o => o.id));
    }

    function hapusObat(index) {
        daftarObat.splice(index, 1);
        renderObat();
    }
</script>
