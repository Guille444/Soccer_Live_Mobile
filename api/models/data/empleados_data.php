<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/empleados_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla USUARIO.
 */
class EmpleadoData extends EmpleadoHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */

         // Método para establecer el ID del empleado, validando que sea un número natural.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del empleado es incorrecto';
            return false;
        }
    }

    // Método para establecer el nombre del empleado, validando que sea alfabético y tenga una longitud adecuada.
    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método para establecer el apellido del empleado, con validaciones similares a las del nombre.
    public function setApellido($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El apellido debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->apellido = $value;
            return true;
        } else {
            $this->data_error = 'El apellido debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

        // Método para establecer el DUI del empleado, validando su formato y evitando duplicados.
    public function setDUI($value)
    {
        if (!Validator::validateDUI($value)) {
            $this->data_error = 'El DUI debe tener el formato ########-#';
            return false;
        } elseif ($this->checkDuplicate($value)) {
            $this->data_error = 'El DUI ingresado ya existe';
            return false;
        } else {
            $this->dui = $value;
            return true;
        }
    }

        // Método para establecer el correo electrónico del empleado, validando formato, longitud y duplicados.
    public function setCorreo($value, $min = 8, $max = 100)
    {
        if (!Validator::validateEmail($value)) {
            $this->data_error = 'El correo no es válido';
            return false;
        } elseif ($this->checkDuplicate2($value)) {
            $this->data_error = 'El correo ingresado ya existe';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->correo = $value;
            return true;
        } else {
            $this->data_error = 'El correo debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

        // Método para establecer el teléfono del empleado, validando duplicados y formato.
    public function setTelefono($value)
    {
        // Primero, verificar si el teléfono ya existe
        if ($this->checkDuplicate3($value)) {
            $this->data_error = 'El teléfono ingresado ya existe';
            return false;
        }
        // Después, validar el formato del teléfono
        elseif (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        }
        // Si el formato del teléfono no es válido
        else {
            $this->data_error = 'El teléfono debe tener el formato (2, 6, 7)###-####';
            return false;
        }
    }

    // Método para establecer la clave del empleado, validando y aplicando hash.
    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            $this->data_error = Validator::getPasswordError();
            return false;
        }
    }

    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
