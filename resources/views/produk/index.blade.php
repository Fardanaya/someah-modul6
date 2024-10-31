<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Produk</title>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container mt-4">
        <h2>Data Produk</h2>
        {{-- Button filter kategori --}}
        <div class="form-group">
            <label for="filter_kategori">Filter Kategori</label>
            <select id="filter_kategori" class="form-control mb-3">
                <option value="">Semua Kategori</option>
            </select>
        </div>
        <button id="addProdukBtn" class="btn btn-primary mb-3">Add Produk</button>
        <table class="table table-bordered" id="produk-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <div id="produkModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditProdukForm">
                        <input type="hidden" id="produk_id" name="produk_id">
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option>Pilih kategori</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $.get("{{ url('api/kategori') }}", function(data) {
                $.each(data.data, function(index, kategori) {
                    $('#kategori_id').append(new Option(kategori.nama_kategori, kategori.id));
                    $('#filter_kategori').append(new Option(kategori.nama_kategori, kategori.id));
                });
            });

            var allProducts = []; //filtering dari client site biar gak ngeberatin hit api
            var table = $('#produk-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ url('api/produk') }}",
                    dataSrc: function(json) {
                        allProducts = json.data.data;
                        return allProducts;
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = "Terjadi kesalahan: " + xhr.status;
                        alert(errorMessage);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama_produk', name: 'nama_produk' },
                    { data: 'harga', name: 'harga' },
                    { data: 'deskripsi', name: 'deskripsi' },
                    { data: 'kategori.nama_kategori', name: 'kategori.nama_kategori' },
                    {
                        data: null,
                        name: 'actions',
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                            `;
                        }
                    }
                ],
            });

            // di trigger ketika selector filter ada perubahan 
            function renderTable(products) {
                table.clear();
                table.rows.add(products);
                table.draw();
            }

            $('#filter_kategori').change(function() {
                var selectedKategori = $(this).val();
                var filteredProducts = allProducts;

                if (selectedKategori) {
                    filteredProducts = allProducts.filter(function(product) {
                        return product.kategori.id == selectedKategori;
                    });
                }

                renderTable(filteredProducts);
            });

            $('#addProdukBtn').click(function() {
                $('#addEditProdukForm')[0].reset();
                $('#produk_id').val('');
                $('#produkModal').modal('show');
            });

            $('#addEditProdukForm').submit(function(e) {
                e.preventDefault();
                var produkId = $('#produk_id').val();
                var formData = {
                    nama_produk: $('#nama_produk').val(),
                    harga: $('#harga').val(),
                    deskripsi: $('#deskripsi').val(),
                    kategori_id: $('#kategori_id').val()
                };
                var type = produkId ? 'PUT' : 'POST';
                var url = produkId ? "{{ url('api/produk') }}/" + produkId : "{{ url('api/produk') }}";

                $.ajax({
                    url: url,
                    type: type,
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        alert('Produk berhasil disimpan');
                        $('#produkModal').modal('hide');
                        $('#produk-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Error ' + xhr.status + ': ' + xhr.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                $.get("{{ url('api/produk') }}/" + id, function(data) {
                    $('#produk_id').val(data.data.id);
                    $('#nama_produk').val(data.data.nama_produk);
                    $('#harga').val(data.data.harga);
                    $('#deskripsi').val(data.data.deskripsi);
                    $('#kategori_id').val(data.data.kategori.id);
                    $('#produkModal').modal('show');
                });
            });

            $(document).on('click', '.delete-btn', function() {
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('api/produk') }}/" + id,
                        type: 'DELETE',
                        success: function(response) {
                            alert('Produk berhasil dihapus');
                            $('#produk-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Error ' + xhr.status + ': ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
