<?php

namespace Core;

class Validator
{
    private array $errors = [];

    /**
     * Valide les données selon les règles fournies.
     *
     * Exemple :
     * [
     *     'name' => ['required', 'maxLength:100'],
     *     'description' => ['maxLength:500']
     * ]
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * Applique une règle à un champ.
     */
    private function applyRule(
        string $field,
        mixed $value,
        string $rule
    ): void {
        // Règle avec paramètre : maxLength:100
        [$ruleName, $parameter] = array_pad(
            explode(':', $rule, 2),
            2,
            null
        );

        switch ($ruleName) {

            case 'required':
                if (
                    $value === null ||
                    (is_string($value) && trim($value) === '')
                ) {
                    $this->errors[$field][] =
                        'Ce champ est obligatoire.';
                }
                break;

            case 'maxLength':
                if (
                    $value !== null &&
                    mb_strlen((string) $value) > (int) $parameter
                ) {
                    $this->errors[$field][] =
                        "Ce champ ne doit pas dépasser {$parameter} caractères.";
                }
                break;

            case 'minLength':
                if (
                    $value !== null &&
                    mb_strlen((string) $value) < (int) $parameter
                ) {
                    $this->errors[$field][] =
                        "Ce champ doit contenir au moins {$parameter} caractères.";
                }
                break;

            case 'numeric':
                if (
                    $value !== null &&
                    (is_string($value) && trim($value) !== '') &&
                    !is_numeric($value)
                ) {
                    $this->errors[$field][] =
                        'Ce champ doit être un nombre.';
                }
                break;

            case 'email':
                if (
                    $value !== null &&
                    !filter_var($value, FILTER_VALIDATE_EMAIL)
                ) {
                    $this->errors[$field][] =
                        'Adresse email invalide.';
                }
                break;

            default:
                throw new \InvalidArgumentException(
                    "Règle de validation inconnue : {$ruleName}"
                );
        }
    }

    /**
     * Retourne toutes les erreurs.
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Retourne les erreurs d'un champ.
     */
    public function errorsFor(string $field): array
    {
        return $this->errors[$field] ?? [];
    }

    /**
     * Indique si un champ possède une erreur.
     */
    public function hasError(string $field): bool
    {
        return !empty($this->errors[$field]);
    }
}