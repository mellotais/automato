package automatos;

import java.util.Stack;

public class Automatos {
    enum State {
        STATE_START,
        STATE_A,
        STATE_B,
        STATE_X,
        STATE_ERROR
    }

    enum Input {
        INPUT_A,
        INPUT_B,
        INPUT_X
    }

    private State currentState = State.STATE_START;
    private Stack<Input> stack = new Stack<>();

    private State[][] matrix = {
        { State.STATE_ERROR, State.STATE_A, State.STATE_B, State.STATE_ERROR }, // STATE_START
        { State.STATE_A, State.STATE_A, State.STATE_ERROR, State.STATE_X }, // STATE_A
        { State.STATE_B, State.STATE_ERROR, State.STATE_B, State.STATE_X }, // STATE_B
        { State.STATE_ERROR, State.STATE_ERROR, State.STATE_ERROR, State.STATE_ERROR }, // STATE_X
        { State.STATE_ERROR, State.STATE_ERROR, State.STATE_ERROR, State.STATE_ERROR } // STATE_ERROR
    };

    public boolean automato(String input) {
        for (int i = 0; i < input.length(); i++) {
            char c = input.charAt(i);
            Input inputSymbol = Input.valueOf("INPUT_" + c);
            int inputIndex = inputSymbol.ordinal();
            currentState = matrix[currentState.ordinal()][inputIndex];
            if (currentState == State.STATE_ERROR) {
                return false;
            }
            if (currentState == State.STATE_START) {
                if (c == 'a' || c == 'b') {
                    stack.push(inputSymbol);
                } else if (c == 'X') {
                    currentState = State.STATE_X;
                } else {
                    return false;
                }
            } else if (currentState == State.STATE_A) {
                if (inputSymbol == Input.INPUT_A && !stack.empty() && stack.peek() == Input.INPUT_A) {
                    stack.pop();
                } else if (inputSymbol == Input.INPUT_B && !stack.empty() && stack.peek() == Input.INPUT_B) {
                    stack.pop();
                } else {
                    return false;
                }
            } else if (currentState == State.STATE_B) {
                if (inputSymbol == Input.INPUT_B && !stack.empty() && stack.peek() == Input.INPUT_B) {
                    stack.pop();
                } else if (inputSymbol == Input.INPUT_A && !stack.empty() && stack.peek() == Input.INPUT_A) {
                    stack.pop();
                } else {
                    return false;
                }
            } else if (currentState == State.STATE_X) {
                return false;
            }
        }
        return stack.empty() && currentState == State.STATE_X;
    }
}