<?php
namespace Apps\Core\Validators;

class Validator
{
    private $errors = [];
    private $rules;
    private $messages;

    public function __construct() {
        $this->rules = [
            'required' => function($value) {
                return !empty($value);
            },
            'min' => function($value, $min) {
                return strlen($value) >= $min;
            },
            'max' => function($value, $max) {
                return strlen($value) <= $max;
            },
            'email' => function($value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            },
            'tel' => function($value) {
                return preg_match("/^(70|77|78|76)[0-9]{7}$/", $value);
            },
            'photo' => function($value) {
                $typeImg = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                return in_array($typeImg, ['png', 'jpeg', 'jpg']);
            },
            'montant' => function($value, $param, $data) {
                return $value <= $data['restant'];
            },
            'positif' => function($value) {
                return $value > 0;
            }
        ];

        $this->messages = [
            'required' => ":field est requis.",
            'min' => ":field doit contenir au moins :param caractères.",
            'max' => ":field ne doit pas dépasser :param caractères.",
            'email' => "L'Email est invalide.",
            'tel' => "Le numéro de téléphone doit commencer par 70, 77, 78 ou 76.",
            'photo' => "Cette photo n'est pas valide.",
            'montant' => ":field ne doit pas dépasser :restant.",
            'positif' => ":field doit être positif."
        ];
    }

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $ruleName = $singleRule;
                $ruleValue = null;

                if (strpos($singleRule, ':') !== false) {
                    list($ruleName, $ruleValue) = explode(':', $singleRule);
                }

                if (isset($this->rules[$ruleName])) {
                    $isValid = $this->rules[$ruleName]($data[$field], $ruleValue, $data);
                    if (!$isValid) {
                        $this->addError($field, $this->formatMessage($field, $ruleName, $ruleValue, $data));
                    }
                }
            }
        }
    }

    private function formatMessage($field, $ruleName, $ruleValue, $data)
    {
        $message = $this->messages[$ruleName];
        $message = str_replace(':field', ucfirst($field), $message);

        if ($ruleValue !== null) {
            $message = str_replace(':param', $ruleValue, $message);
        }

        if (isset($data['restant'])) {
            $message = str_replace(':restant', $data['restant'], $message);
        }

        return $message;
    }

    public function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function fails()
    {
        return !empty($this->errors);
    }
}
?>