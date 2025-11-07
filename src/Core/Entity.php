<?php

abstract class Entity {
    public function toArray(): array {
        return get_object_vars($this);
    }

    public function fromArray(array $data): void {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}