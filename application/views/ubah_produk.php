<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk | Wahyu Widiantoro</title>
    <style>
        .form-container{
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 50%;
        }
        .form-group{
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        input{
            padding: 8px;
        }
        select{
            padding: 8px;
        }

        .button-group{
            display: flex;
            justify-content: flex-end;
        }

        .btn-submit{
            padding: 8px 12px 8px 12px;
            background-color: blue;
            color: whitesmoke;
            font-weight: bold;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div>
        <?php echo $validation_errors; ?>
        <h1>Ubah Produk</h1>
        <form class='form-container' action="<?= base_url().'aksi/ubahproduk'?>" method="post">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="id_produk" value="<?= $data_produk->id_produk ?>">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" value="<?= $data_produk->nama_produk ?>">
            </div>
            <div class="form-group">
                <label for="harga">Harga Produk</label>
                <input type="number" name="harga" id="harga" value="<?= $data_produk->harga ?>">
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <Select name="kategori" id="kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach($kategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] === "$data_produk->kategori_id" ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                    <?php endforeach ?>
                </Select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <Select name="status" id="status">
                <option value="">-- Pilih Status --</option>
                    <?php foreach($status as $s): ?>
                    <option value="<?= $s['id_status'] ?>" <?= $s['id_status'] === "$data_produk->status_id" ? 'selected' : '' ?>><?= $s['nama_status'] ?></option>
                    <?php endforeach ?>
                </Select>
            </div>
            <div class="button-group">
                <button class="btn-submit" type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>