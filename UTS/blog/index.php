<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f0f2f5; color: #333; }
        
        .navbar { background-color: #2c3e50; color: white; padding: 15px 25px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 10; position: relative;}
        .navbar-icon { border: 1px solid rgba(255,255,255,0.3); width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; border-radius: 6px; margin-right: 15px; font-size: 16px;}
        .navbar h2 { margin: 0; font-size: 1.1rem; font-weight: 600;}
        .navbar small { color: #95a5a6; font-size: 0.8rem;}
        
        .container { display: flex; padding: 25px; gap: 25px; align-items: flex-start; min-height: calc(100vh - 120px); }
        
        .sidebar { width: 250px; background-color: white; border-radius: 10px; padding: 20px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-shrink: 0; }
        .sidebar-title { font-size: 0.75rem; color: #aaa; margin-left: 25px; margin-bottom: 15px; font-weight: bold; letter-spacing: 1px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { padding: 12px 20px; margin: 5px 15px; color: #666; border-radius: 6px; cursor: pointer; transition: 0.2s; font-size: 0.95rem; display: flex; align-items: center; }
        .sidebar-menu li i { width: 30px; font-size: 1.1rem; text-align: left; }
        .sidebar-menu li:hover { background-color: #f8f9fa; color: #333; }
        .sidebar-menu li.active { background-color: #e8f5e9; color: #2e7d32; border-left: 4px solid #2e7d32; font-weight: 600; padding-left: 16px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;}
        
        .content { flex: 1; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 30px; overflow-x: auto; }
        .d-flex-between { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { margin: 0; color: #444; font-size: 1.25rem; font-weight: 600; }
        
        .btn { padding: 9px 18px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 600; transition: 0.2s; }
        .btn-green { background-color: #4CAF50; color: white; }
        .btn-green:hover { background-color: #45a049; }
        .btn-blue { background-color: #0d6efd; color: white; }
        .btn-blue:hover { background-color: #0b5ed7; }
        
        .btn-edit { background-color: #3498db; color: white; padding: 7px 14px; font-size: 12px; border: none; cursor: pointer; border-radius: 4px; }
        .btn-edit:hover { background-color: #2980b9; }
        .btn-hapus { background-color: #ef4444; color: white; padding: 7px 14px; font-size: 12px; border: none; cursor: pointer; border-radius: 4px; margin-left: 5px;}
        .btn-hapus:hover { background-color: #dc2626; }
        
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #f4f4f4; vertical-align: middle; }
        .table th { color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .badge-blue { background-color: #e7f1ff; color: #0d6efd; padding: 5px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; display: inline-block;}
        
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 100; }
        .modal-content { background: white; width: 500px; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .modal-title { margin: 0; font-size: 1.2rem; color: #333;}
        .close-btn { cursor: pointer; font-size: 1.5rem; border: none; background: none; color: #aaa; transition: 0.2s;}
        .close-btn:hover { color: #333; }
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; color: #555;}
        .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-family: inherit;}
        .form-control:focus { outline: none; border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);}

        /* CSS KHUSUS UNTUK MODAL DELETE */
        .delete-icon { width: 70px; height: 70px; background-color: #ffe5e5; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto; }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-icon"><i class="fa-solid fa-table-columns"></i></div>
        <div>
            <h2>Sistem Manajemen Blog (CMS)</h2>
            <small>Blog Keren</small>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="sidebar-title">MENU UTAMA</div>
            <ul class="sidebar-menu">
                <li onclick="loadPage('penulis')" id="menu-penulis"><i class="fa-regular fa-user"></i> Kelola Penulis</li>
                <li onclick="loadPage('artikel')" id="menu-artikel"><i class="fa-regular fa-file-lines"></i> Kelola Artikel</li>
                <li onclick="loadPage('kategori')" id="menu-kategori" class="active"><i class="fa-regular fa-folder"></i> Kelola Kategori</li>
            </ul>
        </div>
        <div class="content">
            <div class="d-flex-between">
                <h3 id="page-title" class="page-title">Data Kategori Artikel</h3>
                <button class="btn btn-green" onclick="showForm()" id="btn-add">+ Tambah Kategori</button>
            </div>
            <div id="data-container">
                </div>
        </div>
    </div>

    <div class="modal" id="formModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Form</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="mainForm" onsubmit="saveData(event)" enctype="multipart/form-data">
                <input type="hidden" id="form_id" name="id">
                <input type="hidden" id="form_type">
                <div id="dynamic-form-fields"></div>
                <div style="text-align: right; margin-top: 25px;">
                    <button type="button" class="btn" style="background:#e0e0e0; color:#333; margin-right:10px;" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-blue">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-content" style="width: 380px; text-align: center; padding: 40px 30px;">
            <div class="delete-icon">
                <i class="fa-regular fa-trash-can"></i>
            </div>
            <h3 style="margin: 20px 0 10px; color: #333; font-size: 1.3rem;">Hapus data ini?</h3>
            <p style="color: #999; font-size: 0.95rem; margin-bottom: 30px;">Data yang dihapus tidak dapat dikembalikan.</p>
            <div style="display: flex; justify-content: center; gap: 15px;">
                <button class="btn" style="background-color: #a0a0a0; color: white; width: 130px; font-weight: normal; font-size: 1rem;" onclick="closeDeleteModal()">Batal</button>
                <button class="btn" style="background-color: #ef4444; color: white; width: 130px; font-weight: normal; font-size: 1rem;" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 'kategori';
        let deleteTargetType = '';
        let deleteTargetId = '';

        $(document).ready(function() {
            loadPage('kategori');
        });

        function loadPage(page) {
            currentPage = page;
            $('.sidebar-menu li').removeClass('active');
            $('#menu-' + page).addClass('active');
            
            let titles = {
                'penulis': 'Data Penulis',
                'artikel': 'Data Artikel',
                'kategori': 'Data Kategori Artikel'
            };
            let btnLabels = {
                'penulis': '+ Tambah Penulis',
                'artikel': '+ Tambah Artikel',
                'kategori': '+ Tambah Kategori'
            };
            
            $('#page-title').text(titles[page]);
            $('#btn-add').text(btnLabels[page]);
            
            refreshData();
        }

        function refreshData() {
            $('#data-container').html('<p style="text-align:center; padding: 30px; color:#888;">Memuat data...</p>');
            $.ajax({
                url: 'ambil_' + currentPage + '.php',
                type: 'GET',
                success: function(response) {
                    $('#data-container').html(response);
                },
                error: function() {
                    $('#data-container').html('<p style="color:red; text-align:center; padding: 30px;">Gagal memuat data. Periksa koneksi atau file PHP.</p>');
                }
            });
        }

        function showForm(type = currentPage, id = null) {
            $('#form_type').val(type);
            $('#form_id').val('');
            $('#dynamic-form-fields').empty();
            
            let fields = '';
            
            if (type === 'kategori') {
                $('#modal-title').text(id ? 'Edit Kategori' : 'Tambah Kategori Baru');
                fields = `
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                    </div>
                `;
            } else if (type === 'penulis') {
                $('#modal-title').text(id ? 'Edit Data Penulis' : 'Tambah Penulis Baru');
                let pwdReq = id ? '' : 'required';
                let pwdNote = id ? '<small style="color:#888; display:block; margin-top:5px;">* Kosongkan jika tidak ingin mengubah password</small>' : '';
                fields = `
                    <div style="display:flex; gap:15px;">
                        <div class="form-group" style="flex:1;">
                            <label>Nama Depan</label>
                            <input type="text" name="nama_depan" id="nama_depan" class="form-control" required autocomplete="off">
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label>Nama Belakang</label>
                            <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" ${pwdReq}>
                        ${pwdNote}
                    </div>
                    <div class="form-group">
                        <label>Foto Profil (Opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    </div>
                `;
            } else if (type === 'artikel') {
                $('#modal-title').text(id ? 'Edit Artikel' : 'Tulis Artikel Baru');
                fields = `
                    <div class="form-group">
                        <label>Judul Artikel</label>
                        <input type="text" name="judul" id="judul" class="form-control" required autocomplete="off">
                    </div>
                    <div style="display:flex; gap:15px;">
                        <div class="form-group" style="flex:1;">
                            <label>Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-control" required></select>
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label>Penulis</label>
                            <select name="id_penulis" id="id_penulis" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Isi Artikel</label>
                        <textarea name="isi" id="isi" class="form-control" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar Artikel (Opsional)</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    </div>
                `;
            }
            
            $('#dynamic-form-fields').html(fields);
            
            if (type === 'artikel') {
                $.get('ambil_kategori.php?format=option', function(data) { $('#id_kategori').html(data); });
                $.get('ambil_penulis.php?format=option', function(data) { $('#id_penulis').html(data); });
            }

            if (id) {
                $('#form_id').val(id);
                $.ajax({
                    url: 'ambil_satu_' + type + '.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(data) {
                        if (type === 'kategori') {
                            $('#nama_kategori').val(data.nama_kategori);
                            $('#keterangan').val(data.keterangan);
                        } else if (type === 'penulis') {
                            $('#nama_depan').val(data.nama_depan);
                            $('#nama_belakang').val(data.nama_belakang);
                            $('#user_name').val(data.user_name);
                        } else if (type === 'artikel') {
                            setTimeout(function() {
                                $('#judul').val(data.judul);
                                $('#id_kategori').val(data.id_kategori);
                                $('#id_penulis').val(data.id_penulis);
                                $('#isi').val(data.isi);
                            }, 200); 
                        }
                        $('#formModal').css('display', 'flex');
                    }
                });
            } else {
                $('#formModal').css('display', 'flex');
            }
        }

        function closeModal() {
            $('#formModal').hide();
            $('#mainForm')[0].reset();
        }

        function saveData(e) {
            e.preventDefault();
            let type = $('#form_type').val();
            let id = $('#form_id').val();
            let url = id ? 'update_' + type + '.php' : 'simpan_' + type + '.php';
            
            let formData = new FormData(document.getElementById('mainForm'));
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.trim() === 'sukses') {
                        closeModal();
                        refreshData();
                    } else {
                        alert('Gagal menyimpan data.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan pada server.');
                }
            });
        }

        /* FUNGSI BARU UNTUK POP-UP HAPUS */
        function deleteData(type, id) {
            deleteTargetType = type;
            deleteTargetId = id;
            $('#deleteModal').css('display', 'flex');
        }

        function closeDeleteModal() {
            $('#deleteModal').hide();
            deleteTargetType = '';
            deleteTargetId = '';
        }

        function confirmDelete() {
            if (deleteTargetType && deleteTargetId) {
                $.ajax({
                    url: 'hapus_' + deleteTargetType + '.php',
                    type: 'POST',
                    data: { id: deleteTargetId },
                    success: function(response) {
                        if (response.trim() === 'sukses') {
                            closeDeleteModal();
                            refreshData();
                        } else {
                            alert('Gagal menghapus data.');
                            closeDeleteModal();
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan pada server.');
                        closeDeleteModal();
                    }
                });
            }
        }
    </script>
</body>
</html>