<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container">

    <h2>Tambah Pembelian</h2>
    <form id="savePembelianForm">
        <div class="mb-3">
            <label for="no_pembelian" class="form-label">No Pembelian</label>
            <input type="text" class="form-control" id="no_pembelian" required>
        </div>
        <div class="mb-3">
            <label for="tgl_pembelian" class="form-label">Tanggal Pembelian</label>
            <input type="date" class="form-control" id="tgl_pembelian" required>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#barangModal">Tambah Barang</button>

        <h2>Barang yang Dipilih</h2>
        <table class="table" id="selectedBarangTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="selectedBarangs">
                <!-- Barang yang dipilih akan ditambahkan di sini -->
            </tbody>
        </table>
        <button type="button" class="btn btn-success" id="savePembelianBtn">Simpan Pembelian</button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel">Pilih Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="barangTable">
                            <!-- Data akan diisi dengan JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="selectBarangBtn">Pilih Barang</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/barang')
        .then(response => {
            const barangData = response.data;
            const tableBody = document.getElementById('barangTable');
            barangData.forEach(barang => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${barang.id}</th>
                    <td>${barang.nama_barang}</td>
                    <td><input type="checkbox" class="form-check-input barang-checkbox" value="${barang.id}" data-nama-barang="${barang.nama_barang}"></td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error(error);
        });

    document.getElementById('selectBarangBtn').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.barang-checkbox:checked');
        const selectedBarangContainer = document.getElementById('selectedBarangs');

        checkboxes.forEach(checkbox => {
            const barangId = checkbox.value;
            const barangNama = checkbox.getAttribute('data-nama-barang');

            const row = document.createElement('tr');
            row.innerHTML = `
                <th scope="row">${barangId}</th>
                <td>${barangNama}</td>
                <td><input type="number" class="form-control" value="0" min="0" step="0.01" placeholder="Harga Beli"></td>
                <td><button class="btn btn-danger btn-sm remove-barang-btn">Hapus</button></td>
            `;

            selectedBarangContainer.appendChild(row);

            row.querySelector('.remove-barang-btn').addEventListener('click', function() {
                row.remove();
            });
        });

        const modal = document.getElementById('barangModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    });

    document.getElementById('savePembelianBtn').addEventListener('click', function() {
        const noPembelian = document.getElementById('no_pembelian').value;
        const tglPembelian = document.getElementById('tgl_pembelian').value;
        const selectedBarangs = [];
        document.querySelectorAll('#selectedBarangs tr').forEach(row => {
            selectedBarangs.push({
                id_barang: row.children[0].innerText,
                harga_beli: row.children[2].querySelector('input').value
            });
        });

        axios.post('{{ route("save-pembelian") }}', {
            no_pembelian: noPembelian,
            tgl_pembelian: tglPembelian,
            selectedBarangs: selectedBarangs
        })
        .then(response => {
            alert(response.data.message);
        })
        .catch(error => {
            console.error(error);
        });
    });
});
</script>
</body>
</html>
