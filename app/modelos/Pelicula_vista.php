<?php 

class Pelicula_vista {
    private $id;
    private $idUsuario;
    private $idPelicula;
    private $vista;
    private $fecha_vista;


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

    /**
     * Get the value of vista
     */
    public function getVista()
    {
        return $this->vista;
    }

    /**
     * Set the value of vista
     */
    public function setVista($vista): self
    {
        $this->vista = $vista;

        return $this;
    }

    /**
     * Get the value of fecha_vista
     */
    public function getFechaVista()
    {
        return $this->fecha_vista;
    }

    /**
     * Set the value of fecha_vista
     */
    public function setFechaVista($fecha_vista): self
    {
        $this->fecha_vista = $fecha_vista;

        return $this;
    }
}
