<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Estudiantes</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Gestion de Estudiantes</h1>
    <button id="btnNew" class="btn-new"> Insertar Nuevo Estudiante</button>
    <hr>
    <h2>Lista de Estudiantes</h2>
    <div class="table-container">
        <p>Cargando...</p>
    </div>
</div>

<div id="modal-form" class="modal-background">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2 id="modal-tittle"></h2>
        <form id= "studentForm" class= "student-form">
            <input type="hidden" id="form-action" value="insert">            
            <label for="cedula">Cédula</label>
            <input type="text" id="cedula" name="cedula" required>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" required>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" required>
            <button type="button" class="btn-save" id="saveBtn">Guardar Información</button>
        </form>
    </div>
</div>

<div id="modal-confirmation" class="modal-background">
    <div class="modal-content">
        <h3>Confirmar Eliminación</h3>
        <p>¿Está seguro de que desea eliminar este estudiante?</p>
         <div class="modal-actions">
        <button id="btnConfirmDelete" class="btn-confirm">Sí, Eliminar</button>
        <button id="btn-cancelar" class="btn-cancelar">Cancelar</button>
         </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            const apiUrl = 'index.php?action=api';
            
            function loadTable() {
                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let tableHtml = '<table border="1" style="width: 100%; border-collapse: collapse;">';
                        tableHtml += `<thead>
                        <tr style="background-color: #f2f2f2;">
                        <th style="padding: 12px;"> Cedula</th>
                        <th style="padding: 12px;"> Nombre</th>
                        <th style="padding: 12px;"> Apellido</th>
                        <th style="padding: 12px;"> Direccion</th>
                        <th style="padding: 12px;"> Telefono</th>
                        <th style="padding: 12px;"> Acciones</th>
                        </tr>
                        </thead><tbody>`;
                        data.forEach(function(student) {
                            tableHtml += `<tr>
                            <td style="padding: 8px;">${student.cedula}</td>
                            <td style="padding: 8px;">${student.nombre}</td>
                            <td style="padding: 8px;">${student.apellido}</td>
                            <td style="padding: 8px;">${student.direccion}</td>
                            <td style="padding: 8px;">${student.telefono}</td>
                            <td style="padding: 8px;" class="acciones-cell">
                            <button class="btn-edit" style="padding: 7px;"
                            data-cedula="${student.cedula}" 
                            data-nombre="${student.nombre}" 
                            data-apellido="${student.apellido}" 
                            data-direccion="${student.direccion}" 
                            data-telefono="${student.telefono}"
                            >Editar</button>
                            <button class="btn-delete" style="padding: 7px;"
                            data-cedula="${student.cedula}">
                            Eliminar</button>
                            </td>
                            </tr>`;
                        });
                        tableHtml += '</tbody></table>';
                        $('.table-container').html(tableHtml);
                    },
                    error: function(error){
                        console.error("Error al cargar datos: ", error);
                        $('.table-container').html('<p>Ocurrio un error al cargar los datos.</p>');
                    }
                });
            }
            $('#btnNew').on('click', function(){
                $('#studentForm')[0].reset();
                $('#modal-tittle').text('Nuevo Estudiante');
                $('#cedula').prop('readonly', false);
                $('#form-action').val('insert');
                $('#modal-form').addClass('visible');
            });
            
            $('.close-button').on('click', function() {
                $('.modal-background').removeClass('visible');
            });
    
            $('#saveBtn').on('click', function() {
                const cedula = $('#cedula').val();
                const nombre = $('#nombre').val();
                const apellido = $('#apellido').val();

                if (cedula  === '' || nombre === '' || apellido === '') {
                    alert('Por favor, complete los campos obligatorios: Cédula, Nombre y Apellido.');
                    return;
                }
                const action = $('#form-action').val();
                const studentsData = {
                    cedula: cedula,
                    nombre: nombre,
                    apellido: apellido,
                    direccion: $('#direccion').val(),
                    telefono: $('#telefono').val()
                };
                let ajaxType = (action === 'insert') ? 'POST': 'PUT';
                $.ajax({
                    url: apiUrl, 
                    type: ajaxType,
                    data: studentsData, 
                    dataType: 'json',
                    success: function(response) {
                        $('#modal-form').removeClass('visible');
                        alert("Datos guardados exitosamente.");
                        loadTable(); 
                    },
                    error: function(error) {
                        console.error("Error al guardar el estudiante:", error);
                        alert("Ocurrió un error al guardar. Revise la consola.");
                    }
                });
            });

            $(document).on('click', '.btn-edit', function() {
                $('#modal-tittle').text('Actualizar Informacion');
                $('#cedula').val($(this).data('cedula')).prop('readonly', true);
                $('#nombre').val($(this).data('nombre'));
                $('#apellido').val($(this).data('apellido'));
                $('#direccion').val($(this).data('direccion'));
                $('#telefono').val($(this).data('telefono'));
                $('#form-action').val('update');
                $('#modal-form').addClass('visible');
            });

            let idCardForDelete;

            $(document).on('click', '.btn-delete', function(){
                $('#modal-tittle').text('Eliminar Estudiante');
                idCardForDelete = $(this).data('cedula');
                $('#modal-confirmation').addClass('visible');
            });

            $('#btnConfirmDelete').on('click', function(){
                $.ajax({
                    url: `${apiUrl}&cedula=${idCardForDelete}`,
                    type: 'DELETE',
                    dataType: 'json',
                    success : function(response){
                        $('#modal-confirmation').removeClass('visible');
                        loadTable();
                    },
                    error : function(error){
                        console.error("Error al eliminar un estudiante", error);
                        alert("Ocurrio un error al eliminar");
                    }

                });
            });

            $('#btn-cancelar').on('click', function(){
                $('#modal-confirmation').removeClass('visible');
            });
            loadTable();
        });
    </script>
</body>
</html>