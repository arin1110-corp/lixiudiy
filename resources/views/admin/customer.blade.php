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
                                    class="d-flex align-items-center text-dark text-decoration-none">
                                    <i class="rounded-circle me-2 bi bi-dash-circle-fill"></i>
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
                            <span>Data Customer</span>
                        </div>
                        <div class="card-body">
                            <table
                                id="tabelBidang"
                                class="table table-striped table-bordered w-100"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Customer</th>
                                        <th>No Telepon Customer</th>
                                        <th>Email Customer</th>
                                        <th>Tanggal Daftar Customer</th>
                                        <th>Status Customer</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $no => $b)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $b->customer_nama}}</td>
                                        <td>{{ $b->customer_telepon }}</td>
                                        <td>{{ $b->customer_email}}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($b->customer_tanggaldaftar)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>
                                            @if($b->customer_status == '1')
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
                                                data-id="{{ $b->customer_id }}"
                                                data-nama="{{ $b->customer_nama }}"
                                                data-produk="{{ $b->customer_telepon }}"
                                                data-status="{{ $b->customer_status }}"
                                                data-tanggal="{{ $b->customer_tanggaldaftar }}"
                                                data-email="{{ $b->customer_email }}"
                                                data-notelp="{{ $b->customer_telepon }}"
                                                data-tgllahir="{{ $b->customer_tanggallahir }}"
                                                data-alamat="{{ $b->customer_alamat }}"
                                            >
                                                Lihat Data
                                            </button>
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
                                Lihat Data Customer
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label"
                                    >Nama Customer</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_nama"
                                    name="nama"
                                    readonly
                                />
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label"
                                    >Email Customer</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="edit_email"
                                    name="email"
                                    readonly
                                />
                            </div>
                            <div class="mb-3">
                                <label for="edit_notelp" class="form-label"
                                    >No Telepon Customer</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_notelp"
                                    name="notelp"
                                    readonly
                                />
                            </div>
                            <div class="mb-3">
                                <label for="edit_tgllahir" class="form-label"
                                    >Tanggal Lahir Customer</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    id="edit_tgllahir"
                                    name="tgllahir"
                                    readonly
                                />
                            </div>
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label"
                                    >Alamat Customer</label
                                >
                                <textarea
                                    class="form-control"
                                    id="edit_alamat"
                                    name="alamat"
                                    rows="3"
                                    readonly
                                ></textarea>
                            </div>
                            <div class="mb-3">
                                <label
                                    for="edit_tanggalmasuk"
                                    class="form-label"
                                    >Tanggal Daftar Customer</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    id="edit_tanggalmasuk"
                                    name="tanggalmasuk"
                                    readonly
                                />
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label"
                                    >Status Customer</label
                                >
                                <select
                                    class="form-select"
                                    id="edit_status"
                                    name="status"
                                    disabled
                                >
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Batal
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
                    let email = $(this).data("email");
                    let notelp = $(this).data("notelp");
                    let tgllahir = $(this).data("tgllahir");
                    let alamat = $(this).data("alamat");
                    let tanggalmasuk = $(this).data("tanggal");
                    let status = $(this).data("status");

                    $("#formEdit").attr(
                        "action",
                        "/admin/customer/update/" + id
                    );
                    $("#edit_nama").val(nama);
                    $("#edit_email").val(email);
                    $("#edit_notelp").val(notelp);
                    $("#edit_tgllahir").val(tgllahir);
                    $("#edit_alamat").val(alamat);
                    $("#edit_tanggalmasuk").val(tanggalmasuk);
                    $("#edit_status").val(status);

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
