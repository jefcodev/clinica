<?php

class MetodosUtiles {

    public static function rolUsuarios($valor) {
        switch ($valor) {
            case 'doc': return 'Doctor';
            case 'asi': return 'Asistente';
            case 'adm': return 'Administrador';
            default:
                break;
        }
    }
    

   

}
