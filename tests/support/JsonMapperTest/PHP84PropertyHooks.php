<?php

declare(strict_types=1);

class JsonMapperTest_PHP84PropertyHooks
{
    private string $_name;

    public string $name {
        get => ucfirst($this->_name);
        set => $this->_name = strtolower($value);
    }

    private int $_age;

    public int $age {
        get => $this->_age;
        set {
            if ($value < 0) {
                throw new ValueError('Age cannot be negative');
            }
            $this->_age = $value;
        }
    }

    public function __construct()
    {
        $this->_name = '';
        $this->_age = 0;
    }
}
