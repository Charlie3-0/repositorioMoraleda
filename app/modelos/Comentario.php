<?php 

class Comentario {
    private $id;
    private $idVideojuego;
    private $idUsuario;
    private $comentario;
    private $fecha_comentario;

    

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
     * Get the value of comentario
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set the value of comentario
     */
    public function setComentario($comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get the value of fecha_comentario
     */
    public function getFechaComentario()
    {
        return $this->fecha_comentario;
    }

    /**
     * Set the value of fecha_comentario
     */
    public function setFechaComentario($fecha_comentario): self
    {
        $this->fecha_comentario = $fecha_comentario;

        return $this;
    }
}

