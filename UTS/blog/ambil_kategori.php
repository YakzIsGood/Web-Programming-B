<?php
require 'koneksi.php';

if (isset($_GET['format']) && $_GET['format'] == 'option') {
    $query = "SELECT id, nama_kategori FROM kategori_artikel ORDER BY nama_kategori ASC";
    $result = $db->query($query);
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nama_kategori']) . '</option>';
    }
} else {
    $query = "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY id DESC";
    $result = $db->query($query);
    
    echo '<table class="table borderless mb-0">
            <thead>
                <tr>
                    <th width="30%">NAMA KATEGORI</th>
                    <th width="50%">KETERANGAN</th>
                    <th width="20%">AKSI</th>
                </tr>
            </thead>
            <tbody>';
            
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td><span class="badge-blue">' . htmlspecialchars($row['nama_kategori']) . '</span></td>
                    <td>' . htmlspecialchars($row['keterangan']) . '</td>
                    <td>
                        <button class="btn-edit" onclick="showForm(\'kategori\', ' . $row['id'] . ')">Edit</button>
                        <button class="btn-hapus" onclick="deleteData(\'kategori\', ' . $row['id'] . ')">Hapus</button>
                    </td>
                  </tr>';
        }
    } else {
        echo '<tr><td colspan="3" class="text-center text-muted">Belum ada data kategori.</td></tr>';
    }
    
    echo '</tbody></table>';
}

$db->close();
?>