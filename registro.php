<!DOCTYPE html>
<html lang="es" xmlns:th="http://www.thymeleaf.org">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Registro de Usuario y Mascotas</h4>
                    </div>
                    <div class="card-body">
                        <form action="/cliente/guardar" method="post" class="needs-validation" novalidate>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="identificacion" class="form-label">Identificación</label>
                                    <input type="text" class="form-control" id="identificacion" name="identificacion"
                                        placeholder="Ingrese su identificación" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese su identificación.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ingrese su nombre" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese su nombre.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="primerApellido" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido"
                                        placeholder="Ingrese su primer apellido" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese su primer apellido.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido"
                                        placeholder="Ingrese su segundo apellido" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese su segundo apellido.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="email" class="form-control" id="correo" name="correo"
                                            placeholder="Ingrese su correo electrónico" required>
                                        <div class="invalid-feedback">
                                            Por favor, ingrese un correo electrónico válido.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon2">+506</span>
                                        <input type="text" class="form-control" id="telefono" name="telefono"
                                            placeholder="Ingrese su número de teléfono" required pattern="\d{8}">
                                        <div class="invalid-feedback">
                                            Por favor, ingrese su número de teléfono en el formato XXXXXXXX.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Ingrese su contraseña" required minlength="8">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese una contraseña de al menos 8 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="confirmPassword" placeholder="Confirme su contraseña" required>
                                    <div class="invalid-feedback">
                                        Por favor, confirme su contraseña.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="provincia" class="form-label">Provincia</label>
                                    <select class="form-control" id="provincia" name="provincia" required>
                                        <option value="">Seleccione una provincia</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione una provincia.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="canton" class="form-label">Cantón</label>
                                    <select class="form-control" id="canton" name="canton" required>
                                        <option value="">Seleccione un cantón</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione un cantón.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="distrito" class="form-label">Distrito</label>
                                    <select class="form-control" id="distrito" name="distrito" required>
                                        <option value="">Seleccione un distrito</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione un distrito.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="direccionSennas" class="form-label">Direccion exacta</label>
                                    <textarea class="form-control"
                                        placeholder="Ejemplo: 100 metros norte y 50 metros este del parque central"
                                        id="direccionSennas" name="direccionSennas" required></textarea>
                                    <div class="invalid-feedback">
                                        Por favor, Ingrese su dirección exacta.
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4 class="text-center">Registro de Mascotas</h4>
                            <div id="petContainer">
                                <div class="pet-entry">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="petName" class="form-label">Nombre de la Mascota</label>
                                            <input type="text" class="form-control" id="petName" name="petName[]"
                                                placeholder="Ingrese el nombre de la mascota" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese el nombre de la mascota.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="petType" class="form-label">Tipo de Mascota</label>
                                            <select class="form-control" id="petType" name="petType[]" required>
                                                <option value="">Seleccione el tipo de mascota</option>
                                                <option value="Perro">Perro</option>
                                                <option value="Gato">Gato</option>
                                                <option value="Ave">Ave</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, seleccione el tipo de mascota.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="petBreed" class="form-label">Raza</label>
                                            <input type="text" class="form-control" id="petBreed" name="petBreed[]"
                                                placeholder="Ingrese la raza de la mascota" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese la raza de la mascota.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="petAge" class="form-label">Edad</label>
                                            <input type="number" class="form-control" id="petAge" name="petAge[]"
                                                placeholder="Ingrese la edad de la mascota" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese la edad de la mascota.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mb-3">
                                <button type="button" class="btn btn-secondary" id="addPetButton">Agregar otra mascota</button>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        document.addEventListener('DOMContentLoaded', function() {
            const provinciaSelect = document.getElementById('provincia');
            console.log(provinciaSelect);
            const cantonSelect = document.getElementById('canton');
            console.log(cantonSelect);
            const distritoSelect = document.getElementById('distrito');
            console.log(distritoSelect);

            // Fetch provinces
            fetch('https://api-geo-cr.vercel.app/provincias')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Log the data to see its structure
                    if (Array.isArray(data.data)) {
                        data.data.forEach(provincia => {
                            const option = document.createElement('option');
                            option.value = provincia.idProvincia;
                            option.textContent = provincia.descripcion;
                            provinciaSelect.appendChild(option);
                        });
                    } else {
                        console.error('Expected an array but got:', data);
                    }
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });

            // Fetch all cantons based on selected province
            provinciaSelect.addEventListener('change', function() {
                const provinciaId = this.value;
                cantonSelect.innerHTML = '<option value="">Seleccione un cantón</option>';
                distritoSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
                if (provinciaId) {
                    fetchAllCantons(provinciaId);
                }
            });

            // Fetch all districts based on selected canton
            cantonSelect.addEventListener('change', function() {
                const cantonId = this.value;
                distritoSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
                if (cantonId) {
                    fetchAllDistricts(cantonId);
                }
            });

            function fetchAllCantons(provinciaId) {
                fetch(`https://api-geo-cr.vercel.app/provincias/${provinciaId}/cantones?limit=200`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data); // Log the data to see its structure
                        if (Array.isArray(data.data)) {
                            data.data.forEach(canton => {
                                const option = document.createElement('option');
                                option.value = canton.idCanton;
                                option.textContent = canton.descripcion;
                                cantonSelect.appendChild(option);
                            });
                        } else {
                            console.error('Expected an array but got:', data);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }

            function fetchAllDistricts(cantonId) {
                fetch(`https://api-geo-cr.vercel.app/cantones/${cantonId}/distritos?limit=200`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data); // Log the data to see its structure
                        if (Array.isArray(data.data)) {
                            data.data.forEach(distrito => {
                                const option = document.createElement('option');
                                option.value = distrito.idDistrito;
                                option.textContent = distrito.descripcion;
                                distritoSelect.appendChild(option);
                            });
                        } else {
                            console.error('Expected an array but got:', data);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }

            // Add more pets functionality
            const petContainer = document.getElementById('petContainer');
            const addPetButton = document.getElementById('addPetButton');

            addPetButton.addEventListener('click', function() {
                const petEntry = document.createElement('div');
                petEntry.classList.add('pet-entry');
                petEntry.innerHTML = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="petName" class="form-label">Nombre de la Mascota</label>
                            <input type="text" class="form-control" name="petName[]"
                                placeholder="Ingrese el nombre de la mascota" required>
                            <div class="invalid-feedback">
                                Por favor, ingrese el nombre de la mascota.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="petType" class="form-label">Tipo de Mascota</label>
                            <select class="form-control" name="petType[]" required>
                                <option value="">Seleccione el tipo de mascota</option>
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione el tipo de mascota.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="petBreed" class="form-label">Raza</label>
                            <input type="text" class="form-control" name="petBreed[]"
                                placeholder="Ingrese la raza de la mascota" required>
                            <div class="invalid-feedback">
                                Por favor, ingrese la raza de la mascota.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="petAge" class="form-label">Edad</label>
                            <input type="number" class="form-control" name="petAge[]"
                                placeholder="Ingrese la edad de la mascota" required>
                            <div class="invalid-feedback">
                                Por favor, ingrese la edad de la mascota.
                            </div>
                        </div>
                    </div>
                `;
                petContainer.appendChild(petEntry);
            });
        });
    </script>
</body>

</html>