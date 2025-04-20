<?php 

class Reserva {
    private $id;
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

