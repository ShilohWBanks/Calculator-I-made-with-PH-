<?php
// Start the session
session_start();

// Check if the scores array exists in the session, if not create it
if (!isset($_SESSION['scores'])) {
    $_SESSION['scores'] = array();
}

// Handle the form submission for adding scores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validate input
    if (!empty($_POST['score']) && is_numeric($_POST['score'])) {
        // Add the score to the session
        $_SESSION['scores'][] = floatval($_POST['score']);
    }
}

// Check if the "New Person" button was clicked to reset scores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newPerson'])) {
    // Reset the scores array
    $_SESSION['scores'] = array();
}

// Function to calculate average
function calculateAverage($scores) {
    if (count($scores) > 0) {
        return array_sum($scores) / count($scores);
    }
    return 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Scores Input</title>
    <script>
    // When the page loads, focus on the "score" input field automatically
    window.onload = function() {
        document.getElementById('scoreInput').focus();
    };
    </script>
</head>
<body>

<h2>Enter School Scores</h2>

<!-- Score submission form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Score: <input type="text" id="scoreInput" pattern="[0-9]+(\.[0-9]{1,2})?" title="Please enter a number with up to 2 decimal places." name="score" required>
    <input type="submit" name="submit" value="Submit">
</form>

<!-- New Person form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- New Person button to reset scores -->
    <input type="submit" name="newPerson" value="New Person">
</form>

<?php if (!empty($_SESSION['scores'])): ?>
    <h3>Entered Scores:</h3>
    <ul>
        <?php foreach ($_SESSION['scores'] as $score): ?>
            <li><?php echo htmlspecialchars($score); ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Average Score:</strong> <?php echo calculateAverage($_SESSION['scores']); ?></p>
<?php endif; ?>

</body>
</html>