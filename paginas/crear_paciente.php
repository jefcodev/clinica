<?php
include 'header.php';
?>
<head> 
    <link rel="stylesheet" href="../css/jquery.datetimepicker.css">
</head>
<body>
    <section class="cuerpo">
        <h1>Crear paciente</h1><br>
        <form action="adm_paciente.php" method="post" onsubmit="return validar()">
            <div class="row">
                <div class="col-md-4">   
                    <input class="form-control" title="Cédula o Pasaporte" placeholder="Cédula o Pasaporte" id="numero_identidad" name="numero_identidad" required/>
                    <input class="form-control" title="Nombres" placeholder="Nombres" id="nombres" name="nombres" required/>
                    <input class="form-control" title="Apellidos" placeholder="Apellidos" id="apellidos" name="apellidos" required/>
                    <input class="form-control" type="text" autocomplete="off" placeholder="Fecha nacimiento" id="fecha_nacimiento" name="fecha_nacimiento"/>
                    <select class="form-control" title="Género" id="genero" name="genero">
                        <option value="" selected="" hidden="">Seleccione el Género</option>                  
                        <option value="Masculino">Maculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <input class="form-control" title="Teléfono móvil" placeholder="Teléfono móvil" id="telefono_movil" name="telefono_movil" required/>
                    <input class="form-control" title="Teléfono fijo" placeholder="Teléfono fijo" id="telefono_fijo" name="telefono_fijo" />
                    <input class="form-control" title="Dirección" placeholder="Dirección" id="direccion" name="direccion" required/>
                </div>
                <div class="col-md-4">
                    <select class="form-control" title="Raza" id="raza" name="raza">
                        <option value="" selected="" hidden="">Seleccione la Raza</option>                  
                        <option value="Mestiza">Mestiza</option>
                        <option value="Negra">Negra</option>
                        <option value="Blanca">Blanca</option>
                    </select>
                    <input class="form-control" title="Ocupación" placeholder="Ocupación" id="ocupacion" name="ocupacion" />
                    <select class="form-control" title="Estado Civil" id="estado_civil" name="estado_civil">
                        <option value="" selected="" hidden="">Seleccione Estado Civil</option>                  
                        <option value="Casado">Casado</option>
                        <option value="Soltero">Soltero</option>
                        <option value="Union libre">Unión libre</option>
                    </select>
                    <input class="form-control" title="Correo electrónico" placeholder="Correo electrónico" id="correo_electronico" name="correo_electronico" />
                    <textarea class="form-control" title="Antecedentes personales" placeholder="Antecedentes personales" id="antecedentes_personales" name="antecedentes_personales"></textarea>
                    <textarea class="form-control" title="Antecedentes familiares" placeholder="Antecedentes familiares" id="antecedentes_familiares" name="antecedentes_familiares"></textarea>  
                    <div class="float-right">
                        <input class="btn btn-primary" type="submit" name="btn_crear_paciente" id="btn_crear_paciente" value="Aceptar" />
                        <a class="btn btn-danger" href="lista_pacientes.php">Cancelar</a>
                    </div>                    
                </div>
            </div>
        </form>
        <br>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script language="javascript" src="../js/jquery.datetimepicker.full.min.js"></script>
    <script>
            $('#fecha_nacimiento').datetimepicker({
                timepicker:false,
                format:'Y-m-d'
            });
            $.datetimepicker.setLocale('es');
    </script>
</body>
