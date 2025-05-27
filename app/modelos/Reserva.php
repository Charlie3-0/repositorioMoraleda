<?php 

class Reserva {
    private $id;
    private $fecha_reserva;
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
     * Get the value of fecha_reserva
     */
    public function getFechaReserva()
    {
        return $this->fecha_reserva;
    }

    /**
     * Set the value of fecha_reserva
     */
    public function setFechaReserva($fecha_reserva): self
    {
        $this->fecha_reserva = $fecha_reserva;

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

