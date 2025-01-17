<x-app-layout>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Enllaços o scripts -->

        <link rel="stylesheet" href="{{ asset('build/assets/jquery-confirm.min.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/datatables.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="{{ asset('build/assets/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('build/assets/jquery-confirm.min.js') }}"></script>
        <script src="{{ asset('build/assets/datatables.min.js') }}"></script>


        <title>Pobles de Catalunya</title>
    </head>

    <style>
        /* *** ESTILS BOTONS *** */
        button {
            transition: all 0.3s ease;
        }

        /* Hover para botones */
        button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Activo (clic) en botones */
        button:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Estilo para botones con imágenes */
        button img {
            transition: transform 0.3s ease;
        }

        button:hover img {
            transform: rotate(10deg);
        }

        button:active img {
            transform: rotate(-10deg) scale(0.95);
        }

        /* Cambios al pasar el mouse */
        a:hover {
            background-color: lightgray;
            /* Cambia el fondo */
            color: black;
            /* Cambia el color del texto */
            transform: scale(1.05);
            /* Aumenta el tamaño ligeramente */
            transition: all 0.3s ease;
            /* Transición suave */
        }

        /* Cambios al hacer clic */
        a:active {
            background-color: gray;
            /* Fondo más oscuro al hacer clic */
            transform: scale(0.95);
            /* Reduce el tamaño ligeramente */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            /* Agrega un efecto de sombra */
        }

        /* *** FIN ESTILS BOTONS *** */

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

        .select2-selection.select2-selection--multiple {
            width: 100%;
            min-width: 13rem;
        }

        .bg-gray-100{
            background-color: #E5E7EB;
        }
    </style>

    <body>
        <div>
            <div>
                <div class="container my-3" style="width: 100%; max-width: 100% !important;">
                    <div>
                        <h1 style="text-align: center; font-family: auto; font-size: 40px;">Pobles de Catalunya</h1>
                        <p style="text-align: center; font-family: auto; font-size: 20px; color: red;">A sota del botó 'Crear', tens un filtre per filtrar per províncies o comarques.</p>
                    </div>

                    <div style="display: flex; flex-direction:row; align-items:center; justify-content:center; margin-top:2rem;">
                        <button id="crear-btn" href="" style="display: flex; flex-direction: row; align-items: center; justify-content: center;  column-gap: 0.4rem; background-color: green; padding: 0.6rem; border-radius: 10px; text-transform: uppercase; color: white;">
                            <img src="{{ asset('build/assets/iconoCrear.png') }}" width="20"><span>Crear</span>
                        </button>
                    </div>

                    <div>
                        <div style="display: flex; justify-content: center; margin-top: 2rem; gap: 1rem; flex-direction: column; align-items: center;">

                            <div id="provincia-container">
                                <select id="provincia-select" name="provincia" class="form-control" style="background: lightblue; text-align: center; font-size: 17px; width: auto;">
                                    <option value="XXXX">Totes les provincies</option>
                                    @foreach($provinciaTotal as $provincia)
                                    <option value="{{ $provincia->provincia }}">{{ $provincia->provincia }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="comarca-container" style="display: none;">
                                <select id="comarca-select" name="comarca" class="form-control" style="background: lightblue; text-align: center; font-size: 17px; width: auto;" multiple="multiple">
                                    <option value="ZZZZ">Totes les comarques</option>
                                    @foreach($comarcatotal as $comarca)
                                    <option value="{{ $comarca->comarca }}">{{ $comarca->comarca }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button id="filtra-btn" name="filtra-btn" href="" style="display: flex; flex-direction: row; align-items: center; justify-content: center;  column-gap: 0.4rem; background-color: coral; padding: 0.6rem; border-radius: 10px; text-transform: uppercase; color: white;">
                                <img src="{{ asset('build/assets/iconoCercador.png') }}" width="20"><span>Filtra</span>
                            </button>
                        </div>
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
                                            <button id="vusualitzar-btn" onclick="visualitzarMunicipi('{{$curr->id}}')">
                                                <img src="{{ asset('build/assets/iconoVisualizar.png') }}" alt="Icono de editar" width="30" style="background-color:yellow; border-radius: 5px;">
                                            </button>
                                        </div>

                                        <div>
                                            <button id="editar-btn" onclick="editarMunicipi('{{$curr->id}}')">
                                                <img src="{{ asset('build/assets/iconoEditar.png') }}" alt="Icono de editar" width="30" style="background-color:blue; border-radius: 5px;">
                                            </button>
                                        </div>

                                        <div>
                                            <button id="eliminar-btn" onclick="eliminarMunicipi('{{$curr->id}}')">
                                                <img src="{{ asset('build/assets/iconoEliminar.png') }}" alt="Icono de editar" width="30" style="background-color:red; border-radius: 5px;">
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

            $('#provincia-select').select2();
            $('#comarca-select').select2();
            $('#myTableContainer').css('display', 'flex');
        });

        $('#provincia-select').on('change', function(e) {
            e.preventDefault();

            let value = $('#provincia-select').val();

            if (value == "XXXX") {
                $('#comarca-container').css('display', 'none');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.welcome.recarregaSelectComarques') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: value,
                    },
                    success: function(response) {
                        $('#comarca-select').empty();
                        const optionsSelectComarca = response.map(comarca =>
                            `<option value="${comarca.codiComarca}">${comarca.comarca}</option>`
                        ).join('');
                        $('#comarca-select').append(optionsSelectComarca);
                        $('#comarca-select').trigger('change');
                        console.log(optionsSelectComarca);
                    },
                    error: function(error) {
                        console.log("Error al obtener el municipio:", error);
                    }
                })
                $('#comarca-container').css('display', 'block');
            }
        })

        $("#filtra-btn").on('click', function(e) {
            e.preventDefault();

            let values = $('#comarca-select').val();

            if (values.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.welcome.recargarTaulaAmbComarques') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: values,
                    },
                    success: function(response) {

                        var table = $('#myTable').DataTable();
                        table.clear();

                        if (response && Array.isArray(response)) {
                            table.rows.add(response.map(item => [
                                item.codi,
                                item.nom,
                                item.comarca,
                                item.provincia,
                                `<div class="flex flex-row items-center justify-center" style="column-gap: 0.6rem;">
                                        <div>
                                            <button id="visualitzar-btn" onclick="visualitzarMunicipi(${item.id})">
                                                <img src="{{ asset('build/assets/iconoVisualizar.png') }}" alt="Icono de editar" width="30" style="background-color:yellow; border-radius: 5px;">
                                            </button>
                                        </div>

                                        <div>
                                            <button id="editar-btn" onclick="editarMunicipi(${item.id})">
                                                <img src="{{ asset('build/assets/iconoEditar.png') }}" alt="Icono de editar" width="30" style="background-color:blue; border-radius: 5px;">
                                            </button>
                                        </div>

                                        <div>
                                            <button id="eliminar-btn" onclick="eliminarMunicipi(${item.id})">
                                                <img src="{{ asset('build/assets/iconoEliminar.png') }}" alt="Icono de editar" width="30" style="background-color:red; border-radius: 5px;">
                                            </button>
                                        </div>
                                    </div>`,
                            ])).draw();
                        } else {
                            console.log("Error: La respuesta no contiene datos válidos.");
                        }
                    },
                })
            } else if ($('#provincia-select').val() != "XXXX") {
                var confirmError = $.confirm({
                    title: "<span>Error al filtrar</span>",
                    content: `<span>Per poder filtrar per comarca heu de seleccionar al menys una d'elles.</span>`,
                    draggable: false,
                    closeIcon: false,
                    theme: 'supervan',
                    buttons: {
                        Tancar: {
                            text: 'Tancar',
                            btnClass: 'btn-red',
                            action: function() {
                                this.close();
                            }
                        }
                    }
                });
            }
        });


        function visualitzarMunicipi(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.welcome.obtenirById') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                success: function(response) {
                    console.log(response);

                    let poble = response;

                    let fotosArray = poble.foto.split("####");


                    let imagenesHTML = fotosArray.map(url => {
                        if (url != "") {
                            return `<div style="flex: 1 0 45%; margin-bottom: 1rem; display: flex; justify-content: center;"> 
                        <img src="${url}" alt="Imagen del municipio" style="height: 500; border-radius: 10px; object-fit: cover; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        </div>`;
                        }
                    }).join("");


                    let fichaVisualizar = `

                            <div class="loader" style="">
                                <div class="justify-content-center jimu-primary-loading"></div>
                            </div>
                            <div id="fotoContainer" style="display: none; flex-wrap: wrap; gap: 2rem; font-family: Arial, sans-serif; padding: 2rem; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                <div style="flex: 1; max-width: 100%; min-width: 250px; display: flex; flex-direction: column; align-items: center;">
                                <strong style="font-size: 40px; color:rgb(1, 8, 186); font-weight: bold; text-align: center;">${poble.nom}</strong>
                                <br><br>
                                <strong style="font-size: 20px; color: black; text-align: center;">Descripció:</strong>
                                <p style="font-size: 16px; color: black; text-align: center; width: 100%;">${poble.descripcio}</p>
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
                                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble.latitud}</td>
                                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble.longitud}</td>
                                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${parseFloat(poble.altitud)}</td>
                                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">
                                            ${parseFloat(poble.superficie).toFixed(2)}</td>
                                        <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">${poble.poblacio}</td>
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
                            Tancar: {
                                text: 'Tancar',
                                btnClass: 'btn-red',
                                action: function() {
                                    this.close();
                                }
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

        $("#crear-btn").click(function() {
            $.confirm({
                title: 'Crear Municipi',
                content: `
                            <form id="crearForm" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; padding: 3rem; max-width: 800px; margin: auto; background-color: transparent; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="codi" style="font-weight: bold; margin-bottom: 0.5rem; color: black;">Codi municipi:</label>
                                    <input type="number" id="codi" name="codi" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="nom" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Nom:</label>
                                    <input type="text" id="nom" name="nom" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="codiComarca" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Codi comarca:</label>
                                    <input type="number" id="codiComarca" name="codiComarca" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="comarca" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Comarca:</label>
                                    <input type="text" id="comarca" name="comarca" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="provincia" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Provincia:</label>
                                    <input type="text" id="provincia" name="provincia" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="poblacio" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Población:</label>
                                    <input type="number" id="poblacio" name="poblacio" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column; grid-column: span 2;">
                                    <label for="descripcio" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Descripción:</label>
                                    <textarea id="descripcio" name="descripcio" required style="color: black; width: 100%; height: 150px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;"></textarea>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="latitud" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Latitud:</label>
                                    <input type="text" id="latitud" name="latitud" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="longitud" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Longitud:</label>
                                    <input type="text" id="longitud" name="longitud" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="altitud" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Altitud:</label>
                                    <input type="text" id="altitud" name="altitud" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="superficie" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Superficie:</label>
                                    <input type="text" id="superficie" name="superficie" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column; grid-column: span 2; align-items: center; text-align: center;">
                                    <label for="foto" style="font-weight: bold; color: #333; margin-bottom: 0.5rem; color: black;">Foto URL:</label>
                                    <label for="foto" style="font-weight: bold; color: red; margin-bottom: 0.5rem;">(Si desitges afegir més d'una imatge, separa les adreces URL amb '####', https://exemple.com/imatge1.jpg####https://exemple.com/imatge2.jpg.)</label>
                                    <input type="text" id="foto" name="foto" style="color: black; width: 80%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                            </form>
            `,
                type: 'green',
                theme: 'supervan',
                buttons: {
                    Crear: {

                        text: 'Crear',
                        btnClass: 'btn-green',
                        action: function() {

                            let nom = $("#nom").val();
                            let comarca = $("#comarca").val();
                            let provincia = $("#provincia").val();
                            let poblacio = $("#poblacio").val();
                            let descripcio = $("#descripcio").val();
                            let latitud = $("#latitud").val();
                            let longitud = $("#longitud").val();
                            let altitud = $("#altitud").val();
                            let superficie = $("#superficie").val();
                            let foto = $("#foto").val();
                            let codi = $("#codi").val();
                            let codiComarca = $("#codiComarca").val();

                            $.ajax({
                                url: "{{ route('ajax.welcome.crear') }}",
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    nom: nom,
                                    comarca: comarca,
                                    provincia: provincia,
                                    poblacio: poblacio,
                                    descripcio: descripcio,
                                    latitud: latitud,
                                    longitud: longitud,
                                    altitud: altitud,
                                    superficie: superficie,
                                    foto: foto,
                                    codi: codi,
                                    codiComarca: codiComarca,
                                    updated: 1
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $.alert({
                                            title: 'Èxit',
                                            content: 'Poble creat amb èxit.',
                                            type: 'green',
                                        });
                                        location.reload();
                                    } else {
                                        $.alert({
                                            title: 'Error !',
                                            content: 'Ha ocurregut un error en crear el poble.',
                                            type: 'red',
                                        });
                                    }
                                },
                                error: function() {
                                    $.alert({
                                        title: 'Error !',
                                        content: 'Ha ocurregut un error a la solicitud.',
                                        type: 'red',
                                    });
                                }
                            });
                        },
                    },
                    Tancar: {
                        text: 'Tancar',
                        btnClass: 'btn-red',
                        action: function() {
                            this.close();
                        }
                    }
                }
            });
        });

        function editarMunicipi(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.welcome.obtenirById') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                success: function(response) {
                    let formularioEditar = `
                        <form id="crearForm" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; padding: 3rem; max-width: 800px; margin: auto; background-color: #transparent; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="codi" style="font-weight: bold; margin-bottom: 0.5rem; color: black;">Codi municipi:</label>
                                    <input type="number" id="codi" name="codi" value="${response.codi}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="nom" style="font-weight: bold; margin-bottom: 0.5rem; color: black;">Nom:</label>
                                    <input type="text" id="nom" name="nom" value="${response.nom}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="codiComarca" style="font-weight: bold; margin-bottom: 0.5rem; color: black;">Codi comarca:</label>
                                    <input type="number" id="codiComarca" name="codiComarca" value="${response.codiComarca}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="comarca" style="font-weight: bold; margin-bottom: 0.5rem; color: black;">Comarca:</label>
                                    <input type="text" id="comarca" name="comarca" value="${response.comarca}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="provincia" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Provincia:</label>
                                    <input type="text" id="provincia" name="provincia" value="${response.provincia}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="poblacio" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Población:</label>
                                    <input type="number" id="poblacio" name="poblacio" value="${response.poblacio}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column; grid-column: span 2;">
                                    <label for="descripcio" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Descripción:</label>
                                    <textarea id="descripcio" name="descripcio" required style="color: black; width: 100%; height: 150px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">${response.descripcio}</textarea>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="latitud" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Latitud:</label>
                                    <input type="text" id="latitud" name="latitud"  value="${response.latitud}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="longitud" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Longitud:</label>
                                    <input type="text" id="longitud" name="longitud"  value="${response.longitud}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="altitud" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Altitud:</label>
                                    <input type="text" id="altitud" name="altitud"  value="${response.altitud}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <label for="superficie" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Superficie:</label>
                                    <input type="text" id="superficie" name="superficie"  value="${response.superficie}" required style="color: black; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                                <div style="display: flex; flex-direction: column; grid-column: span 2; align-items: center; text-align: center;">
                                    <label for="foto" style="font-weight: bold; color: black; margin-bottom: 0.5rem;">Foto URL:</label>
                                    <label for="foto" style="font-weight: bold; color: red; margin-bottom: 0.5rem;">(Si desitges afegir més d'una imatge, separa les adreces URL amb '####', https://exemple.com/imatge1.jpg####https://exemple.com/imatge2.jpg.)</label>
                                    <input type="text" id="foto" name="foto" value="${response.foto}" style="color: black; width: 80%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; transition: border-color 0.3s;">
                                </div>
                        </form>
            `;
                    var editarConfirm = $.confirm({
                        title: "Editar Municipi",
                        content: formularioEditar,
                        draggable: false,
                        theme: 'supervan',
                        closeIcon: false,
                        buttons: {
                            Enviar: {
                                btnClass: 'btn-green',
                                action: function() {
                                    var self = this;

                                    let nom = $("#nom").val();
                                    let comarca = $("#comarca").val();
                                    let provincia = $("#provincia").val();
                                    let poblacio = $("#poblacio").val();
                                    let descripcio = $("#descripcio").val();
                                    let latitud = $("#latitud").val();
                                    let longitud = $("#longitud").val();
                                    let altitud = $("#altitud").val();
                                    let superficie = $("#superficie").val();
                                    let foto = $("#foto").val();
                                    let codi = $("#codi").val();
                                    let codiComarca = $("#codiComarca").val();

                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('ajax.welcome.editar') }}",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {
                                            id: id,
                                            nom: nom,
                                            comarca: comarca,
                                            provincia: provincia,
                                            poblacio: poblacio,
                                            descripcio: descripcio,
                                            latitud: latitud,
                                            longitud: longitud,
                                            altitud: altitud,
                                            superficie: superficie,
                                            foto: foto,
                                            codi: codi,
                                            codiComarca: codiComarca
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $.alert({
                                                    title: 'Èxit',
                                                    content: 'Poble actualizat amb èxit.',
                                                    type: 'green',
                                                });
                                                self.close();
                                                location.reload();
                                            } else {
                                                $.alert({
                                                    title: 'Error',
                                                    content: 'Poble no actualizat.',
                                                    type: 'red',
                                                });
                                                console.error("Error al guardar el municipi.");
                                            }
                                        },
                                        error: function() {
                                            $.alert({
                                                title: 'Error !',
                                                content: 'Poble no actualizat.',
                                                type: 'red',
                                            });
                                            console.error("Error al servidor.");
                                        }
                                    });
                                }
                            },
                            Tancar: {
                                text: 'Tancar',
                                btnClass: 'btn-red',
                                action: function() {
                                    this.close();
                                }
                            }
                        },
                        onOpenBefore: function() {
                            var self = this;
                        }
                    });

                },
                error: function() {
                    console.error("Error al obtenir les dades del municpi.");
                }
            });
        }

        function eliminarMunicipi(id) {
            $.confirm({
                title: 'Eliminar Municipi',
                content: '¿Estàs segur que vols eliminar el municipi?',
                type: 'red',
                buttons: {
                    Confirmar: function() {
                        $.ajax({
                            url: "{{ route('ajax.welcome.eliminar') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    $.alert({
                                        title: 'Èxit',
                                        content: response.message,
                                        type: 'green',
                                    });
                                    $('#row-' + id).remove();
                                    location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                $.alert({
                                    title: 'Error',
                                    content: 'Ha ocorregut un error en eliminar el poble.',
                                    type: 'red',
                                });
                            }
                        });
                    },
                    Cancelar: function() {}
                }
            });
        }
    </script>

</x-app-layout>