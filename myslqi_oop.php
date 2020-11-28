<?php
    /* Interface for SQL */
    interface funciones {
        public function conectar();
        public function consultar(string $consulta);
        public function ejecutar(string $sentencia);
        public function desconectar();
    }

    /* Clase principal */
    class DB implements funciones 
    {
        // Atributos
        public string $servidor = "localhost";
        public string $usuario = "root";
        public string $clave = "4250_96Lz";
        public string $bbdd = "byg";
        public bool $estado = false;
        private $datosConsulta;
        private $datosEjecucion;
        public $conexion;

        // Metodos
        public function __construct()
        {
            $this -> conectar();
        }

        public function conectar()
        {
            if(!$this -> estado)
            {
                $this-> conexion = new mysqli($this -> servidor, $this -> usuario, $this -> clave, $this -> bbdd);
                if($this -> conexion) 
                {
                    $this-> estado = true;
                    return $this -> conexion;
                }
                else 
                {
                    echo "No se pudo conectar, por favor revise la configuración.<br>";
                    $this -> conexion = false;
                }
            }
            else 
            {
                echo "Ya conectado a " . $this -> servidor . ". <br>";
            }
        }

        public function consultar(string $consulta)
        {

            if($this -> estado && $this -> conexion != false)
            {
                $this -> datosConsulta = $this-> conexion -> query($consulta);
                if($this -> datosConsulta) {
                    $this -> datosConsulta -> fetch_assoc();
                    return $this -> datosConsulta;
                }
                else
                {
                    echo "No se pudo consultar, compruebe la configuración o la consulta realizada. <br>";
                    $this -> datosConsulta = null;
                }
            }
            else
            {
                echo "Error al consultar. Primero debe conectarse. <br>";
            }
        }
        
        public function ejecutar(string $sentencia)
        {
            if($this -> estado && $this -> conexion != false)
            {
                $this -> datosEjecucion = $this -> conexion -> query($sentencia);
                if(!$this -> datosEjecucion)
                {
                    $this -> datosEjecucion = null;
                    echo "Error al ejecutar tu consulta.<br>";
                }
                else
                {
                    return $this -> datosEjecucion;
                }
            }
        }

        public function desconectar()
        {
            if($this -> estado)
            {
                $this -> conexion = null;
                $this -> estado = false;   
            }
            else
            {
                echo "Ya desconectado. <br>";
            }
        }
    }
?>