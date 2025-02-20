<?php
include 'db_conexion.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM productos WHERE id=:id";
        $stmt = $cnnPDO->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $message = "Producto eliminado exitosamente.";
            $messageType = 'success';
        } else {
            $message = "Error al eliminar el producto.";
            $messageType = 'error';
        }
    } else if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $created_by = 1; 

        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $query = "INSERT INTO productos (name, price, category, description, image, created_by) VALUES (:name, :price, :category, :description, :image, :created_by)";
            $stmt = $cnnPDO->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':created_by', $created_by);

            if ($stmt->execute()) {
                $message = "Producto agregado exitosamente.";
                $messageType = 'success';
            } else {
                $message = "Error al agregar el producto.";
                $messageType = 'error';
            }
        } else {
            $message = "Error al subir la imagen.";
            $messageType = 'error';
        }
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $created_by = $_POST['created_by'];

        $query = "UPDATE productos SET name=:name, price=:price, category=:category, description=:description, created_by=:created_by WHERE id=:id";
        $stmt = $cnnPDO->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':created_by', $created_by);

        if ($stmt->execute()) {
            $message = "Producto actualizado exitosamente.";
            $messageType = 'success';
        } else {
            $message = "Error al actualizar el producto.";
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Productos</title>
    <link rel="stylesheet" href="stylebienvenida.css">
       <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>55
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <style>
    .product-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }
    .card {
        background: #1e1e1e;
        border: 2px solid #00bfff;
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        position: relative;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        cursor: pointer;
    }
    .card:hover {
        transform: scale(1.1);
        box-shadow: 0px 4px 10px rgba(0, 191, 255, 0.5);
    }
    .edit-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 30px;
        right: 10px;
        background: #333;
        border-radius: 5px;
        padding: 5px;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
    .dropdown-menu button {
        display: block;
        background: none;
        border: none;
        color: white;
        padding: 5px;
        cursor: pointer;
    }
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        animation: fadeIn 0.3s ease;
    }
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        background: #222;
        padding: 20px;
        border-radius: 10px;
        color: white;
        width: 300px;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }
    .popup.show {
        display: block;
        transform: translate(-50%, -50%) scale(1);
    }
    .popup img {
        width: 100%;
        border-radius: 5px;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    </style>
</head>
<body>
    <div class="navbar">
        <button class="icon-button" onclick="openSidemenu()">☰</button>
        <div class="app-icon">
                <img id="logo" src="images/logo.png" alt="App Logo" />
            </div>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Buscar..." oninput="showSuggestions(this.value)">
            <div class="suggestions" id="suggestions"></div>
        </div>
        <a href="#" onclick="openAddPopup()">Agregar Producto</a>
        <div class="theme-toggle" onclick="toggleTheme()">🌙</div>
        <button class="icon-button"><i class="fas fa-shopping-cart"></i></button>
    </div>
    <div id="sidemenu" class="sidemenu">
        <a href="javascript:void(0)" class="closebtn" onclick="closeSidemenu()">&times;</a>
        <a href="#">Perfil</a>
        <a href="#">Mis Compras</a>
        <a href="#">Mis Ventas</a>
        <a href="#">Mis Reseñas</a>
        <a href="#">Cerrar Sesión</a>
    </div>
    <div class="main-content">
        <div class="sidebar">
            <h2>Filtrar por Categoría</h2>
            <ul class="category-list">
                <li><a href="#" onclick="filterCategory('Todos')">Todos</a></li>
                <li><a href="#" onclick="filterCategory('Electrónica')">Electrónica</a></li>
                <li><a href="#" onclick="filterCategory('Ropa')">Ropa</a></li>
                <li><a href="#" onclick="filterCategory('Hogar')">Hogar</a></li>
                <li><a href="#" onclick="filterCategory('Libros')">Libros</a></li>
                <li><a href="#" onclick="filterCategory('Juguetes')">Juguetes</a></li>
            </ul>
        </div>
        <div class="product-cards" id="product-cards">
            <?php
            $query = "SELECT * FROM productos";
            $stmt = $cnnPDO->query($query);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="card" data-category="' . htmlspecialchars($row['category']) . '" onclick="openPopup(' . $row['id'] . ')">';
                    echo '<button class="edit-button" onclick="toggleDropdown(event, ' . $row['id'] . ')">⋮</button>';
                    echo '<div class="dropdown-menu" id="dropdown-' . $row['id'] . '">';
                    echo '<button onclick="openEditPopup(event, ' . $row['id'] . ')">Editar</button>';
                    echo '<button onclick="confirmDelete(event, ' . $row['id'] . ')">Eliminar</button>';
                    echo '</div>';
                    echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text">Precio: ' . htmlspecialchars($row['price']) . '</p>';
                    echo '<p class="card-text">Categoría: ' . htmlspecialchars($row['category']) . '</p>';
                    echo '<p class="card-text">Descripción: ' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="card-text">Creado por: ' . htmlspecialchars($row['created_by']) . '</p>';
                    echo '<p class="card-text">Creado en: ' . htmlspecialchars($row['created_at']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="popup-overlay" id="overlay-' . $row['id'] . '" onclick="closePopup(' . $row['id'] . ')"></div>';
                    echo '<div class="popup" id="popup-' . $row['id'] . '">';
                    echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="info">';
                    echo '<h5>' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p>Precio: ' . htmlspecialchars($row['price']) . '</p>';
                    echo '<p>Categoría: ' . htmlspecialchars($row['category']) . '</p>';
                    echo '<p>Descripción: ' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p>Creado por: ' . htmlspecialchars($row['created_by']) . '</p>';
                    echo '<p>Creado en: ' . htmlspecialchars($row['created_at']) . '</p>';
                    echo '<button type="button" onclick="closePopup(' . $row['id'] . ')">Cerrar</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="popup" id="edit-popup-' . $row['id'] . '" style="display: none;">';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<input type="text" name="name" value="' . htmlspecialchars($row['name']) . '">';
                    echo '<input type="text" name="price" value="' . htmlspecialchars($row['price']) . '">';
                    echo '<select name="category">';
                    echo '<option value="Electrónica"' . ($row['category'] == 'Electrónica' ? ' selected' : '') . '>Electrónica</option>';
                    echo '<option value="Ropa"' . ($row['category'] == 'Ropa' ? ' selected' : '') . '>Ropa</option>';
                    echo '<option value="Hogar"' . ($row['category'] == 'Hogar' ? ' selected' : '') . '>Hogar</option>';
                    echo '<option value="Libros"' . ($row['category'] == 'Libros' ? ' selected' : '') . '>Libros</option>';
                    echo '<option value="Juguetes"' . ($row['category'] == 'Juguetes' ? ' selected' : '') . '>Juguetes</option>';
                    echo '</select>';
                    echo '<input type="text" name="description" value="' . htmlspecialchars($row['description']) . '">';
                    echo '<input type="text" name="created_by" value="' . htmlspecialchars($row['created_by']) . '">';
                    echo '<input type="submit" value="Guardar" class="btn btn-primary">';
                    echo '<button type="button" onclick="closeEditPopup(' . $row['id'] . ')">Cancelar</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }

            if ($message) {
                echo '<div class="notification ' . $messageType . '" id="notification">' . $message . '</div>';
            }
            ?>
        </div>
    </div>
    <div class="popup-overlay" id="add-overlay" onclick="closeAddPopup()"></div>
    <div class="popup" id="add-popup" style="display: none;">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="add" value="1">
            <input type="text" name="name" placeholder="Nombre del producto" required>
            <input type="text" name="price" placeholder="Precio" required>
            <select name="category" required>
                <option value="Electrónica">Electrónica</option>
                <option value="Ropa">Ropa</option>
                <option value="Hogar">Hogar</option>
                <option value="Libros">Libros</option>
                <option value="Juguetes">Juguetes</option>
            </select>
            <input type="text" name="description" placeholder="Descripción" required>
            <input type="file" name="image" required>
            <input type="submit" value="Agregar" class="btn btn-primary">
            <button type="button" onclick="closeAddPopup()">Cancelar</button>
        </form>
    </div>
    <div class="popup" id="delete-confirmation-popup" style="display: none;">
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este producto?</p>
        <form id="delete-form" action="" method="post">
            <input type="hidden" name="id" id="delete-product-id">
            <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
            <button type="button" onclick="closeDeleteConfirmationPopup()">Cancelar</button>
        </form>
    </div>
    <script>
        function toggleDropdown(event, id) {
            event.stopPropagation();
            var dropdown = document.getElementById('dropdown-' + id);
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }

        function openPopup(id) {
            document.getElementById('popup-' + id).style.display = 'flex';
            document.getElementById('overlay-' + id).style.display = 'block';
            document.getElementById('dropdown-' + id).style.display = 'none';
        }

        function closePopup(id) {
            document.getElementById('popup-' + id).style.display = 'none';
            document.getElementById('overlay-' + id).style.display = 'none';
        }

        function openEditPopup(event, id) {
            event.stopPropagation();
            document.getElementById('edit-popup-' + id).style.display = 'flex';
            document.getElementById('overlay-' + id).style.display = 'block';
            document.getElementById('dropdown-' + id).style.display = 'none';
        }

        function closeEditPopup(id) {
            document.getElementById('edit-popup-' + id).style.display = 'none';
            document.getElementById('overlay-' + id).style.display = 'none';
        }

        function openAddPopup() {
            document.getElementById('add-popup').style.display = 'flex';
            document.getElementById('add-overlay').style.display = 'block';
        }

        function closeAddPopup() {
            document.getElementById('add-popup').style.display = 'none';
            document.getElementById('add-overlay').style.display = 'none';
        }

        function openSidemenu() {
            document.getElementById('sidemenu').style.width = '250px';
        }

        function closeSidemenu() {
            document.getElementById('sidemenu').style.width = '0';
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        function showSuggestions(value) {
            var suggestions = document.getElementById('suggestions');
            if (value.length === 0) {
                suggestions.innerHTML = '';
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'search_suggestions.php?q=' + encodeURIComponent(value), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    suggestions.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function filterCategory(category) {
            var cards = document.querySelectorAll('.card');
            cards.forEach(function(card) {
                if (category === 'Todos' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function confirmDelete(event, id) {
            event.stopPropagation();
            document.getElementById('delete-product-id').value = id;
            document.getElementById('delete-confirmation-popup').style.display = 'flex';
        }

        function closeDeleteConfirmationPopup() {
            document.getElementById('delete-confirmation-popup').style.display = 'none';
        }

        window.onload = function() {
            var notification = document.getElementById('notification');
            if (notification) {
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 8000);
            }
        }
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        function openAddPopup() {
            document.getElementById('add-popup').classList.remove('hidden');
        }

        function closeAddPopup() {
            document.getElementById('add-popup').classList.add('hidden');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: "¿Eliminar?",
                text: "No podrás recuperar este producto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = "delete.php?id=" + id;
                }
            });
        }

        AOS.init();
        function toggleDropdown(event, id) {
        event.stopPropagation();
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
        document.getElementById('dropdown-' + id).style.display = 'block';
    }
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
    });
    function openPopup(id) {
        document.getElementById('overlay-' + id).style.display = 'block';
        document.getElementById('popup-' + id).style.display = 'block';
    }
    function closePopup(id) {
        document.getElementById('overlay-' + id).style.display = 'none';
        document.getElementById('popup-' + id).style.display = 'none';
    }
    </script>
</body>
</html>