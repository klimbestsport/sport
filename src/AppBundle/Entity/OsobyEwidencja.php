<?php

namespace AppBundle\Entity;

/**
 * OsobyEwidencja
 */
class OsobyEwidencja
{
    /**
     * @var string
     */
    private $login;

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
    private $rokUrodzenia;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set login
     *
     * @param string $login
     *
     * @return OsobyEwidencja
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set imie
     *
     * @param string $imie
     *
     * @return OsobyEwidencja
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
     * @return OsobyEwidencja
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
     * Set rokUrodzenia
     *
     * @param string $rokUrodzenia
     *
     * @return OsobyEwidencja
     */
    public function setRokUrodzenia($rokUrodzenia)
    {
        $this->rokUrodzenia = $rokUrodzenia;

        return $this;
    }

    /**
     * Get rokUrodzenia
     *
     * @return string
     */
    public function getRokUrodzenia()
    {
        return $this->rokUrodzenia;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return OsobyEwidencja
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
