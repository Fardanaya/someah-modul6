<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kategori List</title>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container mt-4">
        <h2>Data Kategori</h2>
        <button id="addKategoriBtn" class="btn btn-primary mb-3">Add Kategori</button>
        <table class="table table-bordered" id="kategori-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Actions</th> 
                </tr>
            </thead>
        </table>
    </div>

    <div id="kategoriModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditKategoriForm">
                        <input type="hidden" id="kategori_id" name="kategori_id">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori"
                             name="nama_kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#kategori-table').DataTable({
            processing: true,
            serverSide: false,  
            ajax: {
                url: "{{ url('api/kategori') }}", 
                dataSrc: function (json) {
                    return json.data.data;
                },
                error: function(xhr, status, error) {
                    var errorMessage = "Terjadi kesalahan: " + xhr.status;
                    alert(errorMessage);
                    $('#kategori-table').DataTable().clear().draw();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nama_kategori', name: 'nama_kategori'},
                {data: 'deskripsi', name: 'deskripsi'},
                {
                    data: null,
                    name: 'actions',
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                        `;
                    }
                }
            ]
        });
        $('#addKategoriBtn').click(function() {
            $('#addEditKategoriForm')[0].reset();
            $('#kategori_id').val('');
            $('#kategoriModal').modal('show');
        });

        $('#addEditKategoriForm').submit(function(e) {
            e.preventDefault(); 
            var kategoriId = $('#kategori_id').val();
            var formData = {
                nama_kategori: $('#nama_kategori').val(),
                deskripsi: $('#deskripsi').val()
            };
            var type = kategoriId ? 'PUT' : 'POST';  
            var url = kategoriId ? "{{ url('api/kategori') }}/" + kategoriId : "{{ url('api/kategori') }}";

            $.ajax({
                url: url,
                type: type,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    alert('Kategori berhasil disimpan');
                    $('#kategoriModal').modal('hide');  
                    $('#kategori-table').DataTable().ajax.reload();  
                },
                error: function(xhr) {
                    var errorMessage = 'Error ' + xhr.status + ': ' + xhr.responseJSON.message;
                    alert(errorMessage);
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.get("{{ url('api/kategori') }}/" + id, function(data) {
                $('#kategori_id').val(data.data.id);
                $('#nama_kategori').val(data.data.nama_kategori);
                $('#deskripsi').val(data.data.deskripsi);
                $('#kategoriModal').modal('show');
            });
        });
        $(document).on('click', '.delete-btn', function() {
            if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('api/kategori') }}/" + id,
                    type: 'DELETE',
                    success: function(response) {
                        alert('Kategori berhasil dihapus');
                        $('#kategori-table').DataTable().ajax.reload();  
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error ' + xhr.status + ': ' + xhr.responseJSON.message;
                        alert(errorMessage);
                    }
                });
            }
        });
    });
    </script>

</body>
</html>


