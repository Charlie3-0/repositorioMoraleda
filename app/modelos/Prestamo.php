<?php 

class Prestamo {
    private $id;
    private $fecha;
    private $devuelta;
    private $idUsuario;
    private $idPelicula;

    
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
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of devuelta
     */
    public function getDevuelta()
    {
        return $this->devuelta;
    }

    /**
     * Set the value of devuelta
     */
    public function setDevuelta($devuelta): self
    {
        $this->devuelta = $devuelta;

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
     * Get the value of idPelicula
     */
    public function getIdPelicula()
    {
        return $this->idPelicula;
    }

    /**
     * Set the value of idPelicula
     */
    public function setIdPelicula($idPelicula): self
    {
        $this->idPelicula = $idPelicula;

        return $this;
    }
}

