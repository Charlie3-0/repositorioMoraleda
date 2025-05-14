<?php 

class Prestamo {
    private $id;
    private $fecha_prestamo;
    private $devuelto;
    private $idUsuario;
    private $idVideojuego;
    
    

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of fecha_prestamo
     */
    public function getFechaPrestamo()
    {
        return $this->fecha_prestamo;
    }

    /**
     * Set the value of fecha_prestamo
     */
    public function setFechaPrestamo($fecha_prestamo): self
    {
        $this->fecha_prestamo = $fecha_prestamo;

        return $this;
    }

    /**
     * Get the value of devuelto
     */
    public function getDevuelto()
    {
        return $this->devuelto;
    }

    /**
     * Set the value of devuelto
     */
    public function setDevuelto($devuelto): self
    {
        $this->devuelto = $devuelto;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     */
    public function setIdUsuario($idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of idVideojuego
     */
    public function getIdVideojuego()
    {
        return $this->idVideojuego;
    }

    /**
     * Set the value of idVideojuego
     */
    public function setIdVideojuego($idVideojuego): self
    {
        $this->idVideojuego = $idVideojuego;

        return $this;
    }
}

