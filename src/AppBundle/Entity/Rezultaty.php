<?php

namespace AppBundle\Entity;

/**
 * Rezultaty
 */
class Rezultaty
{
    /**
     * @var string
     */
    private $rezultatS1;

    /**
     * @var string
     */
    private $xS1;

    /**
     * @var string
     */
    private $rezultatS2;

    /**
     * @var string
     */
    private $xS2;

    /**
     * @var string
     */
    private $czas;
    private $factor2;
    private $karabin;
    private $pistolet;

    /**
     * @var string
     */
    private $uwagiS1;

    /**
     * @var string
     */
    private $uwagiS2;

    /**
     * @var string
     */
    private $imie;

    /**
     * @var string
     */
    private $nazwisko;

    /**
     * @var string
     */
    private $rokU;

    /**
     * @var string
     */
    private $nrLic;

    /**
     * @var string
     */
    private $klub;

    /**
     * @var string
     */
    private $nazwaS;

    /**
     * @var string
     */
    private $nazwaP;
    private $sumaRez;
    private $sumaX;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Konkurencja
     */
    private $konkurencja;
    
  


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zawodnik = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set rezultatS1
     *
     * @param string $rezultatS1
     *
     * @return Rezultaty
     */
    public function setRezultatS1($rezultatS1)
    {
        $this->rezultatS1 = $rezultatS1;

        return $this;
    }

    /**
     * Get rezultatS1
     *
     * @return string
     */
    public function getRezultatS1()
    {
        return $this->rezultatS1;
    }
    
        public function setKarabin($karabin)
    {
        $this->karabin = $karabin;

        return $this;
    }

    /**
     * Get rezultatS1
     *
     * @return string
     */
    public function getKarabin()
    {
        return $this->karabin;
    }
    
     public function setPistolet($pistolet)
    {
        $this->pistolet = $pistolet;

        return $this;
    }

    /**
     * Get rezultatS1
     *
     * @return string
     */
    public function getPistolet()
    {
        return $this->pistolet;
    }

    /**
     * Set xS1
     *
     * @param string $xS1
     *
     * @return Rezultaty
     */
    public function setXS1($xS1)
    {
        $this->xS1 = $xS1;

        return $this;
    }

    /**
     * Get xS1
     *
     * @return string
     */
    public function getXS1()
    {
        return $this->xS1;
    }

    /**
     * Set rezultatS2
     *
     * @param string $rezultatS2
     *
     * @return Rezultaty
     */
    public function setRezultatS2($rezultatS2)
    {
        $this->rezultatS2 = $rezultatS2;

        return $this;
    }

    /**
     * Get rezultatS2
     *
     * @return string
     */
    public function getRezultatS2()
    {
        return $this->rezultatS2;
    }

    /**
     * Set xS2
     *
     * @param string $xS2
     *
     * @return Rezultaty
     */
    public function setXS2($xS2)
    {
        $this->xS2 = $xS2;

        return $this;
    }

    /**
     * Get xS2
     *
     * @return string
     */
    public function getXS2()
    {
        return $this->xS2;
    }

    /**
     * Set factor
     *
     * @param string $czas
     *
     * @return Rezultaty
     */
    public function setCzas($czas)
    {
        $this->czas = $czas;

        return $this;
    }

    /**
     * Get factor
     *
     * @return string
     */
    public function getCzas()
    {
        return $this->czas;
    }

    public function setFactor2($factor2)
    {
        $this->factor2 = $factor2;

        return $this;
    }

    /**
     * Get factor
     *
     * @return string
     */
    public function getFactor2()
    {
        return $this->factor2;
    }
    /**
     * Set uwagiS1
     *
     * @param string $uwagiS1
     *
     * @return Rezultaty
     */
    public function setUwagiS1($uwagiS1)
    {
        $this->uwagiS1 = $uwagiS1;

        return $this;
    }

    /**
     * Get uwagiS1
     *
     * @return string
     */
    public function getUwagiS1()
    {
        return $this->uwagiS1;
    }

    /**
     * Set uwagiS2
     *
     * @param string $uwagiS2
     *
     * @return Rezultaty
     */
    public function setUwagiS2($uwagiS2)
    {
        $this->uwagiS2 = $uwagiS2;

        return $this;
    }

    /**
     * Get uwagiS2
     *
     * @return string
     */
    public function getUwagiS2()
    {
        return $this->uwagiS2;
    }

    /**
     * Set imie
     *
     * @param string $imie
     *
     * @return Rezultaty
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
     * @return Rezultaty
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
     * @return Rezultaty
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
     * @return Rezultaty
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
     * @return Rezultaty
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
     * Set nazwaS
     *
     * @param string $nazwaS
     *
     * @return Rezultaty
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
     * @return Rezultaty
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
    
        public function setSumaRez($sumaRez)
    {
        $this->sumaRez = $sumaRez;

        return $this;
    }

    /**
     * Get nazwaP
     *
     * @return string
     */
    public function getSumaRez()
    {
        return $this->sumaRez;
    }
    
     public function setSumaX($sumaX)
    {
        $this->sumaX = $sumaX;

        return $this;
    }

    /**
     * Get nazwaP
     *
     * @return string
     */
    public function getSumaX()
    {
        return $this->sumaX;
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
     * Set konkurencja
     *
     * @param \AppBundle\Entity\Konkurencja $konkurencja
     *
     * @return Rezultaty
     */
    public function setKonkurencja(\AppBundle\Entity\Konkurencja $konkurencja = null)
    {
        $this->konkurencja = $konkurencja;

        return $this;
    }

    /**
     * Get konkurencja
     *
     * @return \AppBundle\Entity\Konkurencja
     */
    public function getKonkurencja()
    {
        return $this->konkurencja;
    }
    
    
     /**
     * Set kluby
     *
     * @param \AppBundle\Entity\Kluby $kluby
     *
     * @return Rezultaty
     */
   
   
}
