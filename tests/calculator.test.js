// tests/calculator.test.js
const { calculate } = require('../calculator');

describe("Calculator JS", () => {
  test("addition", () => {
    expect(calculate("2+3")).toBe(5);
  });

  test("subtraction", () => {
    expect(calculate("5-2")).toBe(3);
  });

  test("multiplication", () => {
    expect(calculate("3*4")).toBe(12);
  });

  test("division", () => {
    expect(calculate("8/4")).toBe(2);
  });

  test("operator precedence", () => {
    expect(calculate("2+3*4")).toBe(14);
  });

  test("parentheses", () => {
    expect(calculate("(2+3)*4")).toBe(20);
  });

  test("invalid expression throws", () => {
    expect(() => calculate("2+bad")).toThrow("Expression invalide");
  });

  test("empty string throws", () => {
    expect(() => calculate("")).toThrow("Expression invalide");
  });
});
