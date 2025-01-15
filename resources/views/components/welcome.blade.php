<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Enllaços o scripts -->
    <link rel="stylesheet" href="{{ asset('build/assets/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/datatables.min.css') }}">
    <script src="{{ asset('build/assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('build/assets/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('build/assets/datatables.min.js') }}"></script>

    <title>Pobles de Catalunya</title>
</head>

<body>
    <div>
        <div class="container my-3">
            <div>
                <h1 style="text-align: center; font-family: auto; font-size: 40px;">Pobles de Catalunya</h1>
                <p style="text-align: center; font-family: auto; font-size: 20px;">
                    Clica sobre qualsevol comarca o província per veure els pobles que hi pertanyen.
                    <button style="background-color: blue; color: white; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-family: cursive;" onclick="window.location.href='https://dam2m6.codifi.cat/pobles/create'">
                        Afegire
                    </button>
                </p>

            </div>
        </div>

        <div style="display: flex; justify-content: center; padding: 20px; width: 100%;">
            <table id="myTable" style="text-align: center; border: 1px solid #ddd; border-collapse: collapse;">

                <thead>
                    <tr>
                        <th style="text-align: center;">CODI</th>
                        <th style="text-align: center;">NOM</th>
                        <th style="text-align: center;">COMARCA</th>
                        <th style="text-align: center;">PROVINCIA</th>
                        <th style="text-align: center;">ACCIONS</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="flex flex-row items-center justify-center" style="column-gap: 0.6rem;">
                                <div>
                                    <button id="editar_btn" onclick="editarMaterial('')">
                                        <img src="{{ asset('build/assets/iconoVisualizar.png') }}" alt="Icono de editar" width="30" style="background-color:yellow; border-radius: 5px;">
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "paging": true, // Paginación
            "searching": true, // Buscar
            "ordering": true, // Ordenar
            "info": false, // Información de la tabla
            "responsive": true,
            "language": {
                "decimal": "",
                "emptyTable": "No hi ha dades disponibles",
                "info": "Mostrant _START_ a _END_ de _TOTAL_ entrades",
                "infoEmpty": "Mostrant 0 a 0 de 0 entrades",
                "infoFiltered": "(filtrado de _MAX_ entrades totales)",
                "lengthMenu": "Mostrar _MENU_ entrades",
                "loadingRecords": "Cargant...",
                "processing": "Procesant...",
                "search": "Buscar:",
                "zeroRecords": "No s'ha trobat registres coincidents",
                "paginate": {
                    "first": "Primer",
                    "last": "Últim",
                    "next": "Següent",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar per ordenar la columna ascendent",
                    "sortDescending": ": activar per ordenar la columna descendent"
                }
            }
        });
    });

    function mostrarPueblosPorProvincia(provincia) {
        fetch(`/api/pueblos?provincia=${provincia}`)
            .then(response => response.json())
            .then(data => {
                const pueblosDiv = document.querySelector('.pueblos');
                pueblosDiv.innerHTML = '';
                data.forEach(pueblo => {
                    pueblosDiv.innerHTML += `<div>${pueblo.nombre}</div>`;
                });
            });
    }
</script>