<?php

namespace App\Entity;

use App\Repository\ProdottoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdottoRepository::class)]
class Prodotto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $prezzo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descrizione = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getPrezzo(): ?string
    {
        return $this->prezzo;
    }

    public function setPrezzo(string $prezzo): static
    {
        $this->prezzo = $prezzo;

        return $this;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): static
    {
        $this->codice = $codice;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): static
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getIdAndName() : ?string
    {
        return $this->id .' - ' . $this->nome;
    }
}
