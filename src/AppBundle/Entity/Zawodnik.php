<?php

namespace AppBundle\Entity;

/**
 * Zawodnik
 */
class Zawodnik
{
    /**
     * @var string
     */
    public $imie;

    /**
     * @var string
     */
    public $nazwisko;
    /**
     * @var \AppBundle\Entity\Kluby
     */
    private $kluby;
    /**
     * @var string
     */
    public $rokU;

    /**
     * @var string
     */
    public $nrLic;

    /**
     * @var string
     */
    public $klub;

    /**
     * @var integer
     */
    public $id;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rezultaty = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set imie
     *
     * @param string $imie
     *
     * @return Zawodnik
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     *
     * @return Zawodnik
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set rokU
     *
     * @param string $rokU
     *
     * @return Zawodnik
     */
    public function setRokU($rokU)
    {
        $this->rokU = $rokU;

        return $this;
    }

    /**
     * Get rokU
     *
     * @return string
     */
    public function getRokU()
    {
        return $this->rokU;
    }

    /**
     * Set nrLic
     *
     * @param string $nrLic
     *
     * @return Zawodnik
     */
    public function setNrLic($nrLic)
    {
        $this->nrLic = $nrLic;

        return $this;
    }

    /**
     * Get nrLic
     *
     * @return string
     */
    public function getNrLic()
    {
        return $this->nrLic;
    }

    /**
     * Set klub
     *
     * @param string $klub
     *
     * @return Zawodnik
     */
    public function setKlub($klub)
    {
        $this->klub = $klub;

        return $this;
    }

    /**
     * Get klub
     *
     * @return string
     */
    public function getKlub()
    {
        return $this->klub;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set kluby
     *
     * @param \AppBundle\Entity\Kluby $kluby
     *
     * @return Zawodnik
     */
    public function setKluby(\AppBundle\Entity\Kluby $kluby = null)
    {
        $this->kluby = $kluby;

        return $this;
    }

    /**
     * Get kluby
     *
     * @return \AppBundle\Entity\Kluby
     */
    public function getKluby()
    {
        return $this->kluby;
    }
}
