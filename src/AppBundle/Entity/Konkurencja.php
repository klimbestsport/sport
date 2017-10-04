<?php

namespace AppBundle\Entity;

/**
 * Konkurencja
 */
class Konkurencja
{
    /**
     * @var string
     */
    private $nazwaS;

    /**
     * @var string
     */
    private $nazwaP;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nazwaS
     *
     * @param string $nazwaS
     *
     * @return Konkurencja
     */
    public function setNazwaS($nazwaS)
    {
        $this->nazwaS = $nazwaS;

        return $this;
    }

    /**
     * Get nazwaS
     *
     * @return string
     */
    public function getNazwaS()
    {
        return $this->nazwaS;
    }

    /**
     * Set nazwaP
     *
     * @param string $nazwaP
     *
     * @return Konkurencja
     */
    public function setNazwaP($nazwaP)
    {
        $this->nazwaP = $nazwaP;

        return $this;
    }

    /**
     * Get nazwaP
     *
     * @return string
     */
    public function getNazwaP()
    {
        return $this->nazwaP;
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
}
