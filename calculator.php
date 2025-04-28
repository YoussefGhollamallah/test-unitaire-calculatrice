<?php
// calculator.php
class Calculator {
    /**
     * Calcule une expression arithmétique simple.
     *
     * @param string $expr Expression tel que "2+3*4"
     * @return float|int
     * @throws RuntimeException en cas d’erreur ou de division par zéro
     */
    public function calculate(string $expr) {
        // Normalisation des symboles
        $expr = str_replace(['×', '÷', '−', '–', '—'], ['*', '/', '-', '-', '-'], $expr);
        $expr = trim($expr);

        // Refuser les caractères non autorisés
        if ($expr === '' || !preg_match('/^[0-9+\-*\/().\s]+$/', $expr)) {
            throw new RuntimeException("Expression invalide");
        }

        // Évaluation sécurisée dans un scope limité
        try {
            $result = (static function() use ($expr) {
                return eval("return $expr;");
            })();
        } catch (Throwable $e) {
            throw new RuntimeException("Erreur de calcul");
        }

        // Vérifier le résultat
        if (!is_numeric($result) || is_infinite($result) || is_nan($result)) {
            throw new RuntimeException("Erreur de calcul");
        }

        return $result;
    }
}
