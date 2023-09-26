import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class UserRegistrationSystem {
    private static final String DB_URL = "jdbc:sqlite:userdb.db";

    public static void main(String[] args) {
        try {
            Connection connection = DriverManager.getConnection(DB_URL);

            // User registration example
            registerUser(connection, "john_doe", "password123", "john@example.com");

            // User login example
            boolean loginSuccessful = loginUser(connection, "john_doe", "password123");
            if (loginSuccessful) {
                System.out.println("Login successful!");
            } else {
                System.out.println("Login failed.");
            }

            connection.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void registerUser(Connection connection, String username, String password, String email)
            throws SQLException {
        String hashedPassword = hashPassword(password);

        String insertQuery = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        try (PreparedStatement preparedStatement = connection.prepareStatement(insertQuery)) {
            preparedStatement.setString(1, username);
            preparedStatement.setString(2, hashedPassword);
            preparedStatement.setString(3, email);
            preparedStatement.executeUpdate();
        }
    }

    public static boolean loginUser(Connection connection, String username, String password) throws SQLException {
        String selectQuery = "SELECT * FROM users WHERE username = ?";

        try (PreparedStatement preparedStatement = connection.prepareStatement(selectQuery)) {
            preparedStatement.setString(1, username);
            ResultSet resultSet = preparedStatement.executeQuery();

            if (resultSet.next()) {
                String storedPassword = resultSet.getString("password");
                return verifyPassword(password, storedPassword);
            }
        }

        return false;
    }

    private static String hashPassword(String password) {
        // Use a secure password hashing library like BCrypt
        // Example: return BCrypt.hashpw(password, BCrypt.gensalt());
        return password; // For simplicity, we're not hashing the password here.
    }

    private static boolean verifyPassword(String inputPassword, String hashedPassword) {
        // Use a secure password hashing library like BCrypt
        // Example: return BCrypt.checkpw(inputPassword, hashedPassword);
        return inputPassword.equals(hashedPassword); // For simplicity, we're comparing plain passwords here.
    }
}
