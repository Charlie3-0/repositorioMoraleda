<?php 

class Puntuacion {
    private $id;
    private $puntuacion;
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
     * Get the value of puntuacion
     */
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * Set the value of puntuacion
     */
    public function setPuntuacion($puntuacion): self
    {
        $this->puntuacion = $puntuacion;

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