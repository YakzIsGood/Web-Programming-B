<?php
require 'koneksi.php';
$baseUrl = 'http://localhost:8080/Web_Programming_Praktikum/blog/';

if (isset($_GET['format']) && $_GET['format'] == 'option') {
    $query = "SELECT * FROM penulis ORDER BY nama_depan ASC";
    $result = $db->query($query);
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) . '</option>';
    }
} else {
    $query = "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC";
    $result = $db->query($query);
    
    echo '<table class="table borderless mb-0">
            <thead>
                <tr>
                    <th width="15%">FOTO</th>
                    <th width="25%">NAMA</th>
                    <th width="20%">USERNAME</th>
                    <th width="20%">PASSWORD</th>
                    <th width="20%">AKSI</th>
                </tr>
            </thead>
            <tbody>';
            
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $foto = trim($row['foto']);
            $fotoUrl = (empty($foto) || $foto === 'default.png') ? $baseUrl . 'upload_penulis/default.png' : $baseUrl . 'upload_penulis/' . htmlspecialchars($foto);
            
            echo '<tr>
                    <td>
                        <img src="' . $fotoUrl . '" class="table-avatar" style="width:45px; height:45px; object-fit:cover; border-radius:50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" 
                        onerror="this.onerror=null; this.src=\'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0NSIgaGVpZ2h0PSI0NSIgdmlld0JveD0iMCAwIDQ1IDQ1Ij48cmVjdCB3aWR0aD0iNDUiIGhlaWdodD0iNDUiIGZpbGw9IiNlOWVjZWYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZmlsbD0iIzZMNzU3RCIgZm9udC1zaXplPSIxMHB4IiBkeT0iLjNlbSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+Rk9UTzwvdGV4dD48L3N2Zz4=\';">
                    </td>
                    <td>' . htmlspecialchars($row['nama_depan']) . ' ' . htmlspecialchars($row['nama_belakang']) . '</td>
                    <td><span class="badge-blue">' . htmlspecialchars($row['user_name']) . '</span></td>
                    <td class="text-muted fw-bold">********</td>
                    <td>
                        <button class="btn-edit" onclick="showForm(\'penulis\', ' . $row['id'] . ')">Edit</button>
                        <button class="btn-hapus" onclick="deleteData(\'penulis\', ' . $row['id'] . ')">Hapus</button>
                    </td>
                  </tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center text-muted">Belum ada data penulis.</td></tr>';
    }
    
    echo '</tbody></table>';
}

$db->close();
?>