<!DOCTYPE html>
<html lang="id">
    <head>
        @include('admin.partials.headadmin')

        {{-- DataTables CSS --}}
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"
        />
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                {{-- Sidebar --}}
                @include('admin.partials.sidebaradmin')

                {{-- Konten Utama --}}
                <main class="col-md-10 ms-sm-auto p-4">
                    {{-- Header --}}
                    <div
                        class="navbar-header mb-4 d-flex justify-content-between align-items-center"
                    >
                        <h2>Dashboard</h2>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a
                                    href="{{ route('logout') }}"
                                    class="d-flex align-items-center text-dark text-decoration-none"
                                >
                                    <i
                                        class="rounded-circle me-2 bi bi-dash-circle-fill"
                                    ></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Data Bidang --}}
                    <div class="card">
                        <div
                            class="card-header bg-white fw-bold d-flex justify-content-between align-items-center"
                        >
                            <span>Data Rekomendasi Produk</span>
                            <button
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalTambah"
                            >
                                <i class="bi bi-plus-lg"></i> Tambah Data
                            </button>
                        </div>
                        <div class="card-body">
                            <table
                                id="tabelBidang"
                                class="table table-striped table-bordered w-100"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Rekomendasi</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Kategori</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekomendasi as $no => $b)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $b->rekomendasi_nama}}</td>
                                        <td>{{ $b->produk_nama }}</td>
                                        <td>
                                            Rp.
                                            {{ number_format($b->produk_harga, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $b->produk_stok }}</td>
                                        <td>{{ $b->kategori_nama }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($b->rekomendasi_tanggal)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>
                                            @if($b->rekomendasi_status == '1')
                                            <span class="badge bg-success"
                                                >Aktif</span
                                            >
                                            @else
                                            <span class="badge bg-secondary"
                                                >Tidak Aktif</span
                                            >
                                            @endif
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btnEdit"
                                                data-id="{{ $b->rekomendasi_id }}"
                                                data-nama="{{ $b->rekomendasi_nama }}"
                                                data-produk="{{ $b->rekomendasi_produk }}"
                                                data-status="{{ $b->rekomendasi_status }}"
                                                data-tanggal="{{ $b->rekomendasi_tanggal }}"
                                                data-ket="{{ $b->rekomendasi_keterangan }}"
                                            >
                                                Edit
                                            </button>
                                            <!-- <button
                                                class="btn btn-sm btn-danger btnHapus"
                                                data-id="{{ $b->rekomendasi_id }}"
                                                data-nama="{{ $b->rekomendasi_nama }}"
                                            >
                                                Hapus
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Footer --}}
                    @include('admin.partials.footeradmin')
                </main>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div
            class="modal fade"
            id="modalTambah"
            tabindex="-1"
            aria-labelledby="modalTambahLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form
                    action="{{ route('admin.rekomendasi.simpan') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">
                                Tambah Data Rekomendasi Produk
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Rekomendasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="rekomendasi_nama"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label>Produk</label>
                                <select
                                    class="form-select"
                                    name="rekomendasi_produk"
                                    required
                                >
                                    @foreach ($produk as $k)
                                    <option value="{{ $k->produk_id }}">
                                        {{ $k->produk_nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="rekomendasi_tanggal"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select
                                    class="form-select"
                                    name="rekomendasi_status"
                                    required
                                >
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Keterangan</label>
                                <textarea
                                    class="form-control"
                                    name="rekomendasi_keterangan"
                                    rows="3"
                                ></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div
            class="modal fade"
            id="modalEdit"
            tabindex="-1"
            aria-labelledby="modalEditLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">
                                Edit Data Rekomendasi Produk
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Rekomendasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_nama"
                                    name="rekomendasi_nama"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label>Produk</label>
                                <select
                                    class="form-select"
                                    id="edit_produk"
                                    name="rekomendasi_produk"
                                    required
                                >
                                    @foreach ($produk as $k)
                                    <option value="{{ $k->produk_id }}">
                                        {{ $k->produk_nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="edit_tanggalmasuk"
                                    name="rekomendasi_tanggal"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select
                                    class="form-select"
                                    id="edit_status"
                                    name="rekomendasi_status"
                                    required
                                >
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Keterangan</label>
                                <textarea
                                    class="form-control"
                                    id="edit_ket"
                                    name="rekomendasi_keterangan"
                                    rows="3"
                                ></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Hapus --}}
        <div
            class="modal fade"
            id="modalHapus"
            tabindex="-1"
            aria-labelledby="modalHapusLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form id="formHapus" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalHapusLabel">
                                Hapus Data
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Yakin ingin menghapus data
                                <b id="hapus_nama"></b>?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Hapus
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- jQuery harus duluan --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- DataTables --}}
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                // Init DataTable
                $("#tabelBidang").DataTable({
                    responsive: true,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    },
                });

                // Edit Button
                $(".btnEdit").click(function () {
                    let id = $(this).data("id");
                    let nama = $(this).data("nama");
                    let produk = $(this).data("produk");
                    let status = $(this).data("status");
                    let tanggal = $(this).data("tanggal");
                    let ket = $(this).data("ket");

                    $("#formEdit").attr(
                        "action",
                        "/admin/rekomendasi/update/" + id
                    );
                    $("#edit_nama").val(nama);
                    $("#edit_produk").val(produk);
                    $("#edit_status").val(status);
                    $("#edit_tanggalmasuk").val(tanggal);
                    $("#edit_ket").val(ket);

                    let modalEdit = new bootstrap.Modal(
                        document.getElementById("modalEdit")
                    );
                    modalEdit.show();
                });

                // Hapus Button
                $(".btnHapus").click(function () {
                    let id = $(this).data("id");
                    let nama = $(this).data("nama");

                    $("#formHapus").attr(
                        "action",
                        "/admin/rekomendasi/delete/" + id
                    );
                    $("#hapus_nama").text(nama);

                    let modalHapus = new bootstrap.Modal(
                        document.getElementById("modalHapus")
                    );
                    modalHapus.show();
                });
            });
        </script>
    </body>
</html>
