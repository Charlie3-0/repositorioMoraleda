<?php 

class Videojuego_probado {
    private $id;
    private $idUsuario;
    private $idVideojuego;
    private $fecha_probado;

    

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

    /**
     * Get the value of fecha_probado
     */
    public function getFechaProbado()
    {
        return $this->fecha_probado;
    }

    /**
     * Set the value of fecha_probado
     */
    public function setFechaProbado($fecha_probado): self
    {
        $this->fecha_probado = $fecha_probado;

        return $this;
    }
}
