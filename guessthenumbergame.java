import java.util.Random;
import java.util.Scanner;

public class guessthenumbergame {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        Random random = new Random();

        int minRange = 1;
        int maxRange = 100;
        int secretNumber = random.nextInt(maxRange - minRange + 1) + minRange;
        int numberOfGuesses = 0;
        boolean hasGuessedCorrectly = false;

        System.out.println("Welcome to the Guess the Number Game!");
        System.out.println("I have selected a number between " + minRange + " and " + maxRange + ". Try to guess it.");

        while (!hasGuessedCorrectly) {
            System.out.print("Enter your guess: ");
            int userGuess = scanner.nextInt();
            numberOfGuesses++;

            if (userGuess < minRange || userGuess > maxRange) {
                System.out.println("Your guess is out of the valid range.");
            } else if (userGuess < secretNumber) {
                System.out.println("Try higher!");
            } else if (userGuess > secretNumber) {
                System.out.println("Try lower!");
            } else {
                hasGuessedCorrectly = true;
                System.out.println("Congratulations! You've guessed the number " + secretNumber + " in " + numberOfGuesses + " guesses.");
            }
        }

        scanner.close();
    }
}
