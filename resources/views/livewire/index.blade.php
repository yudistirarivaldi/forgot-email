<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container mt-5">

    <h2>Data Pembelian</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">No Pembelian</th>
                <th scope="col">Tanggal Pembelian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pembelian)
                <tr>
                    <th scope="row">{{ $pembelian->id }}</th>
                    <td>{{ $pembelian->no_pembelian }}</td>
                    <td>{{ $pembelian->tgl_pembelian }}</td>
                    <td>
                        <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-pembelian-btn" data-id="{{ $pembelian->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-pembelian-btn').forEach(button => {
        button.addEventListener('click', function() {
            const pembelianId = this.getAttribute('data-id');

            if (confirm('Apakah Anda yakin ingin menghapus pembelian ini?')) {
                axios.delete(`/pembelian/${pembelianId}`, {
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    alert(response.data.message);
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
            }
        });
    });
});
</script>
</body>
</html>
