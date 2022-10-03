<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Model;

class DeliveryPoint
{
    private float $latitude;
    private float $longitude;
    private string $name;
    private string $code;
    private string $type;
    private string $street;
    private string $postCode;
    private string $city;
    private string $openingHours;
    private string $hint;

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getOpeningHours(): string
    {
        return $this->openingHours;
    }

    /**
     * @param string $openingHours
     */
    public function setOpeningHours(string $openingHours): void
    {
        $this->openingHours = $openingHours;
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return $this->hint;
    }

    /**
     * @param string $hint
     */
    public function setHint(string $hint): void
    {
        $this->hint = $hint;
    }

    public function toArray(): array
    {
        return [
            'x' => $this->longitude,
            'y' => $this->latitude,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'street' => $this->street,
            'city' => $this->city,
            'postcode' => $this->postCode,
            'opening_hours' => $this->openingHours,
            'hint' => $this->hint
        ];
    }

}
