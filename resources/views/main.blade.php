<x-guest-layout>
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

    <body class="bg-gray-50 text-black/50">
        <!-- Menú superior -->
        <header class="bg-white border-b border-gray-200">
            <div class="container mx-auto flex justify-between items-center p-4">
                <div class="text-xl font-bold">Pobles de Catalunya</div>
                <div class="flex space-x-4">
                    @if (Route::has('login'))
                        <nav>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-black hover:text-gray-700">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-black hover:text-gray-700">Log in</a>
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <div>
                <h1 style="text-align: center; font-family: auto; font-size: 40px;">Pobles de Catalunya</h1>
                <h4 style="font-size: 18px; font-family: auto; text-align: left;">Clica sobre qualsevol comarca o província per veure els pobles que hi pertanyen.</h4>
            </div>

            <div style="display: flex; justify-content: center;">
                <table id="myTable" style="text-align: center">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Provincia</th>
                            <th>Comarca</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>3</td>
                            <td>3</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="provincias">
                <button onclick="mostrarPueblosPorProvincia('Barcelona')">Barcelona</button>
                <button onclick="mostrarPueblosPorProvincia('Girona')">Girona</button>
                <!-- Agregar más provincias -->
            </div>

            <div class="pueblos">
                <!-- Aquí se mostrarán los pueblos filtrados -->
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
                "info": true, // Información de la tabla
                "responsive": true,
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna ascendente",
                        "sortDescending": ": activar para ordenar la columna descendente"
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
</x-guest-layout>
