<?php

class Seguridad {
    //    public static $PAGINAS = array('lista_pacientes');

    /**
     * LISTADO DE PAGINAS Y PERMISOS DE ASISTENTES
     * @var type 
     */
    public static $ASISTENTE = [array(PAGINAS::LISTA_PACIENTES, ACCIONES::CREAR),
        array(PAGINAS::EDITAR_PACIENTE, ACCIONES::LEER, ACCIONES::EDITAR),
        array(PAGINAS::LISTA_CONSULTAS, ACCIONES::IMPRIMIR),
        array(PAGINAS::LISTA_CITAS, ACCIONES::EDITAR, ACCIONES::CREAR)];

    /**
     * LISTADO DE PAGINAS Y PERMISOS DE DOCTORES
     * @var type 
     */
    public static $DOCTOR = [array(PAGINAS::LISTA_PACIENTES, ACCIONES::EDITAR),
        array(PAGINAS::EDITAR_PACIENTE, ACCIONES::LEER, ACCIONES::EDITAR),
        array(PAGINAS::LISTA_CONSULTAS, ACCIONES::IMPRIMIR, ACCIONES::IMPRIMIR_CLASIFICADO, ACCIONES::EDITAR),
        array(PAGINAS::EDITAR_CONSULTA, ACCIONES::EDITAR),
        array(PAGINAS::INICIO, ACCIONES::ATENDER_CITA),
        array(PAGINAS::LISTA_CITAS, ACCIONES::CREAR),
        array(PAGINAS::LISTA_HISTORIAS, ACCIONES::VER),
        array(PAGINAS::VER_HISTORIA_CLINICA, ACCIONES::VER)];

    public static function tiene_permiso($rol, $pagina, $accion) {
        if ($rol === 'asi') {
            for ($i = 0; $i < count(self::$ASISTENTE); $i++) {
                if (self::$ASISTENTE[$i][0] === $pagina) {
                    $acciones = self::$ASISTENTE[$i];
                    for ($j = 1; $j < count($acciones); $j++) {
                        if ($acciones[$j] === $accion) {
                            return true;
                        }
                    }
                    return false;
                }
            }
        }
        if ($rol === 'doc') {
            for ($i = 0; $i < count(self::$DOCTOR); $i++) {
                if (self::$DOCTOR[$i][0] === $pagina) {
                    $acciones = self::$DOCTOR[$i];
                    for ($j = 1; $j < count($acciones); $j++) {
                        if ($acciones[$j] === $accion) {
                            return true;
                        }
                    }
                    return false;
                }
            }
        }
        if ($rol === 'adm') {
            return true;
        }
        return false;
    }

}

class ACCIONES {

    const EDITAR = 'EDITAR';
    const CREAR = 'CREAR';
    const LEER = 'LEER';
    const NAVEGAR = 'NAVEGAR';
    const VER = 'VER';
    const ENVIAR = 'ENVIAR';
    const IMPRIMIR = 'IMPRIMIR';
    const IMPRIMIR_CLASIFICADO = 'IMPRIMIR_CLASIFICADO';
    const ATENDER_CITA = 'ATENDER_CITA';

}

class PAGINAS {
    const EDITAR_PACIENTE = 'editar_paciente';
    const LISTA_CONSULTAS = 'lista_consultas';
    const EDITAR_CONSULTA = 'editar_consulta';
    const INICIO = 'inicio';
    const LISTA_CITAS = 'lista_citas';
    const LISTA_HISTORIAS = 'lista_historias';
    const LISTA_PACIENTES = 'lista_pacientes';
    const VER_HISTORIA_CLINICA = 'ver_historia_clinica';
    const LISTA_USUARIOS = 'lista_usuarios';
    const CREAR_USUARIOS = 'crear_usuario';
    const EDITAR_USUARIOS = 'editar_usuario';

}
