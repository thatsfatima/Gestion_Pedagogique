<?php

namespace Apps\Core\Validators;

interface IValidator {
    public function validate(array $data, array $rules): ?array;
}


class Validator implements IValidator {
    private array $errors = [];
    private array $data = [];

    public function validate(array $data, array $rules): ?array {
        $this->data = $data;
        $this->errors = [];  // Réinitialiser les erreurs avant chaque validation
        foreach ($rules as $name => $rulesArray) {
            if (array_key_exists($name, $data)) {
                foreach ($rulesArray as $rule) {
                    $this->applyRule($name, $data[$name], $rule);
                }
            } else {
                $this->errors[$name][] = "{$name} est requis.";
            }
        }
        return empty($this->errors) ? null : $this->errors;
    }

    private function applyRule(string $name, mixed $value, string $rule) {
        $ruleMap = [
            "required" => fn() => $this->required($name, $value),
            "email" => fn() => $this->email($name, $value),
            "phone" => fn() => $this->phone($name, $value),
            "alpha" => fn() => $this->alpha($name, $value),
            "alphaNum" => fn() => $this->alphaNum($name, $value),
            "numeric" => fn() => $this->numeric($name, $value),
            "url" => fn() => $this->url($name, $value),
            "boolean" => fn() => $this->boolean($name, $value),
            "date" => fn() => $this->date($name, $value),
            "integer" => fn() => $this->integer($name, $value),
            "float" => fn() => $this->float($name, $value),
            "ip" => fn() => $this->ip($name, $value),
        ];

        $paramRuleMap = [
            "min" => fn() => $this->min($name, $value, $rule),
            "max" => fn() => $this->max($name, $value, $rule),
            "same" => fn() => $this->same($name, $value, $rule),
            "different" => fn() => $this->different($name, $value, $rule),
            "in" => fn() => $this->in($name, $value, $rule),
            "notIn" => fn() => $this->notIn($name, $value, $rule),
            "regex" => fn() => $this->regex($name, $value, $rule),
        ];

        if (isset($ruleMap[$rule])) {
            $ruleMap[$rule]();
        } else {
            foreach ($paramRuleMap as $paramRule => $method) {
                if (strpos($rule, $paramRule . ':') === 0) {
                    $method();
                    break;
                }
            }
        }
    }

    private function parseRuleParameter(string $rule, string $type) {
        preg_match("/{$type}:(.+)/", $rule, $matches);
        return $matches[1] ?? null;
    }

    private function required(string $name, mixed $value) {
        $value = trim((string)$value);
        if (empty($value)) {
            $this->errors[$name][] = "{$name} est requis.";
        }
    }

    private function min(string $name, mixed $value, string $rule) {
        $min = (int)$this->parseRuleParameter($rule, "min");
        if (strlen((string)$value) < $min) {
            $this->errors[$name][] = "{$name} doit avoir au minimum {$min} caractères.";
        }
    }

    private function max(string $name, mixed $value, string $rule) {
        $max = (int)$this->parseRuleParameter($rule, "max");
        if (strlen((string)$value) > $max) {
            $this->errors[$name][] = "{$name} doit avoir au maximum {$max} caractères.";
        }
    }

    private function email(string $name, mixed $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = "{$name} n'est pas un email valide.";
        }
    }

    private function phone(string $name, mixed $value) {
        if (!preg_match("/^(?:\+221)?(70|76|77|78)[0-9]{7}$/", (string)$value)) {
            $this->errors[$name][] = "{$name} n'est pas un numéro de téléphone sénégalais valide.";
        }
    }

    private function alpha(string $name, mixed $value) {
        if (!preg_match('/^[A-Za-z\s]+$/', (string)$value)) {
            $this->errors[$name][] = "{$name} doit contenir uniquement des lettres.";
        }
    }

    private function alphaNum(string $name, mixed $value) {
        if (!ctype_alnum((string)$value)) {
            $this->errors[$name][] = "{$name} doit contenir uniquement des lettres et des chiffres.";
        }
    }

    private function numeric(string $name, mixed $value) {
        if (!is_numeric($value)) {
            $this->errors[$name][] = "{$name} doit être un nombre.";
        }
    }

    private function url(string $name, mixed $value) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->errors[$name][] = "{$name} n'est pas une URL valide.";
        }
    }

    private function boolean(string $name, mixed $value) {
        if (!in_array($value, [true, false, 'true', 'false', 1, 0, '1', '0'], true)) {
            $this->errors[$name][] = "{$name} doit être un booléen.";
        }
    }

    private function date(string $name, mixed $value) {
        if (!strtotime((string)$value)) {
            $this->errors[$name][] = "{$name} n'est pas une date valide.";
        }
    }

    private function same(string $name, mixed $value, string $rule) {
        $otherField = $this->parseRuleParameter($rule, "same");
        if ($value !== $this->data[$otherField]) {
            $this->errors[$name][] = "{$name} doit être identique à {$otherField}.";
        }
    }

    private function different(string $name, mixed $value, string $rule) {
        $otherField = $this->parseRuleParameter($rule, "different");
        if ($value === $this->data[$otherField]) {
            $this->errors[$name][] = "{$name} doit être différent de {$otherField}.";
        }
    }

    private function in(string $name, mixed $value, string $rule) {
        $allowedValues = explode(',', $this->parseRuleParameter($rule, "in"));
        if (!in_array($value, $allowedValues)) {
            $this->errors[$name][] = "{$name} doit être l'une des valeurs suivantes : " . implode(', ', $allowedValues) . ".";
        }
    }

    private function notIn(string $name, mixed $value, string $rule) {
        $disallowedValues = explode(',', $this->parseRuleParameter($rule, "notIn"));
        if (in_array($value, $disallowedValues)) {
            $this->errors[$name][] = "{$name} ne doit pas être l'une des valeurs suivantes : " . implode(', ', $disallowedValues) . ".";
        }
    }

    private function integer(string $name, mixed $value) {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors[$name][] = "{$name} doit être un entier.";
        }
    }

    private function float(string $name, mixed $value) {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[$name][] = "{$name} doit être un nombre à virgule flottante.";
        }
    }

    private function ip(string $name, mixed $value) {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            $this->errors[$name][] = "{$name} doit être une adresse IP valide.";
        }
    }

    private function regex(string $name, mixed $value, string $rule) {
        $pattern = $this->parseRuleParameter($rule, "regex");
        if (!preg_match($pattern, (string)$value)) {
            $this->errors[$name][] = "{$name} ne correspond pas au format attendu.";
        }
    }
}
