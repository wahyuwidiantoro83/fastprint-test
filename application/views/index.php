<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=  base_url().'public/assets/css/style.css' ?>">
    <script src="<?=  base_url().'public/assets/js/jquery-3.7.1.min.js' ?>"></script>
    <title>Data Produk | Wahyu Widiantoro</title>
</head>
<body>
    <div class="container">
    <h1 class='title'>Data Produk</h1>
    <div class='header-bar'>
        <a class="btn-tambah" href="<?= base_url().'produk/tambah'?>">Tambah</a>
        <Select class="filter">
            <option value="">Show All</option>
            <?php foreach($status as $s): ?>
            <option value="<?= $s['id_status'] ?>"><?= $s['nama_status'] ?></option>
            <?php endforeach ?>
        </Select>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="data-table">
            <?php foreach($result as $r): ?>
                <tr>
                    <td><?= $r['id_produk'] ?></td>
                    <td><?= $r['nama_produk'] ?></td>
                    <td><?= $r['kategori'] ?></td>
                    <td><?= $r['harga'] ?></td>
                    <td><?= $r['status'] ?></td>
                    <td>
                        <div class='button-group'>
                            <a class="btn-ubah" href="<?=base_url()."produk/ubah/".$r['id_produk'];?>">Ubah</a>
                            <button class='btn-hapus' data-item-id="<?= $r['id_produk']?>">Hapus</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
<script>
$(document).ready(function () {
    $('table').on('click', '.btn-hapus', function (e) {
        e.preventDefault();
        let id = $(this).data('item-id');
        let confirmed = confirm(`Hapus produk dengan id : ${id}`)

        if (confirmed) {
            $.ajax({
                url: 'http://localhost/fastprint/delete/' + id,
                type: 'DELETE',
                success: function(response) {
                    console.log('Item deleted successfully');
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error deleting item');
                }
            });
        }

    });
    $('.filter').on('change',function(e){
        let filter = e.target.value;

            $.ajax({
                url: `http://localhost/fastprint/API/produk?status=${filter}`,
                type: 'GET',
                success: function(response) {

                    $('.data-table').empty();

                    let data = JSON.parse(response);
                    let output = data.map((value,idx)=>{
                        return `<tr>
                                    <td>${value.id_produk}</td>
                                    <td>${value.nama_produk}</td>
                                    <td>${value.harga}</td>
                                    <td>${value.kategori}</td>
                                    <td>${value.status}</td>
                                    <td>
                                    <div class='button-group'>
                                        <a class="btn-ubah" href="http://localhost/fastprint/produk/ubah/${value.id_produk}">Ubah</a>
                                        <button class="btn-hapus" data-item-id="${value.id_produk}">Hapus</button>
                                    </div>
                                    </td>
                                </tr>`
                    }).join('')

                    $('.data-table').append(output);
                },
                error: function(error) {
                    console.error('Error get item');
                }
            });

    });
});
</script>
</html>