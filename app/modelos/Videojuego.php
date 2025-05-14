<?php 

class Videojuego {
    private $id;
    private $titulo;
    private $desarrollador;
    private $descripcion;
    private $foto;
    private $idCategoria;
    private $fecha_lanzamiento;
    private $trailer;

    

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
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo($titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of desarrollador
     */
    public function getDesarrollador()
    {
        return $this->desarrollador;
    }

    /**
     * Set the value of desarrollador
     */
    public function setDesarrollador($desarrollador): self
    {
        $this->desarrollador = $desarrollador;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of foto
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto($foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of idCategoria
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Set the value of idCategoria
     */
    public function setIdCategoria($idCategoria): self
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    /**
     * Get the value of fecha_lanzamiento
     */
    public function getFechaLanzamiento()
    {
        return $this->fecha_lanzamiento;
    }

    /**
     * Set the value of fecha_lanzamiento
     */
    public function setFechaLanzamiento($fecha_lanzamiento): self
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    /**
     * Get the value of trailer
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Set the value of trailer
     */
    public function setTrailer($trailer): self
    {
        $this->trailer = $trailer;

        return $this;
    }
}

