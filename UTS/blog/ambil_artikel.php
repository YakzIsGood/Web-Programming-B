<?php
require 'koneksi.php';
$baseUrl = 'http://localhost:8080/Web_Programming_Praktikum/blog/';

$query = "SELECT a.*, p.nama_depan, p.nama_belakang, k.nama_kategori 
          FROM artikel a
          JOIN penulis p ON a.id_penulis = p.id
          JOIN kategori_artikel k ON a.id_kategori = k.id
          ORDER BY a.id DESC";

$result = $db->query($query);

echo '<table class="table borderless mb-0">
        <thead>
            <tr>
                <th width="15%">GAMBAR</th>
                <th width="25%">JUDUL</th>
                <th width="15%">KATEGORI</th>
                <th width="15%">PENULIS</th>
                <th width="15%">TANGGAL</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gambar = trim($row['gambar']);
        $gambarUrl = empty($gambar) ? '' : $baseUrl . 'uploads_artikel/' . htmlspecialchars($gambar);
        
        echo '<tr>
                <td>
                    <img src="' . $gambarUrl . '" class="table-avatar" style="width:55px; height:55px; object-fit:cover; border-radius:6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" 
                    onerror="this.onerror=null; this.src=\'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1NSIgaGVpZ2h0PSI1NSIgdmlld0JveD0iMCAwIDU1IDU1Ij48cmVjdCB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIGZpbGw9IiNlOWVjZWYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZmlsbD0iIzZMNzU3RCIgZm9udC1zaXplPSIxMHB4IiBkeT0iLjNlbSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+R0FNQkFSPC90ZXh0Pjwvc3ZnPg==\';">
                </td>
                <td><strong>' . htmlspecialchars($row['judul']) . '</strong></td>
                <td><span class="badge-blue">' . htmlspecialchars($row['nama_kategori']) . '</span></td>
                <td>' . htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) . '</td>
                <td><small>' . htmlspecialchars($row['hari_tanggal']) . '</small></td>
                <td>
                    <button class="btn-edit" onclick="showForm(\'artikel\', ' . $row['id'] . ')">Edit</button>
                    <button class="btn-hapus" onclick="deleteData(\'artikel\', ' . $row['id'] . ')">Hapus</button>
                </td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center text-muted">Belum ada data artikel.</td></tr>';
}

echo '</tbody></table>';

$db->close();
?>