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

    <style>
        div.dt-container {
            width: 90%;
        }

        div.dt-container select.dt-input {
            width: 5rem;
        }

        .jconfirm .jconfirm-holder {
            align-self: center;
            justify-self: center;
        }

        /* From Uiverse.io by Donewenfu */
        .loader {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .jimu-primary-loading:before,
        .jimu-primary-loading:after {
            position: absolute;
            top: 0;
            content: '';
        }

        .jimu-primary-loading:before {
            left: -19.992px;
        }

        .jimu-primary-loading:after {
            left: 19.992px;
            -webkit-animation-delay: 0.32s !important;
            animation-delay: 0.32s !important;
        }

        .jimu-primary-loading:before,
        .jimu-primary-loading:after,
        .jimu-primary-loading {
            background: #076fe5;
            -webkit-animation: loading-keys-app-loading 0.8s infinite ease-in-out;
            animation: loading-keys-app-loading 0.8s infinite ease-in-out;
            width: 13.6px;
            height: 32px;
        }

        .jimu-primary-loading {
            text-indent: -9999em;
            margin: auto;
            position: absolute;
            right: calc(50% - 6.8px);
            top: calc(50% - 16px);
            -webkit-animation-delay: 0.16s !important;
            animation-delay: 0.16s !important;
        }

        @-webkit-keyframes loading-keys-app-loading {

            0%,
            80%,
            100% {
                opacity: .75;
                box-shadow: 0 0 #076fe5;
                height: 32px;
            }

            40% {
                opacity: 1;
                box-shadow: 0 -8px #076fe5;
                height: 40px;
            }
        }

        @keyframes loading-keys-app-loading {

            0%,
            80%,
            100% {
                opacity: .75;
                box-shadow: 0 0 #076fe5;
                height: 32px;
            }

            40% {
                opacity: 1;
                box-shadow: 0 -8px #076fe5;
                height: 40px;
            }
        }
    </style>

    <body>
        <!-- Menú superior -->
        <header class="bg-white border-b border-gray-200">
            <div class="container mx-auto flex justify-between items-center p-4">
                <div class="text-xl font-bold"></div>
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

        <div>
            <div>
                <div class="container my-3" style="    width: 100%; max-width: 100% !important;">
                    <div>
                        <h1 style="text-align: center; font-family: auto; font-size: 40px;">Pobles de Catalunya</h1>
                        <p style="text-align: center; font-family: auto; font-size: 20px;">Clica sobre qualsevol comarca o província per veure els pobles que hi pertanyen.</p>
                    </div>
                </div>

                <div style="justify-content: center; padding: 20px; width: 100%;  display: none;" id="myTableContainer">
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
                            @foreach($pobles as $curr)
                            <tr>
                                <td>{{$curr->codi}}</td>
                                <td>{{$curr->nom}}</td>
                                <td>{{$curr->comarca}}</td>
                                <td>{{$curr->provincia}}</td>
                                <td>
                                    <div class="flex flex-row items-center justify-center" style="column-gap: 0.6rem;">
                                        <div>
                                            <button id="editar_btn" onclick="visualitzarMunicipi('{{$curr->id}}')">
                                                <img src="{{ asset('build/assets/iconoVisualizar.png') }}" alt="Icono de editar" width="30" style="background-color:yellow; border-radius: 5px;">
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            $('#myTableContainer').css('display', 'flex');
        });

        function visualitzarMunicipi(id) {

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.main.obtenirById') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                success: function(response) {
                    
                    let poble = response.poble; // Cambié 'municipi' a 'poble'

                    console.log(response); // Muestra toda la respuesta para inspeccionarla
                    console.log(response.foto); //

                    // Dividir la cadena de fotos en un array de URLs
                    let fotosArray = poble[0].foto.split("####");

                    // Crear las etiquetas <img> para cada URL
                    let imagenesHTML = fotosArray.map(url => {
                        if (url != "") {
                            return `<div style="flex: 1 0 45%; margin-bottom: 1rem; display: flex; justify-content: center;">
            <img src="${url}" alt="Imagen del municipio" style="height: 500; border-radius: 10px; object-fit: cover; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        </div>`;
                        }
                    }).join("");
                    // Unir todas las imágenes en una sola cadena

                    let fichaVisualizar = `

            <div class="loader" style="">
                <div class="justify-content-center jimu-primary-loading"></div>
            </div>
            <div id="fotoContainer" style="display: none; flex-wrap: wrap; gap: 2rem; font-family: Arial, sans-serif; padding: 2rem; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                <div style="flex: 1; max-width: 100%; min-width: 250px; display: flex; flex-direction: column; align-items: center;">
                <strong style="font-size: 40px; color:rgb(1, 8, 186); font-weight: bold; text-align: center;">${poble[0].nom}</strong>
                <br><br>
                <strong style="font-size: 20px; color: black; text-align: center;">Descripció:</strong>
                <p style="font-size: 16px; color: black; text-align: center; width: 100%;">${poble[0].descripcio}</p>
            </div>

            <!-- Imágenes en columnas de 2 -->
            <div style="flex: 1 0 100%; display: flex; flex-wrap: wrap; gap: 1rem;">
                ${imagenesHTML} <!-- Mostrar todas las imágenes en 2 columnas -->
            </div>
            </div>

            <br><br>

            <div style="font-size: 18px; color: black; padding: 2rem; display: none; background-color: white;" id="tablaContainer">
            <h1 style="font-size: 24px; font-weight: bold; color: black;">Característiques:</h1>

            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th
                            style="padding: 10px; text-align: left; background-color: #ecf0f1; color: red; border: 1px solid #ddd;">
                            Latitud</th>
                        <th
                            style="padding: 10px; text-align: left; background-color: #ecf0f1; color: red; border: 1px solid #ddd;">
                            Longitud</th>
                        <th
                            style="padding: 10px; text-align: left; background-color: #ecf0f1; color: red; border: 1px solid #ddd;">
                            Altitud</th>
                        <th
                            style="padding: 10px; text-align: left; background-color: #ecf0f1; color: red; border: 1px solid #ddd;">
                            Superficie</th>
                        <th
                            style="padding: 10px; text-align: left; background-color: #ecf0f1; color: red; border: 1px solid #ddd;">
                            Població</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble[0].latitud}</td>
                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble[0].longitud}</td>
                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${parseFloat(poble[0].altitud)}</td>
                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">
                            ${parseFloat(poble[0].superficie).toFixed(2)}</td>
                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble[0].poblacio}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        `;

                    var visualizarConfirm = $.confirm({
                        title: "Informació del municipi",
                        content: fichaVisualizar,
                        draggable: false,
                        closeIcon: false,
                        theme: 'supervan',
                        buttons: {
                            Tanca: function() {
                                visualizarConfirm.close();
                            }
                        }
                    });

                    setTimeout(() => {
                        $("#fotoContainer").css("display", 'flex');
                        $("#tablaContainer").css("display", "block");
                        $(".loader").css("display", "none");
                    }, 1000);

                },
                error: function(error) {
                    console.log("Error al obtener el municipio:", error);
                    alert(`Hubo un error al intentar obtener los datos del municipio: ${error}`);
                }
            });
        }
    </script>
</x-guest-layout>