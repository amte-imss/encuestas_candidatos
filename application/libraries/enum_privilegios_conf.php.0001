<?php

abstract class MyEnum {

    final public function __construct($value = null) {
        $c = new ReflectionClass($this);
        if (!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }
        $this->value = $value;
    }

    final public function buscar($value = null) {
        $text = $this->getTextoEnum($value);
        $this->texto = $text;
    }

    final public function __toString() {
        return $this->value;
    }

    function getTextoEnum($value = null) {
        return "algo";
    }

}

class enum_privilegios_conf extends MyEnum {

    const
            __default = 0
            , SOLICITA_TARJETON = 1 // Solicitar tarjetón, ésta área apareccerá cuando esté activo el estado (actividad o correccion tarjeton) 
            , NUEVO_TARJETON = 2
            , CORRECCION_TARJETON = 3
            , VALIDAR_CANDIDATOS_SELECCIONADOS = 4//Botón al inicio del buscador 
            , TERMINAR_SELECCION_CANDIDATOS = 5//Botón al inicio del buscador (Este boton solo le aparecera al titular, cuando ya haya validado almenos a un candidato)
            , EXPORTAR_EXCEL = 6 //botón exportar a excel, lista del buscador
            , VALIDAR_CANDIDATO_POR_TITULAR = 7 // BOTON DE validar candidato por  titular y se envia automaticamente a validacion por el titular, donde se desactiva
            , VALIDAR_CANDIDATO_POR_JF = 8 // BOTON DE validar candidato por jefe de area y se envia automaticamente a validacion por el titular, donde se desactiva
            , ENVIAR_CANDIDATO_A_CORRECCION_TITULAR_O_JA = 9 // BOTON de cambio de estado a corrección (tarjeton o docente)
            , ENVIAR_CANDIDATO_A_REVISION_DEL_JA = 10 // boton de envio a jefe de area si algo se mando a corrección
            , AGREGAR_EVALUACION_ACTUACION_CURSO = 11   //Botón azul agregar gigante
            , CORREGIR_EVALUACION_ACTUACION_CURSO = 12
            , MENSAGE_CUMPLIO_TODOS_FILTROS_VALIDACION = 13
            , MENSAGE_YA_EXIXTEN_EMPLEADOS_VALIDADOS_JA = 14
            , MENSAGE_YA_EXIXTEN_EMPLEADOS_VALIDADOS_TITULAR = 15

    ;
    /*
    guardar actuación (evaluaciones)
    corregir

    */
    
    function getTextoEnum($value = null) {
        switch ($value) {
            case 'CLUBS':
                return 'Genial de clubes';
                break;
        }
    }

}
