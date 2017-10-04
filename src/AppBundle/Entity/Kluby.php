<?php

namespace AppBundle\Entity;

/**
 * Kluby
 */
class Kluby
{
    /**
     * @var string
     */
    private $nazwaK;
 
    /**
     * @var integer
     */
    private $id;


    /**
     * Set nazwaK
     *
     * @param string $nazwaK
     *
     * @return Kluby
     */
    public function setNazwaK($nazwaK)
    {
        $this->nazwaK = $nazwaK;

        return $this;
    }

    /**
     * Get nazwaK
     *
     * @return string
     */
    public function getNazwaK()
    {
        return $this->nazwaK;
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
     * @var string
     */
    private $nazwaKrotka;

    /**
     * @var string
     */
    private $nazwaDluga;


    /**
     * Set nazwaKrotka
     *
     * @param string $nazwaKrotka
     *
     * @return Kluby
     */
    public function setNazwaKrotka($nazwaKrotka)
    {
        $this->nazwaKrotka = $nazwaKrotka;

        return $this;
    }

    /**
     * Get nazwaKrotka
     *
     * @return string
     */
    public function getNazwaKrotka()
    {
        return $this->nazwaKrotka;
    }

    /**
     * Set nazwaDluga
     *
     * @param string $nazwaDluga
     *
     * @return Kluby
     */
    public function setNazwaDluga($nazwaDluga)
    {
        $this->nazwaDluga = $nazwaDluga;

        return $this;
    }

    /**
     * Get nazwaDluga
     *
     * @return string
     */
    public function getNazwaDluga()
    {
        return $this->nazwaDluga;
    }
}
