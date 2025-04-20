<?php 


class Pelicula_usuario {
    private $id;
    private $idUsuario;
    private $idPelicula;
    private $vista;
    private $fecha_vista;
    private $comentario;
    private $fecha_comentario;
    private $puntuacion;



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
}

