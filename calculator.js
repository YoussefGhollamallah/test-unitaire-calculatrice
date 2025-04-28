// calculator.js
let currentInput = "";

function updateDisplay() {
    if (typeof document !== 'undefined') {
        document.getElementById('result').value = currentInput;
    }
}

function appendValue(value) {
    currentInput += value;
    updateDisplay();
}

function appendOperator(operator) {
    if (!/[+\-*/]$/.test(currentInput)) {
        currentInput += operator;
        updateDisplay();
    }
}

function clearResult() {
    currentInput = "";
    updateDisplay();
}

function calculate() {
    try {
        const result = evaluateExpression(currentInput);
        currentInput = result.toString();
    } catch (e) {
        currentInput = "Erreur";
    }
    updateDisplay();
}

// Fonction exportable pour Jest
function evaluateExpression(expr) {
    const sanitized = expr.trim();
    if (sanitized === "" || !/^[0-9+\-*/().\s]+$/.test(sanitized)) {
        throw new Error("Expression invalide");
    }
    try {
        const result = eval(sanitized);
        if (typeof result !== "number" || !isFinite(result)) {
            throw new Error("Erreur de calcul");
        }
        return result;
    } catch {
        throw new Error("Erreur de calcul");
    }
}

if (typeof module !== 'undefined') {
    module.exports = { calculate: evaluateExpression };
}
